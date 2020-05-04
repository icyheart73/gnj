<?php namespace CleverAddonsForElementor\Widgets;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

/**
 * CleverSlider
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverSlider extends CleverWidgetBase {

	public $admin_editor_js;


	public function get_name() {
		return 'clever-slider';
	}

	public function get_title() {
		return 'اسلایدر';
	}

	public function get_icon() {
		return 'cs-font clever-icon-slider';
	}

	public function get_keywords() {
		return [ 'slides', 'slider' ];
	}

	public function get_style_depends() {
		return [ 'cleverfont' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'swiper' , 'swiper-script' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'cafe' ),
			'sm' => __( 'Small', 'cafe' ),
			'md' => __( 'Medium', 'cafe' ),
			'lg' => __( 'Large', 'cafe' ),
			'xl' => __( 'Extra Large', 'cafe' ),
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
			'label'     => _x( 'تصویر', 'Background Control', 'cafe' ),
			'type'      => Controls_Manager::MEDIA,
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .bg-banner' => 'background-image: url({{URL}})',
			],
		] );

		$repeater->add_control( 'background_size', [
			'label'      => _x( 'اندازه', 'Background Control', 'cafe' ),
			'type'       => Controls_Manager::SELECT,
			'default'    => 'cover',
			'options'    => [
				'cover'   => _x( 'کاور', 'Background Control', 'cafe' ),
				'contain' => _x( 'شامل', 'Background Control', 'cafe' ),
				'auto'    => _x( 'خودکار', 'Background Control', 'cafe' ),
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
				'{{WRAPPER}} {{CURRENT_ITEM}} .cafe-slide-bg-overlay' => 'background-color: {{VALUE}}',
			],
		] );

		$repeater->add_control( 'background_overlay_blend_mode', [
			'label'      => 'افکت',
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
			'conditions' => [
				'terms' => [
					[
						'name'  => 'background_overlay',
						'value' => 'yes',
					],
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .cafe-slide-bg-overlay' => 'mix-blend-mode: {{VALUE}}',
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
				'{{WRAPPER}} {{CURRENT_ITEM}} .cafe-slide-heading' => 'color: {{VALUE}}',
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
				'{{WRAPPER}} {{CURRENT_ITEM}} .cafe-slide-heading' => 'background-color: {{VALUE}}',
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
					'button_text'      => __( 'Click Here', 'cafe' ),
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
