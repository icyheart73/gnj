<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * GanjeProgressBar
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeProgressBar extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-progress-bar';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Ganje Progress Bar', 'gnje');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-slider-2';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('general_settings', [
            'label' => 'عمومی'
        ]);
        $this->add_control('title', [
            'label' => 'عنوان',
            'type' => Controls_Manager::TEXT,
            'default'=>esc_html__('Progress','gnje'),
            'description' => __('عنوان ', 'gnje'),
        ]);
        $this->add_control('title_tag',
            [
                'label' => __('تگ HTML برای عنوان', 'gnje'),
                'description' => __('برای عنوان یک تگ انتخاب کنید.تگ های عنوان می توانند بیت H1 تا H6 باشند.', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => [
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
            ]);
        $this->add_control('percent', [
            'label' => 'درصد بارگزاری',
            'type' => Controls_Manager::NUMBER,
            'max' => 100,
            'default' => 50,
        ]);
        $this->add_control('percentage_location',
            [
                'label' => 'موقعیت نمایش درصد',
                'description' => __('', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' =>  'بالا',
                    'bottom' =>  'پایین',
                    'inner' =>  'درونی',
                    'stuck-left' =>  'چسبیده چپ',
                    'stuck-right' =>  'چسبیده راست',
                ],
            ]);
        $this->add_control('style',
            [
                'label' => 'سبک',
                'description' => 'انتخاب سبک',
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => 'Default',
                    'grouped' => 'Grouped',
                ],
            ]);
        $this->add_control('duration', [
            'label' => 'مدت زمان (ms)',
            'type' => Controls_Manager::NUMBER,
            'default' => 2000,
        ]);
        $this->end_controls_section();
        $this->start_controls_section('title_style_settings', [
            'label' => 'عنوان',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('title_color', [
            'label' => 'رنگ عنوان',
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-title' => 'color: {{VALUE}};'
            ]
        ]);
        $this->add_responsive_control(
            'title_align',
            [
                'label' => 'ترازبندی',
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => 'چپ',
                        'icon' => 'fa fa-align-left',
                    ],'center' => [
                        'title' => 'وسط',
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => 'راست',
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .gnje-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]

        );
        $this->add_control('title_spacing', [
            'label' => 'فاصله عنوان',
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
        $this->end_controls_section();
        $this->start_controls_section('progress_style_settings', [
            'label' => 'نوار نمایش پیشرفت بارگزاری',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
	    $this->add_control('bg_base', [
		    'label' => __('Background', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .base-bg' => 'background: {{VALUE}};'
            ]
	    ]);
	    $this->add_control('progress_bg', [
		    'label' => __('Progress Background', 'gnje'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gnje-progress-bar' => 'background: {{VALUE}};'
            ]
	    ]);
	    $this->add_control('percentage_color', [
		    'label' => __('Percentage Color', 'gnje'),
		    'type' => Controls_Manager::COLOR,
		    'selectors' => [
			    '{{WRAPPER}} .percent-count' => 'color: {{VALUE}};'
		    ]
	    ]);
        $this->add_control('progress_height', [
            'label' => __('Height', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .base-bg' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_control('progress_dot_height', [
            'label' => __('Dot Height', 'gnje'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .gnje-progress-dot' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'percentage_typography',
                'selector' => '{{WRAPPER}} .percent-count',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]

        );
        $this->add_responsive_control('border_radius', [
            'label' => __('Border Radius', 'gnje'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .base-bg,{{WRAPPER}} .gnje-progress-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'title' => esc_html__('Progress','gnje'),
            'title_tag' => 'h4',
            'percent' => '50',
            'percentage_location' => 'top',
            'duration' => '2000',
            'style' => 'default',
        ], $this->get_settings_for_display());
        $this->add_inline_editing_attributes('title');
        $title_html_classes=['gnje-title'];
        $this->add_render_attribute('title', 'class', $title_html_classes);

        $this->getViewTemplate('template', 'progress-bar', $settings);
    }
}
