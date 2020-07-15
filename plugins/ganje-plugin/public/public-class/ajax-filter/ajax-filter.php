<?php
/**
 * Main class
 */

defined('ABSPATH') || exit; // Exit if accessed directly

if (!class_exists('Ganje_Ajax_Filter')) {
    class Ganje_Ajax_Filter
    {
        /**
         * Frontend object
         *
         * @var string
         * @since 1.0.0
         */
        public $frontend = null;
        private static $instance = null;


        public function __construct()
        {
            /* Register Widget */
            add_action('widgets_init', array($this, 'registerWidgets'));

            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

            $this->init();
        }

        /**
         * Load and register widgets
         *
         * @access public
         * @since  1.0.0
         */
        public function registerWidgets()
        {
            $widgets = array(
                'GNJ_Navigation_Widget',
                'GNJ_Reset_Navigation_Widget',
                'GNJ_Sort_By_Widget',
                'GNJ_Stock_On_Sale_Widget',
                'GNJ_List_Price_Filter_Widget'
            );

            foreach ($widgets as $widget) {
                register_widget($widget);
            }
        }

        /**
         * Load required files
         *
         * @return void
         * @since 1.4
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function init()
        {
            require_once(GNJ_PATH . '/public/public-class/ajax-filter/class-gnj-filter-frontend.php');
            // widget
            require_once(GNJ_PATH . '/public/public-class/ajax-filter/widgets/class-gnj-navigation-widget.php');
            require_once(GNJ_PATH . '/public/public-class/ajax-filter/widgets/class-gnj-reset-navigation-widget.php');
            require_once(GNJ_PATH . '/public/public-class/ajax-filter/widgets/class-gnj-sort-by-widget.php');
            require_once(GNJ_PATH . '/public/public-class/ajax-filter/widgets/class-gnj-stock-on-sale-widget.php');
            require_once(GNJ_PATH . '/public/public-class/ajax-filter/widgets/class-gnj-list-price-filter-widget.php');
            $this->frontend = new GNJ_Filter_Frontend();

        }

        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new Ganje_Ajax_Filter();
            }
            return self::$instance;
        }

        public function enqueue_styles_scripts()
        {
            global $pagenow;

            if ( 'widgets.php' == $pagenow || 'admin.php' == $pagenow ) {
                wp_enqueue_style( 'wp-color-picker' );
                wp_enqueue_script( 'wp-color-picker' );
                wp_enqueue_script( 'ajax_filter_admin', GNJ_URL . '/admin/js/ajax-filter-admin.js', array( 'jquery', 'wp-color-picker' ), true );
            }

            if ( gnj_can_be_displayed() ) {
                wp_enqueue_script( 'gnj_ajx_script', GNJ_URL . 'public/js/ajax-filter-frontend.js', array( 'jquery' ), 1.0 , true );
            }
        }

        /**
         * Get choosen attribute args
         *
         * @return array
         * @since  2.9.3
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function get_layered_nav_chosen_attributes()
        {
            $chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            return $chosen_attributes;
        }
    }
}
Ganje_Ajax_Filter::getInstance();
