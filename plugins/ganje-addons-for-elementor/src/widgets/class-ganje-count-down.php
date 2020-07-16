<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
/**
 * Ganje Count Down
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeCountDown extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-count-down';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'شمارشگر معکوس';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-clock-3';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {

        $this->start_controls_section('settings', [
            'label' => 'تنظیمات',
        ]);
        $this->add_control('date', [
            'label' => 'زمان پایان',
            'type' => Controls_Manager::DATE_TIME,
            'description' => 'تاریخ و زمان پایان شمارش',
        ]);
        $this->add_control(
            'align',
            [
                'label' => __( 'Alignment', 'elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .gnje-countdown' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control('css_class', [
            'label' => 'کلاس HTML سفارشی',
            'type' => Controls_Manager::TEXT,
            'description' => 'می توانید یک کلاس سفارشی HTML را به عنصر اضافه نمایید',
        ]);
        $this->end_controls_section();
	    $this->start_controls_section('normal_style_settings', [
		    'label' => 'سبک نمایش',
		    'tab' => Controls_Manager::TAB_STYLE,
	    ]);
	    $this->add_control('width', [
		    'label' => 'عرض آیتم',
		    'type' => Controls_Manager::SLIDER,
		    'range' => [
			    'px' => [
				    'min' => 0,
				    'max' => 200,
			    ],
		    ],
		    'selectors' => [
			    '{{WRAPPER}} .gnje-countdown .countdown-times > div' => 'min-width:{{SIZE}}{{UNIT}};',
		    ],
		    'description' => 'عرض هر آیتم',
	    ]);

	    $this->add_control('color', [
		    'label' => 'رنگ',
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .gnje-countdown .countdown-times > div' => 'color: {{COLOR}};',
		    ],
	    ]);
	    $this->add_control('color_count', [
		    'label' => 'رنگ شمارش گر',
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .gnje-countdown .countdown-times > div b' => 'color: {{COLOR}};',
		    ],
		    'description' => 'رنگ اعداد شمارنده',
	    ]);
	    $this->add_control('bg_color', [
		    'label' => 'رنگ پس زمینه',
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .gnje-countdown .countdown-times > div' => 'background-color: {{COLOR}};',
		    ],
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
        return ['countdown', 'gnje-script'];
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'date' => '',
            'css_class' => '',
        ], $this->get_settings_for_display());

        $this->getViewTemplate('template', 'count-down', $settings);
    }
}
