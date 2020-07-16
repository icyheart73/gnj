<?php
namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
/**
 * GanjeProductCarousel
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if (class_exists('WooCommerce')):
    final class GanjeProductCarousel extends GanjeWidgetBase
    {
        /**
         * @return string
         */
	    public $admin_editor_js;
        function get_name()
        {
            return 'ganje-product-carousel';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return 'اسلایدر محصول';
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font ganje-icon-carousel';
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
                    'default'       => 'محصولات گنجه',
                ]);

            $this->end_controls_section();

            $this->start_controls_section(
                'section_filter', [
                    'label' => 'فیلتر',
                ]);

                $this->add_control('filter_categories', [
                    'label'         => 'دسته بندی ها',
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'multiple'      => true,
                    'options'       => $this->get_categories_for_gnje('product_cat', 2 ),
                ]);
                $this->add_control('product_ids', [
                    'label'         => 'آیدی محصولات استثنا',
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'multiple'      => true,
                    'options'       => $this->get_list_posts('product'),
                ]);
                $this->add_control('asset_type', [
                    'label'         => 'فیلتر محصولات :',
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'all',
                    'options'       => $this->get_woo_asset_type_for_gnje(),
                ]);
                $this->add_control('orderby', [
                    'label'         => 'مرتب سازی بر اساس :',
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'date',
                    'options'       => $this->get_woo_order_by_for_gnje(),
                ]);
                $this->add_control('order', [
                    'label'         => 'ترتیب',
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'desc',
                    'options'       => $this->get_woo_order_for_gnje(),
                ]);


            $this->end_controls_section();

            $this->start_controls_section(
                'section_carousel', [
                    'label' => 'گزینه ها',
                ]);
		        $this->add_control('posts_per_page', [
			        'label'         => 'تعداد محصولات برای نمایش',
			        'description'   => __('', 'gnje'),
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
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => 'نمایش',
                    'label_off' => 'پنهان',
                    'return_value' => 'true',
                    'default' => 'true',
                ]);
                $this->add_control('show_pag', [
                    'label'         => 'نمایش نقاط ناوبری',
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => 'نمایش',
                    'label_off' => 'پنهان',
                    'return_value' => 'true',
                    'default' => 'true',
                ]);
                $this->add_control('show_nav', [
                    'label'         => 'نمایش فلش های ناوبری',
                    'description'   => __('', 'gnje'),
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
                        '{{WRAPPER}} .gnje-title' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => 'title_typography',
                        'selector' => '{{WRAPPER}} .gnje-title',
                        'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    ]
                );
                $this->add_control('title_background', [
                    'label' => 'رنگ پس زمینه متن',
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-title' => 'background: {{VALUE}};'
                    ]
                ]);


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

            $this->add_render_attribute('title', 'class', 'gnje-title');

            $this->getViewTemplate('template', 'product-carousel', $settings);

        }

    }
endif;
