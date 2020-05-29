<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

class Ganje_Sharing {

    private static $instance = null;
    private $setting;
    /**
     * Path to template folder
     *
     * @since 1.0.0
     */
    public $template_path = GNJ_PATH . '/public/partials/ganje-sharing/';



    public function __construct() {
        $this->get_Settings();

        //-> Ajax Sharing events
        add_action( 'wp_ajax_thf_woocommerce_sharing', [ $this, 'process_ajax_request' ] );
        add_action( 'wp_ajax_nopriv_thf_woocommerce_sharing', [ $this, 'process_ajax_request' ] );

        //-> Show Share Button
        add_action( 'woocommerce_product_thumbnails', array( $this, 'show_in_single_product' ), 20 );
    }

    public function get_Settings() {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Ganje_Sharing();
        }
        return self::$instance;
    }

    /**
     * Check is active
     *
     * @since   1.0.0
     * @static
     * @return  boolean
     */
    public function is_active() {

        if(isset($this->setting['share_product']) && $this->setting['share_product'] =='on')
            return true;
        return false;
    }

    /**
     * @return mixed
     */
    public function email_is_active() {
        if(isset($this->setting['share_email_product']) && $this->setting['share_email_product']=='on')
            return true;
        return false;
    }


    /**
     * @return mixed
     */
    public function sms_is_active() {
        if(isset($this->setting['share_sms_product']) && $this->setting['share_sms_product']=='on')
            return true;
        return false;
    }


    /**
     * @since 1.0.0
     */
    public function process_ajax_request() {

        ganje_check_ajax_referer();

        $json        = [];
        $errors      = [];
        $tcw_sharing = $_POST['tcw_sharing'];

        if ( !empty( $tcw_sharing ) ) {

            $product_id = (int)esc_sql( $tcw_sharing['product_id'] );
            $user_email = strval( preg_replace( '/\s+/', '', $tcw_sharing['email'] ) );
            $user_phone = strval( preg_replace( '/\s+/', '', $tcw_sharing['sms'] ) );

            // Check Product ID
            if ( empty( $product_id ) ) {
                $errors[] = __( 'Product not found!.', TCW_TEXTDOMAIN );
            }

            // Check Email
            if ( !empty( $user_email ) && !is_email( $user_email ) ) {
                $errors[] = __( 'Email is Invalid!.', TCW_TEXTDOMAIN );
            }

            // Check Phone
            if ( !empty( $user_phone ) && !is_valid_mobile( $user_phone ) ) {
                $errors[] = __( 'Phone is Invalid!.', TCW_TEXTDOMAIN );
            }

            if ( empty( $user_email ) && empty( $user_phone ) ) {
                $errors[] = __( 'Please select at least one of the items.', TCW_TEXTDOMAIN );
            }

            if ( empty( $errors ) ) {
                $product = wc_get_product( $product_id );

                // Send Email
                if ( !empty( $user_email ) ) {
                    if ( $this->send_mail( $user_email, $product ) ) {
                        $json['msg'][] = __( 'The email was successfully sent to your friend.', TCW_TEXTDOMAIN );
                    } else {
                        $errors[] = __( 'Unexpected error. Email not sent. Please try again later.', TCW_TEXTDOMAIN );
                    }
                }

                // Send SMS
                if ( !empty( $user_phone ) ) {
                    if ( $this->send_sms( $user_phone, $product ) ) {
                        $json['msg'][] = __( 'The sms was successfully sent to your friend.', TCW_TEXTDOMAIN );
                    } else {
                        $errors[] = __( 'Unexpected error. SMS not sent. Please try again later.', TCW_TEXTDOMAIN );
                    }
                }
            }
        }

        if ( empty( $errors ) ) {
            wp_send_json_success( $json );
        } else {
            $json['msg'] = $errors;

            wp_send_json_error( $json );
        }
    }

    /**
     * @param string|array $to
     * @param WC_Product   $product Product Object.
     * @since 1.0.0
     * @return boolean
     */
    public function send_mail( $to, $product ) {
        $subject = $this->get_template( 'mail.subject', $product );
        $message = $this->get_template( 'mail.content', $product );
        $from    = 'Gange Admin';//TCW::get_option( 'wc_sharing_email_from', false );
        $headers = [];

        if ( $from ) $headers[] = 'From: ' . $from;

        if ( is_array( $to ) ) {
            $headers[] = 'Bcc:' . implode( ',', $to );
            $to        = null;
        }

        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        $mail = wp_mail( $to, $subject, $message, $headers );

        if ( !is_wp_error( $mail ) ) {
            return true;
        }

        return false;
    }

    /**
     * @param string     $type    What the message is for. Valid values are 'mail.subject', 'mail.content'.
     * @param WC_Product $product Product Object.
     * @since 1.0.0
     * @return mixed
     */
    public function get_template( $type, $product ) {
        if ( $type === 'mail.subject' ) {
            $template = 'Esubject';//TCW::get_option( 'wc_sharing_email_subject' );
        } elseif ( $type === 'mail.content' ) {
            $template = 'Econtent';//TCW::get_option( 'wc_sharing_email_content' );
        } elseif ( $type === 'sms' ) {
            $template = 'Etemp';
        }

        if ( !empty( $template ) ) {
            $find = [
                '{site_title}',
                '{site_url}',
                '{product_id}',
                '{product_url}',
                '{product_title}',
                '{product_image}',
                '{regular_price}',
                '{onsale_price}',
                '{onsale_from}',
                '{onsale_to}',
                '{sku}',
                '{stock}',
            ];

            $replace = [
                get_bloginfo( 'name' ),
                site_url(),
                $product->get_id(),
                wp_get_shortlink( $product->get_id() ),
                $product->get_title(),
                $product->get_image(),
                $product->get_regular_price(),
                $product->get_sale_price(),
                $product->get_date_on_sale_from(),
                $product->get_date_on_sale_to(),
                $product->get_sku(),
                $product->get_stock_quantity(),
            ];

            $template = str_replace( $find, $replace, $template );

            return $template;
        }

        return false;
    }

    /**
     * Sharing Subscribe Modal
     *
     * @since 1.0.0
     */
    public function get_share_html() {
        $product_id            = get_the_ID();
        $product_title         = get_the_title();
        $product_link          = get_permalink();
        $product_shortlink     = wp_get_shortlink( $product_id );
        $email_is_active       = $this->email_is_active();
        $sms_is_active         = $this->sms_is_active();

        $share_title = urlencode( $product_title );
        $share_link  = urlencode( $product_link );

        // Compose the share links for Facebook, Twitter and Google+
        $twitter_link     = sprintf( 'https://twitter.com/intent/tweet?text=%2$s&url=%1$s', $share_link, $share_title );
        $facebook_link    = sprintf( 'https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=%1$s', $share_link );
        $google_plus_link = sprintf( 'https://plus.google.com/share?url=%1$s', $share_link );
        $telegram_link    = sprintf( 'https://telegram.me/share/url?url=%1$s', $share_link );

        $data = compact( 'product_id', 'product_title', 'product_link', 'product_shortlink', 'twitter_link', 'facebook_link', 'google_plus_link', 'telegram_link', 'email_is_active', 'sms_is_active', 'twitter_is_active', 'facebook_is_active', 'google_plus_is_active', 'telegram_is_active' );

        gnj_get_template_part( $this->template_path . 'sharing-modal.php', $data );
    }

    /**
     * Show sharing subscribe button in single product
     *
     * @since  1.0.0
     * @action woocommerce_single_product_summary, woocommerce_product_thumbnails
     */
    public function show_in_single_product() {
        if ( !get_the_ID() ) return;

        $this->get_shortcode_content();
    }

    /**
     * Get shortcode content
     *
     * @param string $template
     * @since 1.0.0
     */
    public function get_shortcode_content() {

        $this->get_button_html();
        $this->get_modal_html();

    }

    /**
     * Sharing Subscribe Button
     *
     * @since 1.0.0
     */
    public function get_button_html() {
        $sharing_button_text = 'sharing';//TCW::get_option( 'wc_sharing_button_text', esc_html__( 'Share', TCW_TEXTDOMAIN ) );
        $data                = compact( 'sharing_button_text' );

        gnj_get_template_part( $this->template_path . 'sharing-button.php', $data );
    }


    /**
     * Sharing Subscribe Modal
     *
     * @since 1.0.0
     */
    public function get_modal_html() {
        $product_id            = get_the_ID();
        $product_title         = get_the_title();
        $product_link          = get_permalink();
        $product_shortlink     = wp_get_shortlink( $product_id );
        $email_is_active       = $this->email_is_active();
        $sms_is_active         = $this->sms_is_active();
       /* $twitter_is_active     = $this->icon_is_active( 'twitter' );
        $facebook_is_active    = $this->icon_is_active( 'facebook' );
        $google_plus_is_active = $this->icon_is_active( 'google_plus' );
        $telegram_is_active    = $this->icon_is_active( 'telegram' );*/

        $share_title = urlencode( $product_title );
        $share_link  = urlencode( $product_link );

        // Compose the share links for Facebook, Twitter and Google+
        $twitter_link     = sprintf( 'https://twitter.com/intent/tweet?text=%2$s&url=%1$s', $share_link, $share_title );
        $facebook_link    = sprintf( 'https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=%1$s', $share_link );
        $google_plus_link = sprintf( 'https://plus.google.com/share?url=%1$s', $share_link );
        $telegram_link    = sprintf( 'https://telegram.me/share/url?url=%1$s', $share_link );

        $data = compact( 'product_id', 'product_title', 'product_link', 'product_shortlink', 'twitter_link', 'facebook_link', 'google_plus_link', 'telegram_link', 'email_is_active', 'sms_is_active', 'twitter_is_active', 'facebook_is_active', 'google_plus_is_active', 'telegram_is_active' );

        gnj_get_template_part( $this->template_path . 'sharing-modal.php', $data );
    }


}
Ganje_Sharing::getInstance();
