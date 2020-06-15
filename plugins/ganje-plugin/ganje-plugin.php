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
 * @package           Ganje_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Ganje
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
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
add_action('plugins_loaded','run_ganje_plugin',99);

/**
 * Define Plugin Constants.
 *
 * @access  private
 * @since   1.0.0
 */
define( 'GANJE_PLUGIN_VERSION', '1.0.0' );
// Plugin Path
define( 'GNJ_PATH', __DIR__ );

// Plugin URL
define( 'GNJ_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ganje-plugin-activator.php
 */
function activate_ganje_plugin() {
	require_once GNJ_PATH . '/includes/class-ganje-plugin-activator.php';
	new Ganje_Plugin_Activator;
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ganje-plugin-deactivator.php
 */
function deactivate_ganje_plugin() {
	require_once GNJ_PATH . '/includes/class-ganje-plugin-deactivator.php';
	Ganje_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ganje_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_ganje_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require GNJ_PATH . '/includes/class-ganje-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ganje_plugin() {
    $plugin = Ganje_Plugin::getInstance();
    $plugin->run();
}
