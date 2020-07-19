<?php 
namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
/**
 * GanjeProductAdvanced
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if (class_exists('WooCommerce')):
    final class GanjeProductAdvanced extends GanjeWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'ganje-product-advanced';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Ganje Product Advanced', 'gnje');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font ganje-icon-cart-3';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_setting', [
                    'label' => __('Setting', 'gnje')
                ]);

                $this->add_control('title', [
                    'label'         => __('Title', 'gnje'),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => __( 'GNJE Woo', 'gnje' ),
                ]);

                $this->add_control('layout', [
                    'label'         => __('Layout', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'grid',
                    'options' => [
                        'grid'  => __( 'Grid', 'gnje' ),
                        'carousel' => __( 'Carousel', 'gnje' ),
                    ],
                ]);
                
                $this->add_control('tabs_filter', [
                    'label'         => __('Filter', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options' => [
                        'none'  => __( 'None', 'gnje' ),
                        'cate'  => __( 'Category', 'gnje' ),
                        'asset' => __( 'Asset type', 'gnje' ),
                    ],
                    
                ]);
            $this->end_controls_section();

            $this->start_controls_section(
                'section_options', [
                    'label' => __('Options', 'gnje')
                ]);
                //Cate
                $this->add_control('filter_categories', [
                    'label'         => __('Categories', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'multiple'      => true,
                    'options'       => $this->get_categories_for_gnje('product_cat', 2),
                    'condition'     => [
                        'tabs_filter' => ['none','cate'] ,
                    ],
                ]);
                $this->add_control('default_category', [
                    'label'         => __('Default categories', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => $this->get_categories_for_gnje('product_cat'),
                    'condition'     => [
                        'tabs_filter' => 'cate',
                    ],
                ]);
                $this->add_control('asset_type', [
                    'label'         => __('Asset type', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'all',
                    'options'       => $this->get_woo_asset_type_for_gnje(),
                    'condition'     => [
                        'tabs_filter' => ['none','cate'] ,
                    ],
                ]);

                    // Asset
                $this->add_control('filter_assets', [
                    'label'         => __('Asset type', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'multiple'      => true,
                    'options'       => $this->get_woo_asset_type_for_gnje(2),
                    'condition'     => [
                        'tabs_filter' => 'asset',
                    ],
                ]);
                $this->add_control('default_asset', [
                    'label'         => __('Default asset', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => $this->get_woo_asset_type_for_gnje(),
                    'condition'     => [
                        'tabs_filter' => 'asset',
                    ],
                ]);
                
                    // Filter default
                $this->add_control('product_ids', [
                    'label'         => __('Exclude product IDs', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'multiple'      => true,
                    'options'       => $this->get_list_posts('product'),
                ]);
                $this->add_control('orderby', [
                    'label'         => __('Order by', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'date',
                    'options'       => $this->get_woo_order_by_for_gnje(),
                ]);
                $this->add_control('order', [
                    'label'         => __('Order', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'desc',
                    'options'       => $this->get_woo_order_for_gnje(),
                ]);

                $this->add_control('posts_per_page', [
                    'label'         => __('Products per pages', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 6,
                ]);
                    // Grid
                $this->add_responsive_control('columns',[
                    'label'         => __( 'Columns for row', 'gnje' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range' => [
                        'col' =>[
                            'min' => 1,
                            'max' => 6,
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
                $this->add_control('pagination', [
                    'label'         => __('Pagination', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options' => [
                        'none'      => __( 'None', 'gnje' ),
                        'numeric'   => __( 'Numeric', 'gnje' ),
                        'ajaxload'  => __( 'Ajax Load More', 'gnje' ),
                        'infinity'  => __( 'Infinity Scroll', 'gnje' ),
                    ],
                    'condition'     => [
                        'layout'        => 'grid',
                        'tabs_filter'   => 'none',
                    ],
                ]);
                    // Carousel
                $this->add_responsive_control('slides_to_show',[
                    'label'         => __( 'Slides to Show', 'elementor' ),
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
                    'condition'     => [
                        'layout' => 'carousel',
                    ],
                    
                ]);

                $this->add_control('speed', [
                    'label'         => __('Carousel: Speed to Scroll', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 5000,
                    'condition'     => [
                        'layout' => 'carousel',
                    ],
                    
                ]);
                $this->add_control('scroll', [
                    'label'         => __('Carousel: Slide to Scroll', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 1,
                    'condition'     => [
                        'layout' => 'carousel',
                    ],
                ]);
                $this->add_responsive_control('autoplay', [
                    'label'         => __('Carousel: Auto Play', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'gnje' ),
                    'label_off' => __( 'Hide', 'gnje' ),
                    'return_value' => 'true',
                    'default' => 'true',
                    'condition'     => [
                        'layout' => 'carousel',
                    ],
                ]);
                $this->add_responsive_control('show_pag', [
                    'label'         => __('Carousel: Pagination', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'gnje' ),
                    'label_off' => __( 'Hide', 'gnje' ),
                    'return_value' => 'true',
                    'default' => 'true',
                    'condition'     => [
                        'layout' => 'carousel',
                    ],
                ]);
                $this->add_responsive_control('show_nav', [
                    'label'         => __('Carousel: Navigation', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'gnje' ),
                    'label_off' => __( 'Hide', 'gnje' ),
                    'return_value' => 'true',
                    'default' => 'true',
                    'condition'     => [
                        'layout' => 'carousel',
                    ],
                ]);
                $this->add_control('nav_position', [
                    'label'         => __('Carousel: Navigation position', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'middle-nav',
                    'options' => [
                        'top-nav'       => __( 'Top', 'gnje' ),
                        'middle-nav'    => __( 'Middle', 'gnje' ),
                    ],
                    'condition'     => [
                        'show_nav'  => 'true',
                        'layout'    => 'carousel',
                    ],

                ]);
            $this->end_controls_section();

            $this->start_controls_section(
                'normal_style_settings', [
                    'label' => __('Heading style', 'gnje'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]);
                
                $this->add_control('title_color', [
                    'label' => __('Color', 'gnje'),
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
                    'label' => __('Background', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-title' => 'background: {{VALUE}};'
                    ]
                ]);
            $this->end_controls_section();

            $this->start_controls_section(
                'filter_style_settings', [
                    'label' => __('Filter style', 'gnje'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]);
                $this->add_responsive_control('filter_align',[
                    'label' => __('Align', 'gnje'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'flex-start' => [
                            'title' => __('Left', 'gnje'),
                            'icon' => 'fa fa-align-left',
                        ],'center' => [
                            'title' => __('Center', 'gnje'),
                            'icon' => 'fa fa-align-center',
                        ],
                        'flex-end' => [
                            'title' => __('Right', 'gnje'),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gnje-head-product-filter' => 'justify-content: {{VALUE}};'
                    ]
                ]);
                $this->add_control('filter_color', [
                    'label' => __('Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                    '{{WRAPPER}} .gnje-head-product-filter a' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_control('filter_active_color', [
                    'label' => __('Active Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-head-product-filter a.active, {{WRAPPER}} .gnje-head-product-filter a:hover' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_group_control(
                    Group_Control_Typography::get_type(),[
                        'name' => 'filter_typography',
                        'selector' => '{{WRAPPER}} .gnje-head-product-filter a',
                        'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    ]
                );
                $this->add_control( 'filter_space', [
                    'label'     => __( 'Space', 'gnje' ),
                    'description'     => __( 'Space between filter item', 'gnje' ),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'selectors' => [
                       '{{WRAPPER}} .gnje-head-product-filter li' => 'padding-left: {{SIZE}}{{UNIT}};',
                   ],
               ] );
                $this->add_responsive_control('filter_padding', [
                    'label' => __('Padding', 'gnje'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'separator'   => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .gnje-head-product-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->end_controls_section();
                $this->start_controls_section('carousel_style_settings', [
                    'label' => __('Carousel style', 'gnje'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]);
                $this->add_control('arrow_style', [
                    'label' => __('Arrow', 'gnje'),
                    'type' => Controls_Manager::HEADING,
                ]);
                $this->add_control('arrow_color', [
                    'label' => __('Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_control('arrow_hover_color', [
                    'label' => __('Hover Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                    '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn:hover' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_control( 'arrow_size', [
                    'label'     => __( 'Size', 'gnje' ),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                       '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'padding-left: {{SIZE}}{{UNIT}};',
                   ],
               ] );
                $this->add_control('dotted_style', [
                    'label' => __('Dotted', 'gnje'),
                    'type' => Controls_Manager::HEADING,
                    'separator'   => 'before',
                ]);
                $this->add_control('dotted_color', [
                    'label' => __('Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'background: {{VALUE}};'
                    ]
                ]);
                $this->add_control('dotted_hover_color', [
                    'label' => __('Hover & Active Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                    '{{WRAPPER}} .gnje-carousel ul.slick-dots li:hover, {{WRAPPER}} .gnje-carousel ul.slick-dots li.slick-active' => 'background: {{VALUE}};'
                    ]
                ]);
                $this->add_control( 'dotted_size', [
                    'label'     => __( 'Size', 'gnje' ),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                       'px' => [
                            'min' => 0,
                            'max' => 100,
                    ],
                ],
                    'selectors' => [
                       '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                       '{{WRAPPER}} .gnje-carousel ul.slick-dots li.slick-active' => 'width: calc({{SIZE}}{{UNIT}} * 3);',
                   ],
                ] );
                $this->add_control( 'dotted_radius', [
                    'label'     => __( 'Border radius', 'gnje' ),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                       '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ],
                ] );
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
                'title'                 => '',
                'tabs_filter'           => 'cate',
                'filter_categories'     => '',
                'default_category'      => '',
                'asset_type'            => 'all',
                'filter_assets'         => '',
                'default_asset'         => '',
                'product_ids'           => '',
                'orderby'               => 'date',
                'order'                 => 'desc',
                'posts_per_page'        => 6,
                'columns'               => '',
                'pagination'            => '',
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

            $this->getViewTemplate('template', 'product-advanced', $settings);
        }
    }
endif;