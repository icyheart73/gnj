<?php

namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * Ganje Testimonial
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeServices extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-services';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Ganje Services', 'gnje');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font  ganje-icon-setting';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('thumb', [
            'label' => __('Thumbnail', 'gnje'),
            'type' => Controls_Manager::MEDIA,
        ]);
        $repeater->add_control('icon', [
            'label' => __('Icon', 'gnje'),
            'default' => 'cs-font icon-plane-2',
            'type' => 'ganjeicon',
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
        $repeater->add_control('button_icon', [
            'label' => __('Button Icon', 'gnje'),
            'default' => 'cs-font icon-arrow-right',
            'type' => 'ganjeicon',
        ]);
        $repeater->add_control(
            'button_label',
            [
                'label' => __('Button', 'gnje'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control( 'button_style', [
            'label'   => __( 'Button style', 'gnje' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'normal',
            'options' => [
                'normal'    => __( 'Normal', 'gnje' ),
                'underline' => __( 'Underline', 'gnje' ),
                'outline'   => __( 'Outline', 'gnje' ),
                'flat'   => __( 'Flat', 'gnje' ),
            ]
        ] );
        $repeater->add_control(
            'target_url',
            [
                'label' => __('URL', 'gnje'),
                'type' => Controls_Manager::URL,
                'description' => __('Url of page service want assign when click', 'gnje'),
            ]
        );

        $this->start_controls_section('content_settings', [
            'label' => __('Content Settings', 'gnje')
        ]);
        $this->add_control('content', [
            'label' => __('Services', 'gnje'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default' => [
                [
                    'title' => __('Service 1', 'gnje'),
                ],[
                    'title' => __('Service 2', 'gnje'),
                ],
            ],

        ]);
        $this->add_responsive_control(
            'content_block_align',
            [
                'label' => __('Text Align', 'gnje'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'gnje'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'center' => __('Center', 'gnje'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'gnje'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gnje-wrap-service-content' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control( 'vertical_align', [
            'label'                => __( 'Vertical Align', 'gnje' ),
            'type'                 => Controls_Manager::CHOOSE,
            'label_block'          => false,
            'options'              => [
                'top'    => [
                    'title' => __( 'Top', 'gnje' ),
                    'icon'  => 'eicon-v-align-top',
                ],
                'middle' => [
                    'title' => __( 'Middle', 'gnje' ),
                    'icon'  => 'eicon-v-align-middle',
                ],
                'bottom' => [
                    'title' => __( 'Bottom', 'gnje' ),
                    'icon'  => 'eicon-v-align-bottom',
                ],
            ],
            'selectors'            => [
                '{{WRAPPER}} .gnje-wrap-service' => 'align-items: {{VALUE}}',
            ],
            'selectors_dictionary' => [
                'top'    => 'flex-start',
                'middle' => 'center',
                'bottom' => 'flex-end',
            ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section('layout_settings', [
            'label' => __('Layout Settings', 'gnje')
        ]);
        $this->add_control('layout', [
            'label' => __('Layout', 'gnje'),
            'type' => Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid' => __('Grid', 'gnje'),
                'carousel' => __('Carousel', 'gnje'),
            ],
            'description' => __('Layout of service.', 'gnje'),
        ]);
        $this->add_control('style', [
            'label' => __('Style', 'gnje'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'gnje'),
                'boxed' => __('Boxed', 'gnje'),
            ],
            'description' => __('Style of service.', 'gnje'),
        ]);
        $this->add_control(
            'layout_type',
            [
                'label' => __('Image/Icon position', 'gnje'),
                'type' => Controls_Manager::CHOOSE,
                'default'=>'left',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'gnje'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'none' => [
                        'center' => __('Center', 'gnje'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'gnje'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'condition' => [
                    'style' => 'default'
                ],
            ]
        );

        $this->add_responsive_control('col', [
            'label' => __('Columns Show', 'elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                ]
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
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
        $this->add_control('row', [
            'label' => __('Row', 'elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => '1',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
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
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_control('scroll', [
            'label' => __('Slider to scroll', 'gnje'),
            'type' => Controls_Manager::NUMBER,
            'default' => '1',
            'description' => __('Number services scroll per time.', 'gnje'),
            'condition' => [
                'layout' => 'carousel'
            ],

        ]);
        $this->add_responsive_control('show_nav', [
            'label' => __('Navigation', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('show_pag', [
            'label' => __('Pagination', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('autoplay', [
            'label' => __('Auto Play', 'gnje'),
            'description' => __('', 'gnje'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_control('speed', [
            'label' => __('Auto play speed', 'gnje'),
            'type' => Controls_Manager::NUMBER,
            'default' => '3000',
            'condition' => [
                'layout' => 'carousel',
                'autoplay' => 'true'
            ],
            'description' => __('Time(ms) to next slider.', 'gnje'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('service_style_settings', [
            'label' => __('Service', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('service_space', [
            'label' => __('Space', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-service-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('service_bg_color', [
            'label' => __('Background', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-service' => 'background-color: {{VALUE}};'
            ]
        ]);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_shadow',
                'selector' => '{{WRAPPER}} .gnje-wrap-service',
            ]
        );

        $this->add_control('overlay_heading', [
            'label' => __('Overlay background', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control( 'bg_overlay_blend_mode', [
            'label'      => __( 'Blend Mode', 'gnje' ),
            'type'       => Controls_Manager::SELECT,
            'options'    => [
                ''            => __( 'Normal', 'gnje' ),
                'multiply'    => 'Multiply',
                'screen'      => 'Screen',
                'overlay'     => 'Overlay',
                'darken'      => 'Darken',
                'lighten'     => 'Lighten',
                'color-dodge' => 'Color Dodge',
                'color-burn'  => 'Color Burn',
                'hue'         => 'Hue',
                'saturation'  => 'Saturation',
                'color'       => 'Color',
                'exclusion'   => 'Exclusion',
                'luminosity'  => 'Luminosity',
            ],
            'selectors'  => [
                '{{WRAPPER}} .gnje-wrap-media:after' => 'mix-blend-mode: {{VALUE}}',
            ],
        ] );
        $this->start_controls_tabs( 'overlay_tabs' );

        $this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'gnje' ) ] );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_bg',
                'label' => __('Background Overlay', 'gnje'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .gnje-wrap-media:before',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'gnje' ) ] );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_overlay_bg',
                'label' => __('Background Overlay', 'gnje'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .gnje-wrap-media:after',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_border',
                'label' => __('Border', 'gnje'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .gnje-wrap-service',
                'separator' => 'before',
            ]
        );
        $this->add_control('service_border_radius', [
            'label' => __('Border Radius', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-service' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('service_padding', [
            'label' => __('Padding', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .gnje-service-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('thumb_icon_style_settings', [
            'label' => __('Thumb/Icon', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('thumb_size', [
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
                '{{WRAPPER}} .gnje-wrap-media' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .gnje-wrap-service-content' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
            ],
        ]);
        $this->add_control('thumb_font_size', [
            'label' => __('Font Size', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-media' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('thumb_color', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-media' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('thumb_bg_color', [
            'label' => __('Background', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-media' => 'background-color: {{VALUE}};'
            ]
        ]);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumb_shadow',
                'selector' => '{{WRAPPER}} .gnje-wrap-media',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'thumb_border',
                'label' => __('Border', 'gnje'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .gnje-wrap-media',
                'separator' => 'before',
            ]
        );
        $this->add_control('thumb_border_radius', [
            'label' => __('Border Radius', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('thumb_padding', [
            'label' => __('Padding', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('thumb_margin', [
            'label' => __('Margin', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('title_des_block_settings', [
            'label' => __('Title & Description', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('title_style', [
            'label' => __('Title', 'gnje'),
            'type' => Controls_Manager::HEADING,
        ]);
        $this->add_control('title_color', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-service-title' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('title_space', [
            'label' => __('Space', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-service-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .gnje-service-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('des_style', [
            'label' => __('Description', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('des_color', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-service-des' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'des_typography',
                'selector' => '{{WRAPPER}} .gnje-service-des',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('des_space', [
            'label' => __('Space', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-service-des' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('content_block_padding', [
            'label' => __('Padding', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-service-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_button', [
            'label' => __( 'Button', 'gnje' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'button_typography',
            'selector' => '{{WRAPPER}} .gnje-slide-btn',
            'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
        ] );

        $this->add_control( 'button_border_width', [
            'label'     => __( 'Border Width', 'gnje' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-button:before' => 'border-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'button_border_radius', [
            'label'     => __( 'Border Radius', 'gnje' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'button_padding', [
            'label'      => __( 'Padding', 'gnje' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .gnje-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'after',
        ] );
        $this->start_controls_tabs( 'button_style_tabs' );

        $this->start_controls_tab( 'button_normal', [ 'label' => __( 'Normal', 'gnje' ) ] );

        $this->add_control( 'button_text_color', [
            'label'     => __( 'Text Color', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-button' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_background_color', [
            'label'     => __( 'Background Color', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-button:after' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_border_color', [
            'label'     => __( 'Border Color', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-button:before' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab( 'button_hover', [ 'label' => __( 'Hover', 'gnje' ) ] );

        $this->add_control( 'button_hover_text_color', [
            'label'     => __( 'Text Color', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-button:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_hover_background_color', [
            'label'     => __( 'Background Color', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-button:hover:after' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_hover_border_color', [
            'label'     => __( 'Border Color', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-button:hover:before' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section('slider_nav_settings', [
            'label' => __('Navigation & Pagination', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_control('slider_nav_color', [
            'label' => __('Navigation Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('slider_pag_color', [
            'label' => __('Pagination Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li' => 'background: {{VALUE}};'
            ]
        ]);
        $this->add_control('slider_nav_hover_color_heading', [
            'label' => __('Hover & Active', 'gnje'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'after',
        ]);

        $this->add_control('slider_nav_hover_color', [
            'label' => __('Navigation Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel .gnje-carousel-btn:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('slider_pag_hover_color', [
            'label' => __('Pagination Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-carousel ul.slick-dots li:hover,{{WRAPPER}} .gnje-carousel ul.slick-dots li.slick-active' => 'background: {{VALUE}};'
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
        $settings = array_merge([ // default settings
            'content' => '',
            'layout_type' => 'left',
            'col' => 1,
            'show_nav' => '',
            'show_pag' => '',
            'autoplay' => '',
            'autoplay_speed' => '3000',

        ], $this->get_settings_for_display());


        $this->getViewTemplate('template', 'services', $settings);
    }
}