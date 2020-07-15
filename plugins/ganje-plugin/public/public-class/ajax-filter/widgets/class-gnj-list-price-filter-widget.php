<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'GNJ_List_Price_Filter_Widget' ) ) {
    /**
     * Sort_By_Widget
     */
    class GNJ_List_Price_Filter_Widget extends WP_Widget {

        public function __construct() {
            $widget_ops  = array( 'classname' => 'gnj-list-price-filter', 'description' => 'ابزارک فیلتر براساس قیمت گنجه' );
            $control_ops = array( 'width' => 400, 'height' => 350 );
            parent::__construct( 'gnj-ajax-navigation-list-price-filter', '* فیلتر بر اساس قیمت گنجه' , $widget_ops, $control_ops );

            if ( ! is_admin() ) {
                $sidebars_widgets = wp_get_sidebars_widgets();
                $regex            = '/^gnj-ajax-navigation-list-price-filter-\d+/';
                $found            = false;

                foreach ( $sidebars_widgets as $sidebar => $widgets ) {
                    if ( is_array( $widgets ) ) {
                        foreach ( $widgets as $widget ) {
                            if ( preg_match( $regex, $widget ) ) {
                                $this->actions();
                                $found = true;
                            }

                            if( $found ){
                                break;
                            }
                        }
                    }

                    if( $found ){
		                break;
	                }
                }
            }
        }

        public function actions(){
            /* === Hooks and Actions === */
            add_filter( 'woocommerce_layered_nav_link', array( $this, 'price_filter_args' ) );
            ! is_active_widget( false, false, 'woocommerce_price_filter', true ) && ! is_admin() && add_filter( 'loop_shop_post_in', array( $this, 'price_filter' ) );
        }

        public function widget( $args, $instance ) {
            global $wp_query;

            if( ! gnj_can_be_displayed() ){
                return;
            }

            if(is_search() ){
                return;
            }

            extract( $instance );
            extract( $args );

            $_attributes_array = gnj_get_product_taxonomy();

            if ( !is_post_type_archive( 'product' ) && ! is_tax( $_attributes_array ) ) {
                return;
            }

            echo $before_widget;

            $title = apply_filters( 'widget_title', $title );

            if ( $title ) {
                echo $before_title .$title. $after_title;
            }

            $args = array(
                'prices'         => $instance['prices'],
                'shop_page_uri'  => gnj_get_woocommerce_layered_nav_link(),
		        'instance'      => $instance
            );

            wc_get_template( 'list-price-filter.php', $args, '', GNJ_PATH .'/public/public-class/ajax-filter/templates/loop/' );

            echo $after_widget;

        }


        public function form( $instance ) {
            global $wpdb;

            $is_ajax = defined('DOING_AJAX') && DOING_AJAX ;

	        $min = floor( $wpdb->get_var(
		        'SELECT min(meta_value + 0)
				FROM ' . $wpdb->posts . ' as p
				LEFT JOIN ' . $wpdb->postmeta . ' as pm ON p.ID = pm.post_id
				WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array(
			        '_price',
			        '_min_variation_price'
		        ) ) ) . '") '
	        ) );

	        $max = ceil( $wpdb->get_var(
		        'SELECT max(meta_value + 0)
					FROM ' . $wpdb->posts . ' as p
				LEFT JOIN ' . $wpdb->postmeta . ' as pm ON p.ID = pm.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) . '")'
	        ) );

            $defaults = array(
                'title'             => 'قیمت :',
                'prices'            => array(
                    array(
                        'min' => $min,
                        'max' => $max
                    )
                ),
            );

            $instance = wp_parse_args( (array) $instance, $defaults );
            ?>

            <p>
                <label>
                    <strong>عنوان :</strong><br />
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
                </label>
            </p>

            <p class="yith-wcan-price-filter">
                <label>
                    <?php _e( 'Price Range', 'yith-woocommerce-ajax-navigation' ) ?>:
                </label>
                <span class="range-filter" data-field_name="<?php echo $this->get_field_name( 'prices' ); ?>">
                    <?php $i = 0; ?>
                    <?php if( is_array( $instance['prices'] ) ) : ?>
                        <?php foreach ( $instance['prices'] as $price ) : ?>
                            <input type="text" name="<?php echo $this->get_field_name( 'prices' ); ?>[<?php echo $i; ?>][min]" value="<?php echo $price['min'] ?>" class="yith-wcan-price-filter-input widefat" data-position="<?php echo $i; ?>" />
                            <input type="text" name="<?php echo $this->get_field_name( 'prices' ); ?>[<?php echo $i; ?>][max]" value="<?php echo $price['max'] ?>" class="yith-wcan-price-filter-input widefat" data-position="<?php echo $i; ?>"/>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </span>
            </p>

            <div class="yith-add-new-range-button">
                <input type="button" class="yith-wcan-price-filter-add-range button button-primary" value="<?php _e( 'Add new range', 'yith-woocommerce-ajax-navigation' ) ?>">
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('.yith-wcan-price-filter-add-range').off('click').on('click', function (e) {
                        e.preventDefault();
                        var t = jQuery(this);
                        jQuery.add_new_range(t);
                    });

                    jQuery(document).on('change', '.yith-wcan-dropdown-check', function () {
                        jQuery.select_dropdown(jQuery(this));
                    });
                });
            </script>
        <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']          = strip_tags( $new_instance['title'] );
            $instance['prices']         = isset( $new_instance['prices'] ) ? $this->remove_empty_price_range( $new_instance['prices'] ) : array();
            return $instance;
        }

        public function price_filter_args( $link ) {

            if ( isset( $_GET['orderby'] ) ) {
                $link = add_query_arg( array( 'orderby' => $_GET['orderby'] ), $link );
            }

            return $link;
        }

        public function remove_empty_price_range( $prices ){
            foreach( $prices as $k => $price ){
                if( $price['min'] == '' && $price['max'] == ''  ){
                    unset( $prices[ $k ] );
                }
            }

            return $prices;
        }

        public function price_filter( $filtered_posts = array() ) {
            global $wpdb;

            if ( isset( $_GET['max_price'] ) || isset( $_GET['min_price'] ) ) {

                $matched_products = array();
                $min              = isset( $_GET['min_price'] ) ? floatval( $_GET['min_price'] ) : 0;
                $max              = isset( $_GET['max_price'] ) ? floatval( $_GET['max_price'] ) : 9999999999;

                $matched_products_query = $wpdb->get_results( $wpdb->prepare( '
                    SELECT DISTINCT ID, post_parent, post_type FROM ' . $wpdb->posts .' as p
                    INNER JOIN ' . $wpdb->postmeta .' as pm ON p.ID = pm.post_id
                    WHERE post_type IN ( "product", "product_variation" )
                    AND post_status = "publish"
                    AND meta_key IN ("' . implode( '","', array( '_price' ) ) . '")
                    AND meta_value BETWEEN %f AND %f
                ', $min, $max ), OBJECT_K );

                if ( $matched_products_query ) {
                    foreach ( $matched_products_query as $product ) {
                        if ( $product->post_type == 'product' ) {
                            $matched_products[] = $product->ID;
                        }
                        if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) ) {
                            $matched_products[] = $product->post_parent;
                        }
                    }
                }

                // Filter the id's
                if ( 0 === sizeof( $filtered_posts ) ) {
                    $filtered_posts = $matched_products;
                }
                else {
                    $filtered_posts = array_intersect( $filtered_posts, $matched_products );

                }
                $filtered_posts[] = 0;
            }

            return (array) $filtered_posts;
        }

    }
}
