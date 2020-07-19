<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * GanjeSingleScrollTo
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeSingleScrollTo extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-single-scroll-to';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Ganje Single Scroll To', 'gnje');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-arrow-up';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('general_settings', [
            'label' => __('General', 'gnje')
        ]);
        $this->add_control('target_id', [
            'label' => __('Target ID', 'gnje'),
            'default' => '',
            'description' => __('ID of block want scroll to when click.', 'gnje'),
            'type' => Controls_Manager::TEXT,
        ]);
        $this->add_control('icon',
            [
                'label' => __('Icon', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'down',
                'options' => [
                    'up' => esc_html__('Up','gnje'),
                    'down' =>  esc_html__('Down','gnje'),
                    'font-icon' =>  esc_html__('Font Icon','gnje'),
                ],
            ]);
        $this->add_control('font_icon', [
            'label' => __('Font Icon', 'gnje'),
            'default' => 'cs-font icon-plane-2',
            'type' => 'ganjeicon',
            'condition' => [
                'icon' => 'font-icon'
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('animation_settings', [
            'label' => __('Animation', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control( 'button_animation', [
            'label'     => __( 'Animation', 'gnje' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'inherit',
            'separator' => 'before',
            'options'   => [
                'inherit'           => __( 'Inherit', 'gnje' ),
                'bounce'            => __( 'Bounce', 'gnje' ),
                'bounceIn'          => __( 'Bounce In', 'gnje' ),
                'bounceInDown'      => __( 'Bounce In Down', 'gnje' ),
                'bounceInLeft'      => __( 'Bounce In Left', 'gnje' ),
                'bounceInRight'     => __( 'Bounce In Right', 'gnje' ),
                'bounceInUp'        => __( 'Bounce In Up', 'gnje' ),
                'fadeIn'            => __( 'Fade In', 'gnje' ),
                'fadeInDown'        => __( 'Fade In Down', 'gnje' ),
                'fadeInLeft'        => __( 'Fade In Left', 'gnje' ),
                'fadeInRight'       => __( 'Fade In Right', 'gnje' ),
                'fadeInUp'          => __( 'Fade In Up', 'gnje' ),
                'flash'             => __( 'Flash', 'gnje' ),
                'headShake'         => __( 'Head Shake', 'gnje' ),
                'lightSpeedIn'      => __( 'Light Speed In', 'gnje' ),
                'jello'             => __( 'Jello', 'gnje' ),
                'pulse'             => __( 'Pulse', 'gnje' ),
                'rotateIn'          => __( 'Rotate In', 'gnje' ),
                'rotateInDownLeft'  => __( 'Rotate Down Left', 'gnje' ),
                'rotateInDownRight' => __( 'Rotate Down Right', 'gnje' ),
                'rotateInUpLeft'    => __( 'Rotate Up Left', 'gnje' ),
                'rotateInUpRight'   => __( 'Rotate Up Right', 'gnje' ),
                'rollIn'            => __( 'Roll In', 'gnje' ),
                'zoomIn'            => __( 'Zoom In', 'gnje' ),
                'rubberBand'        => __( 'Rubber Band', 'gnje' ),
                'shake'             => __( 'Shake', 'gnje' ),
                'swing'             => __( 'Swing', 'gnje' ),
                'slideInDown'       => __( 'Slide In Down', 'gnje' ),
                'slideInLeft'       => __( 'Slide In Left', 'gnje' ),
                'slideInRight'      => __( 'Slide In Right', 'gnje' ),
                'slideInUp'         => __( 'Slide In Up', 'gnje' ),
                'tada'              => __( 'Tada', 'gnje' ),
                'wobble'            => __( 'Wobble', 'gnje' ),
                'zoomInDown'        => __( 'Zoom In Down', 'gnje' ),
                'zoomInLeft'        => __( 'Zoom In Left', 'gnje' ),
                'zoomInRight'       => __( 'Zoom In Right', 'gnje' ),
                'zoomInUp'          => __( 'Zoom In Up', 'gnje' )
            ],
        ] );
        $this->add_control('duration', [
            'label' => __('Animation Duration', 'gnje'),
            'default' => '1000',
            'description' => __('ID of block want scroll to when click.', 'gnje'),
            'type' => Controls_Manager::NUMBER,
            'selectors' => [
                '{{WRAPPER}} .gnje-single-scroll-button .gnje-scroll-icon' => 'animation-duration: {{VALUE}}ms;',
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('normal_style_settings', [
            'label' => __('Normal', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('align', [
            'label' => __('Alignment', 'gnje'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start'    => [
                    'title' => __( 'Left', 'elementor' ),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'elementor' ),
                    'icon' => 'fa fa-align-center',
                ],
                'flex-end' => [
                    'title' => __( 'Right', 'elementor' ),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-single-scroll-button' => 'justify-content: {{VALUE}};',
            ],
        ]);
	    $this->add_control('icon_size', [
		    'label' => __('Icon size', 'gnje'),
		    'type' => Controls_Manager::SLIDER,
		    'range' => [
			    'px' => [
				    'min' => 0,
				    'max' => 100,
			    ],
		    ],
		    'selectors' => [
			    '{{WRAPPER}} .gnje-scroll-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
		    ],
	    ]);
	    $this->add_control('color', [
		    'label' => __('Color', 'gnje'),
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .gnje-scroll-icon i' => 'color: {{VALUE}};'
		    ]
	    ]);
        $this->add_control('icon_bg', [
            'label' => __('Icon Background', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-single-scroll-button .bg-box' => 'background: {{VALUE}};'
            ]
        ]);
        $this->end_controls_section();

        $this->start_controls_section('hover_style_settings', [
            'label' => __('Hover', 'gnje'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('color_hover', [
            'label' => __('Color', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-scroll-icon:hover i' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('icon_bg_hover', [
            'label' => __('Button Background', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-single-scroll-button:hover .bg-box' => 'background: {{VALUE}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'target_id' => '',
            'icon' => 'down',
            'font_icon' => '',
            'button_animation' => 'inherit',
        ], $this->get_settings_for_display());

        $this->getViewTemplate('template', 'single-scroll-to', $settings);
    }
}
