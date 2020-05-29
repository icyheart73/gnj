<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Gnj_Otp_Admin{


    protected static $_instance = null;

    public static function get_instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function __construct(){
        add_action( 'edit_user_profile', array( $this, 'edit_profile_page' ) );
        add_action( 'edit_user_profile_update', array( $this, 'save_customer_meta_fields' ) );
        add_action( 'user_profile_update_errors', array( $this, 'verify_user_fields' ), 10, 3 );
        add_filter( 'xoo_el_user_profile_fields', array( $this, 'remove_phone_fields' ) );
    }


    public function remove_phone_fields( $fields ){
        unset( $fields['xoo-ml-reg-phone'], $fields['xoo-ml-reg-phone-cc']  );
        return $fields;
    }


    public function verify_user_fields( $wp_error, $update, $user ){
        if( isset( $_POST['gnj-user-reg-phone'] ) && $_POST['gnj-user-reg-phone'] ){
            $user_by_phone = gnj_get_user_by_phone( $_POST['gnj-user-reg-phone'], $_POST['gnj-user-reg-phone-cc'] );
            if( $user_by_phone && $user_by_phone->ID !== $user->ID  ){
                $wp_error->add( 'user-already-exists', sprintf( __( 'User: #%1s is already registered with %2s phone number', 'mobile-login-woocommerce' ), $user->ID, esc_attr( $_POST['xoo-ml-user-reg-phone'] ) ) );
            }
        }
    }


    public function edit_profile_page( $user ){
        ?>
        <table class="form-table">
            <tr>
                <th><?php  _e( 'Phone', 'mobile-login-woocommerce' ); ?></th>
                <td>
                    <select name="gnj-user-reg-phone-cc">
                        <option value="+98">+98</option>
                    </select>
                    <input type="text" name="gnj-user-reg-phone" value="<?php echo get_user_meta( $user->ID, 'gnj_phone_no',true); ?>">
                </td>
            </tr>
        </table>
        <?php
    }


    /**
     * Save Address Fields on edit user pages.
     *
     * @param int $user_id User ID of the user being saved
     */
    public function save_customer_meta_fields( $user_id ) {

        if( isset( $_POST['gnj-user-reg-phone'] ) ){
            update_user_meta( $user_id, 'gnj_phone_no', sanitize_text_field( $_POST['gnj-user-reg-phone'] ) );
        }

        if( isset( $_POST['gnj-user-reg-phone-cc'] ) ){
            update_user_meta( $user_id, 'gnj_phone_code', sanitize_text_field( $_POST['gnj-user-reg-phone-cc'] ) );
        }

    }

}

Gnj_Otp_Admin::get_instance();

?>
