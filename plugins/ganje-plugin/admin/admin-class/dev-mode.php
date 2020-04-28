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
