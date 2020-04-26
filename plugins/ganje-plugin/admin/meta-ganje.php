<?php
/**
 * Initialize the meta boxes.
 */
add_action( 'admin_init', 'custom_meta_boxes' );

function custom_meta_boxes() {

    $ganje_meta_box = array(
        'id'        => 'ganje_meta_box',
        'title'     => ' باکس فیلد سفارشی گنجه ',
        'desc'      => '',
        'pages'     => array( 'product'),
        'context'   => 'normal',
        'priority'  => 'high',
        'fields'    => array(
            array(
                'label' => 'معرفی محصول',
                'id'    => 'product_intro',
                'type'  => 'tab',
            ),

            array(
                'label' => ' ویدئو',
                'id'    => 'type_video',
                'type'  => 'select',
                'desc'      => 'انتخاب نوع ویدئو',
                'choices' => array(

                    array(
                        'value'       => 'direct_link',
                        'label'       => 'لینک مستقیم',
                    ),
                    array(
                        'value'       => 'aparat_link',
                        'label'       => 'آپارات',
                    ),
                ),

            ),
            array(
                'label'     => '',
                'id'        => 'direct_link_url',
                'type'      => 'text',
                'desc'      => 'لینک مستقیم ویدئو',
                'condition' => 'type_video:is(direct_link)',
            ),
            array(
                'label'     => '',
                'id'        => 'direct_link_title',
                'type'      => 'text',
                'desc'      => 'عنوان ویدئو',
                'condition' => 'type_video:is(direct_link)',
            ),

            array(
                'label'     => '',
                'id'        => 'aparat_embed',
                'type'      => 'textarea',
                'rows'       => '3',
                'desc'      => 'کد اسکریپت (embed)',
                'condition' => 'type_video:is(aparat_link)',
            ),
            array(
                'label'     => 'کاتالوگ',
                'id'        => 'product_catalog',
                'type'      => 'upload',
                'desc'      => 'آپلود کاتالوگ',

            ),
            array(
                'label' => 'پیغام ها',
                'id'    => 'product_attention',
                'type'  => 'tab',
            ),
            array(
                'label'     => 'اعلان ها',
                'id'        => 'product_alert',
                'type'      => 'radio',
                'choices' => array(

                    array(
                        'value'       => 'red',
                        'label'       => 'قرمز',
                    ),
                    array(
                        'value'       => 'yellow',
                        'label'       => 'زرد',
                    ),
                    array(
                        'value'       => 'blue',
                        'label'       => 'آبی',
                    ),
                    array(
                        'value'       => 'green',
                        'label'       => 'سبز',

                    ),
                ),
                'desc'      => '',

            ),
            array(
                'label'     => '',
                'id'        => 'attention_text',
                'type'      => 'textarea',
                'rows'       => '3',
                'desc'      => 'متن اعلان',

            ),
            array(
                'label'     => 'برچسب ها',
                'id'        => 'product_label',
                'type'      => 'colorpicker',
                'desc'      => 'انتخاب رنگ',
            ),
            array(
                'label'     => '',
                'id'        => 'product_label_title',
                'type'      => 'text',
                'desc'      => 'عنوان برچسب ',
            ),
            array(
                'label' => 'نقاط قوت و ضعف',
                'id'    => 'product_sw',
                'type'  => 'tab',
            ),
            array(
                'label'       => 'نقاط قوت',
                'id'          => 'txt_product_s',
                'type'        => 'list-item',
                'desc'        =>'',
            ),
            array(
                'label'       => 'نقاط ضعف',
                'id'          => 'txt_product_w',
                'type'        => 'list-item',
            ),


        )
    );

    ot_register_meta_box( $ganje_meta_box );

}
