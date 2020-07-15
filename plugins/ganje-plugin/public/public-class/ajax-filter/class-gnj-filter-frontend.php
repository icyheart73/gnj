<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('GNJ_Filter_Frontend')) {
    /**
     * Frontend class.
     * The class manage all the frontend behaviors.
     *
     * @since 1.0.0
     */
    class GNJ_Filter_Frontend
    {

        /**
         * @var array deprecated array from WC_QUERY
         * @since version 3.0
         */
        public $filtered_product_ids_for_taxonomy = array();
        public $layered_nav_product_ids = array();
        public $unfiltered_product_ids = array();
        public $filtered_product_ids = array();
        public $layered_nav_post__in = array();
        private $setting;

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct()
        {


            $is_ajax_navigation_active = is_active_widget(false, false, 'gnj-woo-ajax-navigation', true);
            //Actions
            if ($is_ajax_navigation_active) {
                add_filter('woocommerce_is_layered_nav_active', '__return_true');
            }
            $this->get_Settings();

            add_action('wp_enqueue_scripts', array($this, 'ajax_filter_enqueue_styles_scripts'));

            add_filter('the_posts', array($this, 'the_posts'), 15, 2);

            add_filter('woocommerce_layered_nav_link', 'gnj_plus_character_hack', 99);

            add_filter('woocommerce_is_filtered', 'gnj_is_filtered_uri', 20);

            add_action('wp_head', array($this, 'meta_robot_generator'));

        }

        /**
         * Select the correct query object
         *
         * @access public
         * @param WP_Query|bool $query (default: false)
         * @return the query object
         */
        public function select_query_object($current_wp_query)
        {
            return $current_wp_query->query;
        }

        public function get_Settings()
        {
            global $GanjeSetting;
            $this->setting = $GanjeSetting;
        }

        /**
         * Hook into the_posts to do the main product query if needed - relevanssi compatibility.
         *
         * @access public
         * @param array $posts
         * @param WP_Query|bool $query (default: false)
         * @return array
         */
        public function the_posts($posts, $query = false)
        {

            $queried_object = get_queried_object();

            if (!empty($queried_object) && (is_shop() || is_product_taxonomy() || !is_search())) {
                $filtered_posts = array();
                $queried_post_ids = array();

                $query_filtered_posts = $this->layered_nav_query();

                foreach ($posts as $post) {

                    if (in_array($post->ID, $query_filtered_posts)) {
                        $filtered_posts[] = $post;
                        $queried_post_ids[] = $post->ID;
                    }
                }

                $query->posts = $filtered_posts;
                $query->post_count = count($filtered_posts);

                // Get main query
                $current_wp_query = $this->select_query_object($query);

                if (is_array($current_wp_query)) {
                    // Get WP Query for current page (without 'paged')
                    unset($current_wp_query['paged']);
                } else {
                    $current_wp_query = array();
                }

                // Ensure filters are set
                $unfiltered_args = array_merge(
                    $current_wp_query,
                    array(
                        'post_type' => 'product',
                        'numberposts' => -1,
                        'post_status' => 'publish',
                        'meta_query' => is_object($current_wp_query) ? $current_wp_query->meta_query : array(),
                        'fields' => 'ids',
                        'no_found_rows' => true,
                        'update_post_meta_cache' => false,
                        'update_post_term_cache' => false,
                        'pagename' => '',
                        'suppress_filters' => true,
                    )
                );

                $hide_out_of_stock_items = $this->setting['remove_outofstock_filter'] == 'on' ? true : false;


                if ($hide_out_of_stock_items) {
                    $unfiltered_args['meta_query'][] = array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                        'compare' => 'AND'
                    );
                }

                $this->unfiltered_product_ids = get_posts($unfiltered_args);
                $this->filtered_product_ids = $queried_post_ids;

                // Also store filtered posts ids...
                if (sizeof($queried_post_ids) > 0) {
                    $this->filtered_product_ids = array_intersect($this->unfiltered_product_ids, $queried_post_ids);
                } else {
                    $this->filtered_product_ids = $this->unfiltered_product_ids;
                }

                if (sizeof($this->layered_nav_post__in) > 0) {
                    $this->layered_nav_product_ids = array_intersect($this->unfiltered_product_ids, $this->layered_nav_post__in);
                } else {
                    $this->layered_nav_product_ids = $this->unfiltered_product_ids;
                }
            }
            return $posts;
        }

        /**
         * Enqueue frontend styles and scripts
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function ajax_filter_enqueue_styles_scripts()
        {

        }

        /**
         * Layered Nav post filter.
         *
         * @param array $filtered_posts
         * @return array
         */
        public function layered_nav_query($filtered_posts = array())
        {
            $_chosen_attributes = Ganje_Ajax_Filter::getInstance()->get_layered_nav_chosen_attributes();
            $is_product_taxonomy = false;
            if (is_product_taxonomy()) {
                $is_product_taxonomy = array(
                    'taxonomy' => get_queried_object()->taxonomy,
                    'terms' => get_queried_object()->slug,
                    'field' => 'slug'
                );
            }

            if (sizeof($_chosen_attributes) > 0) {

                $matched_products = array(
                    'and' => array(),
                    'or' => array()
                );
                $filtered_attribute = array(
                    'and' => false,
                    'or' => false
                );

                foreach ($_chosen_attributes as $attribute => $data) {
                    $matched_products_from_attribute = array();
                    $filtered = false;

                    if (sizeof($data['terms']) > 0) {
                        foreach ($data['terms'] as $value) {

                            $args = array(
                                'post_type' => 'product',
                                'numberposts' => -1,
                                'post_status' => 'publish',
                                'fields' => 'ids',
                                'no_found_rows' => true,
                                'suppress_filters' => true,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $attribute,
                                        'terms' => $value,
                                        'field' => 'slug'
                                    )
                                ),
                            );

                            $args = gnj_product_visibility_meta($args);

                            if ($is_product_taxonomy) {
                                $args['tax_query'][] = $is_product_taxonomy;
                            }

                            //TODO: Increase performance for get_posts()
                            $post_ids = apply_filters('woocommerce_layered_nav_query_post_ids', get_posts($args), $args, $attribute, $value);

                            if (!is_wp_error($post_ids)) {

                                if (sizeof($matched_products_from_attribute) > 0 || $filtered) {
                                    $matched_products_from_attribute = $data['query_type'] == 'or' ? array_merge($post_ids, $matched_products_from_attribute) : array_intersect($post_ids, $matched_products_from_attribute);
                                } else {
                                    $matched_products_from_attribute = $post_ids;
                                }

                                $filtered = true;
                            }
                        }
                    }

                    if (sizeof($matched_products[$data['query_type']]) > 0 || $filtered_attribute[$data['query_type']] === true) {
                        $matched_products[$data['query_type']] = ($data['query_type'] == 'or') ? array_merge($matched_products_from_attribute, $matched_products[$data['query_type']]) : array_intersect($matched_products_from_attribute, $matched_products[$data['query_type']]);
                    } else {
                        $matched_products[$data['query_type']] = $matched_products_from_attribute;
                    }

                    $filtered_attribute[$data['query_type']] = true;

                    $this->filtered_product_ids_for_taxonomy[$attribute] = $matched_products_from_attribute;
                }

                // Combine our AND and OR result sets
                if ($filtered_attribute['and'] && $filtered_attribute['or'])
                    $results = array_intersect($matched_products['and'], $matched_products['or']);
                else
                    $results = array_merge($matched_products['and'], $matched_products['or']);

                if ($filtered) {

                    $this->layered_nav_post__in = $results;
                    $this->layered_nav_post__in[] = 0;

                    if (sizeof($filtered_posts) == 0) {
                        $filtered_posts = $results;
                        $filtered_posts[] = 0;
                    } else {
                        $filtered_posts = array_intersect($filtered_posts, $results);
                        $filtered_posts[] = 0;
                    }

                }
            } else {

                $args = array(
                    'post_type' => 'product',
                    'numberposts' => -1,
                    'post_status' => 'publish',
                    'fields' => 'ids',
                    'no_found_rows' => true,
                    'suppress_filters' => true,
                    'tax_query' => array(),
                    'meta_query' => array()
                );

                if ($is_product_taxonomy) {
                    $args['tax_query'][] = $is_product_taxonomy;
                }

                if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
                    $min_price = sanitize_text_field($_GET['min_price']);
                    $max_price = sanitize_text_field($_GET['max_price']);
                    $args['meta_query'][] = array(
                        'key' => '_price',
                        'value' => array($min_price, $max_price),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                }

                $args = gnj_product_visibility_meta($args);

                global $wp_query;
                $queried_object = function_exists('get_queried_object') && is_callable(array($wp_query, 'get_queried_object')) ? get_queried_object() : false;

                $taxonomy = $queried_object && property_exists($queried_object, 'taxonomy') ? $queried_object->taxonomy : false;
                $slug = $queried_object && property_exists($queried_object, 'slug') ? $queried_object->slug : false;

                //TODO: Increase performance for get_posts()
                $post_ids = apply_filters('woocommerce_layered_nav_query_post_ids', get_posts($args), $args, $taxonomy, $slug);

                if (!is_wp_error($post_ids)) {
                    $this->layered_nav_post__in = $post_ids;
                    $this->layered_nav_post__in[] = 0;

                    if (sizeof($filtered_posts) == 0) {
                        $filtered_posts = $post_ids;
                        $filtered_posts[] = 0;
                    } else {
                        $filtered_posts = array_intersect($filtered_posts, $post_ids);
                        $filtered_posts[] = 0;
                    }
                }
            }

            return (array)$filtered_posts;
        }

        /**
         * Add Meta Robots in the <head> section
         *
         * @return void
         * @author Andrea Grillo <andrea.grillo@yithemes.com
         * @since 2.4.1
         */
        public function meta_robot_generator()
        {
            $_chosen_attributes = Ganje_Ajax_Filter::getInstance()->get_layered_nav_chosen_attributes();
            $has_filtered_url = !empty($_chosen_attributes) || (isset($_GET['min_price']) || isset($_GET['max_price'])) || isset($_GET['product_tag']) || isset($_GET['product_cat']) || isset($_GET['onsale_filter']) || isset($_GET['instock_filter']);
            if (gnj_can_be_displayed() && $has_filtered_url && (is_product_tag() || is_product_taxonomy() || is_product_category() || is_shop())) {
                echo '<meta name="robots" content="index,follow">';
            }
        }
    }
}
