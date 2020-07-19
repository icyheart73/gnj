<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

/**
 * GanjeSlider
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeSlider extends GanjeWidgetBase {

	public $admin_editor_js;


	public function get_name() {
		return 'ganje-slider';
	}

	public function get_title() {
		return 'اسلایدر';
	}

	public function get_icon() {
		return 'cs-font ganje-icon-slider';
	}

	public function get_keywords() {
		return [ 'slides', 'slider' ];
	}

	public function get_style_depends() {
		return [ 'ganjefont' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'swiper' , 'swiper-script' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'gnje' ),
			'sm' => __( 'Small', 'gnje' ),
			'md' => __( 'Medium', 'gnje' ),
			'lg' => __( 'Large', 'gnje' ),
			'xl' => __( 'Extra Large', 'gnje' ),
		];
	}

	public function editor_js() {
		echo $this->admin_editor_js ;
	}

	protected function _register_controls() {
		$repeater = new Repeater();

		$this->start_controls_section( 'section_slides', [
			'label' => 'اسلاید ها',
		] );

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => 'پس زمینه' ] );

		$repeater->add_control( 'background_image', [
			'label'     => _x( 'تصویر', 'Background Control', 'gnje' ),
			'type'      => Controls_Manager::MEDIA,
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .bg-banner' => 'background-image: url({{URL}})',
			],
		] );

		$repeater->add_control( 'background_size', [
			'label'      => _x( 'اندازه', 'Background Control', 'gnje' ),
			'type'       => Controls_Manager::SELECT,
			'default'    => 'cover',
			'options'    => [
				'cover'   => _x( 'کاور', 'Background Control', 'gnje' ),
				'contain' => _x( 'شامل', 'Background Control', 'gnje' ),
				'auto'    => _x( 'خودکار', 'Background Control', 'gnje' ),
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .bg-banner' => 'background-size: {{VALUE}}',
			],
			'conditions' => [
				'terms' => [
					[
						'name'     => 'background_image[url]',
						'operator' => '!=',
						'value'    => '',
					],
				],
			],
		] );
		$repeater->add_control( 'background_overlay', [
			'label'      => 'پوشش پس زمینه' ,
			'type'       => Controls_Manager::SWITCHER,
			'default'    => 'yes',
			'separator'  => 'before',
			'conditions' => [
				'terms' => [
					[
						'name'     => 'background_image[url]',
						'operator' => '!=',
						'value'    => '',
					],
				],
			],
		] );

		$repeater->add_control( 'background_overlay_color', [
			'label'      => 'رنگ',
			'type'       => Controls_Manager::COLOR,
			'default'    => '',
			'conditions' => [
				'terms' => [
					[
						'name'  => 'background_overlay',
						'value' => 'yes',
					],
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .gnje-slide-bg-overlay' => 'background-color: {{VALUE}}',
			],
		] );

		$repeater->add_control( 'background_overlay_blend_mode', [
			'label'      => 'افکت',
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
			'conditions' => [
				'terms' => [
					[
						'name'  => 'background_overlay',
						'value' => 'yes',
					],
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .gnje-slide-bg-overlay' => 'mix-blend-mode: {{VALUE}}',
			],
		] );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'content', [ 'label' => 'محتوا' ] );

		$repeater->add_control( 'heading', [
			'label'       => 'عنوان و توضیحات',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'عنوان اسلاید',
			'label_block' => true,
		] );

		$repeater->add_control( 'description', [
			'label'      => 'توضیحات',
			'type'       => Controls_Manager::TEXTAREA,
			'default'    => 'توضیحات خور را وارد کنید',
			'show_label' => false,
		] );

		$repeater->add_control( 'link', [
			'label'       => 'لینک',
			'type'        => Controls_Manager::URL,
			'placeholder' => '#',
		] );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => 'استایل' ] );

		$repeater->add_control( 'custom_style', [
			'label'       => 'سفارشی',
			'type'        => Controls_Manager::SWITCHER,
			'description' => 'استایل سفارشی فقط برای همین اسلاید تنظیم می شود' ,
		] );


		$repeater->add_control(
			'color_divider',
			[
				'type'       => Controls_Manager::DIVIDER,
				'style'      => 'thick',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);
		$repeater->add_control( 'slide_text_color', [
			'label'      =>  'رنگ متن',
			'type'       => Controls_Manager::COLOR,
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .gnje-slide-heading' => 'color: {{VALUE}}',
			],
			'conditions' => [
				'terms' => [
					[
						'name'  => 'custom_style',
						'value' => 'yes',
					],
				],
			],
		] );

		$repeater->add_control( 'slide_background_color', [
			'label'      => 'رنگ پس زمینه',
			'type'       => Controls_Manager::COLOR,
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .gnje-slide-heading' => 'background-color: {{VALUE}}',
			],
			'conditions' => [
				'terms' => [
					[
						'name'  => 'custom_style',
						'value' => 'yes',
					],
				],
			],
		] );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control( 'slides', [
			'label'       => 'اسلایدها',
			'type'        => Controls_Manager::REPEATER,
			'show_label'  => true,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'heading'          => 'اسلاید 1',
					'description'      =>'توضیحات خود را وارد کنید',
					'button_text'      => 'اینجا کلیک کنید',
					'background_color' => '#3d70b2',
				],
				[
					'heading'          => 'اسلاید 2',
					'description'      => 'توضیحات خود را وارد کنید',
					'button_text'      => __( 'Click Here', 'gnje' ),
					'background_color' => '#6596e6',
				],
				[
					'heading'          => 'اسلاید 3',
					'description'      => 'توضیحات خود را وارد کنید',
					'button_text'      => 'اینجا کلیک کنید',
					'background_color' => '#41d6c3',
				],
			],
			'title_field' => '{{{ heading }}}',
		] );

		$this->add_responsive_control( 'slides_height', [
			'label'      => 'ارتفاع',
			'type'       => Controls_Manager::SLIDER,
			'range'      => [
				'px' => [
					'min' => 100,
					'max' => 1000,
				],
				'vh' => [
					'min' => 10,
					'max' => 100,
				],
			],
			'default'    => [
				'size' => 400,
			],
			'size_units' => [ 'px', 'vh'],
			'selectors'  => [
				'{{WRAPPER}} .bg-banner' => 'height: {{SIZE}}{{UNIT}};',
			],
			'separator'  => 'before',
		] );
		$this->add_responsive_control( 'show_arrows', [
			'label'          => 'نمایش فلش های ناوبری',
			'type'           => Controls_Manager::SWITCHER,
			'default'        => 'yes',
			'tablet_default' => 'yes',
			'mobile_default' => 'no'
		] );
		$this->add_responsive_control( 'show_dots', [
			'label'   => 'نمایش نقاط ناوبری',
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->end_controls_section();

		}
	/**
	 * Render
	 */
	protected function render() {
		$this->getViewTemplate( 'template', 'slider', $this->get_settings() );
	}
}
