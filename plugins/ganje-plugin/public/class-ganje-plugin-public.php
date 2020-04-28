<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.ganje-wp.ir
 * @since      1.0.0
 *
 * @package    Ganje_Plugin
 * @subpackage Ganje_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ganje_Plugin
 * @subpackage Ganje_Plugin/public
 * @author     Ganje <Ganje@gmail.com>
 */
class Ganje_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->load_dependencies();

	}

    private function load_dependencies() {
        /**
         * Required: include OptionTree.
         */
        if ( ! class_exists( 'Persian_Woocommerce_Core' ) ) {

            require_once GNJ_PATH . '/public/public-class/wc-persian.php';
        }
            if(is_product()) {
                require_once GNJ_PATH . '/public/public-class/view-product-meta.php';
                echo 'amir';
            }
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ganje_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ganje_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ganje-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ganje_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ganje_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ganje-plugin-public.js', array( 'jquery' ), $this->version, false );

	}

}
