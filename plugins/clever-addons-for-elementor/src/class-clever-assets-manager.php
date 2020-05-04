<?php namespace CleverAddonsForElementor;

/**
 * AssetsManager
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class AssetsManager
{
    /**
     * Nope constructor
     */
    private function __construct()
    {

    }

    /**
     * Singleton
     */
    static function instance($return = false)
    {
        static $self = null;

        if (null === $self) {
            $self = new self;
            add_action('admin_enqueue_scripts', [$self, '_loadAdminAssets']);
            add_action('elementor/frontend/after_register_styles', [$self, '_afterRegisterFrontendStyles'], 10, 0);
            add_action('elementor/frontend/after_register_scripts', [$self, '_afterRegisterFrontendScripts'], 10, 0);
            add_action('elementor/frontend/after_enqueue_styles', [$self, '_afterEnqueueFrontendStyles'], 10, 0);
            add_action('elementor/frontend/before_enqueue_scripts', [$self, '_beforeEnqueueFrontendScripts'], 10, 0);
            add_action('elementor/editor/after_enqueue_styles', [$self, '_afterEnqueueEditorStyles'], 10, 0);
            add_action('elementor/editor/after_register_scripts', [$self, '_afterRegisterEditorScripts'], 10, 0);
            add_action('elementor/editor/before_enqueue_scripts', [$self, '_beforeEnqueueEditorScripts'], 10, 0);
        }

        if ($return) {
            return $self;
        }
    }

    /**
     * Register and enqueue admin assets
     *
     * @internal Used as a callback.
     */
    function _loadAdminAssets($hook_suffix)
    {
        if ('cafe-plugin-settings' === $hook_suffix) {
            wp_enqueue_style('cafe-admin', CAFE_URI.'assets/css/admin.min.css', [], Plugin::VERSION);
            wp_enqueue_script('cafe-admin', CAFE_URI.'assets/js/admin.min.js', [], Plugin::VERSION);
        }
    }

    /**
     * Register frontend stylesheets
     *
     * @internal Used as a callback.
     */
    function _afterRegisterFrontendStyles()
    {
        wp_register_style('cleverfont', CAFE_URI.'assets/vendor/cleverfont/style.css', [], Plugin::VERSION);
    }

    /**
     * Register frontend scripts
     *
     * @internal Used as a callback.
     */
    function _afterRegisterFrontendScripts()
    {
	    wp_register_script( 'vimeoapi', 'https://player.vimeo.com/api/player.js', true );
	    wp_register_script( 'youtube-api', 'https://www.youtube.com/player_api', true );
	    wp_register_script('typed', CAFE_URI.'assets/vendor/typed/typed.min.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('countdown', CAFE_URI.'assets/vendor/countdown/countdown.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('spritespin', CAFE_URI.'assets/vendor/spritespin/spritespin.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('infinite-scroll', CAFE_URI.'assets/vendor/infinite-scroll/infinite-scroll.pkgd.min.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('twentytwenty', CAFE_URI.'assets/vendor/twentytwenty/jquery.twentytwenty.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('event-move', CAFE_URI.'assets/vendor/twentytwenty/jquery.event.move.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('cafe-script', CAFE_URI.'assets/js/frontend.min.js', ['jquery-core'], Plugin::VERSION, true);
        wp_register_script('swiper-script', CAFE_URI.'assets/js/swiper-script.js', [ 'elementor-frontend' , 'swiper' ], Plugin::VERSION, true);
    }

    /**
     * @internal Used as a callback
     */
    function _afterRegisterEditorScripts()
    {
        $this->_afterRegisterFrontendScripts();
    }

    /**
     * Enqueue frontend stylesheets
     *
     * @internal Used as a callback.
     */
    function _afterEnqueueFrontendStyles()
    {
        wp_enqueue_style('cleverfont');
        wp_enqueue_style('cafe-style', CAFE_URI.'assets/css/frontend.min.css', [], Plugin::VERSION);
    }

    /**
     * @internal Used as a callback.
     */
    function _afterEnqueueEditorStyles()
    {
        $this->_afterEnqueueFrontendStyles();
    }

    /**
     * Enqueue frontend dev scripts
     *
     * @ignore For dev purpose only. Will be removed later.
     * @internal Used as a callback.
     */
    function _beforeEnqueueFrontendScripts()
    {
        wp_localize_script('cafe-script', 'cafeFrontendConfig', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('CleverAddonsForElementorFrontendNonce'),
        ]);

        wp_enqueue_script('cafe-script');
    }

    /**
     * @internal Used as a callback.
     */
    function _beforeEnqueueEditorScripts()
    {

    }
}

// Initialize.
AssetsManager::instance();
