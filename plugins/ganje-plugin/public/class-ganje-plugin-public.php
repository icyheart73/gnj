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
class Ganje_Plugin_Public
{


    private $plugin_name;
    private $setting;


    private $version;


    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->get_Settings();
        $this->load_dependencies();

    }

    public function get_Settings()
    {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    private function load_dependencies()
    {

        if (!class_exists('Persian_Woocommerce_Core')) {

            require_once GNJ_PATH . '/public/public-class/wc-persian.php';
        }

        require_once GNJ_PATH . '/public/public-class/view-product-meta.php';

        require_once GNJ_PATH . '/public/function-helper.php';

        require_once GNJ_PATH . '/public/public-class/view-product-addons.php';
        require_once GNJ_PATH . '/public/public-class/ganje-sharing-product.php';

        if ($this->setting['free_price'] == 'on') {

            require_once GNJ_PATH . '/public/public-class/ganje-single-product-free-price.php';
        }
        if ($this->setting['product_qa'] == 'on') {

            require_once GNJ_PATH . '/public/public-class/question-answer/view-product-qa.php';
            require_once GNJ_PATH . '/public/public-class/question-answer/class-ganje-discussion.php';
            require_once GNJ_PATH . '/public/public-class/question-answer/class-ganje-question.php';
            require_once GNJ_PATH . '/public/public-class/question-answer/class-ganje-answer.php';

        }

        if (class_exists('WoocommerceIR_SMS_Helper') && $this->setting['otp'] == 'on') {

            require_once GNJ_PATH . '/public/public-class/otp/otp.php';
        }

        require_once GNJ_PATH . '/public/public-class/calling-order/ganje-calling-order.php';
        require_once GNJ_PATH . '/public/public-class/wish-list/ganje-wishlist.php';

    }

    public function enqueue_styles()
    {


        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ganje-plugin-public.css', array(), $this->version, 'all');
        wp_enqueue_style('sweetalert2CSS', plugin_dir_url(__FILE__) . 'css/sweetalert2.min.css', array(), $this->version, 'all');

    }


    public function enqueue_scripts()
    {

        wp_enqueue_script('gnj-scripts', plugin_dir_url(__FILE__) . 'js/ganje-plugin-public.js', array('jquery'), $this->version, true);
        wp_enqueue_script('gnj-handlebar', plugin_dir_url(__FILE__) . 'js/handlebars.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script('sweetalert2', plugin_dir_url(__FILE__) . 'js/sweetalert2.min.js', array('jquery'), $this->version, true);
        wp_localize_script(
            'gnj-scripts',
            'gnj_scripts',
            array(
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('gnj-nonce'),
                'boxList' => GNJ_URL . '/public/public-class/wish-list/view/box-list.html',
                'button' => GNJ_URL . '/public/public-class/wish-list/view/button.html',
                'loading_icon' => 'dfgdfgfdg',
            )
        );

	}

}
