<?php
namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * GanjeInstagram
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */

final class GanjeInstagram extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-instagram';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'اینستاگرام گنجه';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-landscape-image';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_setting', [
                'label' => 'تنظیمات',
            ]);

        $this->add_control('title', [
            'label'		    => 'عنوان',
            'type'		    => Controls_Manager::TEXT,
            'default'       => 'اینستاگرام گنجه',
        ]);
        $this->add_control('username', [
            'label'         => 'username@',
            'description'   => 'نام کاربری یا هشتگ مورد نظر خود را وارد کنید.',
            'type'          => Controls_Manager::TEXT,
        ]);
        $this->add_control('number', [
            'label'         => 'تعداد تصاویر',
            'type'          => Controls_Manager::NUMBER,
        ]);

        $this->add_control('img_size', [
            'label'         => 'اندازه تصویر',
            'description'   => __('', 'gnje'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'small',
            'options' => [
                'thumbnail'     => __( 'Thumbnail', 'gnje' ),
                'small'         => __( 'Small', 'gnje' ),
                'large'         => __( 'Large', 'gnje' ),
                'original'      => __( 'Original', 'gnje' ),
            ],
        ]);
        $this->add_control('show_likes', [
            'label'         => 'نمایش تعداد لایک ها',
            'description'   => __('', 'gnje'),
            'type'          => Controls_Manager::SWITCHER,
            'label_on' => 'نمایش',
            'label_off' => 'مخفی',
            'return_value' => 'true',
            'default' => 'true',
        ]);
        $this->add_control('show_comments', [
            'label'         => 'نمایش تعداد کامنت ها',
            'description'   => __('', 'gnje'),
            'type'          => Controls_Manager::SWITCHER,
            'label_on' =>  'نمایش',
            'label_off' => 'مخفی',
            'return_value' => 'true',
            'default' => 'true',
        ]);
        $this->add_control('show_type', [
            'label'         => 'نمایش آیکون برای (تصویر / ویدئو)',
            'description'   => __('', 'gnje'),
            'type'          => Controls_Manager::SWITCHER,
            'label_on' =>  'نمایش',
            'label_off' => 'مخفی',
            'return_value' => 'true',
            'default' => 'true',
        ]);


        $this->add_control('layout', [
            'label'         => 'چیدمان',
            'description'   => __('', 'gnje'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'grid',
            'options' => [
                'grid'      => 'جدولی',
            ],
        ]);

            //Grid
        $this->add_responsive_control('columns',[
            'label'         => 'تعداد ستون در هر ردیف',
            'type'          => Controls_Manager::SLIDER,
            'range' => [
                'col' =>[
                    'min' => 1,
                    'max' => 6,
	                'step' => 1,
                ]
            ],
            'devices' => [ 'desktop', 'tablet', 'mobile' ],
            'desktop_default' => [
                'size' => 4,
                'unit' => 'col',
            ],
            'tablet_default' => [
                'size' => 3,
                'unit' => 'col',
            ],
            'mobile_default' => [
                'size' => 2,
                'unit' => 'col',
            ],
            'condition'     => [
                'layout' => 'grid',
            ],

        ]);
            //Slide

        $this->end_controls_section();

    }
    /**
     * Load style
     */
    public function get_style_depends()
    {
        return ['gnje-style'];
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['jquery-slick', 'gnje-script'];
    }
    /**
     * Render
     */
    protected function render()
    {
        // default settings
        $settings = array_merge([
            'title'             => '',
            'username'          => '',
            'number'            => '',

            'img_size'          => 'large',
            'show_likes'        => '',
            'show_comments'     => '',
            'show_type'         => '',
            'show_time'         => '',
            'time_layout'       => 'elapsed',
            'date_format'       => '',
            'layout'            => 'carousel',
            'columns'           => '',

            'slides_to_show'    => 4,
            'speed'             => 5000,
            'scroll'            => 1,
            'autoplay'          => 'true',
            'show_pag'          => 'true',
            'show_nav'          => 'true',
            'nav_position'      => 'middle-nav',

        ], $this->get_settings_for_display());

        $this->add_inline_editing_attributes('title');

        $this->getViewTemplate('template', 'instagram', $settings);
    }
}

