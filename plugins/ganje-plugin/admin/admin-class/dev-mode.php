<?php


add_action( 'admin_menu', 'wpse_91693_register');

function wpse_91693_register()
{
    add_menu_page(
        'devMode',     // page title
        'devMode',     // menu title
        'manage_options',   // capability
        'devMode',     // menu slug
        'wpse_91693_render' // callback function
    );
}
function wpse_91693_render()
{
    print '<div class="wrap">';
    do_action('devmode' ,10 );
    print '</div>';
}

add_action( 'devmode', 'testvar');


// Get Woocommerce variation price based on product ID
function testvar(){
    $product = new WC_Product_Variable(159);
    $variations = $product->get_available_variations();
    var_dump($variations['display_price']);
    $var_data = [];
    foreach ($variations as $variation) {
        foreach ($variation['attributes'] as $var) {
            echo $var;
            echo '<hr>';
        }

        echo '<img src="'.$variation['image']['url'].'" />';
        echo '<hr>';
        echo $variation['display_regular_price'];
        echo '<hr>';
        echo $variation['display_price'];
        echo '<hr>';
        echo '<hr>';
        echo '<hr>';
    }
}
