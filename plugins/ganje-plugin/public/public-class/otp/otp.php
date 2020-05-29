<?php
class Ganje_Otp {
    protected static $_instance = null;

    public static function get_instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function __construct(){
        $this->includes();
    }

    /**
     * File Includes
     */
    public function includes(){

        if($this->is_request('frontend')){

            require_once GNJ_PATH.'/public/public-class/otp/otp-fronted.php';
        }

    }


    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined( 'DOING_AJAX' );
            case 'cron':
                return defined( 'DOING_CRON' );
            case 'frontend':
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

}
Ganje_Otp::get_instance();

