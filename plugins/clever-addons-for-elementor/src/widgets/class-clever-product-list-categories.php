<?php

namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * CleverProductListCategories
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
if (class_exists('WooCommerce')):
    final class CleverProductListCategories extends CleverWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'clever-product-list-categories';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Clever Product Categories List', 'cafe');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font clever-icon-cart-3';
        }
        public function get_script_depends()
        {
            return ['jquery-slick', 'cafe-script'];
        }
        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_title', [
                'label' => __('Title', 'cafe')
            ]);

            $this->add_control('title', [
                'label' => __('Title', 'cafe'),
                'type' => Controls_Manager::TEXT,
                'default' => __('CAFE Woo', 'cafe'),
            ]);

            $this->end_controls_section();

            $this->start_controls_section(
                'section_filter', [
                'label' => __('Filter', 'cafe')
            ]);
            $this->add_control('layout', [
                'label' => __('Layout', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('Grid', 'cafe'),
                    'carousel' => __('Carousel', 'cafe'),
                ],
            ]);
            $this->add_control('layout_style', [
                'label' => __('Layout style', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SELECT,
                'default' => 'sub_cate',
                'options' => [
                    'sub_cate' => __('Sub categories', 'cafe'),
                    'list_cate' => __('List categories', 'cafe'),
                ],
            ]);
            $this->add_control('filter_parent_categories', [
                'label' => __('Parent categories', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SELECT2,
                'default' => '',
                'multiple' => true,
                'options' => $this->get_parent_categories_for_cafe('product_cat', 2),
                'condition' => [
                    'layout_style' => 'sub_cate',
                ],
            ]);
            $this->add_control('filter_categories', [
                'label' => __('Categories', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SELECT2,
                'default' => '',
                'multiple' => true,
                'options' => $this->get_categories_for_cafe('product_cat', 2),
                'condition' => [
                    'layout_style' => 'list_cate',
                ],
            ]);

            $this->add_responsive_control('columns', [
                'label' => __('Columns for row', 'cafe'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    'layout' => 'grid',
                ],
                'range' => [
                    'col' => [
                        'min' => 1,
                        'max' => 6,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
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
            ]);
            $this->add_control('max_sub_cat', [
                'label' => __('Maximum sub cat', 'cafe'),
                'description' => __('Maximum sub cat display, leave it 0 if want display all', 'cafe'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
                'condition' => [
                    'layout_style' => 'sub_cate',
                ],
            ]);
            $this->add_control('show_view_more', [
                'label' => __('Show view more', 'cafe'),
                'description' => __('Work with case number sub categories more than Maximum sub cat', 'cafe'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'layout_style' => 'sub_cate',
                ],
            ]);
            $this->add_control('show_view_more_text', [
                'label' => __('View more text', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'show_view_more' => 'true',
                ],
            ]);

            $this->add_control('speed', [
                'label' => __('Carousel: Speed to Scroll', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('slides_to_show',[
                'label'         => __( 'Slides to Show', 'elementor' ),
                'type'          => Controls_Manager::SLIDER,
                'condition' => [
                    'layout' => 'carousel',
                ],
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
                
            ]);
            $this->add_control('scroll', [
                'label' => __('Carousel: Slide to Scroll', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'condition' => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('autoplay', [
                'label' => __('Carousel: Auto Play', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'cafe'),
                'label_off' => __('Hide', 'cafe'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('show_pag', [
                'label' => __('Carousel: Pagination', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'cafe'),
                'label_off' => __('Hide', 'cafe'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('show_nav', [
                'label' => __('Carousel: Navigation', 'cafe'),
                'description' => __('', 'cafe'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'cafe'),
                'label_off' => __('Hide', 'cafe'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->end_controls_section();

            $this->start_controls_section(
                'normal_style_settings', [
                'label' => __('Heading', 'cafe'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_control('title_color', [
                'label' => __('Title Color', 'cafe'),
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
                'label' => __('Title Background', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cafe-title' => 'background: {{VALUE}};'
                ]
            ]);


            $this->end_controls_section();
            $this->start_controls_section(
                'content_style_settings', [
                'label' => __('Content Block', 'cafe'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]);
            $this->add_control('content_block_bg', [
                'label' => __('Background', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wrap-content-category-item' => 'background: {{VALUE}};'
                ]
            ]);
            $this->add_responsive_control('content_block_padding', [
                'label' => __('Padding', 'cafe'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wrap-content-category-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]);
            $this->add_responsive_control('content_block_border_radius', [
                'label' => __('Border Radius', 'cafe'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wrap-content-category-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]);
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'content_block_border',
                    'label' => __('Border', 'cafe'),
                    'placeholder' => '1px',
                    'default' => '1px',
                    'selector' => '{{WRAPPER}} .wrap-content-category-item',
                    'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'content_block_shadow',
                    'separator' => 'before',
                    'selector' => '{{WRAPPER}} .wrap-content-category-item',
                ]
            );
            $this->end_controls_section();
            $this->start_controls_section(
                'normal_parent_style_settings', [
                'label' => __('Category Heading', 'cafe'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]);
            $this->add_responsive_control(
                'cat_heading_align',
                [
                    'label' => __('Align', 'cafe'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', 'cafe'),
                            'icon' => 'fa fa-align-left',
                        ],
                        'none' => [
                            'center' => __('Center', 'cafe'),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', 'cafe'),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .category-content .product-category-heading' => 'text-align: {{VALUE}};'
                    ]
                ]
            );
            $this->add_control('parent_category_color', [
                'label' => __('Color', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-content .product-category-heading a' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('parent_category_color_hover', [
                'label' => __('Color Hover', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-content .product-category-heading a:hover' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'parent_category_typography',
                    'selector' => '{{WRAPPER}} .category-content .product-category-heading',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );
            $this->add_responsive_control('parent_category_space', [
                'label' => __('Space', 'cafe'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-content .product-category-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]);
            $this->end_controls_section();
            $this->start_controls_section(
                'cat_style_settings', [
                'label' => __('Sub Category item', 'cafe'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style' => 'sub_cate',
                ],
            ]);
            $this->add_responsive_control(
                'cat_align',
                [
                    'label' => __('Align', 'cafe'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', 'cafe'),
                            'icon' => 'fa fa-align-left',
                        ],
                        'none' => [
                            'center' => __('Center', 'cafe'),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', 'cafe'),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .category-content .category-item' => 'text-align: {{VALUE}};'
                    ]
                ]
            );
            $this->add_control('cat_color', [
                'label' => __('Color', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-content .category-item a' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('cat_color_hover', [
                'label' => __('Color Hover', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .category-content .category-item a:hover' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'cat_typography',
                    'selector' => '{{WRAPPER}} .category-content .category-item',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );
            $this->add_responsive_control('cat_space', [
                'label' => __('Space', 'cafe'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}  .category-content .category-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]);
            $this->end_controls_section();
            $this->start_controls_section(
                'viewmore_style_settings', [
                'label' => __('View More', 'cafe'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_view_more' => 'true',
                ],
            ]);
            $this->add_responsive_control(
                'viewmore_align',
                [
                    'label' => __('Align', 'cafe'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', 'cafe'),
                            'icon' => 'fa fa-align-left',
                        ],
                        'none' => [
                            'center' => __('Center', 'cafe'),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', 'cafe'),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .category-content' => 'text-align: {{VALUE}};'
                    ]
                ]
            );
            $this->add_control('viewmore_color', [
                'label' => __('Color', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-content .view-more' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('viewmore_color_hover', [
                'label' => __('Color Hover', 'cafe'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .category-content .view-more:hover' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'viewmore_typography',
                    'selector' => '{{WRAPPER}} .category-content .view-more',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );
            $this->add_responsive_control('viewmore_space', [
                'label' => __('Space', 'cafe'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}  .category-content .view-more' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
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
                'layout'                => 'grid',
                'layout_style'          => 'sub_cate',
                'filter_parent_categories' => '',
                'filter_categories'     => '',
                'max_sub_cat'           => '4',
                'show_view_more'        => 'false',
                'columns'               => 4,
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

            $this->getViewTemplate('template', 'product-list-categories', $settings);
        }
    }
endif;