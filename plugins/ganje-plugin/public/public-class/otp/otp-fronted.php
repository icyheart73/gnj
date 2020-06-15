<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class OTP_Frontend{

    protected static $_instance = null;
    private $setting;

    public static function get_instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct(){

        echo '111';
        $this->get_Settings();

        if( $this->setting['otp'] === "on" ){
            add_action( 'woocommerce_login_form_end', array( $this, 'wc_login_with_otp_form' ) );
            echo 'eeeee';
        }

        if( $this->setting['otp_verification'] === "on" ){
            add_action( 'woocommerce_register_form_start', array( $this, 'wc_register_phone_input' ) );
            add_action( 'woocommerce_edit_account_form_start', array( $this, 'wc_myaccount_edit_phone_input' ) );
            add_filter(  'gnj_get_phone_forms', array( $this, 'add_wc_register_form_for_phone' ) );
        }

    }

    public function get_Settings(){
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }


    public function add_wc_register_form_for_phone( $register_forms ){
        $register_forms[] = 'woocommerce-register-nonce'; // wc registration
        $register_forms[] = 'save_account_details'; //wc edit account
        return $register_forms;
    }


    public function wc_login_with_otp_form(){
        $args = self::wc_register_phone_input_args();
        return gnj_get_login_with_otp_form( $args );

    }

    public static function wc_register_phone_input_args( $args = array() ){
        $default_args = array(
            'label' 		=> 'تلفن همراه',
            'cont_class' 	=> array(
                'woocommerce-form-row',
                'woocommerce-form-row--wide',
                'form-row form-row-wide'
            ),
            'input_class' 	=> array(
                'woocommerce-Input',
                'input-text',
                'woocommerce-Input--text'
            )
        );
        return wp_parse_args( $args, $default_args );
    }

    public function wc_myaccount_edit_phone_input(){
        return gnj_get_phone_input_field( self::wc_register_phone_input_args(
            array(
                'form_type' 	=> 'update_user',
                'default_phone' => gnj_get_user_phone( get_current_user_id(), 'number' ),
                'default_cc'	=> gnj_get_user_phone( get_current_user_id(), 'code' ),
            )
        ) );
    }

    public function wc_register_phone_input(){
        return gnj_get_phone_input_field( self::wc_register_phone_input_args() );
    }

    public function wc_register_phone_form(){
        return gnj_phone_input_form( self::wc_register_phone_input_args() );
    }

}

OTP_Frontend::get_instance();
