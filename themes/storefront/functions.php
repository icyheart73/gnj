<?php

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,
	'main'       => require 'inc/class-storefront.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
}
/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function set_product_cookie(){
    if(is_product()) {
        if (isset($_COOKIE['ProductCookie'])) {

            setcookie('ProductCookie', '', time() - 3600);

        }

            global $post;
            $value = get_the_terms($post->ID, 'product_cat');
            $i = 0;
            foreach ($value as $item) {
                $cookieCat[$i] = $item->name;
                $i++;
            }
            $cookieCat = implode(',', $cookieCat);
            setcookie("ProductCookie", $cookieCat, time() + (86400 * 30), COOKIEPATH, COOKIE_DOMAIN);
        }


}

