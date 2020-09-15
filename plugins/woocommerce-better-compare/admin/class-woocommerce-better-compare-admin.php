<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://woocommerce.db-dzine.com
 * @since      1.0.0
 *
 * @package    WooCommerce_Better_Compare
 * @subpackage WooCommerce_Better_Compare/admin
 * @author     Daniel Barenkamp <support@db-dzine.com>
 */

class WooCommerce_Better_Compare_Admin extends WooCommerce_Better_Compare {


	protected $plugin_name;


	protected $version;


	public function __construct( ) {


		$this->notice = "";

	}


    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name.'-admin', plugin_dir_url(__FILE__).'css/woocommerce-better-compare-admin.css', array(), $this->version, 'all');
    }


    public function load_extensions()
    {
        if(!is_admin() || !current_user_can('administrator') || (defined('DOING_AJAX') && DOING_AJAX && !$_POST['action'] == "woocommerce_better_compare_options_ajax_save")){
            return false;
        }

        // Load the theme/plugin options
        if (file_exists(plugin_dir_path(dirname(__FILE__)).'admin/options-init.php')) {
            require_once plugin_dir_path(dirname(__FILE__)).'admin/options-init.php';
        }
    }

	
    public function init()
    {
    	global $woocommerce_better_compare_options;

        if(!is_admin() || !current_user_can('administrator') || (defined('DOING_AJAX') && DOING_AJAX)){
            $woocommerce_better_compare_options = get_option('woocommerce_better_compare_options');
        }

        $this->options = $woocommerce_better_compare_options;
    }


    public function register_widgets()
    {
        //register_widget( 'WooCommerce_Better_Compare_Widget' );
       // register_widget( 'WooCommerce_Better_Compare_Autocomplete_Widget' );
    }
}
