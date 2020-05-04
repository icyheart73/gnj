<?php

namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * Clever Testimonial
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverServices extends CleverWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'clever-services';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Clever Services', 'cafe');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font  clever-icon-setting';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('thumb', [
            'label' => __('Thumbnail', 'cafe'),
            'type' => Controls_Manager::MEDIA,
        ]);
        $repeater->add_control('icon', [
            'label' => __('Icon', 'cafe'),
            'default' => 'cs-font icon-plane-2',
            'type' => 'clevericon',
        ]);
        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'cafe'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,

            ]
        );
        $repeater->add_control(
            'des',
            [
                'label' => __('Description', 'cafe'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        $repeater->add_control('button_icon', [
            'label' => __('Button Icon', 'cafe'),
            'default' => 'cs-font icon-arrow-right',
            'type' => 'clevericon',
        ]);
        $repeater->add_control(
            'button_label',
            [
                'label' => __('Button', 'cafe'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control( 'button_style', [
            'label'   => __( 'Button style', 'cafe' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'normal',
            'options' => [
                'normal'    => __( 'Normal', 'cafe' ),
                'underline' => __( 'Underline', 'cafe' ),
                'outline'   => __( 'Outline', 'cafe' ),
                'flat'   => __( 'Flat', 'cafe' ),
            ]
        ] );
        $repeater->add_control(
            'target_url',
            [
                'label' => __('URL', 'cafe'),
                'type' => Controls_Manager::URL,
                'description' => __('Url of page service want assign when click', 'cafe'),
            ]
        );

        $this->start_controls_section('content_settings', [
            'label' => __('Content Settings', 'cafe')
        ]);
        $this->add_control('content', [
            'label' => __('Services', 'cafe'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default' => [
                [
                    'title' => __('Service 1', 'cafe'),
                ],[
                    'title' => __('Service 2', 'cafe'),
                ],
            ],

        ]);
        $this->add_responsive_control(
            'content_block_align',
            [
                'label' => __('Text Align', 'cafe'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'cafe'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'center' => __('Center', 'cafe'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'cafe'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cafe-wrap-service-content' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control( 'vertical_align', [
            'label'                => __( 'Vertical Align', 'cafe' ),
            'type'                 => Controls_Manager::CHOOSE,
            'label_block'          => false,
            'options'              => [
                'top'    => [
                    'title' => __( 'Top', 'cafe' ),
                    'icon'  => 'eicon-v-align-top',
                ],
                'middle' => [
                    'title' => __( 'Middle', 'cafe' ),
                    'icon'  => 'eicon-v-align-middle',
                ],
                'bottom' => [
                    'title' => __( 'Bottom', 'cafe' ),
                    'icon'  => 'eicon-v-align-bottom',
                ],
            ],
            'selectors'            => [
                '{{WRAPPER}} .cafe-wrap-service' => 'align-items: {{VALUE}}',
            ],
            'selectors_dictionary' => [
                'top'    => 'flex-start',
                'middle' => 'center',
                'bottom' => 'flex-end',
            ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section('layout_settings', [
            'label' => __('Layout Settings', 'cafe')
        ]);
        $this->add_control('layout', [
            'label' => __('Layout', 'cafe'),
            'type' => Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid' => __('Grid', 'cafe'),
                'carousel' => __('Carousel', 'cafe'),
            ],
            'description' => __('Layout of service.', 'cafe'),
        ]);
        $this->add_control('style', [
            'label' => __('Style', 'cafe'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'cafe'),
                'boxed' => __('Boxed', 'cafe'),
            ],
            'description' => __('Style of service.', 'cafe'),
        ]);
        $this->add_control(
            'layout_type',
            [
                'label' => __('Image/Icon position', 'cafe'),
                'type' => Controls_Manager::CHOOSE,
                'default'=>'left',
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
            'label' => __('Slider to scroll', 'cafe'),
            'type' => Controls_Manager::NUMBER,
            'default' => '1',
            'description' => __('Number services scroll per time.', 'cafe'),
            'condition' => [
                'layout' => 'carousel'
            ],

        ]);
        $this->add_responsive_control('show_nav', [
            'label' => __('Navigation', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('show_pag', [
            'label' => __('Pagination', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_responsive_control('autoplay', [
            'label' => __('Auto Play', 'cafe'),
            'description' => __('', 'cafe'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_control('speed', [
            'label' => __('Auto play speed', 'cafe'),
            'type' => Controls_Manager::NUMBER,
            'default' => '3000',
            'condition' => [
                'layout' => 'carousel',
                'autoplay' => 'true'
            ],
            'description' => __('Time(ms) to next slider.', 'cafe'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('service_style_settings', [
            'label' => __('Service', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('service_space', [
            'label' => __('Space', 'cafe'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-service-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('service_bg_color', [
            'label' => __('Background', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-service' => 'background-color: {{VALUE}};'
            ]
        ]);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_shadow',
                'selector' => '{{WRAPPER}} .cafe-wrap-service',
            ]
        );

        $this->add_control('overlay_heading', [
            'label' => __('Overlay background', 'cafe'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control( 'bg_overlay_blend_mode', [
            'label'      => __( 'Blend Mode', 'cafe' ),
            'type'       => Controls_Manager::SELECT,
            'options'    => [
                ''            => __( 'Normal', 'cafe' ),
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
                '{{WRAPPER}} .cafe-wrap-media:after' => 'mix-blend-mode: {{VALUE}}',
            ],
        ] );
        $this->start_controls_tabs( 'overlay_tabs' );

        $this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'cafe' ) ] );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_bg',
                'label' => __('Background Overlay', 'cafe'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .cafe-wrap-media:before',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'cafe' ) ] );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_overlay_bg',
                'label' => __('Background Overlay', 'cafe'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .cafe-wrap-media:after',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_border',
                'label' => __('Border', 'cafe'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .cafe-wrap-service',
                'separator' => 'before',
            ]
        );
        $this->add_control('service_border_radius', [
            'label' => __('Border Radius', 'cafe'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-service' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('service_padding', [
            'label' => __('Padding', 'cafe'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .cafe-service-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('thumb_icon_style_settings', [
            'label' => __('Thumb/Icon', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('thumb_size', [
            'label' => __('Size', 'cafe'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cafe-wrap-service-content' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
            ],
        ]);
        $this->add_control('thumb_font_size', [
            'label' => __('Font Size', 'cafe'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('thumb_color', [
            'label' => __('Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('thumb_bg_color', [
            'label' => __('Background', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'background-color: {{VALUE}};'
            ]
        ]);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumb_shadow',
                'selector' => '{{WRAPPER}} .cafe-wrap-media',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'thumb_border',
                'label' => __('Border', 'cafe'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .cafe-wrap-media',
                'separator' => 'before',
            ]
        );
        $this->add_control('thumb_border_radius', [
            'label' => __('Border Radius', 'cafe'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('thumb_padding', [
            'label' => __('Padding', 'cafe'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('thumb_margin', [
            'label' => __('Margin', 'cafe'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('title_des_block_settings', [
            'label' => __('Title & Description', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('title_style', [
            'label' => __('Title', 'cafe'),
            'type' => Controls_Manager::HEADING,
        ]);
        $this->add_control('title_color', [
            'label' => __('Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-service-title' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('title_space', [
            'label' => __('Space', 'cafe'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-service-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cafe-service-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('des_style', [
            'label' => __('Description', 'cafe'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('des_color', [
            'label' => __('Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-service-des' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'des_typography',
                'selector' => '{{WRAPPER}} .cafe-service-des',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );
        $this->add_control('des_space', [
            'label' => __('Space', 'cafe'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-service-des' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('content_block_padding', [
            'label' => __('Padding', 'cafe'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cafe-wrap-service-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_button', [
            'label' => __( 'Button', 'cafe' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'button_typography',
            'selector' => '{{WRAPPER}} .cafe-slide-btn',
            'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
        ] );

        $this->add_control( 'button_border_width', [
            'label'     => __( 'Border Width', 'cafe' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-button:before' => 'border-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'button_border_radius', [
            'label'     => __( 'Border Radius', 'cafe' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cafe-button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'button_padding', [
            'label'      => __( 'Padding', 'cafe' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .cafe-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'after',
        ] );
        $this->start_controls_tabs( 'button_style_tabs' );

        $this->start_controls_tab( 'button_normal', [ 'label' => __( 'Normal', 'cafe' ) ] );

        $this->add_control( 'button_text_color', [
            'label'     => __( 'Text Color', 'cafe' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-button' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_background_color', [
            'label'     => __( 'Background Color', 'cafe' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-button:after' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_border_color', [
            'label'     => __( 'Border Color', 'cafe' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-button:before' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab( 'button_hover', [ 'label' => __( 'Hover', 'cafe' ) ] );

        $this->add_control( 'button_hover_text_color', [
            'label'     => __( 'Text Color', 'cafe' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-button:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_hover_background_color', [
            'label'     => __( 'Background Color', 'cafe' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-button:hover:after' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_hover_border_color', [
            'label'     => __( 'Border Color', 'cafe' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-button:hover:before' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section('slider_nav_settings', [
            'label' => __('Navigation & Pagination', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'layout' => 'carousel'
            ],
        ]);
        $this->add_control('slider_nav_color', [
            'label' => __('Navigation Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-carousel .cafe-carousel-btn' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('slider_pag_color', [
            'label' => __('Pagination Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-carousel ul.slick-dots li' => 'background: {{VALUE}};'
            ]
        ]);
        $this->add_control('slider_nav_hover_color_heading', [
            'label' => __('Hover & Active', 'cafe'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'after',
        ]);

        $this->add_control('slider_nav_hover_color', [
            'label' => __('Navigation Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-carousel .cafe-carousel-btn:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('slider_pag_hover_color', [
            'label' => __('Pagination Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-carousel ul.slick-dots li:hover,{{WRAPPER}} .cafe-carousel ul.slick-dots li.slick-active' => 'background: {{VALUE}};'
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