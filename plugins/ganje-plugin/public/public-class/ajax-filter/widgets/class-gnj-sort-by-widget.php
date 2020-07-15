<?php
/**
 * Main class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'GNJ_Sort_By_Widget' ) ) {
    /**
     * YITH_WCAN_Sort_By_Widget
     *
     * @since 1.0.0
     */
    class GNJ_Sort_By_Widget extends WP_Widget {

        public function __construct() {
            $classname = 'yith-woocommerce-ajax-product-filter yith-wcan-sort-by';
            $widget_ops  = array( 'classname' => 'gnj-woocommerce-ajax-product-filter gnj-sort-by', 'description' => 'ابزارک ترتیب مرتب سازی محصولات' );
            $control_ops = array( 'width' => 400, 'height' => 350 );
            parent::__construct( 'gnj-ajax-navigation-sort-by', '* ترتیب مرتب سازی محصولات گنجه', $widget_ops, $control_ops );

            if ( ! is_admin() ) {
                $sidebars_widgets = wp_get_sidebars_widgets();
                $regex            = '/^gnj-ajax-navigation-sort-by-\d+/';

                if( isset( $sidebars_widgets['wp_inactive_widgets'] ) ){
                    unset( $sidebars_widgets['wp_inactive_widgets'] );
                }

                foreach ( $sidebars_widgets as $sidebar => $widgets ) {
                    if ( is_array( $widgets ) ) {
                        foreach ( $widgets as $widget ) {
                            if ( preg_match( $regex, $widget ) ) {
                                $this->actions();
                                break;
                            }
                        }
                    }
                }
            }
        }

        public function actions(){
            /* === Hooks and Actions === */
            add_filter( 'wc_get_template', array( $this, 'sort_by_template' ), 10, 5 );
            add_filter( 'woocommerce_layered_nav_link', array( $this, 'sortby_filter_args' ) );
            remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        }

        public function widget( $args, $instance ) {
            global $wp_query;
            extract( $instance );
            extract( $args );

            $_attributes_array = gnj_get_product_taxonomy();

            if( ! gnj_can_be_displayed() ){
                return;
            }

            if ( is_search()) {
                return;
            }

            if ( !is_post_type_archive( 'product' ) && ! is_tax( $_attributes_array ) ) {
                return;
            }

            if ( empty( $wp_query->found_posts ) ) {
                return;
            }

            echo $before_widget;

            $title = apply_filters( 'widget_title', $title );

            if ( $title ) {
                echo $before_title .$title. $after_title;
            }

            woocommerce_catalog_ordering();

            echo $after_widget;

        }


        public function form( $instance ) {
            $defaults = array(
                'title'             => 'مرتب سازی بر اساس'
            );

            $instance = wp_parse_args( (array) $instance, $defaults );
            ?>

            <p>
                <label>
                    <strong>عنوان :</strong><br />
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
                </label>
            </p>

        <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']          = strip_tags( $new_instance['title'] );
            return $instance;
        }

        public function sort_by_template( $located, $template_name, $args, $template_path, $default_path ){

            if( 'loop/orderby.php' == $template_name ){
                $located        = wc_locate_template( 'sortby.php', '', GNJ_PATH .'/public/public-class/ajax-filter/templates/loop/' );
            }

            return $located;
        }

        public function sortby_filter_args( $link ){
            if( isset( $_GET['orderby'] ) ){
                $link = add_query_arg( array( 'orderby' => $_GET['orderby'] ), $link );
            }

            return $link;
        }

    }
}
