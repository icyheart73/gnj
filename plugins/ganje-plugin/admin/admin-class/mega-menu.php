<?php

class GNJ_Megamenu {

    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/

    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {

        // add custom menu fields to menu
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'gnj_add_custom_nav_fields' ) );

        // save menu custom fields
        add_action( 'wp_update_nav_menu_item', array( $this, 'gnj_update_custom_nav_fields'), 10, 3 );

        // edit menu walker
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'gnj_edit_walker'), 10, 2 );

    } // end constructor

    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     *
     * @access      public
     * @since       1.0
     * @return      void
     */
    function gnj_add_custom_nav_fields( $menu_item ) {

        $menu_item->subtitle = get_post_meta( $menu_item->ID, '_menu_item_subtitle', true );
        $menu_item->gnj_icon = get_post_meta( $menu_item->ID, '_gnj_menu_icon', true );
        return $menu_item;

    }

    /**
     * Save menu custom fields
     *
     * @access      public
     * @since       1.0
     * @return      void
     */
    function gnj_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

        // Check if element is properly sent
        if ( is_array( $_REQUEST['menu-item-subtitle']) ) {
            $subtitle_value = $_REQUEST['menu-item-subtitle'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_subtitle', $subtitle_value );
        }

        // Check if element is properly sent
        if ( is_array( $_REQUEST['gnj-menu-icon']) ) {
            $subtitle_value = $_REQUEST['gnj-menu-icon'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_gnj_menu_icon', $subtitle_value );
        }

    }

    /**
     * Define new Walker edit
     *
     * @access      public
     * @since       1.0
     * @return      void
     */
    function gnj_edit_walker($walker,$menu_id) {

        return 'Walker_Nav_Menu_Edit_Custom';

    }

}

// instantiate plugin's class
new GNJ_Megamenu();

include_once( 'edit_custom_walker.php' );
include_once( 'custom_walker.php' );
