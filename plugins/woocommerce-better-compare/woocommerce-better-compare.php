<?php

/**
* The plugin bootstrap file
*
 * This file is read by WordPress to generate the plugin information in the plugin
* admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.ganje-wp.ir
 * @since             1.0.0
* @package           Ganje_Extra_Plugin
*
 * @wordpress-plugin
* Plugin Name:       Ganje_Compare & Attribute Groups
* Plugin URI:        http://www.ganje-wp.ir
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ganje
 * Author URI:        http://www.ganje-wp.ir
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ganje-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-better-compare.php';



if ( !class_exists( 'ReduxFramework' ) && file_exists( plugin_dir_path( __FILE__ ) . 'redux-framework/redux-core/framework.php' ) ) {

    require_once plugin_dir_path( __FILE__ ) . 'redux-framework/redux-core/framework.php';
}

function run_WooCommerce_Better_Compare() {

	$plugin_data = get_plugin_data( __FILE__ );
	$version = $plugin_data['Version'];

	$plugin = new WooCommerce_Better_Compare($version);
	$plugin->run();

	return $plugin;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$WooCommerce_Better_Compare = run_WooCommerce_Better_Compare();



require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-group-attributes.php';


function run_WooCommerce_Group_Attributes() {

    $plugin_data = get_plugin_data( __FILE__ );
    $version = $plugin_data['Version'];

    $plugin = new WooCommerce_Group_Attributes($version);
    $plugin->run();

    return $plugin;

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Load the TGM init if it exists
if ( file_exists( plugin_dir_path( __FILE__ ) . 'admin/tgm/tgm-init.php' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'admin/tgm/tgm-init.php';
}


    $WooCommerce_Group_Attributes = run_WooCommerce_Group_Attributes();
