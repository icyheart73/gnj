<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.ganje-wp.ir
 * @since      1.0.0
 *
 * @package    Ganje_Plugin
 * @subpackage Ganje_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ganje_Plugin
 * @subpackage Ganje_Plugin/admin
 * @author     Ganje <Ganje@gmail.com>
 */
class Ganje_Plugin_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
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
		require_once GNJ_PATH . '/admin/option-tree/ot-loader.php';
		require_once GNJ_PATH . '/admin/theme-options.php';
		require_once GNJ_PATH . '/admin/meta-ganje.php';
		require_once GNJ_PATH . '/admin/admin-class/wc-persian.php';
		require_once GNJ_PATH . '/admin/function-helper.php';

	}

	public function disable_ui_option(){
		/* Lets OptionTree know the UI Builder is being overridden */
		global $ot_has_custom_theme_options;
		$ot_has_custom_theme_options = true;
	}

	public function ganje_theme_option(){
		include ('theme-options.php');
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ganje-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ganje-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

}
