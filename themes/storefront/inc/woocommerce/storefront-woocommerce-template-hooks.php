<?php
/**
 * Storefront WooCommerce hooks
 *
 * @package storefront
 */

/**
 * Homepage
 *
 * @see  storefront_product_categories()
 * @see  storefront_recent_products()
 * @see  storefront_featured_products()
 * @see  storefront_popular_products()
 * @see  storefront_on_sale_products()
 * @see  storefront_best_selling_products()
 */
add_action( 'homepage', 'storefront_product_categories', 20 );
add_action( 'homepage', 'storefront_recent_products', 30 );
add_action( 'homepage', 'storefront_featured_products', 40 );
add_action( 'homepage', 'storefront_popular_products', 50 );
add_action( 'homepage', 'storefront_on_sale_products', 60 );
add_action( 'homepage', 'storefront_best_selling_products', 70 );


add_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );


/**
 * Header
 *
 * @see storefront_product_search()
 * @see storefront_header_cart()
 */
add_action( 'storefront_header', 'storefront_product_search', 40 );
add_action( 'storefront_header', 'storefront_header_cart', 60 );
