<?php namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

/**
 * CleverIcon
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverIcon extends CleverWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'clever-icon';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'آیکون گنجه';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font clever-icon-small-diamond';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('icon_settings', [
            'label' => 'آیکون ها',
        ]);
        $this->add_control('icon', [
            'label' => 'آیکون',
            'default' => 'cs-font icon-plane-2',
            'type' => 'clevericon',
        ]);
	    $this->add_control('link', [
		    'label' => 'لینک',
		    'type' => Controls_Manager::URL,
		    'description' => 'هنگام کلیک به آدرس درج شده ارجاع داده می شود',
	    ]);
	    $this->add_control('align', [
		    'label' => 'تراز کردن',
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
			    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
		    ],
	    ]);
	    $this->add_control('css_class', [
		    'label' => 'کلاس HTML سفارشی',
		    'type' => Controls_Manager::TEXT,
		    'description' => 'می توانید یک کلاس سفارشی HTML را به عنصر اضافه نمایید.',
	    ]);
        $this->end_controls_section();
        $this->start_controls_section('normal_style_settings', [
            'label' => 'حالت عادی',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
	    $this->add_control('icon_size', [
		    'label' => 'اندازه آیکون',
		    'type' => Controls_Manager::SLIDER,
		    'range' => [
			    'px' => [
				    'min' => 0,
				    'max' => 100,
			    ],
		    ],
		    'selectors' => [
			    '{{WRAPPER}} .cafe-icon' => 'font-size: {{SIZE}}{{UNIT}};',
		    ],
	    ]);
	    $this->add_control('icon_block_size', [
		    'label' => 'اندازه بلاک آیکون',
		    'type' => Controls_Manager::SLIDER,
		    'range' => [
			    'px' => [
				    'min' => 0,
				    'max' => 300,
			    ],
		    ],
		    'selectors' => [
			    '{{WRAPPER}} .cafe-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
		    ],
	    ]);
	    $this->add_control('color', [
		    'label' => 'رنگ',
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .cafe-icon' => 'color: {{VALUE}};'
		    ]
	    ]);
	    $this->add_control('icon_bg', [
		    'label' => 'پس زمینه آیکون',
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .cafe-icon' => 'background: {{VALUE}};'
		    ]
	    ]);
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .cafe-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'label' => __('Border', 'cafe'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .cafe-icon',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control('padding', [
            'label' => 'حاشیه داخلی',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .cafe-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
	    $this->add_responsive_control('border_radius', [
		    'label' => 'انحنای زوایا',
		    'type' => Controls_Manager::DIMENSIONS,
		    'size_units' => ['px', '%'],
		    'selectors' => [
			    '{{WRAPPER}} .cafe-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		    ],
	    ]);

        $this->end_controls_section();

        $this->start_controls_section('hover_style_settings', [
            'label' => 'حالت هاور',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('color_hover', [
            'label' => 'رنگ',
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-icon:hover' => 'color: {{VALUE}};'
            ]
        ]);
	    $this->add_control('border_color_hover', [
		    'label' => 'رنگ حاشیه',
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .cafe-icon:hover' => 'border-color: {{VALUE}};'
		    ]
	    ]);
        $this->add_control('icon_bg_hover', [
            'label' => 'پس زمینه',
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cafe-icon:hover' => 'background: {{VALUE}};'
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
            'link' => '',
            'css_class' => '',
            'icon' => '',
        ], $this->get_settings_for_display());

        $this->getViewTemplate('template', 'icon', $settings);
    }
}
