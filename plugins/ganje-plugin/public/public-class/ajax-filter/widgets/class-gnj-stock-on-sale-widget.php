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

if ( ! class_exists( 'GNJ_Stock_On_Sale_Widget' ) ) {
    /**
     * YITH_WCAN_Sort_By_Widget
     *
     * @since 1.0.0
     */
    class GNJ_Stock_On_Sale_Widget extends WP_Widget {

        protected $_id_base = 'gnj-ajax-navigation-stock-on-sale';

        public function __construct() {
            $widget_ops  = array( 'classname' => 'gnj-woocommerce-ajax-product-filter gnj-stock-on-sale', 'description' => 'ابزارک نمایش محصولات موجود و تخفیف خرده گنجه' );
            $control_ops = array( 'width' => 400, 'height' => 350 );
            parent::__construct( 'gnj-ajax-navigation-stock-on-sale', '* موجود / حراج گنجه' , $widget_ops, $control_ops );

            if ( ! is_admin() ) {
                $sidebars_widgets = wp_get_sidebars_widgets();
                $regex            = '/^gnj-ajax-navigation-stock-on-sale-\d+/';

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
            add_action( 'woocommerce_product_query', array( $this, 'show_in_stock_products' ) );
            add_filter( 'woocommerce_layered_nav_link', array( $this, 'stock_on_sale_filter_args' ),15 );
            add_filter( 'loop_shop_post_in', array( $this, 'show_on_sale_products' ) );

            /* === WooCommerce Shop page Display Option Check === */
            add_filter('woocommerce_product_subcategories_args', array( $this,  'force_to_show_products_instead_of_cateories_in_shop_page' ), 99 );
        }

        public function widget( $args, $instance ) {
            global $wp_query;
            if( ! gnj_can_be_displayed() ){
                return;
            }

            if( empty( $instance['onsale'] ) && empty( $instance['instock'] ) ) {
                return;
            }

            $_attributes_array = gnj_get_product_taxonomy();

            if ( is_search() ) {
                return;
            }

            if ( ! is_post_type_archive( 'product' ) && ! is_tax( $_attributes_array ) ) {
                return;
            }

            $found_onsale_products = false;
            $onsale_ids            = wc_get_product_ids_on_sale();

            $on_sale_products_in_current_selection = array_intersect( Ganje_Ajax_Filter::getInstance()->frontend->layered_nav_product_ids, $onsale_ids );

            if ( ! empty( $on_sale_products_in_current_selection ) ) {
                $found_onsale_products = true;
            }

            extract( $instance );
            extract( $args );

            $shop_page_uri = gnj_get_woocommerce_layered_nav_link();

            $filter_value_args = array(
                'queried_object' => get_queried_object()
            );

            $filter_value = gnj_get_filter_args( $filter_value_args );

            $shop_page_uri = add_query_arg( $filter_value, $shop_page_uri );
            $onsale_text   = 'محصولات تخفیف خرده';
            $instock_text  = 'محصولات موجود';

            $onsale_class  =  ! empty( $_GET['onsale_filter'] ) ? 'gnj-onsale-button active' : 'gnj-onsale-button';
            $instock_class = ! empty( $_GET['instock_filter'] ) ? 'gnj-instock-button active' : 'gnj-instock-button';

            echo $before_widget;

            $title = apply_filters( 'widget_title', $title );

            if ( $title ) {
                echo $before_title .$title. $after_title;
            }

            echo '<ul class="gnj-stock-on-sale">';

            if( $found_onsale_products && $instance['onsale'] ){
                $filter_link = ! empty( $_GET['onsale_filter'] ) ? remove_query_arg( 'onsale_filter', $shop_page_uri ) : add_query_arg( array( 'onsale_filter' => 1 ), $shop_page_uri );
                $filter_link = preg_replace("/page\/[0-9]*\//", "", $filter_link);
                echo '<li><a rel="nofollow" href="' . esc_url( $filter_link ) . '" class="' . $onsale_class . '">' . $onsale_text . '</a></li>';
            }

            if( $instance['instock'] ){
                $instock_link = ! empty( $_GET['instock_filter'] ) ? remove_query_arg( 'instock_filter', $shop_page_uri ) : add_query_arg( array( 'instock_filter' => 1 ), $shop_page_uri );
                $instock_link = preg_replace("/page\/[0-9]*\//", "", $instock_link);
                echo '<li><a rel="nofollow" href="' . esc_url( $instock_link ) . '" class="' . $instock_class . '">' . $instock_text . '</a></li>';
            }

            echo '</ul>';
            echo $after_widget;
        }


        public function form( $instance ) {
            $defaults = array(
                'title'         => 'فیلتر بر اساس :',
                'onsale'        => 1,
                'instock'       => 1
            );

            $instance = wp_parse_args( (array) $instance, $defaults );
            ?>

            <p>
                <label>
                    <strong>عنوان :</strong><br />
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
                </label>
            </p>

             <p id="gnj-onsale-<?php echo $instance['onsale'] ? 'enabled' : 'disabled' ?>" class="yith-wcan-onsale">
                <label for="<?php echo $this->get_field_id( 'onsale' ); ?>">نمایش فیلتر محصولات تخفیف خرده :
                    <input type="checkbox" id="<?php echo $this->get_field_id( 'onsale' ); ?>" name="<?php echo $this->get_field_name( 'onsale' ); ?>" value="1" <?php checked( $instance['onsale'], 1, true )?> class="yith-wcan-onsalen-check widefat" />
                </label>
            </p>

             <p id="gnj-instock-<?php echo $instance['instock'] ? 'enabled' : 'disabled' ?>" class="yith-wcan-instock">
                <label for="<?php echo $this->get_field_id( 'instock' ); ?>">نمایش فیلتر محصولات موجود :
                    <input type="checkbox" id="<?php echo $this->get_field_id( 'instock' ); ?>" name="<?php echo $this->get_field_name( 'instock' ); ?>" value="1" <?php checked( $instance['instock'], 1, true )?> class="yith-wcan-instockn-check widefat" />
                </label>
            </p>
        <?php
        }

        public function stock_on_sale_filter_args( $link ){
            if ( ! empty( $_GET['onsale_filter'] ) ) {
                $link = add_query_arg( array( 'onsale_filter' => $_GET['onsale_filter'] ), $link );
            }

            if ( ! empty( $_GET['instock_filter'] ) ) {
                $link = add_query_arg( array( 'instock_filter' => $_GET['instock_filter'] ), $link );
            }

            return $link;
        }

        public function show_in_stock_products( $q ) {
            $current_widget_options = $this->get_settings();

            if ( ! empty( $_GET['instock_filter'] ) && ! empty( $current_widget_options[ $this->number ]['instock'] ) ) {
                //in stock products
                $meta_query = array(
                        'relation' => 'AND',
                        array(
                            'key'     => '_stock_status',
                            'value'   => 'instock',
                            'compare' => '='
                        ),
                    );

                $q->set( 'meta_query', array_merge( WC()->query->get_meta_query(), $meta_query ) );
            }
        }

        public function show_on_sale_products( $ids ) {
            $current_widget_options = $this->get_settings();

            if ( ! empty( $_GET['onsale_filter'] ) && ! empty( $current_widget_options[$this->number]['onsale'] ) ) {
                $ids = array_merge( $ids, wc_get_product_ids_on_sale() );
            }
            return $ids;
        }

        public function update( $new_instance, $old_instance ) {

            $instance = $old_instance;

            $instance['title']          = strip_tags( $new_instance['title'] );
            $instance['onsale']         = isset( $new_instance['onsale'] ) ? 1 : 0;
            $instance['instock']        = isset( $new_instance['instock'] ) ? 1 : 0;
            return $instance;
        }

        public function force_to_show_products_instead_of_cateories_in_shop_page( $args ){
            $show_categories_in_shop_page       = 'subcategories' === get_option( 'woocommerce_shop_page_display' );
            $stock_onsale_filter_enabled        = ( isset( $_GET['instock_filter'] ) || isset( $_GET['onsale_filter'] ) );

            if ($show_categories_in_shop_page && is_shop() && $stock_onsale_filter_enabled) {

                $args['include'] = -1;
            }
            return $args;
        }
    }
}
