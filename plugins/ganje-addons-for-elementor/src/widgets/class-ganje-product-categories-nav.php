<?php

namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

/**
 * GanjeProductwithBannerandTabs
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if ( class_exists( 'WooCommerce' ) ):
	final class GanjeProductCategories extends GanjeWidgetBase {
		/**
		 * @return string
		 */
		function get_name() {
			return 'ganje-product-categories-nav';
		}

		/**
		 * @return string
		 */
		function get_title() {
			return __( 'Ganje Product Categories Navigation', 'gnje' );
		}

		/**
		 * @return string
		 */
		function get_icon() {
			return 'cs-font ganje-icon-list-2';
		}

		/**
		 * Register controls
		 */
		protected function _register_controls() {

			$this->start_controls_section(
				'section_categories', [
				'label' => __( 'Categories', 'gnje' )
			] );
			;$this->add_control( 'title', [
				'label'     => __( 'Title', 'gnje' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Product Categories','gnje'),
			] );
			$this->add_control( 'cats', [
				'label'       => __( 'Categories', 'gnje' ),
				'description' => __( '', 'gnje' ),
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'multiple'    => true,
				'options'     => $this->get_categories_for_gnje( 'product_cat', 2 ),
			] );
			$this->add_control( 'show_sub', [
				'label'   => __( 'Show Sub categories', 'gnje' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			] );
			$this->add_control( 'enable_accordion', [
				'label'     => __( 'Enable Sub categories accordion', 'gnje' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => [
					'show_sub' => 'yes',
				],
			] );$this->add_control( 'css_class', [
				'label'     => __( 'Custom css class', 'gnje' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
			] );

			$this->end_controls_section();

			$this->start_controls_section( 'title_style_settings', [
				'label' => __( 'Title', 'gnje' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			] );
			$this->add_control( 'title_color', [
				'label'     => __( 'Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-title' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'title_background', [
				'label'     => __( 'Background', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-title' => 'background: {{VALUE}};'
				]
			] );
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'selector' => '{{WRAPPER}} .gnje-title',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_control('title_space', [
				'label' => __('Space', 'gnje'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gnje-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]);
			$this->add_responsive_control('sub_cat_padding', [
				'label' => __('Border Radius', 'gnje'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'separator'   => 'before',
				'selectors' => [
					'{{WRAPPER}} .gnje-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);
			$this->end_controls_section();
			$this->start_controls_section( 'cat_style_settings', [
				'label' => __( 'Category', 'gnje' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			] );
			$this->add_control( 'cat_color', [
				'label'     => __( 'Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-cat-item>a' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'cat_color_hover', [
				'label'     => __( 'Color Hover', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-cat-item:hover>a' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'cat_background', [
				'label'     => __( 'Background', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-cat-item' => 'background: {{VALUE}};'
				]
			] );
			$this->add_control( 'cat_background_hover', [
				'label'     => __( 'Background Hover', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-cat-item:hover' => 'background: {{VALUE}};'
				]
			] );
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'cat_typography',
					'selector' => '{{WRAPPER}} .gnje-cat-item',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'wrap_border',
					'label'       => __( 'Border', 'gnje' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .gnje-cat-item',
					'separator'   => 'before',
				]
			);
			$this->add_responsive_control('cat_padding', [
				'label' => __('Padding', 'gnje'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'separator'   => 'before',
				'selectors' => [
					'{{WRAPPER}} .gnje-cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);
			$this->end_controls_section();
			$this->start_controls_section( 'sub_cat_style_settings', [
				'label' => __( 'Sub Category', 'gnje' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			] );
			$this->add_responsive_control( 'sub_cat_width', [
				'label'          => __( 'With', 'elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'default'        => [
					'size' => 250,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .gnje-sub-cat' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_sub' => 'yes',
					'enable_accordion' => 'no',
				],
			] );
			$this->add_control( 'sub_cat_color', [
				'label'     => __( 'Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-sub-cat .gnje-cat-item>a' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'sub_cat_color_hover', [
				'label'     => __( 'Color Hover', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-sub-cat .gnje-cat-item:hover>a' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'sub_cat_background', [
				'label'     => __( 'Background', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-sub-cat .gnje-cat-item' => 'background: {{VALUE}};'
				]
			] );
			$this->add_control( 'sub_cat_background_hover', [
				'label'     => __( 'Background Hover', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-sub-cat .gnje-cat-item:hover' => 'background: {{VALUE}};'
				]
			] );
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'sub_cat_typography',
					'selector' => '{{WRAPPER}} .gnje-sub-cat .gnje-cat-item',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'sub_cat_border',
					'label'       => __( 'Border', 'gnje' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .gnje-sub-cat .gnje-cat-item',
					'separator'   => 'before',
				]
			);
			$this->add_responsive_control('sub_cat_padding', [
				'label' => __('Padding', 'gnje'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'separator'   => 'before',
				'selectors' => [
					'{{WRAPPER}} .gnje-sub-cat .gnje-cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);
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
			return [ 'gnje-script' ];
		}

		/**
		 * Render
		 */
		protected function render() {
			// default settings
			$settings = array_merge( [
				'title'             => esc_html__('Product Categories','gnje'),
				'cats'             => '',
				'show_sub'         => 'no',
				'enable_accordion' => 'no',
				'css_class' => 'no',
			], $this->get_settings_for_display() );
			$this->add_inline_editing_attributes('title');
			$this->add_render_attribute('title', 'class', 'gnje-title');
			$this->getViewTemplate( 'template', 'product-categories-nav', $settings );
		}
	}
endif;