<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

/**
 * Ganje Time Line
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeTimeLine extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-time-line';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Ganje Time Line', 'gnje');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-news-list';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('date', [
            'label' => __('Date', 'gnje'),
            'type' => Controls_Manager::TEXT,
            'description' => __('Date of time line.', 'gnje'),
        ]);
        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'gnje'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'des',
            [
                'label' => __('Description', 'gnje'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        $this->start_controls_section('settings', [
            'label' => __('Settings', 'gnje')
        ]);
        $this->add_control('timeline', [
            'label' => __('Time Line Content', 'gnje'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ date }}}',
            'separator' => 'after',
        ]);
        $this->add_control('layout', [
            'label' => __('Layout', 'gnje'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'list' => esc_html__('List', 'gnje'),
                'carousel' => esc_html__('Carousel', 'gnje'),
            ],
        ]);
        $this->add_responsive_control('cols', [
            'label' => __('Columns', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'desktop_default' => [
                'size' => 3,
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
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->add_control('center_mode', [
            'label' => __('Center mode', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'true',
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->add_control('speed', [
            'label' => __('Carousel: Speed to Scroll', 'gnje'),
            'description' => __('', 'gnje'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5000,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->add_control('scroll', [
            'label' => __('Carousel: Slide to Scroll', 'gnje'),
            'description' => __('', 'gnje'),
            'type' => Controls_Manager::NUMBER,
            'default' => 1,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->add_responsive_control('autoplay', [
            'label' => __('Carousel: Auto Play', 'gnje'),
            'description' => __('', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'gnje'),
            'label_off' => __('Hide', 'gnje'),
            'return_value' => 'true',
            'default' => 'true',
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->add_responsive_control('show_pag', [
            'label' => __('Carousel: Pagination', 'gnje'),
            'description' => __('', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'gnje'),
            'label_off' => __('Hide', 'gnje'),
            'return_value' => 'true',
            'default' => 'true',
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->add_responsive_control('show_nav', [
            'label' => __('Carousel: Navigation', 'gnje'),
            'description' => __('', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'gnje'),
            'label_off' => __('Hide', 'gnje'),
            'return_value' => 'true',
            'default' => 'true',
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                ],
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('style_settings', [
            'label' => __('Style', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_responsive_control(
            'text_align',
            [
                'label' => __('Content Align', 'gnje'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'gnje'),
                        'icon' => 'fa fa-align-left',
                    ], 'center' => [
                        'title' => __('Center', 'gnje'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'gnje'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gnje-timeline-item' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_control('border_color', [
            'label' => __('Border Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'description' => __('Border color in left side', 'gnje'),
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline' => 'border-color: {{COLOR}}',
            ],
        ]);
        $this->add_control('border_width', [
            'label' => __('Border width', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline' => 'border-left-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('dot_color', [
            'label' => __('Dot Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'description' => __('Dot color in left side', 'gnje'),
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-date::before' => 'color: {{COLOR}}',
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-date::after' => 'background-color: {{COLOR}}',
            ],
        ]);
        $this->add_control('dot_size', [
            'label' => __('Dot size', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-date::before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-date::after' => 'width: calc({{SIZE}}{{UNIT}} - 10px);height:  calc({{SIZE}}{{UNIT}} - 10px);'
            ],
        ]);
        $this->add_control('date_style_heading', [
            'label' => __('Date', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'selector' => '{{WRAPPER}} .gnje-timeline .gnje-timeline-date',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('date_color', [
            'label' => __('Date Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-date' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_control('title_style_heading', [
            'label' => __('Title', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .gnje-timeline .gnje-timeline-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('title_color', [
            'label' => __('Title Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-title' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_control('des_style_heading', [
            'label' => __('Description', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'des_typography',
                'selector' => '{{WRAPPER}} .gnje-timeline .gnje-timeline-description',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('des_color', [
            'label' => __('Description Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline .gnje-timeline-description' => 'color: {{COLOR}}',
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('style_center_mod_settings', [
            'label' => __('Center Mode', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ], [
                        'name' => 'center_mode',
                        'operator' => '==',
                        'value' => 'true',
                    ],
                ],
            ],
        ]);
        $this->add_control('date_center_style_heading', [
            'label' => __('Date', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_center_typography',
                'selector' => '{{WRAPPER}} .gnje-timeline-item.slick-center .gnje-timeline-date',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('date_center_color', [
            'label' => __('Date Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline-item.slick-center .gnje-timeline-date' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_control('title_center_style_heading', [
            'label' => __('Title', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_center_typography',
                'selector' => '{{WRAPPER}} .gnje-timeline-item.slick-center .gnje-timeline-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('title_center_color', [
            'label' => __('Title Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline-item.slick-center .gnje-timeline-title' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_control('des_center_style_heading', [
            'label' => __('Description', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'des_center_typography',
                'selector' => '{{WRAPPER}} .gnje-timeline-item.slick-center.gnje-timeline-description',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('des_center_color', [
            'label' => __('Description Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline-item.slick-center .gnje-timeline-description' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_control('center_bottom_space', [
            'label' => __('Space', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-timeline .slick-center .gnje-head-timeline-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('style_carousel_navigation_settings', [
            'label' => __('Navigation', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                    [
                        'name' => 'show_nav',
                        'operator' => '==',
                        'value' => 'true',
                    ],
                ],
            ],
        ]);
        $this->start_controls_tabs('navigation_carousel_tabs');

        $this->start_controls_tab('normal', ['label' => __('Normal', 'gnje')]);

        $this->add_control('carousel_navigation_color', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'background: {{COLOR}}',
            ],
        ]);
        $this->add_control('carousel_navigation_width', [
            'label' => __('Width', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'width:{{SIZE}}{{UNIT}};',
            ],
        ]);$this->add_control('carousel_navigation_height', [
            'label' => __('Height', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'height:{{SIZE}}{{UNIT}}',
            ],
        ]);
        $this->add_control('carousel_navigation_space', [
            'label' => __('Space', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'margin:0 calc({{SIZE}}{{UNIT}}/2);',
            ],
        ]);
        $this->add_control('carousel_navigation_border_radius', [
            'label' => __('Border Radius', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],'%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'border-radius:{{SIZE}}{{UNIT}}',
            ],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('hover', ['label' => __('Hover/Active', 'gnje')]);
        $this->add_control('carousel_navigation_color_hover', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li.slick-active,{{WRAPPER}} .gnje-carousel ul.slick-dots li:hover' => 'background: {{COLOR}}',
            ],
        ]);
        $this->add_control('carousel_navigation_width_hover', [
            'label' => __('Width', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li.active,{{WRAPPER}} .gnje-carousel ul.slick-dots li:hover' => 'width:{{SIZE}}{{UNIT}};',
            ],
        ]);        $this->add_control('carousel_navigation_height_hover', [
            'label' => __('Height', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li.active,{{WRAPPER}} .gnje-carousel ul.slick-dots li:hover' => 'height:{{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('carousel_navigation_border_radius_hover', [
            'label' => __('Border Radius', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],'%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li.active,{{WRAPPER}} .gnje-carousel ul.slick-dots li:hover' => 'border-radius:{{SIZE}}{{UNIT}}',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section('style_carousel_pagination_settings', [
            'label' => __('Pagination', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'layout',
                        'operator' => '==',
                        'value' => 'carousel',
                    ],
                    [
                        'name' => 'show_pag',
                        'operator' => '==',
                        'value' => 'true',
                    ],
                ],
            ],
        ]);
        $this->add_control( 'pag_arrow_left_icon', [
            'label'     => __( 'Arrow Left', 'gnje' ),
            'type'      => 'ganjeicon',
        ] );
        $this->add_control( 'pag_arrow_right_icon', [
            'label'     => __( 'Arrow Right', 'gnje' ),
            'type'      => 'ganjeicon',
        ] );
        $this->add_control('carousel_pag_size', [
            'label' => __('Size', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'height:{{SIZE}}{{UNIT}};line-height:{{SIZE}}{{UNIT}};width:{{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('carousel_pag_icon_size', [
            'label' => __('Icon Size', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'font-size:{{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('carousel_pag_border_radius', [
            'label' => __('Border Radius', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],'%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'border-radius:{{SIZE}}{{UNIT}}',
            ],
        ]);
        $this->start_controls_tabs('pag_carousel_tabs');

        $this->start_controls_tab('pag_carousel_normal', ['label' => __('Normal', 'gnje')]);

        $this->add_control('pag_navigation_color', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pag_border',
                'label' => __('Border', 'gnje'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn',
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('pag_carousel_hover', ['label' => __('Hover', 'gnje')]);
        $this->add_control('carousel_page_color_hover', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn:hover' => 'color: {{COLOR}}',
            ],
        ]);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pag_border_hover',
                'label' => __('Border', 'gnje'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn:hover',
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

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
        $settings = array_merge([ // default settings
            'timeline' => '',
            'layout' => 'list',
            'center_mode' => 'true',
            'cols' => '3',
        ], $this->get_settings_for_display());

        $this->getViewTemplate('template', 'timeline', $settings);
    }
}
