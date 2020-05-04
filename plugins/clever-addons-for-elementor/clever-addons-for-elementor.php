<?php namespace CleverAddonsForElementor;

/**
 * Plugin Name: Clever Addons for Elementor
 * Plugin URI:  http://www.zootemplate.com/wordpress-plugins/clever-addons-for-elementor
 * Description: An ultimate addon for Elementor Page Builder.
 * Author:      CleverSoft
 * Version:     1.0.1.9
 * Text Domain: cafe
 * Domain Path: /languages/
 * Requires PHP: 5.6
 */

use Exception;

/**
 * Plugin container.
 */
final class Plugin
{
    /**
     * Version
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * Option key
     *
     * @var string
     */
    const OPTION_NAME = 'cafe_plugin_settings';

    /**
     * Settings
     *
     * @var array
     */
    private $settings;

    /**
     * Constructor
     */
    function __construct(array $settings = [])
    {
        $this->settings = $settings;

        // Define constants.
        define('CAFE_DIR', __DIR__ . '/');
        define('CAFE_URI', plugins_url('/', __FILE__));

        // Bind important events.
        add_action('plugins_loaded', [$this, '_install'], 10, 0);
        add_action('activate_clever-addons-for-elementor/clever-addons-for-elementor.php', [$this, '_activate']);
        add_action('deactivate_clever-addons-for-elementor/clever-addons-for-elementor.php', [$this, '_deactivate']);
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
            throw new Exception(__('Invalid setting!', 'cafe'));
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
				    $message = __('<strong>Clever Elementor Addon</strong> requires Elementor Page Builder plugin to be active. Please install and activate Elementor Page Builder!', 'cafe');
				    $button_text = __('Activate Elementor', 'cafe');
			    } else {
				    if(!current_user_can('activate_plugins')) return;
				    $activation_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
				    $message = __('<strong>Clever Elementor Addon</strong> requires Elementor Page Builder plugin to be active. Please install and activate Elementor Page Builder!', 'cafe');
				    $button_text = __('Install Elementor', 'cafe');
			    }
			    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
			    printf('<div class="error"><p>%1$s</p>%2$s</div>', $message, $button);
		    }, 10, 0);
	    }

        // Make sure translation is available.
        if ( function_exists( 'determine_locale' ) ) {
            $locale = determine_locale();
        } else {
            // @todo Remove when start supporting WP 5.0 or later.
            $locale = is_admin() ? get_user_locale() : get_locale();
        }

        $locale = apply_filters( 'plugin_locale', $locale, 'subscribe2' );

        load_textdomain( 'cafe', CAFE_DIR . '/languages/cafe-'.$locale.'.mo' );
        load_plugin_textdomain('cafe', false, CAFE_DIR.'languages');

        if (is_admin()) {
            require CAFE_DIR.'src/class-cafe-settings-page.php';
        }

        // Load resources.
        require CAFE_DIR.'src/class-clever-elements-category.php';
        require CAFE_DIR.'src/class-clever-widgets-manager.php';
        require CAFE_DIR.'src/class-clever-assets-manager.php';
        require CAFE_DIR.'src/class-clever-controls-manager.php';
        require CAFE_DIR.'src/helpers/helper.php';

        if (class_exists('WooCommerce')) {
            require CAFE_DIR . 'src/helpers/wc.php';
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
