<?php

namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

/**
 * GanjeProductCategoryBanner
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if ( class_exists( 'WooCommerce' ) ):
	final class GanjeProductCategoryBanner extends GanjeWidgetBase {
		/**
		 * @return string
		 */
		function get_name() {
			return 'ganje-product-category-banner';
		}

		/**
		 * @return string
		 */
		function get_title() {
			return __( 'Ganje Product Category Banner', 'gnje' );
		}

		/**
		 * @return string
		 */
		function get_icon() {
			return 'cs-font ganje-icon-cart-3';
		}

		/**
		 * Register controls
		 */
		protected function _register_controls() {
			$this->start_controls_section(
				'section_title', [
				'label' => __( 'Category', 'gnje' )
			] );
			$this->add_control( 'cat', [
				'label'       => __( 'Category', 'gnje' ),
				'description' => __( 'Select category you want display', 'gnje' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => $this->get_categories_for_gnje( 'product_cat' ),
			] );
			$this->add_control( 'image', [
				'label'         => __( 'Upload Image', 'gnje' ),
				'description'   => __( 'Select an image for the banner.', 'gnje' ),
				'type'          => Controls_Manager::MEDIA,
				'dynamic'       => [ 'active' => true ],
				'show_external' => true,
				'default'       => [
					'url' => GNJE_URI . 'assets/img/banner-placeholder.png'
				]
			] );
			$this->add_control( 'title', [
				'label'       => __( 'Title', 'gnje' ),
				'placeholder' => __( 'Title for Category.', 'gnje' ),
				'description' => __( 'Leave it blank if use default category name.', 'gnje' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true
			] );
			$this->add_control( 'show_des', [
				'label'        => __( 'Show description', 'gnje' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Show category description.', 'gnje' ),
				'return_value' => 'true',
				'default'      => 'false',
			] );
			$this->add_control( 'des', [
				'label'       => __( 'Description', 'gnje' ),
				'placeholder' => __( 'Description for Category.', 'gnje' ),
				'description' => __( 'Leave it blank if use default category name.', 'gnje' ),
				'type'        => Controls_Manager::TEXTAREA,
				'condition'   => [
					'show_des' => 'true'
				],
				'label_block' => true
			] );
			$this->add_control( 'show_count', [
				'label'        => __( 'Show Product Count', 'gnje' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Show product count.', 'gnje' ),
				'return_value' => 'true',
				'default'      => 'false',
			] );
			$this->add_control(
				'button_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control('button_label', [
				'label' => __('Button Label', 'gnje'),
				'placeholder' => __('Button', 'gnje'),
				'description' => __('Leave it blank if don\'t use it', 'gnje'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'default' => __('Button', 'gnje'),
				'label_block' => false
			]);
			$this->add_control('button_icon', [
				'label' => __('Icon', 'gnje'),
				'type' => 'ganjeicon'
			]);
			$this->add_control('button_icon_pos', [
				'label' => __('Icon position', 'gnje'),
				'type' => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => [
					'before' => __('Before', 'gnje'),
					'after' => __('After', 'gnje'),
				]
			]);
			$this->add_control('button_style', [
				'label' => __('Button style', 'gnje'),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => __('Normal', 'gnje'),
					'underline' => __('Underline', 'gnje'),
					'outline' => __('Outline', 'gnje'),
				]
			]);
			$this->add_control(
				'css_class_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'css_class', [
				'label'       => __( 'Custom HTML Class', 'gnje' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'You may add a custom HTML class to style element later.', 'gnje' ),
			] );
			$this->end_controls_section();
			$this->start_controls_section( 'normal_style_settings', [
				'label' => __( 'Normal', 'gnje' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			] );
			$this->add_control( 'overlap', [
				'label'        => __( 'Overlap image', 'gnje' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Content of product will show below image.', 'gnje' ),
				'return_value' => 'true',
				'default'      => 'true',
			] );
			$this->add_control( 'content_align', [
				'label'     => __( 'Vertical Align', 'gnje' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => __( 'Top', 'gnje' ),
					'center'     => __( 'Middle', 'gnje' ),
					'flex-end'   => __( 'Bottom', 'gnje' ),
				],
				'condition' => [
					'overlay_banner' => 'true'
				],
				'selectors' => [
					'{{WRAPPER}} .gnje-wrap-product-category-content' => 'justify-content: {{VALUE}};'
				]
			] );
			$this->add_responsive_control( 'text_align', [
				'label'     => __( 'Text Align', 'gnje' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'   => __( 'Left', 'gnje' ),
					'center' => __( 'Center', 'gnje' ),
					'right'  => __( 'Right', 'gnje' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gnje-product-category-content' => 'text-align: {{VALUE}};'
				]
			] );
			$this->add_responsive_control( 'dimensions', [
				'label'      => __( 'Dimensions', 'gnje' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .gnje-wrap-product-category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );
			$this->add_control( 'overlay_bg_heading', [
				'label' => __( 'Overlay Background', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'overlay_bg',
					'label'    => __( 'Background Overlay', 'gnje' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .gnje-wrap-product-category-content',
				]
			);
			$this->add_control(
				'content_bg_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'content_bg_heading', [
				'label' => __( 'Content Background', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'content_bg',
					'label'    => __( 'Content Background', 'gnje' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .gnje-product-category-content',
				]
			);
			$this->add_control(
				'title_color_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'title_color_heading', [
				'label' => __( 'Title', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_control( 'title_color', [
				'label'     => __( 'Title Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-title, {{WRAPPER}} .gnje-product-category-content' => 'color: {{VALUE}};'
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

			$this->add_control(
				'des_color_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'des_color_heading', [
				'label' => __( 'Description', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_control( 'des_color', [
				'label'     => __( 'Description Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-description' => 'color: {{VALUE}};'
				]
			] );
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'des_typography',
					'selector' => '{{WRAPPER}} .gnje-description',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_control(
				'count_color_divider',
				[
					'type' => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'count_color_heading', [
				'label' => __( 'Product Count', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_control( 'count_color', [
				'label'     => __( 'Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-count' => 'color: {{VALUE}};'
				]
			] );
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'cont_typography',
					'selector' => '{{WRAPPER}} .product-count',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_control(
				'button_style_divider',
				[
					'type' => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control('button_style_heading', [
				'label' => __('Button', 'gnje'),
				'type' => Controls_Manager::HEADING
			]);
			$this->add_control('button_color', [
				'label' => __('Button Color', 'gnje'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-button' => 'color: {{VALUE}};'
				]
			]);
			$this->add_control('button_bg', [
				'label' => __('Button Background', 'gnje'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-button.outline::after,{{WRAPPER}}  .gnje-button.normal::after' => 'background: {{VALUE}};'
				]
			]);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .gnje-button',
					'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_responsive_control('button_spacing', [
				'label' => __('Spacing', 'gnje'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .gnje-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);
			$this->add_responsive_control('button_border_radius', [
				'label' => __('Border Radius', 'gnje'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .gnje-button,{{WRAPPER}} .gnje-button:before,{{WRAPPER}} .gnje-button:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);
			$this->end_controls_section();
			$this->start_controls_section( 'hover_style_settings', [
				'label' => __( 'Hover', 'gnje' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			] );
			$this->add_control( 'title_color_hover', [
				'label'     => __( 'Title Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-product-category-banner:hover .gnje-title:hover' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'des_color_hover', [
				'label'     => __( 'Description Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-product-category-banner:hover .gnje-description' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'button_color_hover', [
				'label'     => __( 'Button Color', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-button:hover' => 'color: {{VALUE}};'
				]
			] );
			$this->add_control( 'button_bg_hover', [
				'label'     => __( 'Button Background', 'gnje' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gnje-button.outline:hover:after,{{WRAPPER}}  .gnje-button.normal:hover:after' => 'background: {{VALUE}};'
				]
			] );
			$this->add_control(
				'overlay_bg_hover_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'overlay_bg_hover_heading', [
				'label' => __( 'Background Overlay', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'overlay_bg_hover',
					'label'    => __( 'Background Overlay', 'gnje' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .gnje-product-category-banner:hover .gnje-wrap-product-category-content',
				]
			);
			$this->add_control(
				'content_bg_hover_divider',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control( 'content_bg_hover_heading', [
				'label' => __( 'Background Content', 'gnje' ),
				'type'  => Controls_Manager::HEADING
			] );
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'content_bg_hover',
					'label'    => __( 'Background Content', 'gnje' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .gnje-product-category-banner:hover .gnje-product-category-content',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Load style
		 */
		public function get_style_depends() {
			return [ 'gnje-style' ];
		}

		/**
		 * Render
		 */
		protected function render() {
			// default settings
			$settings = array_merge( [
				'cat'        => '',
				'image'      => '',
				'title'      => '',
				'show_des'   => '',
				'des'        => '',
				'show_count' => '',
				'overlap' => '',
				'button_label' => '',
				'button_icon' => '',
				'button_icon_pos' => 'after',
				'button_style' => 'normal',
				'css_class' => '',

			], $this->get_settings_for_display() );

			$this->add_inline_editing_attributes( 'title' );

			$this->add_inline_editing_attributes('button_label');

			$this->add_render_attribute( 'title', 'class', 'gnje-title' );

			$button_html_classes='gnje-button '.$settings['button_style'];
			$this->add_render_attribute('button_label', 'class', $button_html_classes);

			$this->getViewTemplate( 'template', 'product-category-banner', $settings );
		}
	}
endif;