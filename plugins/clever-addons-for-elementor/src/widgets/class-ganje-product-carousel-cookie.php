<?php
namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
/**
 * CleverProductCarousel
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
if (class_exists('WooCommerce')):
    final class GanjeProductCarouselCookie extends CleverWidgetBase
    {
        /**
         * @return string
         */
        public $admin_editor_js;
        function get_name()
        {
            return 'gnj-product-carousel-cookie';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return 'اسلایدر محصول بر اساس آخرین بازید کاربر';
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font clever-icon-carousel';
        }
        public function editor_js() {
            echo $this->admin_editor_js ;
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
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_title', [
                'label' => 'عنوان'
            ]);

            $this->add_control('title', [
                'label'		    => 'عنوان',
                'type'		    => Controls_Manager::TEXT,
                'default'       => 'محصولات پیشنهادی',
            ]);

            $this->end_controls_section();


            $this->start_controls_section(
                'section_carousel', [
                'label' => 'گزینه ها',
            ]);
            $this->add_control('posts_per_page', [
                'label'         => 'تعداد محصولات برای نمایش',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 6,
            ]);
            $this->add_responsive_control('slides_to_show_row',[
                'label'         =>'تعداد ردیف',
                'type'          => Controls_Manager::SLIDER,
                'range' => [
                    'px' =>[
                        'min' => 1,
                        'max' => 6,
                    ]
                ],
                'devices' => [ 'desktop', 'mobile' ],
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

            ]);
            $this->add_responsive_control('slides_to_show_columns',[
                'label'         =>'تعداد ستون',
                'type'          => Controls_Manager::SLIDER,
                'range' => [
                    'px' =>[
                        'min' => 1,
                        'max' => 6,
                    ]
                ],
                'devices' => [ 'desktop', 'mobile' ],
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

            ]);

            $this->add_control('autoplay', [
                'label'         => 'اسلاید خودکار',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'پنهان',
                'return_value' => 'true',
                'default' => 'true',
            ]);
            $this->add_control('show_pag', [
                'label'         => 'نمایش نقاط ناوبری',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'پنهان',
                'return_value' => 'true',
                'default' => 'true',
            ]);
            $this->add_control('show_nav', [
                'label'         => 'نمایش فلش های ناوبری',
                'description'   => __('', 'cafe'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'پنهان',
                'return_value' => true,
                'default' => true,
            ]);
            $this->end_controls_section();

            $this->start_controls_section(
                'normal_style_settings', [
                'label' => 'طرح بندی',
                'tab' => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_control('title_color', [
                'label' => 'رنگ عنوان',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cafe-title' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .cafe-title',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );
            $this->add_control('title_background', [
                'label' => 'رنگ پس زمینه متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cafe-title' => 'background: {{VALUE}};'
                ]
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
         * Render
         */
        protected function render()
        {
            // default settings
            $settings = array_merge([
                'title'                 => '',
                'filter_categories'     => '',
                'product_ids'           => '',
                'asset_type'            => 'all',
                'orderby'               => 'date',
                'order'                 => 'desc',
                'posts_per_page'        => 6,
                'slides_to_show'        => 4,
                'speed'                 => 5000,
                'scroll'                => 1,
                'autoplay'              => 'true',
                'show_pag'              => 'true',
                'show_nav'              => 'true',
                'nav_position'          => 'middle-nav',

            ], $this->get_settings_for_display());

            $this->add_inline_editing_attributes('title');

            $this->add_render_attribute('title', 'class', 'cafe-title');
            if(isset( $_COOKIE['ProductCookie'] ))
            $this->getViewTemplate('template', 'product-carousel-cookie', $settings);

        }

    }
endif;
