<?php


/**
 * Loading All CSS Stylesheets and Javascript Files
 *
 * @since v1.0
 */


class Ganje_style
{
    private static $instance = null;
    private $setting;

    public function __construct()
    {
       add_action( 'wp_enqueue_scripts',  array($this, 'ganje_scripts_loader') , 20 );
    }

    public function get_Settings()
    {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Ganje_style();
        }
        return self::$instance;
    }

    function ganje_scripts_loader() {
        $theme_version = wp_get_theme()->get( 'Version' );

        // 1. Styles
        wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', false, $theme_version, 'all' );
        wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css', false, $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles

        //Ganje Style
        wp_enqueue_style( 'ganje', get_template_directory_uri() . '/assets/css/ganje.css', false, $theme_version, 'all' );


        if ( is_rtl() ) {
            wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.css', false, $theme_version, 'all' );
        }

        // 2. Scripts
        wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.bundle.js', array( 'jquery' ), $theme_version, true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

}

Ganje_style::getInstance();