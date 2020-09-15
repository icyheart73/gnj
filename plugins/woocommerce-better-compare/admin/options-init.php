<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "woocommerce_better_compare_options";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'woocommerce_better_compare_options',
        'use_cdn' => TRUE,
        'dev_mode' => FALSE,
        'display_name' => 'سیستم مقایسه و گروه بندی ویژگی ها',
        'display_version' => '1.3.4',
        'page_title' => 'WooCommerce Compare Products',
        'update_notice' => FALSE,
        'intro_text' => '',
        'admin_bar' => FALSE,
        'menu_type' => 'submenu',
        'menu_title' => 'مقایسه محصولات و گروه بندی ویژگی ها',
        'allow_sub_menu' => TRUE,
        'page_parent' => 'woocommerce',
        // 'page_parent_post_type' => 'stores',
        'customizer' => FALSE,
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_color' => 'lightgray',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */



    // Set the help sidebar
    // $content = __('<p>This is the sidebar content, HTML is allowed.</p>', 'woocommerce-better-compare' );
    // Redux::setHelpSidebar( $opt_name, $content );
    /*
     * <--- END HELP TABS
     */

    $atts = wc_get_attribute_taxonomies();

    $enabled = array(
            'im' => 'تصویر',
            'ti' => 'عنوان',
            're' => 'نظرات',
            'pr' => 'قیمت',
            'sk' => 'شاخص',
            'ex' => 'توضیحات کوتاه',
            'di' => 'ابعاد',
            'we' => 'وزن',
            'rm' => 'بیشتر',
    );

    $temp = array();
    if(!empty($atts)) {
        foreach ($atts as $value) {
            $temp['attr-' . $value->attribute_name] = $value->attribute_label;
        }
    }

    $enabled = array_merge($enabled, $temp);

    // Attribute Groups
    $args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'orderby' => 'menu_order', 'suppress_filters' => 0);
    $attribute_groups = get_posts( $args );

    $temp = array();
    if(!empty($attribute_groups)) {
        foreach ($attribute_groups as $attribute_group) {
            $temp['group-' . $attribute_group->ID] = __('Group:', 'woocommerce-better-compare') . ' ' . $attribute_group->post_title;
        }
    }
    $enabled = array_merge($enabled, $temp);

    $dataToShow = array(
        'enabled' => $enabled,
        'disabled' => array(
            'de' => 'توضیحات',
            'st' => 'موجود',
            'va' => 'متغیر ها',
            'ca' => 'افزودن به سبد خرید',
        )
    );

    /*
     *
     * ---> START SECTIONS
     *
     */

    Redux::setSection( $opt_name, array(
        'title'  => 'مقایسه محصول و گروه بندی ویژگی ها',
        'id'     => 'general',
        'icon'   => 'el el-home',
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => 'عمومی',
        // 'desc'       => __('', 'woocommerce-better-compare' ),
        'id'         => 'general-settings',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'enable',
                'type'     => 'checkbox',
                'title'    => ' فعال سازی لیست مقایسه',
                'default'  => '1',
            ),
            array(
                'id'       => 'enablegp',
                'type'     => 'checkbox',
                'title'    => 'فعال سازی گروه بندی ویژگی ها',
            ),

            array(
                'id'       => 'enableGroupedAttributes',
                'type'     => 'checkbox',
                'title'    =>'فعال سازی گروه بندی ویژگی ها در مقایسه',
                'default'  => '0',
            ),

            array(
                'id'       => 'multipleAttributesInGroups',
                'type'     => 'checkbox',
                'title'    => 'ویژگی چندتایی',
                'subtitle' => __( 'به ویژگی ها اجازه دهید در چندین گروه ویژگی باشند. <br/>
به عنوان مثال. ویژگی رنگ می تواند در بیش از 1 گروه ویژگی 
باشد!', 'woocommerce-group-attributes' ),
                'default' => 0
            ),
            // array(
            //     'id'       => 'enableDraggable',
            //     'type'     => 'checkbox',
            //     'title'    => __('Enable Draggable', 'woocommerce-better-compare' ),
            //     'subtitle' => __('Users can drag and drop products to the compare bar.', 'woocommerce-better-compare' ),
            //     'default'  => '0',
            // ),
            array(
                'id'       => 'maxProducts',
                'type'     => 'spinner',
                'title'    => 'حداکثر محصول برای مقایسه',
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '20',
            ),

        )
    ) );



    Redux::setSection( $opt_name, array(
        'title'      => 'نوار مقایسه و جداول',
        // 'desc'       => __('', 'woocommerce-better-compare' ),
        'id'         => 'compareBarSettings',
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'hideSimilarities',
                'type'     => 'checkbox',
                'title'    => 'مخفی کردن موارد مشابه',
                'subtitle' => 'نمایش آپشن مخفی کردن موارد مشابه',
                'default'  => '1',
                'required' => array('compareBar', 'equals', '1'),
            ),

            array(
                'id'       => 'compareBar',
                'type'     => 'checkbox',
                'title'    => 'نمایش نوار مقایسه',
                'default'  => '1',
            ),

            array(
               'id' => 'section-compare-bar',
               'type' => 'section',
               'title' => 'سبک های نوار مقایسه',
               'subtitle' => __('Styles for the compare bar.', 'woocommerce-better-compare'),
               'indent' => false,
               'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareBarTextColor',
                'type'      => 'color',
                'title'    => __('Compare Bar Text Color', 'woocommerce-better-compare'),
                'subtitle' => __('Text Color of the compare bar', 'woocommerce-better-compare'),
                'default'   => '#333',
                'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareBarBackgroundColor',
                'type'      => 'color_rgba',
                'title'    => __('Compare Bar Background Color', 'woocommerce-better-compare'),
                'subtitle' => __('Background Color of the compare bar', 'woocommerce-better-compare'),
                // See Notes below about these lines.
                //'output'    => array('background-color' => '.site-header'),
                //'compiler'  => array('color' => '.site-header, .site-footer', 'background-color' => '.nav-bar'),
                'default'   => array(
                    'color'     => '#FFFFFF',
                    'alpha'     => 0.98
                ),
                // These options display a fully functional color palette.  Omit this argument
                // for the minimal color picker, and change as desired.
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => true,
                    'show_alpha'                => true,
                    'show_palette'              => true,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => true,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                ),
                'required' => array('compareBar', 'equals', '1'),
            ),
            array(
               'id' => 'section-compare-table',
               'type' => 'section',
               'title' => __('Compare Table Styles', 'woocommerce-better-compare'),
               'subtitle' => __('Styles for the flyout compare table.', 'woocommerce-better-compare'),
               'indent' => false,
               'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareTableTextColor',
                'type'      => 'color',
                'title'    => __('Compare Table Text Color', 'woocommerce-better-compare'),
                'subtitle' => __('Text Color of the compare Table', 'woocommerce-better-compare'),
                'default'   => '#333',
                'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareTableBackgroundColor',
                'type'      => 'color_rgba',
                'title'    => __('Compare Table Background Color', 'woocommerce-better-compare'),
                'subtitle' => __('Background Color of the compare Table', 'woocommerce-better-compare'),
                'default'   => array(
                    'color'     => '#ffffff',
                ),
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => true,
                    'show_alpha'                => true,
                    'show_palette'              => true,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => true,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                ),
                'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareTableOddBackgroundColor',
                'type'      => 'color_rgba',
                'title'    => __('Compare Table Odd Background Color', 'woocommerce-better-compare'),
                'default'   => array(
                    'color'     => '#f3f3f3',
                ),
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => true,
                    'show_alpha'                => true,
                    'show_palette'              => true,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => true,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                ),
                'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareTableEvenBackgroundColor',
                'type'      => 'color_rgba',
                'title'    => __('Compare Table Even Background Color', 'woocommerce-better-compare'),
                'default'   => array(
                    'color'     => '#ffffff',
                    'alpha'     => 0.9
                ),
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => true,
                    'show_alpha'                => true,
                    'show_palette'              => true,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => true,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                ),
                'required' => array('compareBar', 'equals', '1'),
            ),
            array(
                'id'        => 'compareTableHighlightBackgroundColor',
                'type'      => 'color_rgba',
                'title'    => __('Compare Table Highlight Background Color', 'woocommerce-better-compare'),
                'default'   => array(
                    'color'     => '#d30000',
                    'alpha'     => 0.9
                ),
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => true,
                    'show_alpha'                => true,
                    'show_palette'              => true,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => true,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Color'
                ),
                'required' => array('compareBar', 'equals', '1'),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => 'داده ها برای مقایسه',
        // 'desc'       => __('Custom stylesheet / javascript.', 'woocommerce-better-compare' ),
        'id'         => 'data',
        'subsection' => true,
        'fields'     =>  array(
            array(
                'id'      => 'dataToCompare',
                'type'    => 'sorter',
                'options' => $dataToShow
            ),
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      =>'صفحه محصول',
        'id'         => 'display',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'displayButtonOnProductPage',
                'type'     => 'checkbox',
                'title'    => 'نمایش دکمه مقایسه در صفحه محصول',
                'default'  => '1',
            ),

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => 'تنظیمات پیشرفته',
        'desc'       => 'طرح ها و جاوا اسکریپت سفارشی',
        'id'         => 'advanced',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'customCSS',
                'type'     => 'ace_editor',
                'mode'     => 'css',
                'title'    => 'css سفارشی',
            ),
            array(
                'id'       => 'customJS',
                'type'     => 'ace_editor',
                'mode'     => 'javascript',
                'title'    => 'جاوا اسکریپت سفارشی',
            ),
        )
    ));


    /*
     * <--- END SECTIONS
     */
