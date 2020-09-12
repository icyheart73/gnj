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

/**
 * Hack for plus character
 *
 * @return string the filtered link
 *
 */
function gnj_plus_character_hack($link)
{
    return $link = str_replace('+', '%2B', $link);
}

/**
 * Get is the current uri are filtered
 *
 * @return bool true if the url are filtered, false otherwise
 *
 * @since    2.8.6
 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
 */
function gnj_is_filtered_uri()
{
    $_chosen_attributes = Ganje_Ajax_Filter::getInstance()->get_layered_nav_chosen_attributes();
    $brands = '';
    //check if current page is filtered
    $is_filtered_uri = isset($_GET['product_cat']) || count($_chosen_attributes) > 0 || isset($_GET['min_price']) || isset($_GET['max_price']) || isset($_GET['orderby']) || isset($_GET['instock_filter']) || isset($_GET['onsale_filter']) || isset($_GET['product_tag']) || isset($_GET[$brands]);

    return $is_filtered_uri;
}


function gnj_product_visibility_meta($args)
{
    if (taxonomy_exists('product_visibility')) {
        $product_visibility_term_ids = wc_get_product_visibility_term_ids();
        $args['tax_query'] = isset($args['tax_query']) ? $args['tax_query'] : array();
        $args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'term_taxonomy_id',
            'terms' => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
            'operator' => 'NOT IN',
        );
    }

    return $args;
}


/**
 * Can the widget be displayed?
 *
 * @return bool
 */
function gnj_can_be_displayed()
{
    $return = false;

    if (
        (is_active_widget(false, false, 'gnj-woo-ajax-navigation', true) ||
            is_active_widget(false, false, 'gnj-woo-ajax-navigation-sort-by', true) ||
            is_active_widget(false, false, 'gnj-woo-ajax-navigation-stock-on-sale', true) ||
            is_active_widget(false, false, 'gnj-woo-ajax-navigation-list-price-filter', true)) &&
        (is_shop() || defined('SHOP_IS_ON_FRONT') || is_product_taxonomy() || is_product_category())
    ) {
        $return = true;
    }

    return $return;
}

/**
 * Get the product taxonomy array
 * @return array product taxonomy array
 *
 * @since    2.2
 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
 */

function gnj_get_product_taxonomy()
{
    global $_attributes_array;
    $product_taxonomies = !empty($_attributes_array) ? $_attributes_array : get_object_taxonomies('product');
    return $product_taxonomies;
}

/**
 * Get current layered link
 *
 * @return string|bool The new link
 *
 * @since    1.4
 * @author Andrea Grillo <andrea.grillo@yithemes.com>
 */
function gnj_get_woocommerce_layered_nav_link() {
    $return = false;
    $term = $source_id  = ! empty( $_GET['source_id'] ) ? $_GET['source_id'] : '';
    $taxonomy = $source_tax = ! empty( $_GET['source_tax'] ) ? $_GET['source_tax'] : '';

    if ( defined( 'SHOP_IS_ON_FRONT' ) || ( is_shop() && ! is_product_category() ) ) {
        $return             = get_post_type_archive_link( 'product' );
        return $return;
    }

    elseif ( ! is_shop() && is_product_category( $source_id ) && false ) {
        $return = get_term_link( get_queried_object()->slug, 'product_cat' );
        return $return;
    }

    else {
        $return = get_post_type_archive_link( 'product' );
        return $return;
    }
}

/**
 * Retreive the filter query args option
 *
 * @return array The option(s)
 *
 * @since    1.4
 */
function gnj_get_filter_args( $args = array() ) {
    $default_args = array( 'check_price_filter' => true );
    $args = wp_parse_args( $args, $default_args );
    extract( $args );

    $filter_value = array();
    $regexs       = array( '/^filter_[a-zA-Z0-9]/', '/^query_type_[a-zA-Z0-9]/', '/product_tag/', '/product_cat/', '/source_id/', '/source_tax/' );

    if ( ! empty( $_GET ) ) {
        foreach ( $regexs as $regex ) {
            foreach ( $_GET as $query_var => $value ) {
                if ( preg_match( $regex, $query_var ) ) {
                    $filter_value[$query_var] = $value;
                }
            }
        }
    }

    if ( $check_price_filter ) {
        // WooCommerce Price Filter
        if ( isset( $_GET['min_price'] ) ) {
            $filter_value['min_price'] = $_GET['min_price'];
        }

        if ( isset( $_GET['max_price'] ) ) {
            $filter_value['max_price'] = $_GET['max_price'];
        }
    }

    // WooCommerce In Stock/On Sale filters
    if ( isset( $_GET['instock_filter'] ) ) {
        $filter_value['instock_filter'] = $_GET['instock_filter'];
    }

    if ( isset( $_GET['onsale_filter'] ) ) {
        $filter_value['onsale_filter'] = $_GET['onsale_filter'];
    }

    if ( isset( $_GET['orderby'] ) ) {
        $filter_value['orderby'] = $_GET['orderby'];
    }

    if ( isset( $_GET['product_tag'] ) ) {
        $filter_value['product_tag'] = urlencode( $_GET['product_tag'] );
    }

    elseif( is_product_tag() && $queried_object ){
        $filter_value['product_tag'] = $queried_object->slug;
    }

    if (isset($_GET['product_cat'])) {
        $filter_value['product_cat'] = urlencode( $_GET['product_cat'] );
    }

    elseif( is_product_category() && $queried_object ){
        $filter_value['product_cat'] = $queried_object->slug;
    }

    if ( isset( $_GET['source_id'] ) && isset( $_GET['source_tax'] ) ) {
        $filter_value['source_id']  = $_GET['source_id'];
        $filter_value['source_tax'] = $_GET['source_tax'];
    }

    elseif( ! is_shop() && is_product_taxonomy() && $queried_object && ! isset( $filter_value['source_id'] ) && ! isset( $filter_value['source_tax'] )){
        $filter_value['source_id']   = $queried_object->term_id;
        $filter_value['source_tax']  = $queried_object->taxonomy;
    }

    return apply_filters( 'gnj_get_filter_args', $filter_value );
}

/**
 * Check if there is an active price filter
 *
 * @return bool True if the the filter is active, false otherwise
 *
 * @since    1.4
 */
function gnj_check_active_price_filter( $min_price, $max_price ) {
    return isset( $_GET['min_price'] ) && $_GET['min_price'] == $min_price && isset( $_GET['max_price'] ) && $_GET['max_price'] == $max_price;
}

/**
 * Remove min_price and max_price query args from filters array value
 *
 * @return array The array params
 *
 * @since    1.4
 */
function gnj_remove_price_filter_query_args( $filter_value ) {
    foreach ( array( 'min_price', 'max_price' ) as $remove ) {
        unset( $filter_value[$remove] );
    }

    return $filter_value;
}

/**
 * Get the array of objects terms
 *
 * @param $type A type of term to display
 *
 * @return $terms mixed|array
 *
 * @since  1.3.1
 */
function gnj_get_terms( $case, $taxonomy, $instance = false ) {

    $reordered = false;

    $args = array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true
    );

    switch ( $case ) {

        case 'all':
            $terms = gnj_wp_get_terms( $args );
            break;

        case 'hierarchical':
            $terms = gnj_wp_get_terms( $args );
            if( ! in_array( $instance['type'], apply_filters( 'yith_wcan_display_type_list', array( 'list' ) ) ) ) {
                $terms = gnj_reorder_terms_by_parent( $terms, $taxonomy );
                $reordered = true;
            }
            break;

        case 'parent' :
            $args['parent'] = false;
            $terms = gnj_wp_get_terms( $args );
            break;

        default:
            if ( 'parent' == $instance['display'] ) {
                $args['parent'] = false;
            }

            $terms = gnj_wp_get_terms( $args );

            if ( 'hierarchical' == $instance['display'] ) {
                if( ! in_array( $instance['type'], array( 'list' , 'tags' ) ) ) {
                    $terms = gnj_reorder_terms_by_parent( $terms, $taxonomy );
                    $reordered = true;
                }
            }
            break;
    }

    if( ! $reordered ){
        $terms = gnj_reorder_terms_by_parent( $terms, $taxonomy );
        $reordered = true;
    }

    if('hierarchical' != $instance['display'] && ! is_wp_error( $terms ) && ! $reordered ){
        usort( $terms, 'gnj_terms_sort' );
    }

    return apply_filters( 'gnj_get_terms_list', $terms, $taxonomy, $instance );
}

/**
 * get_terms function support for old WordPress Version
 *
 * @param array $args
 *
 * @return bool
 */
function gnj_wp_get_terms( $args ) {

    $terms = get_terms( $args );

    if( ! is_array( $terms ) ){
        $terms = array();
    }

    return $terms;
}

/**
 * Sort the array of terms associating the child to the parent terms
 *
 * @param $terms mixed|array
 *
 * @return mixed!array
 * @since 1.3.1
 */
function gnj_reorder_terms_by_parent( $terms, $taxonomy ) {

    /* Extract Child Terms */
    $child_terms  = array();
    $terms_count  = 0;
    $parent_terms = array();

    foreach ( $terms as $array_key => $term ) {

        if ( $term->parent != 0 ) {

            $term_parent = $term->parent;
            while( true ){
                $temp_parent_term = get_term_by( 'id', $term_parent, $taxonomy );
                if( $temp_parent_term->parent != 0 ){
                    $term_parent = $temp_parent_term->parent;
                }

                else {
                    break;
                }
            }

            if ( isset( $child_terms[$term_parent] ) && $child_terms[$term_parent] != null ) {
                $child_terms[$term_parent] = array_merge( $child_terms[$term_parent], array( $term ) );
            }
            else {
                $child_terms[$term_parent] = array( $term );
            }

        }
        else {
            $parent_terms[$terms_count] = $term;
        }
        $terms_count ++;
    }

    /* Reorder Terms */
    $terms_count = 0;
    $terms       = array();

    foreach ( $parent_terms as $term ) {

        $terms[$terms_count] = $term;

        /* The term as child */
        if ( array_key_exists( $term->term_id, $child_terms ) ) {

            usort( $child_terms[$term->term_id], 'gnj_terms_sort' );

            foreach ( $child_terms[$term->term_id] as $child_term ) {
                $terms_count ++;
                $terms[$terms_count] = $child_term;
            }
        }
        $terms_count ++;
    }

    usort( $terms, 'gnj_terms_sort' );


    return $terms;
}

/**
 * Enable multi level taxonomies management
 *
 * @return array the full terms array
 *
 * @since    2.8.1
 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
 */
function gnj_reorder_hierachical_categories( $parent_term_id, $taxonomy = 'product_cat' ) {

    $childs = gnj_wp_get_terms(
        array(
            'taxonomy'      => $taxonomy,
            'parent'        => $parent_term_id,
            'hierarchical'  => true,
            'hide_empty'    => false
        )
    );

    if ( !empty( $childs ) ) {
        $temp = array();
        foreach ( $childs as $child ) {
            $temp[$child->term_id] = gnj_reorder_hierachical_categories( $child->term_id, $taxonomy );
        }
        return $temp;
    }

    else {
        return array();
    }
}

/**
 * Return true if the term has a child, false otherwise
 *
 * @param $term     The term object
 * @param $taxonomy the taxonomy to search
 *
 * @return bool
 *
 * @since 1.3.1
 */
function gnj_term_has_child( $term, $taxonomy ) {
    $count       = 0;
    $child_terms = gnj_wp_get_terms( array( 'taxonomy' => $taxonomy, 'child_of' => $term->term_id ) );

    if( ! is_wp_error( $child_terms ) ){

        foreach ( $child_terms as $child_term ) {
            $_products_in_term = get_objects_in_term( $child_term->term_id, $taxonomy );
            $count += sizeof( array_intersect( $_products_in_term, Ganje_Ajax_Filter::getInstance()->frontend->layered_nav_product_ids ) );
        }
    }

    return empty( $count ) ? false : true;
}

/**
 * Return true if the term is a child, false otherwise
 *
 * @param $term The term object
 *
 * @return bool
 *
 * @since 1.3.1
 */
function gnj_term_is_child( $term ) {
    return ( isset( $term->parent ) && $term->parent != 0 ) ? true : false;
}

/**
 * Return a dropdown with Woocommerce attributes
 */
function gnj_dropdown_attributes( $selected, $echo = true ) {
    $_woocommerce = function_exists( 'wc' ) ? wc() : null;
    $options    = "";
    $attributes = array();

    if ( ! empty( $_woocommerce ) ) {

        if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
            $attribute_taxonomies = wc_get_attribute_taxonomies();
        }
        else {
            $attribute_taxonomies = $_woocommerce->get_attribute_taxonomies();
        }

        if ( empty( $attribute_taxonomies ) ) {
            return array();
        }

        foreach ( $attribute_taxonomies as $attribute ) {

            /* FIX TO WOOCOMMERCE 2.1 */
            if ( function_exists( 'wc_attribute_taxonomy_name' ) ) {
                $taxonomy = wc_attribute_taxonomy_name( $attribute->attribute_name );
            }
            else {
                $taxonomy = $_woocommerce->attribute_taxonomy_name( $attribute->attribute_name );
            }


            if ( taxonomy_exists( $taxonomy ) ) {
                $attributes[] = $attribute->attribute_name;
            }
        }

        foreach ( $attributes as $attribute ) {
            $options .= "<option name='{$attribute}'" . selected( $attribute, $selected, false ) . ">{$attribute}</option>";
        }
    }

    if ( $echo ) {
        echo $options;
    }
    else {
        return $options;
    }
}

/**
 * Print the widgets options already filled
 *
 * @param $type      string list|colors|label
 * @param $attribute woocommerce taxonomy
 * @param $id        id used in the <input />
 * @param $name      base name used in the <input />
 * @param $values    array of values (could be empty if this is an ajax call)
 *
 * @return string
 */
function gnj_attributes_table( $type, $attribute, $id, $name, $values = array(), $echo = true ) {
    $return = '';

    $terms = get_terms( array( 'taxonomy' => 'pa_' . $attribute, 'hide_empty' => '0' ) );

    if ( 'list' == $type ) {
        $return = '<input type="hidden" name="' . $name . '[colors]" value="" /><input type="hidden" name="' . $name . '[labels]" value="" />';
    }

    elseif ( 'color' == $type ) {
        if ( ! empty( $terms ) ) {
            $return = '<table><tr><th>نام</th><th>رنگ</th></tr>';

            foreach ( $terms as $term ) {
                if( $term instanceof WP_Term ){
                    $return .= "<tr><td><label for='{$id}{$term->term_id}'>{$term->name}</label></td><td><input type='text' id='{$id}{$term->term_id}' name='{$name}[colors][{$term->term_id}]' value='" . ( isset( $values[$term->term_id] ) ? $values[$term->term_id] : '' ) . "' size='3' class='gnj-colorpicker' /></td></tr>";
                }
            }

            $return .= '</table>';
        }

        $return .= '<input type="hidden" name="' . $name . '[labels]" value="" />';
    }

    if ( $echo ) {
        echo $return;
    }

    return $return;
}

/**
 * Return true if the term is a parent, false otherwise
 *
 * @param $term The term object
 *
 * @return bool
 *
 * @since 1.3.1
 */
function gnj_term_is_parent( $term ) {

    return ( isset( $term->parent ) && $term->parent == 0 ) ? true : false;
}

function gnj_terms_sort( $a, $b ){
    $result = 0;
    if ( $a->count < $b->count ) {
        $result = 1;
    }

    elseif ( $a->count > $b->count ) {
        $result = - 1;
    }
    return $result;
}

function gnj_remove_premium_query_arg( $link ) {
    $reset           = array( 'orderby', 'onsale_filter', 'instock_filter', 'product_tag', 'product_cat' );
    return remove_query_arg( $reset, $link );
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
/////////////////////////////schema//////////////////////////
function woocommerce_schema_product(){
    if(is_product()){
        global $post; // Get current post (product) data
        $product_id = $post->ID; // Get product ID
        $product = wc_get_product($product_id); // Get product information

        $name = $product->get_name(); // Get product name
        $description = $product->get_short_description(); // Get product description
        $price = $product->get_price(); // Get product price
        $currency = get_woocommerce_currency();
        $stock_status = $product->get_stock_status(); // Get product stock status -- 1. instock 2. outofstock 3. onbackorder

        $review_count = $product->get_review_count(); // Get review count
        $reviews_args = [ // Review arguments
            'post_id' => $product_id
        ];
        $reviews = get_comments($reviews_args); // Get reviews and store as array
        $avg_rating = trim($product->get_average_rating(), '0'); // Get product rating ?>
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "Product",
                <?php if($review_count > 1){ ?>

                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "<?php echo $avg_rating; ?>",
                    "reviewCount": "<?php echo $review_count; ?>"
                }
                <?php } ?>

                "name": "<?php echo $name; ?>",
                <?php if($description != ''){
                echo '"description": "' . $description . '",';
            } ?>

                "offers": {
                    "@type": "Offer",
                    "availability": "<?php if($stock_status == 'instock'){ // If in stock
                echo 'https://schema.org/InStock';
            } elseif($stock_status == 'outofstock') { // If out of stock
                echo 'https://schema.org/OutOfStock';
            } elseif($stock_status == 'onbackorder'){ // If on backorder
                echo 'https://schema.org/PreOrder';
            } ?>",
                    "price": "<?php echo $price; ?>",
                    "priceCurrency": "<?php echo $currency; ?>"
                }
                <?php if($review_count == 1){ ?>

                "review": [
                    <?php foreach($reviews as $review){
                $id = $review->comment_ID;
                $reviewer = $review->comment_author;
                $date = $review->comment_date;
                $content = $review->comment_content;
                $rating = get_comment_meta($id, 'rating', true); ?>

                    {
                        "@type": "Review",
                        "author": "<?php echo $reviewer; ?>",
                        "datePublished": "<?php echo date("Y-m-d", strtotime($date)); ?>",
                        "description": "<?php echo $content; ?>",
                        "reviewRating": {
                            "@type": "Rating",
                            "bestRating": "5",
                            "ratingValue": "<?php echo $rating; ?>",
                            "worstRating": "1"
                        }
                    }
                    <?php } ?>

                ]
                <?php } elseif($review_count > 1){ ?>,

                "review": [
                    <?php $i = 0;
                foreach($reviews as $review){
                    $id = $review->comment_ID;
                    $reviewer = $review->comment_author;
                    $date = $review->comment_date;
                    $content = $review->comment_content;
                    $rating = get_comment_meta($id, 'rating', true); ?>

                    {
                        "@type": "Review",
                        "author": "<?php echo $reviewer; ?>",
                        "datePublished": "<?php echo date("Y-m-d", strtotime($date)); ?>",
                        "description": "<?php echo $content; ?>",
                        "reviewRating": {
                            "@type": "Rating",
                            "bestRating": "5",
                            "ratingValue": "<?php echo $rating; ?>",
                            "worstRating": "1"
                        }
                    }<?php if(++$i != $review_count){ ?>,<?php } ?>
                <?php } ?>

                ]
                <?php } ?>

            }
        </script>
    <?php }
} add_action('wp_head', 'woocommerce_schema_product');
