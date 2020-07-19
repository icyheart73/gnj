<?php namespace GanjeAddonsForElementor;

/**
 * Plugin Name: المان های قالب گنجه برای افزونه المنتور
 * Plugin URI:  http://ganje.avin-tarh.ir
 * Description: این پلاگین المان های اختصاصی قالب گنجه را به صفحه ساز المنتور اضافه میکند.
 * Author:      Avin-Tarh
 * Version:     1.0.0
 * Text Domain: gnje
 * Domain Path: /languages/
 * Requires PHP: 5.6
 */

use Exception;

/**
 * Plugin container.
 */
final class Plugin
{

    const VERSION = '1.0.0';
    const OPTION_NAME = 'gnje_plugin_settings';
    private $settings;

    /**
     * Constructor
     */
    function __construct(array $settings = [])
    {
        $this->settings = $settings;

        // Define constants.
        define('GNJE_DIR', __DIR__ . '/');
        define('GNJE_URI', plugins_url('/', __FILE__));

        // Bind important events.
        add_action('plugins_loaded', [$this, '_install'], 10, 0);
        add_action('activate_ganje-addons-for-elementor/ganje-addons-for-elementor.php', [$this, '_activate']);
        add_action('deactivate_ganje-addons-for-elementor/ganje-addons-for-elementor.php', [$this, '_deactivate']);
    }

    /**
     * Getter
     *
     * @throws InvalidArgumentException
     *
     * @return object
     */
    function __get($key)
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        } else {
            throw new Exception('Invalid setting!');
        }
    }

    /**
     * Do activation
     *
     * @internal Used as a callback.
     *
     * @see https://developer.wordpress.org/reference/functions/register_activation_hook/
     *
     * @param bool $network Whether to activate this plugin on network or a single site.
     */
    function _activate($network)
    {
        add_option(self::OPTION_NAME, [

        ]);
    }

    /**
     * Do installation
     *
     * @internal Used as a callback.
     *
     * @see https://developer.wordpress.org/reference/hooks/plugins_loaded/
     */
    function _install()
    {
	    if(!did_action('elementor/loaded')) {
		    add_action('admin_notices', function() {
			    if(!is_plugin_active('elementor/elementor.php')) {
				    if(!current_user_can('activate_plugins')) return;
				    $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=elementor/elementor.php&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_elementor/elementor.php');
				    $message = '<strong>المان های گنجه المنتور</strong> نیازمند نصب و فعال سازی افزونه المنتور می باشد.!';
				    $button_text = 'فعال سازی المنتور';
			    } else {
				    if(!current_user_can('activate_plugins')) return;
				    $activation_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
				    $message = '<strong>المان های گنجه المنتور</strong> نیازمند نصب و فعال سازی افزونه المنتور می باشد.!';
				    $button_text = 'نصب المنتور';
			    }
			    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
			    printf('<div class="error"><p>%1$s</p>%2$s</div>', $message, $button);
		    }, 10, 0);
	    }

        if (is_admin()) {
            require GNJE_DIR.'src/class-gnje-settings-page.php';
        }

        // Load resources.
        require GNJE_DIR.'src/class-ganje-elements-category.php';
        require GNJE_DIR.'src/class-ganje-widgets-manager.php';
        require GNJE_DIR.'src/class-ganje-assets-manager.php';
        require GNJE_DIR.'src/class-ganje-controls-manager.php';
        require GNJE_DIR.'src/helpers/helper.php';

        if (class_exists('WooCommerce')) {
            require GNJE_DIR . 'src/helpers/wc.php';
        }
    }

    /**
     * Do deactivation
     *
     * @internal Used as a callback.
     *
     * @see https://developer.wordpress.org/reference/functions/register_deactivation_hook/
     *
     * @param bool $network  Whether to deactivate this plugin on network or a single site.
     */
    function _deactivate($network)
    {

    }

    /**
     * Pre-activation check
     *
     * @throws Exception
     */
    private function preActivate()
    {
        if (version_compare(PHP_VERSION, '5.6', '<')) {
            throw new Exception('This plugin requires PHP version 5.6 at least!');
        }

        if (version_compare($GLOBALS['wp_version'], '4.7', '<')) {
            throw new Exception('This plugin requires WordPress version 4.7 at least!');
        }

        // if (version_compare(ELEMENTOR_VERSION, '2.4.6', '<')) {
        //     throw new Exception('This plugin requires Elementor Page Builder version 2.4.6 at least!');
        // }

        if (!class_exists('Elementor\Plugin')) {
            throw new Exception('This plugin requires Elementor Page Builder version 2.3.2 at least. Please install and activate the latest version of Elementor Page Builder!');
        }
    }
}

// Initialize plugin.
return new Plugin((array)get_option(Plugin::OPTION_NAME, []));
