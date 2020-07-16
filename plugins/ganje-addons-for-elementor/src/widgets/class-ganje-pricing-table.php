<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use GanjeAddonsForElementor\Ganje_Custom_Control;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

/**
 * Ganje Pricing Table
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjePricingTable extends GanjeWidgetBase {
	/**
	 * @return string
	 */
	function get_name() {
		return 'ganje-pricing-table';
	}

	/**
	 * @return string
	 */
	function get_title() {
		return __( 'Ganje Pricing Table', 'gnje' );
	}

	/**
	 * @return string
	 */
	function get_icon() {
		return 'cs-font ganje-icon-online-shopping';
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		$repeater = new \Elementor\Repeater();
		$repeater->start_controls_tabs( 'feature_repeater' );

		$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'gnje' ) ] );
		$repeater->add_control( 'title', [
			'label'       => __( 'Title', 'gnje' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'This is features', 'gnje' ),
			'label_block' => true,
		] );
		$repeater->add_control( 'icon', [
			'label'   => __( 'Icon', 'gnje' ),
			'type'    => 'ganjeicon',
			'default' => 'cs-font ganje-icon-check',
		] );
		$repeater->end_controls_tab();
		$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'gnje' ) ] );
		$repeater->add_control( 'color', [
			'label'     => __( 'Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
			],
		] );
		$repeater->add_control( 'background_color', [
			'label'     => __( 'Background Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
			],
		] );
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$repeater->end_controls_tab();

		$this->start_controls_section( 'heading_section', [
			'label' => __( 'Heading', 'gnje' )
		] );
		$this->add_control( 'title', [
			'label'       => __( 'Title', 'gnje' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'Pricing Table', 'gnje' ),
			'description' => __( 'This text is heading content', 'gnje' ),
		] );
		$this->add_control( 'title_tag',
			[
				'label'       => __( 'HTML Tag', 'gnje' ),
				'description' => __( 'Select a heading tag for the title. Headings are defined with H1 to H6 tags.', 'gnje' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'options'     => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'p',
					'div' => 'div',
					'span' => 'span',
				],
				'label_block' => true,
			] );
		$this->add_control( 'des', [
			'label'       => __( 'Description', 'gnje' ),
			'default'     => '',
			'type'        => Controls_Manager::TEXTAREA,
			'description' => __( 'This text is heading content', 'gnje' ),
		] );
		$this->end_controls_section();
		$this->start_controls_section( 'price_section', [
			'label' => __( 'Price', 'gnje' )
		] );
		$this->add_control( 'currency', [
			'label'   => __( 'Currency', 'gnje' ),
			'default' => '$',
			'type'    => Controls_Manager::TEXT,
		] );
		$this->add_control( 'price', [
			'label'       => __( 'Price', 'gnje' ),
			'default'     => '49',
			'type'        => Controls_Manager::TEXT,
			'description' => __( 'Price for display', 'gnje' ),
		] );
		$this->add_control( 'original_price', [
			'label'       => __( 'Original Price', 'gnje' ),
			'type'        => Controls_Manager::TEXT,
			'description' => __( 'Original Price before sale for display', 'gnje' ),
		] );
		$this->add_control( 'duration', [
			'label'       => __( 'Period', 'gnje' ),
			'default'     => __( '/Month', 'gnje' ),
			'type'        => Controls_Manager::TEXT,
			'description' => __( 'Original Price before sale for display', 'gnje' ),
		] );
		$this->add_control( 'duration_des', [
			'label'   => __( 'Description', 'gnje' ),
			'default' => __( '', 'gnje' ),
			'type'    => Controls_Manager::TEXT,
		] );
		$this->end_controls_section();
		$this->start_controls_section( 'features_section', [
			'label' => __( 'Features', 'gnje' )
		] );
		$this->add_control( 'features_list', [
			'label'       => __( 'Features list', 'gnje' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'title' => __( 'This is features 1', 'gnje' ),
				],
				[
					'title' => __( 'This is features 2', 'gnje' ),
				],
				[
					'title' => __( 'This is features 3', 'gnje' ),
				],
			]
		] );
		$this->end_controls_section();
		$this->end_controls_section();
		$this->start_controls_section( 'button_section', [
			'label' => __( 'Button', 'gnje' )
		] );
		$this->add_control( 'button_text', [
			'label'       => __( 'Text', 'gnje' ),
			'type'        => Controls_Manager::TEXT,
			'description' => __( 'Text display inside button', 'gnje' ),
			'default'     => __( 'Get Started', 'gnje' ),
		] );
		$this->add_control( 'button_icon', [
			'label' => __( 'Icon', 'gnje' ),
			'type'  => 'ganjeicon'
		] );
		$this->add_control( 'button_icon_pos', [
			'label'   => __( 'Icon position', 'gnje' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'after',
			'options' => [
				'before' => __( 'Before', 'gnje' ),
				'after'  => __( 'After', 'gnje' ),
			]
		] );
		$this->add_control( 'link_type', [
			'label'   => __( 'Link Type', 'gnje' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'url',
			'options' => [
				'url'  => __( 'URL', 'gnje' ),
				'page' => __( 'Page', 'gnje' ),
			]
		] );
		$this->add_control( 'link', [
			'label'       => __( 'Link', 'gnje' ),
			'type'        => Controls_Manager::URL,
			'description' => __( 'Redirect link when click to banner.', 'gnje' ),
			'separator'   => 'after',
			'condition'   => [
				'link_type' => 'url',
			]
		] );
		$this->add_control( 'link_page',
			[
				'label'     => __( 'Page', 'gnje' ),
				'type'      => Controls_Manager::SELECT2,
				'options'   => $this->getPages(),
				'condition' => [
					'link_type' => 'page'
				],
				'multiple'  => false,
				'separator' => 'after'
			]
		);
		$this->add_control(
			'link_page_new_window',
			[
				'label'        => __( 'Open new window', 'gnje' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'link_type' => 'page'
				],
			]
		);
		$this->add_control( 'button_style', [
			'label'   => __( 'Button style', 'gnje' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'normal',
			'options' => [
				'normal'    => __( 'Normal', 'gnje' ),
				'underline' => __( 'Underline', 'gnje' ),
				'outline'   => __( 'Outline', 'gnje' ),
				'flat'      => __( 'Flat', 'gnje' ),
				'slide'     => __( 'Slide', 'gnje' ),
			]
		] );
		$this->end_controls_section();
		$this->start_controls_section( 'badge_section', [
			'label' => __( 'Badge', 'gnje' )
		] );
		$this->add_control( 'badge_text', [
			'label'       => __( 'Text', 'gnje' ),
			'type'        => Controls_Manager::TEXT,
			'description' => __( 'Text display inside badge', 'gnje' ),
			'default'     => __( 'New!', 'gnje' ),
		] );
		$this->add_control( 'badge_icon', [
			'label' => __( 'Icon', 'gnje' ),
			'type'  => 'ganjeicon'
		] );
		$this->add_control( 'badge_type', [
			'label'   => __( 'Badge type', 'gnje' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'banner',
			'options' => [
				'banner' => __( 'Banner', 'gnje' ),
				'circle' => __( 'Circle', 'gnje' ),

			]
		] );
		$this->end_controls_section();

        /*Heading style*/
        $this->start_controls_section( 'general_style_settings', [
            'label' => __( 'General', 'gnje' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'general_style', [
            'label'   => __( 'Style', 'gnje' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __( 'Default', 'gnje' ),
                'style-1' => __( 'Style-1', 'gnje' ),

            ]
        ] );
		$this->end_controls_section();

		/*Heading style*/
		$this->start_controls_section( 'heading_style_settings', [
			'label' => __( 'Heading Block', 'gnje' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'heading_block_bg',
				'label'    => __( 'Background Block', 'gnje' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gnje-wrap-block-heading',
                'condition' => [
                    'general_style' => 'default'
                ],
			]
		);
        $this->add_control( 'heading_block_bg_normal', [
            'label'     => __( 'Background', 'gnje' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-wrap-pricing-table.style-1 .gnje-wrap-block-heading' => '--background-color: {{VALUE}};background-color: {{VALUE}};'
            ]
        ] );
		$this->add_responsive_control(
			'heading_block_align',
			[
				'label'     => __( 'Content Align', 'gnje' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'gnje' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'gnje' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'gnje' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gnje-wrap-block-heading' => 'text-align: {{VALUE}};'
				]
			]
		);
		$this->add_responsive_control( 'heading_block_padding', [
			'label'      => __( 'Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-block-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'heading_border',
				'label'       => __( 'Border', 'gnje' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gnje-wrap-block-heading',
				'separator'   => 'after',
			]
		);
		$this->add_control( 'title_color', [
			'label'     => __( 'Title Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-heading' => 'color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gnje-heading',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_responsive_control( 'title_padding', [
			'label'      => __( 'Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'separator'  => 'after',
			'selectors'  => [
				'{{WRAPPER}} .gnje-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->add_control( 'des_color', [
			'label'     => __( 'Description Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-des' => 'color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'des_typography',
				'selector' => '{{WRAPPER}} .gnje-des',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_responsive_control( 'des_padding', [
			'label'      => __( 'Description Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'separator'  => 'after',
			'selectors'  => [
				'{{WRAPPER}} .gnje-des' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();
		/*Heading style*/
		$this->start_controls_section( 'price_style_settings', [
			'label' => __( 'Price Block', 'gnje' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'price_color', [
			'label'     => __( 'Price Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-price' => 'color: {{VALUE}};'
			]
		] );
		$this->add_control( 'price_block_color', [
			'label'     => __( 'Background Block Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-wrap-price' => 'background-color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .gnje-price',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_control( 'o_price_heading', [
			'label' => __( 'Original Price', 'gnje' ),
			'type'  => Controls_Manager::HEADING,
		] );
		$this->add_control( 'o_price_color', [
			'label'     => __( 'Price Color', 'gnje' ),
			'separator' => 'before',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-original-price' => 'color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'o_price_typography',
				'selector' => '{{WRAPPER}} .gnje-original-price',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_control( 'duration_color', [
			'label'     => __( 'Period Color', 'gnje' ),
			'separator' => 'before',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-duration' => 'color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'duration_typography',
				'selector' => '{{WRAPPER}} .gnje-duration',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_control( 'duration_display_type', [
			'label'     => __( 'Display type', 'gnje' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'inline',
			'options'   => [
				'inline' => __( 'Inline', 'gnje' ),
				'block'  => __( 'Block', 'gnje' ),
			],
			'selectors' => [
				'{{WRAPPER}} .gnje-duration' => 'display: {{VALUE}};'
			]
		] );
		$this->add_control( 'duration_des_color', [
			'label'     => __( 'Period Description Color', 'gnje' ),
			'separator' => 'before',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-duration-des' => 'color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'duration_des_typography',
				'selector' => '{{WRAPPER}} .gnje-duration-des',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_responsive_control( 'price_block_padding', [
			'label'      => __( 'Price Block Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'separator'  => 'before',
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();
		$this->start_controls_section( 'feature_style_settings', [
			'label' => __( 'Features Block', 'gnje' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'feature_color_settings', [
			'label'     => __( 'Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-wrap-list-features' => 'color: {{VALUE}};'
			]
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feature_typo',
				'selector' => '{{WRAPPER}} .gnje-wrap-list-features',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_control( 'feature_icon_color_settings', [
			'label'     => __( 'Icon Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-wrap-list-features i' => 'color: {{VALUE}};'
			]
		] );
		$this->add_control( 'feature_icon_size_settings', [
			'label'      => __( 'Icon size', 'gnje' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-list-features i' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'feature_icon_space_settings', [
			'label'      => __( 'Icon space', 'gnje' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-list-features i' => 'padding-right: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'feature_space_settings', [
			'label'      => __( 'Space', 'gnje' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-list-features .gnje-feature' => 'padding: {{SIZE}}{{UNIT}} 0 {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control(
			'features_block_align',
			[
				'label'     => __( 'Content Align', 'gnje' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'gnje' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'gnje' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'gnje' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gnje-wrap-list-features' => 'text-align: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'features_block_bg',
				'label'    => __( 'Background Block', 'gnje' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gnje-wrap-list-features',
			]
		);
		$this->add_responsive_control( 'features_block_padding', [
			'label'      => __( 'Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-list-features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'features_border',
				'label'       => __( 'Border', 'gnje' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gnje-wrap-list-features',

			]
		);
		$this->add_control( 'feature_item_border_heading', [
			'label'     => __( 'Item Border', 'gnje' ),
			'separator' => 'before',
			'type'      => Controls_Manager::HEADING
		] );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'feature_item_border',
				'label'       => __( 'Item Border', 'gnje' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gnje-feature',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section( 'button_block_settings', [
			'label' => __( 'Button Block', 'gnje' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_block_bg',
				'label'    => __( 'Background Block', 'gnje' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gnje-wrap-button',
			]
		);
		$this->add_responsive_control(
			'button_block_align',
			[
				'label'     => __( 'Content Align', 'gnje' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'gnje' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'gnje' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'gnje' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gnje-wrap-button' => 'text-align: {{VALUE}};'
				]
			]
		);
		$this->add_responsive_control( 'button_block_padding', [
			'label'      => __( 'Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .gnje-wrap-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_block_border',
				'label'       => __( 'Border', 'gnje' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gnje-wrap-button',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section( 'button_style_settings', [
			'label' => __( 'Button', 'gnje' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'button_width', [
			'label'      => __( 'Button Width', 'gnje' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 1000,
				],
				'%'  => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .gnje-button ' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .gnje-button',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_control( 'button_color', [
			'label'     => __( 'Color', 'gnje' ),
			'separator' => 'before',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-button' => 'color: {{VALUE}};'
			]
		] );
		$this->add_control( 'button_color_hover', [
			'label'     => __( 'Color Hover', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-button:hover' => 'color: {{VALUE}};'
			]
		] );
		$this->add_control( 'button_bg', [
			'label'     => __( 'Background Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .gnje-button:after,{{WRAPPER}} .gnje-button:before' => 'background-color: {{VALUE}};'
			]
		] );
		$this->add_control( 'button_bg_hover', [
			'label'     => __( 'Background Color Hover', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-button:hover:after,{{WRAPPER}} .gnje-button:hover:before' => 'background-color: {{VALUE}};'
			]
		] );
		$this->add_control( 'button_border_color', [
			'label'     => __( 'Border Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .gnje-button:before' => 'border-color: {{VALUE}};'
			]
		] );
		$this->add_control( 'button_border_color_hover', [
			'label'     => __( 'Border Color Hover', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-button:hover:before' => 'border-color: {{VALUE}};'
			]
		] );
		$this->add_responsive_control( 'button_style_border_radius', [
			'label'      => __( 'Border radius', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'separator'  => 'before',
			'selectors'  => [
				'{{WRAPPER}} .gnje-button, {{WRAPPER}} .gnje-button:before, {{WRAPPER}} .gnje-button:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'button_style_padding', [
			'label'      => __( 'Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'separator'  => 'before',
			'selectors'  => [
				'{{WRAPPER}} .gnje-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();
		$this->start_controls_section( 'badge_style_settings', [
			'label' => __( 'Badge', 'gnje' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'badge_size', [
			'label'     => __( 'Badge size', 'gnje' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 1000,
				]
			],
			'selectors' => [
				'{{WRAPPER}} .gnje-badge.banner .wrap-badge' => 'border-width: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .gnje-badge.circle'             => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .gnje-badge .badge-text',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		$this->add_control( 'badge_color', [
			'label'     => __( 'Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-badge .badge-text' => 'color: {{VALUE}};'
			]
		] );
		$this->add_control( 'badge_bg_color', [
			'label'     => __( 'Background Color', 'gnje' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .gnje-badge.circle'             => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .gnje-badge.banner .wrap-badge' => 'border-right-color: {{VALUE}};',
			]
		] );
		$this->add_responsive_control( 'badge_style_padding', [
			'label'      => __( 'Padding', 'gnje' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'separator'  => 'before',
			'selectors'  => [
				'{{WRAPPER}} .gnje-badge .badge-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();
	}

	/**
	 * Load style
	 */
	public function get_style_depends() {
		return [ 'gnje-style' ];
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
	public function get_script_depends() {
		return [ 'typed', 'gnje-script' ];
	}

	/**
	 * Render
	 */
	protected function render() {
		$settings = array_merge( [ // default settings
			'title'                => esc_html__( 'Get Started', 'gnje' ),
			'title_tag'            => 'h3',
			'des'                  => esc_html__( 'This is Description', 'gnje' ),
			'currency'             => '$',
			'price'                => '49',
			'original_price'       => '',
			'duration'             => esc_html__( '/Month', 'gnje' ),
			'duration_des'         => '',
			'features_list'        => '',
			'button_text'          => esc_html__( 'Button', 'gnje' ),
			'button_icon'          => '',
			'button_icon_pos'      => 'after',
			'link_type'            => '',
			'link'                 => '',
			'link_page'            => '',
			'link_page_new_window' => '',
			'button_style'         => 'normal',
			'badge_text'           => esc_html__( 'New', 'gnje' ),
			'badge_icon'           => '',
			'badge_type'           => 'banner',
			'general_style'        => 'default',
		], $this->get_settings_for_display() );

		$this->add_inline_editing_attributes( 'title' );
		$this->add_render_attribute( 'title', 'class', 'gnje-heading' );
		$this->add_inline_editing_attributes( 'des' );
		$this->add_render_attribute( 'des', 'class', 'gnje-des' );
		$this->add_inline_editing_attributes( 'badge_text' );

		$this->add_render_attribute( 'badge_text', 'class', 'badge-text' );

		$this->add_inline_editing_attributes( 'button_text' );
		$button_class = 'gnje-button ' . $settings['button_style'];
		$this->add_render_attribute( 'button_text', 'class', $button_class );

		$this->getViewTemplate( 'template', 'pricing-table', $settings );
	}
}
