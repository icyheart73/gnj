<?php
add_filter( 'ot_list_item_settings', 'filter_ot_list_item_settings', 10, 2 );
function filter_ot_list_item_settings( $settings, $id ) {
    $type = explode('_', $id);
    if ( $type[0] == 'txt' ) {

        $settings = array();
    }
    return $settings;
}

add_filter( 'ot_list_item_title_label', 'change_ot_list_item_label', 10, 2 );
function change_ot_list_item_label( $list_label, $list_id ) {

        $list_label = '';

    return $list_label;

}
add_filter('ot_social_links_description','change_ot_social_links_description',10 , 2);

function change_ot_social_links_description( $field_label, $field_id)
{
    $field_label = '';
    return $field_label;
}


