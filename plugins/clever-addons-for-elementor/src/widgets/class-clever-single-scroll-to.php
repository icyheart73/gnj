<?php namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * CleverSingleScrollTo
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverSingleScrollTo extends CleverWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'clever-single-scroll-to';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Clever Single Scroll To', 'cafe');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font clever-icon-arrow-up';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('general_settings', [
            'label' => __('General', 'cafe')
        ]);
        $this->add_control('target_id', [
            'label' => __('Target ID', 'cafe'),
            'default' => '',
            'description' => __('ID of block want scroll to when click.', 'cafe'),
            'type' => Controls_Manager::TEXT,
        ]);
        $this->add_control('icon',
            [
                'label' => __('Icon', 'cafe'),
                'type' => Controls_Manager::SELECT,
                'default' => 'down',
                'options' => [
                    'up' => esc_html__('Up','cafe'),
                    'down' =>  esc_html__('Down','cafe'),
                    'font-icon' =>  esc_html__('Font Icon','cafe'),
                ],
            ]);
        $this->add_control('font_icon', [
            'label' => __('Font Icon', 'cafe'),
            'default' => 'cs-font icon-plane-2',
            'type' => 'clevericon',
            'condition' => [
                'icon' => 'font-icon'
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('animation_settings', [
            'label' => __('Animation', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control( 'button_animation', [
            'label'     => __( 'Animation', 'cafe' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'inherit',
            'separator' => 'before',
            'options'   => [
                'inherit'           => __( 'Inherit', 'cafe' ),
                'bounce'            => __( 'Bounce', 'cafe' ),
                'bounceIn'          => __( 'Bounce In', 'cafe' ),
                'bounceInDown'      => __( 'Bounce In Down', 'cafe' ),
                'bounceInLeft'      => __( 'Bounce In Left', 'cafe' ),
                'bounceInRight'     => __( 'Bounce In Right', 'cafe' ),
                'bounceInUp'        => __( 'Bounce In Up', 'cafe' ),
                'fadeIn'            => __( 'Fade In', 'cafe' ),
                'fadeInDown'        => __( 'Fade In Down', 'cafe' ),
                'fadeInLeft'        => __( 'Fade In Left', 'cafe' ),
                'fadeInRight'       => __( 'Fade In Right', 'cafe' ),
                'fadeInUp'          => __( 'Fade In Up', 'cafe' ),
                'flash'             => __( 'Flash', 'cafe' ),
                'headShake'         => __( 'Head Shake', 'cafe' ),
                'lightSpeedIn'      => __( 'Light Speed In', 'cafe' ),
                'jello'             => __( 'Jello', 'cafe' ),
                'pulse'             => __( 'Pulse', 'cafe' ),
                'rotateIn'          => __( 'Rotate In', 'cafe' ),
                'rotateInDownLeft'  => __( 'Rotate Down Left', 'cafe' ),
                'rotateInDownRight' => __( 'Rotate Down Right', 'cafe' ),
                'rotateInUpLeft'    => __( 'Rotate Up Left', 'cafe' ),
                'rotateInUpRight'   => __( 'Rotate Up Right', 'cafe' ),
                'rollIn'            => __( 'Roll In', 'cafe' ),
                'zoomIn'            => __( 'Zoom In', 'cafe' ),
                'rubberBand'        => __( 'Rubber Band', 'cafe' ),
                'shake'             => __( 'Shake', 'cafe' ),
                'swing'             => __( 'Swing', 'cafe' ),
                'slideInDown'       => __( 'Slide In Down', 'cafe' ),
                'slideInLeft'       => __( 'Slide In Left', 'cafe' ),
                'slideInRight'      => __( 'Slide In Right', 'cafe' ),
                'slideInUp'         => __( 'Slide In Up', 'cafe' ),
                'tada'              => __( 'Tada', 'cafe' ),
                'wobble'            => __( 'Wobble', 'cafe' ),
                'zoomInDown'        => __( 'Zoom In Down', 'cafe' ),
                'zoomInLeft'        => __( 'Zoom In Left', 'cafe' ),
                'zoomInRight'       => __( 'Zoom In Right', 'cafe' ),
                'zoomInUp'          => __( 'Zoom In Up', 'cafe' )
            ],
        ] );
        $this->add_control('duration', [
            'label' => __('Animation Duration', 'cafe'),
            'default' => '1000',
            'description' => __('ID of block want scroll to when click.', 'cafe'),
            'type' => Controls_Manager::NUMBER,
            'selectors' => [
                '{{WRAPPER}} .cafe-single-scroll-button .cafe-scroll-icon' => 'animation-duration: {{VALUE}}ms;',
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('normal_style_settings', [
            'label' => __('Normal', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('align', [
            'label' => __('Alignment', 'cafe'),
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
                '{{WRAPPER}} .cafe-wrap-single-scroll-button' => 'justify-content: {{VALUE}};',
            ],
        ]);
	    $this->add_control('icon_size', [
		    'label' => __('Icon size', 'cafe'),
		    'type' => Controls_Manager::SLIDER,
		    'range' => [
			    'px' => [
				    'min' => 0,
				    'max' => 100,
			    ],
		    ],
		    'selectors' => [
			    '{{WRAPPER}} .cafe-scroll-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
		    ],
	    ]);
	    $this->add_control('color', [
		    'label' => __('Color', 'cafe'),
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .cafe-scroll-icon i' => 'color: {{VALUE}};'
		    ]
	    ]);
        $this->add_control('icon_bg', [
            'label' => __('Icon Background', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-single-scroll-button .bg-box' => 'background: {{VALUE}};'
            ]
        ]);
        $this->end_controls_section();

        $this->start_controls_section('hover_style_settings', [
            'label' => __('Hover', 'cafe'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('color_hover', [
            'label' => __('Color', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-scroll-icon:hover i' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_control('icon_bg_hover', [
            'label' => __('Button Background', 'cafe'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-single-scroll-button:hover .bg-box' => 'background: {{VALUE}};'
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
