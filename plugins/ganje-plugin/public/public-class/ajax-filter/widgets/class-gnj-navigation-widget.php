<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('GNJ_Navigation_Widget')) {


    class GNJ_Navigation_Widget extends WP_Widget
    {

        /**
         * Use to print or not widget
         */
        public $found = false;

        function __construct()
        {
            $widget_ops = array('classname' => 'gnj-woocommerce-ajax-product-filter', 'description' => 'فیلتر پیشرفته محصول قالب گنجه');
            $control_ops = array('width' => 400, 'height' => 350);
            add_action('wp_ajax_gnj_select_type', array($this, 'ajax_print_terms'));
            add_filter('gnj_get_terms_list', array($this, 'reorder_terms_list'), 10, 3);
            parent::__construct('gnj-woo-ajax-navigation', '* فیلتر پیشرفته محصول قالب گنجه', $widget_ops, $control_ops);
        }


        function widget($args, $instance)
        {
            global $wc_product_attributes;
            add_filter('gnj_term_param_uri', array($this, 'term_param_uri'), 10, 3);
            add_filter('gnj_list_type_query_arg', array($this, 'type_query_args'), 10, 3);
            add_filter('gnj_is_attribute_check', array($this, 'filter_by_attributes_check'), 10, 2);
            add_filter("gnj_widget_title_ajax_navigation", array($this, 'widget_title'), 10, 3);
            add_action('gnj_widget_display_categories', array($this, 'show_premium_widget'), 10, 4);
            add_filter( 'gnj_get_terms_params', array( $this, 'get_terms_params' ), 10, 3 );

            if ( ! empty( $instance['type'] ) && 'tags' == $instance['type'] ) {
                $query_option = isset( $instance['tags_list_query'] ) ? $instance['tags_list_query'] : 'include';
                add_filter( "gnj_".$query_option."_terms", array( $this, 'gnj_include_exclude_terms' ), 10, 2 );
                add_filter( 'gnj_list_filter_query_product_tag', array( $this, 'gnj_list_filter_query_product_tag' ) );
            }

            $_chosen_attributes = Ganje_Ajax_Filter::getInstance()->get_layered_nav_chosen_attributes();
            $queried_object = get_queried_object();

            extract($args);
            $_attributes_array = gnj_get_product_taxonomy();

            if (is_search()) {
                return;
            }

            if (!is_post_type_archive('product') && !is_tax($_attributes_array)) {
                return;
            }

            $filter_term_field = 'slug';
            $current_term = $_attributes_array && is_tax($_attributes_array) ? get_queried_object()->$filter_term_field : '';
            $title = apply_filters('gnj_widget_title_ajax_navigation', (isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : ''), $instance, $this->id_base);
            $query_type = isset($instance['query_type']) ? $instance['query_type'] : 'and';
            $display_type = isset($instance['type']) ? $instance['type'] : 'list';
            $terms_type_list = 'all';
            $instance['id'] = $this->id;
            $instance['attribute'] = empty($instance['attribute']) ? '' : $instance['attribute'];

            /* FIX TO WOOCOMMERCE 2.1 */
            if (function_exists('wc_attribute_taxonomy_name')) {
                $taxonomy = wc_attribute_taxonomy_name($instance['attribute']);
            } else {
                $taxonomy = WC()->attribute_taxonomy_name($instance['attribute']);
            }

            $taxonomy = apply_filters('gnj_get_terms_params', $taxonomy, $instance, 'taxonomy_name');
            $terms_type_list = apply_filters('gnj_get_terms_params', $terms_type_list, $instance, 'terms_type');

            if (!taxonomy_exists($taxonomy)) {
                return;
            }

            $terms = gnj_get_terms($terms_type_list, $taxonomy, $instance);

            if (count($terms) > 0) {
                ob_start();

                $this->found = false;

                echo $before_widget;

                $title = html_entity_decode(apply_filters('widget_title', $title));

                if (!empty($title)) {
                    echo $before_title . $title . $after_title;
                }

                // Force found when option is selected - do not force found on taxonomy attributes
                if (!$_attributes_array || !is_tax($_attributes_array)) {
                    if (is_array($_chosen_attributes) && array_key_exists($taxonomy, $_chosen_attributes)) {
                        $this->found = true;
                    }
                }

                if (in_array($display_type, array('list', 'tags'))) {

                    $ancestors = gnj_wp_get_terms(
                        array(
                            'taxonomy' => $taxonomy,
                            'parent' => 0,
                            'hierarchical' => true,
                            'hide_empty' => false,
                        )
                    );
                    if (!empty($ancestors) && !is_wp_error($ancestors)) {

                        foreach ($ancestors as $ancestor) {
                            $tree[$ancestor->term_id] = gnj_reorder_hierachical_categories($ancestor->term_id, $taxonomy);
                        }
                    }

                    $this->add_reset_taxonomy_link($taxonomy, $instance);

                    // List display
                    echo "<ul class='gnj-list'>";

                    $this->get_list_html($tree, $taxonomy, $query_type, $display_type, $instance, $terms_type_list, $current_term, $args , 0, $filter_term_field);

                    echo "</ul>";
                } elseif (in_array($display_type, array('select'))) {
                    ?>

                    <a class="gnj-select-open" href="#">Filters</a>

                    <?php
                    // Select display
                    echo "<div class='gnj-select-wrapper'>";

                    echo "<ul class='gnj-select'>";

                    foreach ($terms as $term) {
                        $this->found = false;

                        $_products_in_term = get_objects_in_term($term->term_id, $taxonomy);

                        $option_is_set = (isset($_chosen_attributes[$taxonomy]) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']));

                        // If this is an AND query, only show options with count > 0
                        if ($query_type == 'and') {

                            $count = sizeof(array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->layered_nav_product_ids));

                            if ($count > 0) {
                                $this->found = true;
                            }

                            if (!gnj_term_has_child($term, $taxonomy) && $count == 0 && !$option_is_set) {
                                continue;
                            }

                            // If this is an OR query, show all options so search can be expanded
                        } else {

                            $count = sizeof(array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->unfiltered_product_ids));

                            if ($count > 0) {
                                $this->found = true;
                            }

                            if ($count == 0) {
                                continue;
                            }
                        }

                        $arg = 'filter_' . sanitize_title($instance['attribute']);
                        $current_filter = (isset($_GET[$arg])) ? explode(',', $_GET[$arg]) : array();
                        if (!is_array($current_filter)) {
                            $current_filter = array();
                        }

                        $current_filter = array_map('esc_attr', $current_filter);

                        if (!in_array($term->$filter_term_field, $current_filter)) {
                            $current_filter[] = $term->$filter_term_field;
                        }

                        $link = gnj_get_woocommerce_layered_nav_link();

                        // All current filters
                        if ($_chosen_attributes) {
                            foreach ($_chosen_attributes as $name => $data) {
                                if ($name !== $taxonomy) {

                                    // Exclude query arg for current term archive term
                                    while (in_array($term->slug, $data['terms'])) {
                                        $key = array_search($current_term, $data);
                                        unset($data['terms'][$key]);
                                    }

                                    // Remove pa_ and sanitize
                                    $filter_name = urldecode(sanitize_title(str_replace('pa_', '', $name)));

                                    if (!empty($data['terms'])) {
                                        $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                                    }

                                    if ($data['query_type'] == 'or') {
                                        $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                                    }
                                }
                            }
                        }

                        // Min/Max
                        if (isset($_GET['min_price'])) {
                            $link = add_query_arg('min_price', $_GET['min_price'], $link);
                        }

                        if (isset($_GET['max_price'])) {
                            $link = add_query_arg('max_price', $_GET['max_price'], $link);
                        }

                        if (isset($_GET['product_tag'])) {
                            $link = add_query_arg('product_tag', urlencode($_GET['product_tag']), $link);
                        } elseif (is_product_tag() && $queried_object) {
                            $link = add_query_arg(array('product_tag' => $queried_object->slug), $link);
                        }

                        if (isset($_GET['product_cat'])) {
                            $categories_filter_operator = 'and' == $query_type ? '+' : ',';
                            $_chosen_categories = explode($categories_filter_operator, urlencode($_GET['product_cat']));
                            $link = add_query_arg(
                                'product_cat',
                                implode($categories_filter_operator, $_chosen_categories),
                                $link
                            );
                        } elseif (is_product_category() && $queried_object) {
                            //Removed @JoseCostaRos
                            $link = add_query_arg(array('product_cat' => $queried_object->slug), $link);
                        }

                        if (is_product_taxonomy() && !gnj_is_filtered_uri() && $term->term_id != $queried_object->term_id) {

                            $link = add_query_arg(
                                array(
                                    'source_id' => $queried_object->term_id,
                                    'source_tax' => $queried_object->taxonomy,
                                    $queried_object->taxonomy => $queried_object->slug
                                ), $link);
                        }

                        if (isset($_GET['source_id']) && isset($_GET['source_tax'])) {
                            $add_source_id = true;
                            if (property_exists($term, 'term_id') && property_exists($queried_object, 'term_id') && $term->term_id == $queried_object->term_id) {
                                if (!gnj_is_filtered_uri()) {
                                    $add_source_id = false;
                                }
                            }

                            if ($add_source_id) {
                                $args = array('source_id' => $_GET['source_id'], 'source_tax' => $_GET['source_tax']);
                                if (property_exists($queried_object, 'taxonomy') && isset($_GET[$queried_object->taxonomy])) {
                                    $args[$queried_object->taxonomy] = $_GET[$queried_object->taxonomy];
                                }
                                $link = add_query_arg($args, $link);
                            }
                        }

                        // Current Filter = this widget
                        $term_param = apply_filters('gnj_term_param_uri', $term->$filter_term_field, $display_type, $term);
                        $check_for_current_widget = isset($_chosen_attributes[$taxonomy]) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']);
                        if ($check_for_current_widget) {

                            $class = '';

                            // Remove this term is $current_filter has more than 1 term filtered
                            if (sizeof($current_filter) > 1) {
                                $current_filter_without_this = array_diff($current_filter, array($term->$filter_term_field));
                                $link = add_query_arg($arg, implode(',', $current_filter_without_this), $link);
                            }

                        } else {
                            $class = '';
                            $link = add_query_arg($arg, implode(',', $current_filter), $link);
                        }

                        // Search Arg
                        if (get_search_query()) {
                            $link = add_query_arg('s', urlencode(get_search_query()), $link);
                        }

                        // Post Type Arg
                        if (isset($_GET['post_type'])) {
                            $link = add_query_arg('post_type', $_GET['post_type'], $link);
                        }

                        // Query type Arg
                        if ($query_type == 'or' && !(sizeof($current_filter) == 1 && isset($_chosen_attributes[$taxonomy]['terms']) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']))) {
                            $link = add_query_arg('query_type_' . sanitize_title($instance['attribute']), 'or', $link);
                        }

                        $link = esc_url(urldecode(apply_filters('woocommerce_layered_nav_link', $link)));

                        $show_count = $count != 0 && !empty($instance['show_count']) && !$instance['show_count'];

                        echo '<li ' . $class . '>';

                        echo ($this->found || $option_is_set) ? '<a rel="nofollow" data-type="select" href="' . $link . '">' : '<span>';

                        echo $term->name;

                        if ($this->found) {
                            echo ' <small class="count">' . $count . '</small><div class="clear"></div>';
                        }

                        echo ($this->found || $option_is_set) ? '</a>' : '</span>';

                        echo '</li>';

                    }

                    echo "</ul>";

                    echo "</div>";
                } elseif ($display_type == 'color') {
                    // List display
                    echo "<ul class='gnj-color'>";

                    foreach ($terms as $term) {

                        // Get count based on current view - uses transients
                        $transient_name = 'wc_ln_count_' . md5(sanitize_key($taxonomy) . sanitize_key($term->term_id));

                        $_products_in_term = get_objects_in_term($term->term_id, $taxonomy);

                        $option_is_set = (isset($_chosen_attributes[$taxonomy]) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']));

                        // If this is an AND query, only show options with count > 0
                        if ($query_type == 'and') {

                            $count = sizeof(array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->layered_nav_product_ids));

                            if ($count > 0) {
                                $this->found = true;
                            }

                            if ($count == 0 && !$option_is_set) {
                                continue;
                            }

                            // If this is an OR query, show all options so search can be expanded
                        } else {

                            $count = sizeof(array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->unfiltered_product_ids));

                            if ($count > 0) {
                                $this->found = true;
                            }

                            if ($count == 0) {
                                continue;
                            }
                        }

                        $arg = 'filter_' . sanitize_title($instance['attribute']);

                        $current_filter = (isset($_GET[$arg])) ? explode(',', $_GET[$arg]) : array();

                        if (!is_array($current_filter)) {
                            $current_filter = array();
                        }

                        $current_filter = array_map('esc_attr', $current_filter);

                        if (property_exists($term, $filter_term_field) && !in_array($term->$filter_term_field, $current_filter)) {
                            $current_filter[] = $term->$filter_term_field;
                        }

                        $link = gnj_get_woocommerce_layered_nav_link();

                        // All current filters
                        if ($_chosen_attributes) {
                            foreach ($_chosen_attributes as $name => $data) {
                                if ($name !== $taxonomy) {

                                    // Exclude query arg for current term archive term
                                    while (in_array($term->slug, $data['terms'])) {
                                        $key = array_search($current_term, $data);
                                        unset($data['terms'][$key]);
                                    }

                                    // Remove pa_ and sanitize
                                    $filter_name = sanitize_title(str_replace('pa_', '', $name));

                                    if (!empty($data['terms'])) {
                                        $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                                    }

                                    if ($data['query_type'] == 'or') {
                                        $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                                    }
                                }
                            }
                        }

                        // Min/Max
                        if (isset($_GET['min_price'])) {
                            $link = add_query_arg('min_price', $_GET['min_price'], $link);
                        }

                        if (isset($_GET['max_price'])) {
                            $link = add_query_arg('max_price', $_GET['max_price'], $link);
                        }

                        if (isset($_GET['product_tag'])) {
                            $link = add_query_arg('product_tag', urlencode($_GET['product_tag']), $link);
                        } elseif (is_product_tag() && $queried_object) {
                            $link = add_query_arg(array('product_tag' => $queried_object->slug), $link);
                        }

                        if (isset($_GET['product_cat'])) {
                            $categories_filter_operator = 'and' == $query_type ? '+' : ',';
                            $_chosen_categories = explode($categories_filter_operator, urlencode($_GET['product_cat']));
                            $link = add_query_arg(
                                'product_cat',
                                implode($categories_filter_operator, $_chosen_categories),
                                $link
                            );
                        } elseif (is_product_category() && $queried_object) {
                            //Removed @JoseCostaRos
                            $link = add_query_arg(array('product_cat' => $queried_object->slug), $link);
                        }

                        if (is_product_taxonomy() && !gnj_is_filtered_uri() && $term->term_id != $queried_object->term_id) {
                            $link = add_query_arg(
                                array(
                                    'source_id' => $queried_object->term_id,
                                    'source_tax' => $queried_object->taxonomy,
                                    $queried_object->taxonomy => $queried_object->slug
                                ), $link);
                        }

                        if (isset($_GET['source_id']) && isset($_GET['source_tax'])) {
                            $add_source_id = true;
                            if (property_exists($term, 'term_id') && property_exists($queried_object, 'term_id') && $term->term_id == $queried_object->term_id) {
                                if (!gnj_is_filtered_uri()) {
                                    $add_source_id = false;
                                }
                            }

                            if ($add_source_id) {
                                $args = array('source_id' => $_GET['source_id'], 'source_tax' => $_GET['source_tax']);
                                $link = add_query_arg($args, $link);
                            }
                        }

                        // Current Filter = this widget
                        if (isset($_chosen_attributes[$taxonomy]) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms'])) {

                            $class = 'chosen';

                            // Remove this term is $current_filter has more than 1 term filtered
                            if (sizeof($current_filter) > 1) {
                                $current_filter_without_this = array_diff($current_filter, array($term->$filter_term_field));
                                $link = add_query_arg($arg, implode(',', $current_filter_without_this), $link);
                            }
                        } else {
                            $class = '';
                            $link = add_query_arg($arg, implode(',', $current_filter), $link);
                        }

                        // Search Arg
                        if (get_search_query()) {
                            $link = add_query_arg('s', urlencode(get_search_query()), $link);
                        }

                        // Post Type Arg
                        if (isset($_GET['post_type'])) {
                            $link = add_query_arg('post_type', $_GET['post_type'], $link);
                        }

                        // Query type Arg
                        if ($query_type == 'or' && !(sizeof($current_filter) == 1 && isset($_chosen_attributes[$taxonomy]['terms']) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']))) {
                            $link = add_query_arg('query_type_' . sanitize_title($instance['attribute']), 'or', $link);
                        }

                        $link = esc_url(urldecode(apply_filters('woocommerce_layered_nav_link', $link)));
                        $term_id = $term->term_id;

                        $color = '';

                        if (!empty($instance['colors'][$term_id])) {
                            $color = $instance['colors'][$term_id];
                        } elseif (function_exists('ywccl_get_term_meta') && !empty($wc_product_attributes[$term->taxonomy]->attribute_type) && 'colorpicker' == $wc_product_attributes[$term->taxonomy]->attribute_type) {
                            $colors = ywccl_get_term_meta($term->term_id, $term->taxonomy . '_yith_wccl_value');
                            if (!empty($colors)) {
                                $colors = explode(',', $colors);
                                $color = $colors[0];
                            }
                        }

                        if ($color) {

                            echo '<li ' . $class . '>';

                            echo ($count > 0 || $option_is_set) ? '<a rel="nofollow" style="background-color:' . $color . '" href="' . $link . '" title="' . $term->name . '" >' : '<span class="gnj-color-not-available" style="background-color:' . $color . ';" >';

                            echo $term->name;

                            echo ($count > 0 || $option_is_set) ? '</a>' : '</span>';
                        }
                    }

                    echo "</ul>";

                } else {
                    do_action("gnj_widget_display_categories", $args, $instance, $terms, $taxonomy);

                }
                // End display type conditional

                echo $after_widget;


                echo ob_get_clean();

            }
        }

        function form($instance)
        {
            $defaults = array(
                'title' => '',
                'attribute' => '',
                'query_type' => 'and',
                'type' => 'list',
                'colors' => '',
                'display' => 'all',
                'tags_list' => array(),
                'tags_list_query' => 'exclude',
            );

            $instance = wp_parse_args((array)$instance, $defaults);

            $widget_types = array(
                'list' => 'چک باکس',
                'color' => 'کد رنگ',
                'select' => 'منوی کشویی',
                'categories' => 'دسته بندی',
                'tags' => 'برچسب'
            );

            $terms = gnj_wp_get_terms(array('taxonomy' => 'product_tag', 'hide_empty' => false));
            ?>

            <p>
                <label>
                    <strong>عنوان فیلتر :</strong><br/>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
                           name="<?php echo $this->get_field_name('title'); ?>"
                           value="<?php echo $instance['title']; ?>"/>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('type'); ?>"><strong>نوع نمایش :</strong></label>
                <select class="gnj_type widefat" id="<?php echo esc_attr($this->get_field_id('type')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('type')); ?>">
                    <?php foreach ($widget_types as $type => $label) : ?>
                        <option value="<?php echo $type ?>" <?php selected($type, $instance['type']) ?>><?php echo $label ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('query_type'); ?>">نوع انتخاب : </label>
                <select id="<?php echo esc_attr($this->get_field_id('query_type')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('query_type')); ?>">
                    <option value="and" <?php selected($instance['query_type'], 'and'); ?>> و</option>
                    <option value="or" <?php selected($instance['query_type'], 'or'); ?>> یا</option>
                </select>
            </p>

            <p class="gnj-attribute-list"
               style="display: <?php echo $instance['type'] == 'tags' || $instance['type'] == 'categories' ? 'none' : 'block' ?>;">

                <label for="<?php echo $this->get_field_id('attribute'); ?>"><strong> ویژگی : </strong></label>
                <select class="gnj_attributes widefat"
                        id="<?php echo esc_attr($this->get_field_id('attribute')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('attribute')); ?>">
                    <?php gnj_dropdown_attributes($instance['attribute']); ?>
                </select>
            </p>

            <div class="gnj-widget-tag-list <?php echo $instance['type'] ?>">
                <?php

                if (is_wp_error($terms) || empty($terms)) {
                    echo 'برچسبی پیدا نشد.';
                } else { ?>
                    <strong>برچسب ها :</strong>
                    <select class="gnj_tags_query_type widefat"
                            id="<?php echo esc_attr($this->get_field_id('tags_list_query')); ?>"
                            name="<?php echo esc_attr($this->get_field_name('tags_list_query')); ?>">
                        <option value="include" <?php selected('include', $instance['tags_list_query']) ?>>نمایش انتخاب
                            شده ها
                        </option>
                        <option value="exclude" <?php selected('exclude', $instance['tags_list_query']) ?>>مخفی کردن
                            انتخاب شده ها
                        </option>
                    </select>
                    <div class="gnj-select-option">
                        <small>برچسب هایی که هیچ محصولی در آنها وجود دارد نمایش داده نمیشوند.</small>
                    </div>
                    <div class="gnj_select_tag_wrapper">
                        <table class="gnj_select_tag">
                            <thead>
                            <tr>
                                <th>نام برچسب</th>
                                <th></th>
                                <th>تعداد محصولات در این برچسب</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($terms as $term) : ?>
                                <tr>
                                    <td class="term_name">
                                        <?php $checked = is_array($instance['tags_list']) && array_key_exists($term->term_id, $instance['tags_list']) ? 'checked' : ''; ?>
                                        <input type="checkbox" value="<?php echo $term->slug ?>"
                                               name="<?php echo esc_attr($this->get_field_name('tags_list')); ?>[<?php echo $term->term_id; ?>]"
                                               class="<?php echo esc_attr($this->get_field_name('tags_list')); ?> gnj_tag_list_checkbox"
                                               id="<?php echo esc_attr($this->get_field_id('tags_list')); ?>" <?php echo $checked; ?>/>
                                        <label for=""><?php echo $term->name; ?></label>
                                    </td>
                                    <td></td>
                                    <td class="term_count">
                                        ( <?php echo $term->count; ?> )
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>

            <div class="gnj_placeholder">
                <?php
                $values = array();

                if ($instance['type'] == 'color') {
                    $values = $instance['colors'];
                }

                gnj_attributes_table(
                    $instance['type'],
                    $instance['attribute'],
                    'widget-' . $this->id . '-',
                    'widget-' . $this->id_base . '[' . $this->number . ']',
                    $values,
                    $instance['display']
                );
                ?>
            </div>
            <span class="spinner" style="display: none;"></span>

            <input type="hidden" name="widget_id" value="widget-<?php echo $this->id ?>-"/>
            <input type="hidden" name="widget_name"
                   value="widget-<?php echo $this->id_base ?>[<?php echo $this->number ?>]"/>

            <script>jQuery(document).trigger('gnj_colorpicker');</script>
            <?php
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['attribute'] = !empty($new_instance['attribute']) ? stripslashes($new_instance['attribute']) : array();
            $instance['query_type'] = stripslashes($new_instance['query_type']);
            $instance['type'] = stripslashes($new_instance['type']);
            $instance['colors'] = !empty($new_instance['colors']) ? $new_instance['colors'] : array();
            $instance['labels'] = !empty($new_instance['labels']) ? $new_instance['labels'] : array();
            $instance['tags_list']          = ! empty( $new_instance['tags_list'] ) ? $new_instance['tags_list'] : array();
            $instance['tags_list_query']    = isset( $new_instance['tags_list_query'] ) ? $new_instance['tags_list_query'] : 'include';
            $instance['see_all_tax_text']   = $new_instance['see_all_tax_text'];

            return $instance;
        }

        public function show_premium_widget($args, $instance, $terms, $taxonomy)
        {

            extract($args);

            $_attributes_array = gnj_get_product_taxonomy();

            if (is_search()) {
                return;
            }

            if (!is_post_type_archive('product') && !is_tax($_attributes_array)) {
                return;
            }

            $current_term = $_attributes_array && is_tax($_attributes_array) ? get_queried_object()->term_id : '';
            $query_type = isset($instance['query_type']) ? $instance['query_type'] : 'and';
            $display_type = isset($instance['type']) ? $instance['type'] : 'list';
            $terms_type_list = (isset($instance['display']) && $display_type == 'categories') ? $instance['display'] : 'all';

            $instance['attribute'] = empty($instance['attribute']) ? '' : $instance['attribute'];

            $ancestors = array();
            $tree = array();


            $ancestors = gnj_wp_get_terms(
                array(
                    'taxonomy' => 'product_cat',
                    'parent' => 0,
                    'hierarchical' => true,
                    'hide_empty' => false,
                )
            );

            if (!empty($ancestors) && !is_wp_error($ancestors)) {

                //usort($ancestors, 'gnj_terms_sort');

                foreach ($ancestors as $ancestor) {
                    $tree[$ancestor->term_id] = gnj_reorder_hierachical_categories($ancestor->term_id);
                }
            }


            $categories_filter_operator = 'and' == $query_type ? '+' : ',';

            $this->add_reset_taxonomy_link($taxonomy, $instance);

            // List display
            echo "<ul class='gnj-list categories'>";
            $this->get_categories_list_html($args, $tree, $taxonomy, $display_type, $query_type, $instance, $terms_type_list, $current_term, $categories_filter_operator, 0);

            echo "</ul>";

        }

        public function ajax_print_terms()
        {
            $type = $_POST['value'];
            $attribute = $_POST['attribute'];
            $return = array('message' => '', 'content' => $_POST);

            $terms = gnj_wp_get_terms(array('taxonomy' => 'pa_' . $attribute, 'hide_empty' => '0'));

            $settings = $this->get_settings();
            $widget_settings = $settings[$this->number];
            $value = '';

            if ('label' == $type) {
                $value = $widget_settings['labels'];
            } elseif ('color' == $type) {
                $value = $widget_settings['colors'];
            } elseif ('multicolor' == $type) {
                $value = $widget_settings['multicolor'];
            }

            if ($type) {
                $return['content'] = gnj_attributes_table(
                    $type,
                    $attribute,
                    $_POST['id'],
                    $_POST['name'],
                    $value,
                    false
                );
            }

            echo json_encode($return);
            die();
        }

        public function get_categories_list_html($args, $terms, $taxonomy, $display_type, $query_type, $instance, $terms_type_list, $current_term, $categories_filter_operator, $level = 0)
        {
            $_chosen_attributes = Ganje_Ajax_Filter::getInstance()->get_layered_nav_chosen_attributes();
            $_get_current_filter = '';
            foreach ($terms as $parent_id => $term_ids) {

                $count = 0;
                $term = get_term_by('id', $parent_id, 'product_cat');
                $filter_is_hierarchical = $instance['display'] == 'hierarchical';

                $_products_in_term = get_objects_in_term($term->term_id, $taxonomy);

                $option_is_set = (isset($_chosen_attributes[$taxonomy]) && in_array($term->term_id, $_chosen_attributes[$taxonomy]['terms']));

                $term_param = apply_filters('gnj_term_param_uri', $term->slug, $display_type, $term);

                // If this is an AND query, only show options with count > 0
                if ($query_type == 'and') {

                    $product_selection = array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->layered_nav_product_ids);
                    $count = sizeof($product_selection);

                    if ($count > 0 && $current_term !== $term_param) {
                        $this->found = true;
                    }

                    if ((!gnj_term_has_child($term, $taxonomy)) && $count == 0 && !$option_is_set) {
                        continue;
                    }

                    // If this is an OR query, show all options so search can be expanded
                } else {
                    //TODO: Temporary Fix
                    $to_exclude = get_transient('gnj_exclude_from_catalog_product_ids');

                    if (false === $to_exclude) {
                        $unfiltered_args = array(
                            'post_type' => 'product',
                            'numberposts' => -1,
                            'post_status' => 'publish',
                            'fields' => 'ids',
                            'no_found_rows' => true,
                            'update_post_meta_cache' => false,
                            'update_post_term_cache' => false,
                            'pagename' => '',
                            'wc_query' => 'get_products_in_view', //Only for WC <= 2.6.x
                            'suppress_filters' => true,
                        );

                        $wc_get_product_visibility_term_ids = function_exists('wc_get_product_visibility_term_ids') ? wc_get_product_visibility_term_ids() : array();

                        if (!empty($wc_get_product_visibility_term_ids['exclude-from-catalog'])) {
                            $unfiltered_args['tax_query'][] = array(
                                'taxonomy' => 'product_visibility',
                                'terms' => $wc_get_product_visibility_term_ids['exclude-from-catalog'],
                                'operator' => 'IN',
                            );
                        }

                        $to_exclude = get_posts($unfiltered_args);
                        set_transient('gnj_exclude_from_catalog_product_ids', $to_exclude, MONTH_IN_SECONDS);
                    }

                    $product_selection = array_intersect($_products_in_term, array_diff($_products_in_term, $to_exclude));

                    $count = sizeof($product_selection);

                    $this->found = true;
                }

                $arg = $taxonomy;

                if (!empty($_GET[$arg])) {
                    $_get_current_filter = 'and' == $query_type ? urlencode($_GET[$arg]) : $_GET[$arg];
                }


                $current_filter = (isset($_GET[$arg])) ? explode($categories_filter_operator, $_get_current_filter) : array();

                if (!is_array($current_filter)) {
                    $current_filter = array();
                }

                $current_filter = array_map('esc_attr', $current_filter);

                if (!in_array($term_param, $current_filter)) {
                    $current_filter[] = $term_param;
                }

                $link = '';
                $link = gnj_get_woocommerce_layered_nav_link();

                // All current filters
                if ($_chosen_attributes) {
                    foreach ($_chosen_attributes as $name => $data) {
                        if ($name !== $taxonomy) {

                            // Exclude query arg for current term archive term
                            while (in_array($current_term, $data['terms'])) {
                                $key = array_search($current_term, $data);
                                unset($data['terms'][$key]);
                            }

                            // Remove pa_ and sanitize
                            $filter_name = sanitize_title(str_replace('pa_', '', $name));

                            if (!empty($data['terms'])) {
                                $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                            }

                            if ($data['query_type'] == 'or') {
                                $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                            }
                        }
                    }
                }

                $_chosen_categories = array();
                $queried_object = get_queried_object();

                // Min/Max
                if (isset($_GET['min_price'])) {
                    $link = add_query_arg('min_price', $_GET['min_price'], $link);
                }

                if (isset($_GET['max_price'])) {
                    $link = add_query_arg('max_price', $_GET['max_price'], $link);
                }

                if (isset($_GET['product_tag']) && $display_type != 'tags') {
                    $link = add_query_arg('product_tag', urlencode($_GET['product_tag']), $link);
                } elseif (is_product_tag() && $queried_object) {
                    $link = add_query_arg(array('product_tag' => $queried_object->slug), $link);
                }

                if (isset($_GET['product_cat'])) {
                    $_get_product_cat = 'and' == $query_type ? urlencode($_GET['product_cat']) : $_GET['product_cat'];
                    $_chosen_categories = explode($categories_filter_operator, $_get_product_cat);
                } elseif (is_product_category() && $queried_object) {
                    //Removed @JoseCostaRos
                    $current_filter[] = $_chosen_categories[] = $queried_object->slug;
                }

                $skip = false;

                if (is_product_taxonomy() && !gnj_is_filtered_uri() && $term->term_id != $queried_object->term_id) {

                    $link = add_query_arg(
                        array(
                            'source_id' => $queried_object->term_id,
                            'source_tax' => $queried_object->taxonomy,
                            $queried_object->taxonomy => $queried_object->slug
                        ), $link);
                }

                // Current Filter = this widget
                if (in_array($term->slug, $_chosen_categories)) {
                    $class = '';

                    // Remove this term is $current_filter has more than 1 term filtered
                    if (sizeof($current_filter) > 1) {
                        $current_filter = array_map('strtolower', $current_filter);
                        $term_param = strtolower($term_param);
                        $current_filter_without_this = array_diff($current_filter, array($term_param));
                        $value = implode($categories_filter_operator, $current_filter_without_this);
                        if (!empty($value)) {
                            $link = add_query_arg($arg, $value, $link);
                        }
                    }
                } else {
                    $class = '';

                    $link = add_query_arg($arg, implode($categories_filter_operator, $current_filter), $link);
                }

                // Search Arg
                if (get_search_query()) {
                    $link = add_query_arg('s', urlencode(get_search_query()), $link);
                }

                // Post Type Arg
                if (isset($_GET['post_type'])) {
                    $link = add_query_arg('post_type', $_GET['post_type'], $link);
                }

                if (isset($_GET['source_id']) && isset($_GET['source_tax'])) {
                    $add_source_id = true;
                    if (property_exists($term, 'term_id') && property_exists($queried_object, 'term_id') && $term->term_id == $queried_object->term_id) {
                        if (!gnj_is_filtered_uri()) {
                            $add_source_id = false;
                        }
                    }

                    if ($add_source_id) {
                        $args = array('source_id' => $_GET['source_id'], 'source_tax' => $_GET['source_tax']);
                        $link = add_query_arg($args, $link);
                    }
                }

                $is_attribute = apply_filters('gnj_is_attribute_check', true, $instance);

                // Query type Arg
                if ($is_attribute && $query_type == 'or' && !(sizeof($current_filter) == 1 && isset($_chosen_attributes[$taxonomy]['terms']) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->term_id, $_chosen_attributes[$taxonomy]['terms']))) {
                    $link = add_query_arg('query_type_' . sanitize_title($instance['attribute']), 'or', $link);
                }

                $link = str_replace('+', '%2B', $link);
                $link = esc_url(urldecode(apply_filters('woocommerce_layered_nav_link', $link)));

                $exclude = array();

                if (!empty($exclude) && in_array($term->term_id, $exclude)) {
                    $skip = true;
                }

                $li_printed = false;

                if (!$skip) {
                    $gnj_skip_no_products_in_category = $filter_is_hierarchical;
                    $li_printed = $count > 0 || $option_is_set || $query_type == 'or' || !$gnj_skip_no_products_in_category;

                    if ($li_printed) {
                        echo '<li ' . apply_filters('gnj_categories_item_class', $class, $term) . '>';
                    }

                    if ($count > 0 || $option_is_set || $query_type == 'or') {
                        printf('<a rel="nofollow" href="%s">%s</a>', $link, $term->name);
                    } elseif (!$gnj_skip_no_products_in_category) {
                        printf('<span>%s</span>', $term->name);
                    }

                    $hide_count = !empty($instance['show_count']) && !$instance['show_count'];

                    if ($count != 0 && !$hide_count) {
                        echo ' <small class="count">' . $count . '</small><div class="clear"></div>';
                    }
                }

                if (!empty($term_ids) && is_array($term_ids)) {
                    echo '<ul class="gnj-child-terms level-' . $level . '">';
                    $temp_level = $level;
                    $temp_level++;
                    $this->get_categories_list_html($args, $term_ids, $taxonomy, $display_type, $query_type, $instance, $terms_type_list, $current_term, $categories_filter_operator, $temp_level);
                    echo '</ul>';
                }

                if ($li_printed) {
                    echo '</li>';
                }
            }
        }

        public function gnj_include_exclude_terms( $ids, $instance ) {
            $option_ids = empty( $instance['tags_list'] ) ? array() : $instance['tags_list'];

            if ( empty( $option_ids ) ) {
                if ( 'gnj_include_terms' == current_filter() ) {
                    $option_ids = array();
                }

                elseif ( 'gnj_exclude_terms' == current_filter() ) {
                    $option_ids = array();
                }
            }

            else {
                $option_ids = is_array( $option_ids ) ? array_keys( $option_ids ) : array();
            }

            return array_merge( $ids, $option_ids );
        }

        public function gnj_list_filter_query_product_tag( $_get ) {
            return urlencode( $_get );
        }

        public function get_list_html($terms, $taxonomy, $query_type, $display_type, $instance, $terms_type_list, $current_term, $args , $level = 0, $filter_term_field = 'slug')
        {
            $_chosen_attributes = Ganje_Ajax_Filter::getInstance()->get_layered_nav_chosen_attributes();
            $queried_object = get_queried_object();

            foreach ($terms as $parent_id => $term_ids) {

                $term = get_term_by('id', $parent_id, $taxonomy);

                $exclude    = apply_filters( 'gnj_exclude_terms', array(), $instance );
                $include    = apply_filters( 'gnj_include_terms', array(), $instance );

                $echo = false;

                if( 'tags' == $instance['type'] ) {
                    $term_id = $term->term_id;
                    if ( 'exclude' ==  $instance['tags_list_query'] ){
                        $echo = ! in_array( $term_id, $exclude );
                    }

                    elseif ( 'include' ==  $instance['tags_list_query'] ){
                        $echo = in_array( $term_id, $include );
                    }
                }

                else {
                    $echo = true;
                }

                $filter_by_tags_hierarchical = $terms_type_list == 'tags';

                if ($echo) {

                    $_products_in_term = get_objects_in_term($term->term_id, $taxonomy);

                    $option_is_set = (isset($_chosen_attributes[$taxonomy]) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']));


                    $term_param = apply_filters('gnj_term_param_uri', $term->$filter_term_field, $display_type, $term);

                    $count = 0;

                    // If this is an AND query, only show options with count > 0
                    if ($query_type == 'and') {
                        $count = sizeof(array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->layered_nav_product_ids));
                    } else {
                        // If this is an OR query, show all options so search can be expanded
                        $count = sizeof(array_intersect($_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->unfiltered_product_ids));
                    }

                    if ($count > 0) {
                        $this->found = true;
                    }

                    $arg = apply_filters('gnj_list_type_query_arg', 'filter_' . sanitize_title($instance['attribute']), $display_type, $term, $instance['attribute']);

                    $current_filter = (isset($_GET[$arg])) ? explode(',', urlencode($_GET[$arg])) : array();

                    if (!is_array($current_filter)) {
                        $current_filter = array();
                    }

                    $current_filter = array_map('esc_attr', $current_filter);

                    if (!in_array($term_param, $current_filter)) {
                        $current_filter[] = $term_param;
                    }

                    $link = gnj_get_woocommerce_layered_nav_link();

                    // All current filters
                    if ($_chosen_attributes) {
                        foreach ($_chosen_attributes as $name => $data) {
                            if ($name !== $taxonomy) {
                                // Remove pa_ and sanitize
                                $filter_name = sanitize_title(str_replace('pa_', '', $name));
                                // Exclude query arg for current term archive
                                if (in_array($term->slug, $data['terms'])) {
                                    $key = array_search($current_term, $data);
                                    unset($data['terms'][$key]);
                                }

                                if (!empty($data['terms'])) {
                                    $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                                }

                                if ($data['query_type'] == 'or') {
                                    $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                                }
                            } else {
                                $filter_name = sanitize_title(str_replace('pa_', '', $name));
                                $link = remove_query_arg('filter_' . $filter_name, $link);
                            }
                        }
                    }

                    // Min/Max
                    if (isset($_GET['min_price'])) {
                        $link = add_query_arg('min_price', $_GET['min_price'], $link);
                    }

                    if (isset($_GET['max_price'])) {
                        $link = add_query_arg('max_price', $_GET['max_price'], $link);
                    }

                    if (isset($_GET['product_tag']) && $display_type != 'tags') {
                        $link = add_query_arg('product_tag', urlencode($_GET['product_tag']), $link);
                    } elseif (is_product_tag() && $queried_object && $current_term != $queried_object->slug) {
                        $link = add_query_arg(array('product_tag' => $queried_object->slug), $link);
                    }

                    if (isset($_GET['source_id']) && isset($_GET['source_tax'])) {
                        $add_source_id = true;

                        if (property_exists($term, 'term_id') && property_exists($queried_object, 'term_id') && $term->term_id == $queried_object->term_id) {
                            if (!gnj_is_filtered_uri()) {
                                $add_source_id = false;
                            }
                        }

                        if ($add_source_id) {
                            $args = array('source_id' => $_GET['source_id'], 'source_tax' => $_GET['source_tax']);
                            $link = add_query_arg($args, $link);
                        }
                    }

                    if (isset($_GET['product_cat'])) {
                        $categories_filter_operator = 'and' == $query_type ? '+' : ',';
                        $_chosen_categories = explode($categories_filter_operator, urlencode($_GET['product_cat']));
                        $link = add_query_arg(
                            'product_cat',
                            implode($categories_filter_operator, $_chosen_categories),
                            $link
                        );
                    } elseif (is_product_category() && $queried_object) {
                        //Removed @JoseCostaRos
                        $link = add_query_arg(array('product_cat' => $queried_object->slug), $link);
                    }

                    if (is_product_taxonomy() && !gnj_is_filtered_uri() && $term->term_id != $queried_object->term_id) {
                        $link = add_query_arg(
                            array(
                                'source_id' => $queried_object->term_id,
                                'source_tax' => $queried_object->taxonomy,
                                $queried_object->taxonomy => $queried_object->slug
                            ), $link);
                    }

                    $check_for_current_widget = isset($_chosen_attributes[$taxonomy]) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']);
                    $class = '';

                    // Current Filter = this widget
                    if (apply_filters('gnj_list_type_current_widget_check', $check_for_current_widget, $current_filter, $display_type, $term_param)) {

                        $class = 'class=""';


                        // Remove this term is $current_filter has more than 1 term filtered

                        if (sizeof($current_filter) > 1) {
                            $current_filter_without_this = array_diff($current_filter, array($term_param));
                            $link = add_query_arg($arg, implode(',', $current_filter_without_this), $link);
                        }
                    } else {

                        $link = add_query_arg($arg, implode(',', $current_filter), $link);
                    }

                    // Search Arg
                    if (get_search_query()) {
                        $link = add_query_arg('s', urlencode(get_search_query()), $link);
                    }

                    // Post Type Arg
                    if (isset($_GET['post_type'])) {
                        $link = add_query_arg('post_type', $_GET['post_type'], $link);
                    }

                    $is_attribute = apply_filters('gnj_is_attribute_check', true, $instance);

                    // Query type Arg
                    if ($is_attribute && $query_type == 'or' && !(sizeof($current_filter) == 1 && isset($_chosen_attributes[$taxonomy]['terms']) && is_array($_chosen_attributes[$taxonomy]['terms']) && in_array($term->$filter_term_field, $_chosen_attributes[$taxonomy]['terms']))) {
                        $link = add_query_arg('query_type_' . sanitize_title($instance['attribute']), 'or', $link);
                    }

                    $link = esc_url(urldecode(apply_filters('woocommerce_layered_nav_link', $link)));

                    $li_printed = false;
                    $to_print = false;

                    if ($count > 0 || $option_is_set) {
                        $to_print = true;
                        $term_name = $term->name;
                        printf('<li rel="nofollow"><a %s href="%s">%s</a>', $class, $link, $term_name);
                        $li_printed = true;
                    } else {
                        $to_print = !$filter_by_tags_hierarchical && $query_type != 'and';
                        if ($to_print) {
                            printf('<li %s><span>%s</span>', $class, $term->name);
                            $li_printed = true;
                        }
                    }

                    echo ' <small class="count">' . $count . '</small><div class="clear"></div>';


                    if ($li_printed) {
                        echo '</li>';
                    }

                }
                if (!empty($term_ids)) {
                    echo '<ul class="gnj-child-terms level-' . $level . '">';
                    $temp_level = $level;
                    $temp_level++;
                    $this->get_list_html($term_ids, $taxonomy, $query_type, $display_type, $instance, $terms_type_list, $current_term, $args, $temp_level, $filter_term_field);
                    echo '</ul>';
                }
            }
        }

        public function reorder_terms_list($terms, $taxonomy, $instance)
        {
            if ('product_tag' == $taxonomy && 'tags' == $instance['type']) {
                $terms = gnj_reorder_terms_by_parent($terms, $taxonomy);
            }
            return $terms;
        }

        public function term_param_uri($term_param, $type, $term)
        {
            if ('tags' == $type) {
                $term_param = $term->slug;
            }

            return $term_param;
        }

        public function type_query_args($arg, $type, $term = null)
        {
            if ('tags' == $type) {
                $arg = 'product_tag';
            }
            return $arg;
        }

        public function filter_by_attributes_check($check, $instance)
        {
            if ('tags' == $instance['type']) {
                $check = false;
            }
            return $check;
        }

        public function widget_title($title, $instance, $id_base)
        {
            $instance['dropdown_type'] = isset($instance['dropdown_type']) ? $instance['dropdown_type'] : 'open';
            $span_html = sprintf('<span class="widget-dropdown" data-toggle="%s"></span>', !empty($instance['dropdown_type']) ? $instance['dropdown_type'] : 'open');
            $title = !empty($instance['dropdown']) ? $title . ' ' . $span_html : $title;
            return $title;
        }

        public function get_terms_params( $param, $instance, $type ) {
            if( empty( $instance['type'] ) ){
                $instance['type'] = 'list';
            }

            if ( 'tags' == $instance['type'] ) {
                if ( 'taxonomy_name' == $type ) {
                    $param = 'product_tag';
                }

            }

            elseif( 'categories' == $instance['type'] && 'taxonomy_name' == $type ){
                $param = 'product_cat';
            }
            return $param;
        }

        //Override in Premium classes
        public function add_reset_taxonomy_link($taxonomy, $instance)
        {
        }
    }
}

//TODO: Temporary Fix

add_action('save_post', 'gnj_exclude_from_catalog_product_ids', 99);

function gnj_exclude_from_catalog_product_ids()
{
    delete_transient('gnj_exclude_from_catalog_product_ids');
}

