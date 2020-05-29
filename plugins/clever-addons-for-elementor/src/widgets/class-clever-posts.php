<?php

namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Clever Posts
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverPosts extends CleverWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'clever-posts';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'پست گنجه';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font clever-icon-blog';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('content_settings', [
            'label' => 'تنظیمات محتوا',
        ]);
        $this->add_control('cat', [
            'label' => 'دسته بندی ها',
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => true,
            'description' => 'انتخاب دسته بندی برای نمایش',
            'options' => $this->get_categories_for_cafe('category', 0),
        ]);
        $this->add_control('ignore_sticky_posts', [
            'label' => esc_html__('نادیده گرفتن پست ثابت', 'cafe'),
            'description' => esc_html__('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'true',
        ]);
        $this->add_control('only_sticky_posts', [
            'label' => esc_html__('فقط نمایش پست ثابت', 'cafe'),
            'description' => esc_html__('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'نمایش',
            'label_off' => 'پنهان',
            'return_value' => 'yes',
            'default' => 'no',
        ]);
        $this->add_control('offset', [
            'label' => 'انحراف',
            'type' => Controls_Manager::NUMBER,
            'default' => '0',
        ]);
        $this->add_control('order', [
            'label' => __('مرتب سازی', 'cafe'),
            'type' => Controls_Manager::SELECT,
            'default' => 'ASC',
            'options' => [
                'ASC' => 'صعودی',
                'DESC' => 'نزولی',

            ],
        ]);
        $this->add_control('orderby', [
            'label' => 'ترتیب',
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'ID' => 'آیدی',
                'author' => 'نویسنده',
                'title' => 'عنوان',
                'name' => 'نام',
                'date' => 'تاریخ',
                'modified' => 'ویرایش شده',
                'parent' => 'ارث بری',
                'rand' => 'تصادفی',
            ],
        ]);
        $this->add_control('posts_per_page', [
            'label' => 'تعداد آیتم ها',
            'type' => Controls_Manager::NUMBER,
            'default' => '3',
            'description' => 'تعداد پست برای نمایش',
        ]);
        $this->add_control('output_type', [
            'label' => __('نمایش محتوا', 'cafe'),
            'type' => Controls_Manager::SELECT,
            'default' => 'برگزیده',
            'options' => [
                'excerpt' => 'برگزیده',
                'full' => 'محتوای کامل',
                'none' => 'هیچکدام',
            ],
            'description' => __('', 'cafe'),
        ]);
        $this->add_control('excerpt_length', [
            'label' => __('Excerpt Length', 'cafe'),
            'type' => Controls_Manager::NUMBER,
            'default' => '30',
            'condition' => [
                'output_type' => 'excerpt'
            ],
        ]);
        $this->add_control('pagination', [
            'label' => 'صفحه بندی',
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => 'هیچکدام',
                'numeric' => 'عددی',
            ],
            'condition' => [
                'layout' => ['grid','list'],
            ],
            'description' => __(' ', 'cafe'),
        ]);

        $this->end_controls_section();

        $this->start_controls_section('layout_settings', [
            'label' => 'چیدمان'
        ]);
        $this->add_control('layout', [
            'label' => 'چیدمان',
            'type' => Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid' => 'شبکه ای',
                'list' => 'لیست',
                'carousel' => 'اسلاید',
            ],
            'description' => 'چیدمان بلاگ',
        ]);
        $this->add_control('style', [
            'label' => esc_html__('سبک', 'cafe'),
            'type' =>  Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('پیش فرض', 'cafe'),
                'basic' => esc_html__('اصلی', 'cafe'),
                'boxed' => esc_html__('جعبه ای', 'cafe'),
                'image-shadow' => esc_html__('تصویر سایه ای', 'cafe'),
                'img-left' => esc_html__('تصویر چپ', 'cafe'),
                'first-large' => esc_html__('اولین بزرگتر(فقط در حالت شبکه ای)', 'cafe'),
                'content-overlay' => esc_html__('پوشش مطالب', 'cafe'),
            ],
            'condition' => [
                'layout' =>  ['carousel','grid']
            ],
        ]);
        $this->add_responsive_control('col', [
            'label' => 'ستون ها',
            'type' => Controls_Manager::NUMBER,
            'desktop_default' => '3',
            'tablet_default' =>  '1',
            'mobile_default' => '1',
            'description' => 'تعداد ستون در هر ردیف',
            'condition' => [
                'layout' => 'grid'
            ],
        ]);
        $this->add_control('image_size', [
            'label' => __('اندازه تصویر', 'cafe'),
            'type' => Controls_Manager::SELECT,
            'default' => 'medium',
            'options' => $this->getImgSizes(),
            'description' => 'انتحاب اندازه تصویر',
        ]);
        $this->add_control('show_date_post', [
            'label' => 'نمایش تاریخ پست',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('show_cat_post', [
            'label' => 'نمایش دسته بندی پست',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('show_author_post', [
            'label' => 'نمایش نویسنده پست',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_control('show_read_more', [
            'label' => 'نمایش بیشتر بخوانید',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
        ]);
        $this->add_responsive_control('slides_to_show',[
            'label'         => 'تعداد اسلاید برای نمایش',
            'type'          => Controls_Manager::SLIDER,
            'range' => [
                'px' =>[
                    'min' => 1,
                    'max' => 10,
                ]
            ],
            'devices' => [ 'desktop', 'tablet', 'mobile' ],
            'desktop_default' => [
                'size' => 4,
                'unit' => 'px',
            ],
            'tablet_default' => [
                'size' => 3,
                'unit' => 'px',
            ],
            'mobile_default' => [
                'size' => 2,
                'unit' => 'px',
            ],
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_control('scroll', [
            'label' => 'تعداد اسلاید در حرکت',
            'type' => Controls_Manager::NUMBER,
            'default' => '1',
            'description' => 'تعداد اسلاید جابجا شده در هر حرکت',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('show_nav', [
            'label' => 'کلیدهای پیمایش',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('show_pag', [
            'label' => __('نمایش نقاط صفحه بندی', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('autoplay', [
            'label' => 'حرکت خودکار',
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);

        $this->add_control('css_class', [
            'label' => __('کلاس HTML اضافی', 'cafe'),
            'type' => Controls_Manager::TEXT,
            'description' => __('کلاس HTML سفارشی برای المان', 'cafe'),
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
        return ['jquery-slick', 'cafe-script'];
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'cat' => '',
            'posts_per_page' => '3',
            'ignore_sticky_posts'=> 'true',
            'only_sticky_posts'=> 'no',
            'offset'=> '0',
            'order'=> 'ASC',
            'orderby'=> 'date',
            'output_type' => 'excerpt',
            'excerpt_length' => '30',
            'pagination' => 'none',
            'layout' => 'grid',
            'col' => '3',
            'col_table' => '1',
            'col_mobile' => '1',
            'image_size' => 'medium',
            'show_date_post' => 'false',
            'show_cat_post' => 'false',
            'show_author_post' => 'false',
            'show_read_more' => 'false',
            'show_nav' => 'false',
            'show_pag' => 'false',
            'show_avatar' => 'false',
            'autoplay' => 'false',
            'speed' => '3000',
            'css_class' => '',

        ], $this->get_settings_for_display());


        $this->getViewTemplate('template', 'posts', $settings);
    }
}
