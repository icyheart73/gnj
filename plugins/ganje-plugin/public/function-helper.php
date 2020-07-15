<?php
//Get tempalte
if (!function_exists('gnj_get_template')) {
    function gnj_get_template($template_name, $path = '', $args = array(), $return = false)
    {

        $located = gnj_locate_template($template_name, $path);

        if ($args && is_array($args)) {
            extract($args);
        }

        if ($return) {
            ob_start();
        }

        // include file located
        if (file_exists($located)) {
            include($located);
        }

        if ($return) {
            return ob_get_clean();
        }
    }
}

//Locate template
if (!function_exists('gnj_locate_template')) {
    function gnj_locate_template($template_name, $template_path)
    {

        // Look within passed path within the theme - this is priority.
        $template = locate_template($template_name);

        //Check woocommerce directory for older version
        if (!$template && class_exists('woocommerce')) {
            if (file_exists(WC()->plugin_path() . '/templates/' . $template_name)) {
                $template = WC()->plugin_path() . '/templates/' . $template_name;
            }
        }

        if (!$template) {
            $template = trailingslashit($template_path) . $template_name;
        }

        return $template;
    }
}

//Phone input field
function gnj_get_phone_input_field($args = array(), $return = false)
{

    $args = wp_parse_args($args, array(
        'label' => 'تلفن همراه',
        'input_class' => array(),
        'cont_class' => array(),
        'label_class' => array(),
        'show_phone' => 'required',
        'show_cc' => 'disable',
        'default_phone' => '',
        'default_cc' => '+98',
        'form_token' => mt_rand(1000, 9999),
        'form_type' => 'register_user'
    ));

    return gnj_get_template('gnj-phone-input.php', GNJ_PATH . '/public/partials/otp/', $args, $return);
}

//OTP login form
function gnj_get_login_with_otp_form($args = array(), $return = false)
{

    $args = wp_parse_args($args, array(
        'label' => 'تلفن همراه',
        'button_class' => array(
            'button', 'btn'
        ),
        'input_class' => array(),
        'cont_class' => array(),
        'label_class' => array(),
        'form_token' => mt_rand(1000, 9999),
        'form_type' => 'login_with_otp',
        'redirect' => $_SERVER['REQUEST_URI'],
        'is_login_popup' => false,
        'login_first' => 'yes',
    ));

    return gnj_get_template('gnj-otp-login-button.php', GNJ_PATH . '/public/partials/otp/', $args, $return);
}


//Phone input form
function gnj_phone_input_form($args = array(), $return = false)
{

    $phone_input = gnj_get_phone_input_field($args, true);

    $args = array(
        'phone_input' => $phone_input
    );

    return gnj_get_template('gnj-phone-input-form.php', GNJ_PATH . '/public/partials/otp/', $args, $return);

}


//OTP Form
function gnj_phone_otp_form($args, $return = false)
{

    $args = wp_parse_args($args, array(
        'otp_length' => 4
    ));
    return gnj_get_template('gnj-form-otp.php', GNJ_PATH . '/public/partials/otp/', $args, $return);

}

add_action('wp_footer', 'gnj_phone_otp_form');


//Get user phone number
function gnj_get_user_phone($user_id, $code_or_phone = '')
{

    $code = esc_attr(get_user_meta($user_id, 'gnj_phone_code', true));
    $number = esc_attr(get_user_meta($user_id, 'gnj_phone_no', true));

    if ($code_or_phone === 'number') {
        return $number;
    } else if ($code_or_phone === 'code') {
        return $code;
    }

    return array(
        'code' => $code,
        'number' => $number
    );
}

//Add notice
function gnj_add_notice( $message, $notice_type = 'error' ){

    $classes = $notice_type === 'error' ? 'xoo-ml-notice-error' : 'xoo-ml-notice-success';

    $html = '<div class="'.$classes.'">'.$message.'</div>';

    return apply_filters('gnj_notice_html',$html,$message,$notice_type);
}

/*
 * Search user by phone number
*/
function gnj_get_user_by_phone($phone_no, $phone_code = '')
{

    $meta_query_args = array(
        'relation' => 'AND',
        array(
            'key' => 'gnj_phone_no',
            'value' => $phone_no,
            'compare' => '='
        )
    );

    if ($phone_code) {
        $meta_query_args[] = array(
            'key' => 'gnj_phone_code',
            'value' => $phone_code,
            'compare' => '='
        );
    }

    $args = array(
        'meta_query' => $meta_query_args
    );

    $user_query = new WP_User_Query($args);

    $phone_users = $user_query->get_results();

    if (count($phone_users) === 1) {
        return $phone_users[0];
    } else {
        return false;
    }
}

/**
 * Cehck Ajax Security Nonce
 */
function ganje_check_ajax_referer()
{
    $check_nonce = check_ajax_referer('thf_ajax_security_nonce', 'security', false);

    if (!$check_nonce || is_bot()) {
        if (wp_doing_ajax()) {
            wp_die(-1, 403);
        } else {
            die('-1');
        }
    }
}

/**
 * Check if the current request made by a known bot?
 */
function is_bot($ua = null)
{

    if (empty($ua)) {
        $ua = $_SERVER['HTTP_USER_AGENT'];
    }

    $bot_agents = array(
        'alexa',
        'altavista',
        'ask jeeves',
        'attentio',
        'baiduspider',
        'bingbot',
        'chtml generic',
        'crawler',
        'fastmobilecrawl',
        'feedfetcher-google',
        'firefly',
        'froogle',
        'gigabot',
        'googlebot',
        'googlebot-mobile',
        'heritrix',
        'httrack',
        'ia_archiver',
        'irlbot',
        'iescholar',
        'infoseek',
        'jumpbot',
        'linkcheck',
        'lycos',
        'mediapartners',
        'mediobot',
        'motionbot',
        'msnbot',
        'mshots',
        'openbot',
        'pss-webkit-request',
        'pythumbnail',
        'scooter',
        'slurp',
        'Speed Insights',
        'snapbot',
        'spider',
        'taptubot',
        'technoratisnoop',
        'teoma',
        'twiceler',
        'yahooseeker',
        'yahooysmcm',
        'yammybot',
        'ahrefsbot',
        'Pingdom',
        'GTmetrix',
        'PageSpeed',
        'Google Page Speed',
        'kraken',
        'yandexbot',
        'twitterbot',
        'tweetmemebot',
        'openhosebot',
        'queryseekerspider',
        'linkdexbot',
        'grokkit-crawler',
        'livelapbot',
        'germcrawler',
        'domaintunocrawler',
        'grapeshotcrawler',
        'cloudflare-alwaysonline',
    );

    foreach ($bot_agents as $bot_agent) {
        if (false !== stripos($ua, $bot_agent)) {
            return true;
        }
    }

    return false;
}


function is_valid_mobile($number)
{
    $patern = '/(0|\+98)?([ ]|,|-|[()]){0,2}9[0|1|2|3|4]([ ]|,|-|[()]){0,3}(?:[0-9]([ ]|,|-|[()]){0,2}){8}/';

    if (preg_match($patern, strval($number), $matches, PREG_OFFSET_CAPTURE, 0))
        return true;

    return false;
}

/**
 * Add support for $args to the template part
 */
function gnj_get_template_part($located, $args = array())
{

    if ($args && is_array($args)) {
        extract($args);
    }

    if (!empty($located) && file_exists($located)) {
        include($located);
    }
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function gnj_invoice_init() {
    $labels = array(
        'name'                  => 'Invoice',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => true,
        'show_ui'            => false,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'invoice' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'supports'           => array('title'),
        'exclude_from_search' => true,
        'show_in_rest' => false,
    );

    register_post_type( 'invoice', $args );
}
add_action( 'init','gnj_invoice_init' );
