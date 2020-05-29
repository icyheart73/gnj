<?php
//Get tempalte
if( !function_exists( 'gnj_get_template' ) ){
    function gnj_get_template ( $template_name, $path = '', $args = array(), $return = false ) {

        $located = gnj_locate_template ( $template_name, $path );

        if ( $args && is_array ( $args ) ) {
            extract ( $args );
        }

        if ( $return ) {
            ob_start ();
        }

        // include file located
        if ( file_exists ( $located ) ) {
            include ( $located );
        }

        if ( $return ) {
            return ob_get_clean ();
        }
    }
}
//Locate template
if( !function_exists( 'gnj_locate_template' ) ){
    function gnj_locate_template ( $template_name, $template_path ) {

        // Look within passed path within the theme - this is priority.
        $template = locate_template($template_name);

        //Check woocommerce directory for older version
        if( !$template && class_exists( 'woocommerce' ) ){
            if( file_exists( WC()->plugin_path() . '/templates/' . $template_name ) ){
                $template = WC()->plugin_path() . '/templates/' . $template_name;
            }
        }

        if ( ! $template ) {
            $template = trailingslashit( $template_path ) . $template_name;
        }

        return $template;
    }
}

//Phone input field
function gnj_get_phone_input_field( $args = array(), $return = false ){

    $args = wp_parse_args( $args, array(
        'label' 		=> 'تلفن همراه',
        'input_class' 	=> array(),
        'cont_class'	=> array(),
        'label_class' 	=> array(),
        'show_phone' 	=> 'required',
        'show_cc'	 	=> 'disable',
        'default_phone' => '',
        'default_cc' 	=> '+98',
        'form_token' 	=> mt_rand( 1000, 9999 ),
        'form_type' 	=> 'register_user'
    ) );

    return gnj_get_template( 'gnj-phone-input.php', GNJ_PATH.'/public/partials/otp/', $args, $return );
}

//OTP login form
function gnj_get_login_with_otp_form( $args = array(), $return = false ){

    $args = wp_parse_args( $args, array(
        'label' 			=> 'تلفن همراه',
        'button_class' 		=> array(
            'button', 'btn'
        ),
        'input_class' 		=> array(),
        'cont_class'		=> array(),
        'label_class' 		=> array(),
        'form_token' 		=> mt_rand( 1000, 9999 ),
        'form_type' 		=> 'login_with_otp',
        'redirect' 			=> $_SERVER['REQUEST_URI'],
        'is_login_popup' 	=> false,
        'login_first' 	=> 'yes',
    ) );

    return gnj_get_template( 'gnj-otp-login-button.php', GNJ_PATH.'/public/partials/otp/', $args, $return );
}


//Phone input form
function gnj_phone_input_form( $args = array(), $return = false ){

    $phone_input = gnj_get_phone_input_field( $args, true );

    $args = array(
        'phone_input' => $phone_input
    );

    return gnj_get_template( 'gnj-phone-input-form.php', GNJ_PATH.'/public/partials/otp/', $args, $return );

}


//OTP Form
function gnj_phone_otp_form( $args, $return = false ){

    $args = wp_parse_args( $args, array(
        'otp_length'	=> 4
    ) );
    return gnj_get_template( 'gnj-form-otp.php', GNJ_PATH.'/public/partials/otp/', $args, $return );

}
add_action( 'wp_footer', 'gnj_phone_otp_form' );


//Get user phone number
function gnj_get_user_phone( $user_id, $code_or_phone = '' ){

    $code 	= esc_attr( get_user_meta( $user_id, 'gnj_phone_code', true ) );
    $number = esc_attr( get_user_meta( $user_id, 'gnj_phone_no', true ) );

    if( $code_or_phone === 'number' ){
        return $number;
    }else if( $code_or_phone === 'code' ){
        return $code;
    }

    return array(
        'code' 		=> $code,
        'number' 	=> $number
    );
}



/*
 * Search user by phone number
*/
function gnj_get_user_by_phone( $phone_no, $phone_code = '' ){

    $meta_query_args = array(
        'relation' => 'AND',
        array(
            'key' 		=> 'gnj_phone_no',
            'value' 	=> $phone_no,
            'compare' 	=> '='
        )
    );

    if( $phone_code ){
        $meta_query_args[] = array(
            'key' 		=> 'gnj_phone_code',
            'value' 	=> $phone_code,
            'compare' 	=> '='
        );
    }

    $args = array(
        'meta_query' => $meta_query_args
    );

    $user_query = new WP_User_Query( $args );

    $phone_users = $user_query->get_results();

    if ( count( $phone_users ) === 1 ){
        return $phone_users[0];
    }
    else{
        return false;
    }

}
