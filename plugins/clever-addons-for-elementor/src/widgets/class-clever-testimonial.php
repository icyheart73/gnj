<?php

namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * Clever Testimonial
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverTestimonial extends CleverWidgetBase
{
    /**
     * @return string
     */

	public $admin_editor_js;

    function get_name()
    {
        return 'clever-testimonial';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'نظرات کاربران';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font clever-icon-quote-1';
    }
	public function editor_js() {
		echo $this->admin_editor_js ;
	}

    /**
     * Register controls
     */
    protected function _register_controls()
    {

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('author_avatar', [
            'label' => 'آواتار',
            'type' => Controls_Manager::MEDIA,
        ]);
        $repeater->add_control(
            'author',
            [
                'label' => 'نویسنده',
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'author_des',
            [
                'label' => 'توصیف نویسنده',
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control('star', [
            'label' => 'ستاره',
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 5,
                ]
            ],

        ]);
        $repeater->add_control(
            'testimonial_content',
            [
                'label' => 'محتوای نظرات',
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->start_controls_section('content_settings', [
            'label' => 'تنظیمات محتوا',
        ]);
        $this->add_control('content', [
            'label' => 'محتوا',
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ author }}}',
            'default' => [
                [
                    'author' => 'نظر اول',
                ],
                [
                    'author' => 'نظر دوم',
                ],
                [
                    'author' => 'نظر سوم',
                ],
            ],

        ]);
        $this->end_controls_section();
        $this->start_controls_section('layout_settings', [
            'label' => 'تنظیمات چیدمان',
        ]);
        $this->add_control('show_quotation', [
            'label' => 'فعال کردن نماد نقل قول',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('layout', [
            'label' => 'چیدمان',
            'type' => Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid' => 'جدولی',
                'swiper' => 'اسلایدر',
            ],
            'description' => 'چیدمان نظرات',
        ]);

        $this->add_responsive_control('columns', [
            'label' => 'تعداد ستون برای هر ردیف',
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 5,
                ]
            ],
            'devices' => ['desktop', 'mobile'],
            'desktop_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
            'condition' => [
                'layout' => 'grid'
            ],
        ]);
        $this->add_responsive_control('slides_to_show', [
            'label' => 'تعداد اسلاید در هر صفحه',
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 4,
                ]
            ],
            'devices' => ['desktop', 'mobile'],
            'desktop_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 1,
                'unit' => 'px',
            ],
            'condition' => [
                'layout' => 'swiper'
            ],
        ]);

        $this->add_responsive_control('show_nav', [
            'label' => 'نمایش فلش های ناوبری',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'swiper'
            ],
        ]);
        $this->add_responsive_control('show_pag', [
            'label' => 'نمایش نقاط ناوبری',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'swiper'
            ],
        ]);
        $this->add_responsive_control('autoplay', [
            'label' => 'حرکت خودکار',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'swiper'
            ],
        ]);

        $this->add_control('show_avatar', [
            'label' => 'نمایش آواتار کاربر',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('show_des', [
            'label' => 'نمایش توصیف کاربر',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('show_star', [
            'label' => 'نمایش ستاره ها',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('css_class', [
            'label' => 'کلاس HTML سفارشی',
            'type' => Controls_Manager::TEXT,
            'description' => 'می توانید یک کلاس سفارشی HTML را به عنصر اضافه نمایید.',
        ]);
        $this->end_controls_section();

    }

    /**
     * Load style
     */
    public function get_style_depends()
    {
        return ['cafe-style'];
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
        return ['swiper', 'swiper-script'];
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'content' => '',
            'layout' => 'grid',
            'style' => 'default',
            'col' => 1,
            'show_quotation' => '',
            'show_des' => '',
            'show_nav' => '',
            'show_pag' => '',
            'show_avatar' => '',
            'show_star' => 'false',
            'autoplay' => '',
            'autoplay_speed' => '3000',
            'css_class' => '',

        ], $this->get_settings_for_display());


        $this->getViewTemplate('template', 'testimonial', $settings);
    }
}
