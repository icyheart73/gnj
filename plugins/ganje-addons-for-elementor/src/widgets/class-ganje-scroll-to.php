<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

/**
 * GanjeScrollTo
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
 final class GanjeScrollTo extends GanjeWidgetBase
 {
     public function get_name()
     {
         return 'ganje-scroll-to';
     }

     public function get_title()
     {
         return __('Ganje Scroll To', 'gnje');
     }

     public function get_icon()
     {
         return 'eicon-scroll';
     }

     /**
      * Register controls
      */
     protected function _register_controls()
     {
         $this->start_controls_section(
             'content_templates',
             [
                 'label'         => __('Sections', 'gnje'),
             ]
         );

         $this->add_control(
             'template_height_hint',
            [
                 'label'         => '<span style="line-height: 1.4em;"><b>NOTICE</b>:</span> You may need to refresh the page to see the changes.',
                 'type'          => Controls_Manager::RAW_HTML,

            ]
        );

         $this->add_control(
             'content_type',
             [
                 'label'         => __('Content Type', 'gnje'),
                 'type'          => Controls_Manager::SELECT,
                 'options'       => [
                     'ids'           => __('HTML ID', 'gnje'),
                     'templates'     => __('Templates', 'gnje')
                 ],
                 'default'       => 'templates'
             ]
         );

         $temp_repeater = new REPEATER();

         $temp_repeater->add_control(
             'label',
            [
                 'label'	  	 => __('Label', 'gnje'),
                 'type'          => Controls_Manager::TEXT,
                 'default'       => ''
            ]
        );

         $temp_repeater->add_control(
             'icon',
            [
                 'label'	  	 => __('Icon', 'gnje'),
                 'type'          => 'ganjeicon',
                 'default'       => ''
            ]
        );

         $temp_repeater->add_control(
             'section_template',
            [
                 'label'			=> __('Template', 'gnje'),
                 'type'          => Controls_Manager::SELECT,
                 'options'       => $this->getSavedElementorTemplates(),
                 'multiple'      => false,
            ]
        );

         $this->add_control(
             'section_repeater',
            [
                'label'          => __('Sections', 'gnje'),
                'type'           => Controls_Manager::REPEATER,
                'fields'         => array_values($temp_repeater->get_controls()),
                'condition'      => [
                    'content_type'   => 'templates'
                ],
                'title_field'    => '{{{ label }}}'
            ]
         );

         $id_repeater = new REPEATER();

         $id_repeater->add_control(
             'section_id',
            [
                 'label'			=> __('Section ID', 'gnje'),
                 'type'          => Controls_Manager::TEXT,
                 'dynamic'       => [ 'active' => true ],
            ]
        );

        $id_repeater->add_control(
            'label',
           [
                'label'	  	 => __('Label', 'gnje'),
                'type'          => Controls_Manager::TEXT,
                'default'       => ''
           ]
       );

        $id_repeater->add_control(
            'icon',
           [
                'label'	  	 => __('Icon', 'gnje'),
                'type'          => 'ganjeicon',
                'default'       => ''
           ]
       );

         $this->add_control(
             'id_repeater',
            [
                'label'          => __('Sections', 'gnje'),
                'type'           => Controls_Manager::REPEATER,
                'fields'         => array_values($id_repeater->get_controls()),
                'condition'      => [
                    'content_type'   => 'ids'
                ],
                'title_field'    => '{{{ label }}}'
            ]
         );

         $this->end_controls_section();

         $this->start_controls_section(
             'nav_menu',
             [
                 'label'     => __('Navigation', 'gnje'),
             ]
         );

         $this->add_control(
             'navigation_layout',
             [
                 'label'         => __('Layout', 'gnje'),
                 'type'          => Controls_Manager::SELECT,
                 'options'       => [
                     'dots'  => __('Dots', 'gnje'),
                     'lines' => __('Lines', 'gnje'),
                 ],
                 'default'       => 'dots'
             ]
         );
         $this->add_control(
              'dots_tooltips_switcher',
              [
                  'label'         => __('Show Tooltips', 'gnje'),
                  'type'          => Controls_Manager::SWITCHER,
                  'default'       => 'yes'
              ]
          );

         $this->add_control(
             'navigation_dots_pos',
             [
                 'label'         => __('Position', 'gnje'),
                 'type'          => Controls_Manager::SELECT,
                 'options'       => [
                     'left'  => __('Left', 'gnje'),
                     'right' => __('Right', 'gnje'),
                 ],
                 'default'       => 'right'
             ]
         );

         $this->end_controls_section();

         $this->start_controls_section(
             'advanced_settings',
             [
                 'label'         => __('Scroll Settings', 'gnje'),
             ]
         );

         $this->add_control(
             'scroll_speed',
             [
                 'label'         => __('Scroll Speed', 'gnje'),
                 'type'          => Controls_Manager::NUMBER,
                 'description'   => __('Set scrolling speed in seconds, the default is 1', 'gnje'),
             ]
         );

         $this->add_control(
             'full_section',
             [
                 'label'         => __('Full Section Scroll', 'gnje'),
                 'type'          => Controls_Manager::SWITCHER,
                 'default'       => 'yes',
             ]
         );

         $this->end_controls_section();

         $this->start_controls_section(
             'navigation_style',
             [
                 'label'         => __('Navigation', 'gnje'),
                 'tab'           => CONTROLS_MANAGER::TAB_STYLE,
             ]
         );

         $this->start_controls_tabs('navigation_style_tabs');

         $this->start_controls_tab(
             'lines_style_tab',
             [
                 'label'         => __('Lines', 'gnje'),
                 'condition' => [
                     'navigation_layout'    => 'lines',

                 ]
             ]
         );
         $this->add_control(
             'lines_color',
             [
                 'label'         => __('Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item'  => 'color: {{VALUE}}'
                 ]
             ]
         );
         $this->add_control(
             'lines_active_color',
             [
                 'label'         => __('Active/Hover Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item.active, {{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item:hover'  => 'color: {{VALUE}}'
                 ]
             ]
         );
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'          => 'lines_label_typo',
                 'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item',
             ]
         );
         $this->add_control(
             'lines_height',
             [
                 'label'         => __('Height', 'gnje'),
                 'type'          => Controls_Manager::SLIDER,
                 'size_units'    => ['px'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item'  => 'border-width: {{SIZE}}{{UNIT}};',
                 ]
             ]
         );
         $this->add_control(
             'lines_width',
             [
                 'label'         => __('Width', 'gnje'),
                 'type'          => Controls_Manager::SLIDER,
                 'size_units'    => ['px'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item'  => 'max-width: {{SIZE}}{{UNIT}};',
                 ]
             ]
         );
         $this->add_control(
             'line_margin',
             [
                 'label'         => __('Margin', 'gnje'),
                 'type'          => Controls_Manager::DIMENSIONS,
                 'size_units'    => ['px', 'em', '%'],
                 'separator'   => 'before',
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item'  => 'margin:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
         $this->add_control(
             'line_padding',
             [
                 'label'         => __('Padding', 'gnje'),
                 'type'          => Controls_Manager::DIMENSIONS,
                 'size_units'    => ['px', 'em', '%'],
                 'separator'   => 'before',
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons-list.lines .gnje-scrollto-nav-item'  => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );

         $this->end_controls_tab();
         $this->start_controls_tab(
             'tooltips_style_tab',
             [
                 'label'         => __('Tooltips', 'gnje'),
                 'condition' => [
                     'dots_tooltips_switcher'    => 'yes',
                     'navigation_layout'    => 'dots',

                 ]
             ]
         );

         $this->add_control(
             'tooltips_color',
             [
                 'label'         => __('Tooltips Text Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value' => Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip'  => 'color: {{VALUE}};',
                 ],
                 'condition' => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'          => 'tooltips_typography',
                 'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip span',
                 'condition'     => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_control(
             'tooltips_background',
             [
                 'label'         => __('Tooltips Background', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value' => Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip'  => 'background-color: {{VALUE}};',
                     '{{WRAPPER}}  .gnje-scrollto-nav-icons.right .gnje-scrollto-nav-item-tooltip::after' => 'border-left-color: {{VALUE}}',
                     '{{WRAPPER}}  .gnje-scrollto-nav-icons.left .gnje-scrollto-nav-item-tooltip::after' => 'border-right-color: {{VALUE}}',
                 ],
                 'condition' => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name'          =>  'tooltips_border',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip',
                 'condition'     => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_control(
             'tooltips_border_radius',
             [
                 'label'         => __('Border Radius', 'gnje'),
                 'type'          => Controls_Manager::SLIDER,
                 'size_units'    => ['px', 'em', '%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip'  => 'border-radius: {{SIZE}}{{UNIT}};',
                 ],
                 'condition'     => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name'          => 'tooltips_shadow',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip',
                 'condition'     => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_responsive_control(
             'tooltips_margin',
             [
                 'label'         => __('Margin', 'gnje'),
                 'type'          => Controls_Manager::DIMENSIONS,
                 'size_units'    => ['px', 'em', '%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'condition' => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->add_responsive_control(
             'tooltips_padding',
             [
                 'label'         => __('Padding', 'gnje'),
                 'type'          => Controls_Manager::DIMENSIONS,
                 'size_units'    => ['px', 'em', '%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-item-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'condition' => [
                     'dots_tooltips_switcher'    => 'yes'
                 ]
             ]
         );

         $this->end_controls_tab();

         $this->start_controls_tab(
             'dots_style_tab',
             [
                 'label'         => __('Dots', 'gnje'),
                 'condition' => [
                     'navigation_layout'    => 'dots',

                 ]

             ]
         );
	     $this->add_control(
		     'dot_size',
		     [
			     'label'         => __('Size', 'gnje'),
			     'type'          => Controls_Manager::SLIDER,
			     'size_units'    => ['px'],
			     'selectors'     => [
				     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li'  => 'width:  {{SIZE}}{{UNIT}};height:  {{SIZE}}{{UNIT}};',
			     ]
		     ]
	     );
	     $this->add_control(
		     'dot_icon_size',
		     [
			     'label'         => __('Icon Size', 'gnje'),
			     'type'          => Controls_Manager::SLIDER,
			     'size_units'    => ['px'],
			     'selectors'     => [
				     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li'  => 'font-size:  {{SIZE}}{{UNIT}};',
			     ]
		     ]
	     );
         $this->add_control(
             'dots_color',
             [
                 'label'         => __('Dots Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value' => Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li'  => 'background-color: {{VALUE}};',
                 ]
             ]
         );
         $this->add_control(
             'dots_bg_color',
             [
                 'label'         => __('Dots Background', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value' => Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li '  => 'background-color: {{VALUE}};',
                 ]
             ]
         );
         $this->add_control(
             'active_dot_color',
             [
                 'label'         => __('Active Dot Background Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value' => Scheme_Color::COLOR_2
                 ],
                 'selectors'     => [
                     '{{WRAPPER}}  .gnje-scrollto-nav-item.active .gnje-scrollto-nav-item-link span, {{WRAPPER}}  .gnje-scrollto-nav-item:hover .gnje-scrollto-nav-item-link span'  => 'background-color: {{VALUE}};',
                 ]
             ]
         );

         $this->add_control(
             'dots_border_color',
             [
                 'label'         => __('Dots Border Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_2
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons .gnje-scrollto-nav-item-link span'  => 'border-color: {{VALUE}};',
                 ]
             ]
         );
	     $this->add_control(
		     'dot_border_radius',
		     [
			     'label'         => __('Border Radius', 'gnje'),
			     'type'          => Controls_Manager::DIMENSIONS,
			     'size_units'    => ['px', 'em', '%'],
			     'separator'   => 'before',
			     'selectors'     => [
				     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li, {{WRAPPER}}  ul.gnje-scrollto-nav-icons-list span'  => 'border-radius:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			     ]
		     ]
	     );
	     $this->add_control(
		     'dot_padding',
		     [
			     'label'         => __('Padding', 'gnje'),
			     'type'          => Controls_Manager::DIMENSIONS,
			     'size_units'    => ['px', 'em', '%'],
			     'separator'   => 'before',
			     'selectors'     => [
				     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li'  => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			     ]
		     ]
	     );
	     $this->add_control(
		     'dot_margin',
		     [
			     'label'         => __('Margin', 'gnje'),
			     'type'          => Controls_Manager::DIMENSIONS,
			     'size_units'    => ['px', 'em', '%'],
			     'separator'   => 'before',
			     'selectors'     => [
				     '{{WRAPPER}}  ul.gnje-scrollto-nav-icons-list li'  => 'margin:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			     ]
		     ]
	     );

         $this->end_controls_tab();

         $this->start_controls_tab(
             'container_style_tab',
             [
                 'label'         => __('Container', 'gnje'),
             ]
         );

         $this->add_control(
             'navigation_background',
             [
                 'label'         => __('Background Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons'  => 'background-color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_control(
             'navigation_border_radius',
             [
                 'label'         => __('Border Radius', 'gnje'),
                 'type'          => Controls_Manager::SLIDER,
                 'size_units'    => ['px', 'em', '%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-icons'  => 'border-radius: {{SIZE}}{{UNIT}};',
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'label'         => __('Shadow', 'gnje'),
                 'name'          => 'navigation_box_shadow',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-icons',
             ]
         );
	     $this->add_control(
		     'navigation_padding',
		     [
			     'label'         => __('Padding', 'gnje'),
			     'type'          => Controls_Manager::DIMENSIONS,
			     'size_units'    => ['px', 'em', '%'],
			     'separator'   => 'before',
			     'selectors'     => [
				     '{{WRAPPER}} .gnje-scrollto-nav-icons'  => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			     ]
		     ]
	     );

         $this->end_controls_tab();

         $this->end_controls_tabs();

         $this->end_controls_section();

         $this->start_controls_section(
             'navigation_menu_style',
             [
                 'label'     => __('Navigation Menu', 'gnje'),
                 'tab'       => CONTROLS_MANAGER::TAB_STYLE,
                 'condition' => [
                     'nav_menu_switch'   => 'yes'
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'          => 'navigation_items_typography',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item .gnje-scrollto-nav-item-link'
             ]
         );

         $this->start_controls_tabs('navigation_menu_style_tabs');

         $this->start_controls_tab(
             'normal_style_tab',
             [
                 'label'         => __('Normal', 'gnje'),
             ]
         );

         $this->add_control(
             'normal_color',
             [
                 'label'         => __('Text Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item .gnje-scrollto-nav-item-link'  => 'color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_control(
             'normal_hover_color',
             [
                 'label'         => __('Text Hover Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item .gnje-scrollto-nav-item-link:hover'  => 'color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_control(
             'normal_background',
             [
                 'label'         => __('Background Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_2
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item'  => 'background-color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'label'         => __('Shadow', 'gnje'),
                 'name'          => 'normal_shadow',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item'
             ]
         );

         $this->end_controls_tab();

         $this->start_controls_tab(
             'active_style_tab',
             [
                 'label'         => __('Active', 'gnje'),
             ]
         );

         $this->add_control(
             'active_color',
             [
                 'label'         => __('Text Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_2
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item.active .gnje-scrollto-nav-item-link'  => 'color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_control(
             'active_hover_color',
             [
                 'label'         => __('Text Hover Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_2
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item.active .gnje-scrollto-nav-item-link:hover'  => 'color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_control(
             'active_background',
             [
                 'label'         => __('Background Color', 'gnje'),
                 'type'          => Controls_Manager::COLOR,
                 'scheme'        => [
                     'type'  => Scheme_Color::get_type(),
                     'value'=> Scheme_Color::COLOR_1
                 ],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item.active'  => 'background-color: {{VALUE}}'
                 ]
             ]
         );

         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'label'         => __('Shadow', 'gnje'),
                 'name'          => 'active_shadow',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item.active'
             ]
         );

         $this->end_controls_tabs();

         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name'          => 'navigation_items_border',
                 'selector'      => '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item',
                 'separator'     => 'before'
             ]
         );

         $this->add_control(
             'navigation_items_border_radius',
             [
                 'label'         => __('Border Radius', 'gnje'),
                 'type'          => Controls_Manager::SLIDER,
                 'size_units'    => ['px','em','%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item'  => 'border-radius: {{SIZE}}{{UNIT}};',
                 ]
             ]
         );

         $this->add_responsive_control(
             'navigation_items_margin',
             [
                 'label'         => __('Margin', 'gnje'),
                 'type'          => Controls_Manager::DIMENSIONS,
                 'size_units'    => ['px', 'em', '%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );

         $this->add_responsive_control(
             'navigation_items_padding',
             [
                 'label'         => __('Padding', 'gnje'),
                 'type'          => Controls_Manager::DIMENSIONS,
                 'size_units'    => ['px', 'em', '%'],
                 'selectors'     => [
                     '{{WRAPPER}} .gnje-scrollto-nav-menu .gnje-scrollto-nav-menu-item .gnje-scrollto-nav-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );

         $this->end_controls_section();
     }

     protected function render()
     {
         $settings = $this->get_settings_for_display();

         $id = $this->get_id();

         $this->add_render_attribute('vertical_scroll_wrapper', 'class', 'gnje-scrollto-section');

         $this->add_render_attribute('vertical_scroll_wrapper', 'id', 'gnje-scrollto-section--' . $id);

         $this->add_render_attribute('vertical_scroll_inner', 'class', array('gnje-scrollto-section-inner'));

         $this->add_render_attribute('vertical_scroll_inner', 'id', 'gnje-scrollto-' . $id);

         $this->add_render_attribute('vertical_scroll_dots', 'class', array('gnje-scrollto-nav-icons', $settings['navigation_dots_pos']));

         $this->add_render_attribute('vertical_scroll_dots_list', 'class', array('gnje-scrollto-nav-icons-list',$settings['navigation_layout']));

         $this->add_render_attribute('vertical_scroll_menu', 'id', 'gnje-scrollto-nav-menu-' . $id);

         $this->add_render_attribute('vertical_scroll_sections_wrap', 'id', 'gnje-scrollto-sections-wrap-' . $id);

         $this->add_render_attribute('vertical_scroll_sections_wrap', 'class', 'gnje-scrollto-sections-wrap');

         $scroll_settings = [
             'id'        => $id,
             'speed'     => !empty($settings['scroll_speed']) ? $settings['scroll_speed'] * 1000 : 700,
             'tooltips'  => 'yes' == $settings['dots_tooltips_switcher'] ? true : false,
             'dotsPos'   => $settings['navigation_dots_pos'],
             'fullSection'=> 'yes' == $settings['full_section'] ? true : false
         ];

         $templates = 'templates' === $settings['content_type'] ? $settings['section_repeater'] : $settings['id_repeater'];
         $checkType = 'templates' === $settings['content_type'] ? true : false;
         ?>

         <div <?php echo $this->get_render_attribute_string('vertical_scroll_wrapper'); ?> data-settings='<?php echo wp_json_encode($scroll_settings); ?>'>
             <div <?php echo $this->get_render_attribute_string('vertical_scroll_inner'); ?>>
                 <div <?php echo $this->get_render_attribute_string('vertical_scroll_dots'); ?>>
                     <ul <?php echo $this->get_render_attribute_string('vertical_scroll_dots_list'); ?>>
                         <?php foreach ($templates as $index => $section) : ?>
                             <li data-index="<?php echo $index; ?>" data-menuanchor="<?php echo $checkType ? 'section_' . $id . $index : $templates[$index]['section_id']; ?>" class="gnje-scrollto-nav-item" data-label="<?php echo $section['label'] ?>">
                                 <div class="gnje-scrollto-nav-item-link"><i class="<?php echo $section['icon'] ?>"></i>
                                     <?php if($settings['dots_tooltips_switcher']=='yes'){?><span class="label"><?php echo $section['label'] ?></span><?php }?>
                                 </div>
                             </li>
                         <?php endforeach; ?>
                     </ul>
                 </div>
                 <?php if ('templates' === $settings['content_type']) : ?>
                     <div <?php echo $this->get_render_attribute_string('vertical_scroll_sections_wrap'); ?>>

                         <?php foreach ($templates as $index => $section) :
                                 $this->add_render_attribute('section_' . $index, 'class', [ 'gnje-scrollto-temp', 'gnje-scrollto-temp-' . $id ]);
         $this->add_render_attribute('section_' . $index, 'id', 'section_' . $id . $index); ?>
                             <div <?php echo $this->get_render_attribute_string('section_' . $index); ?>>
                                 <?php
                                     $template_id = $section['section_template'];
         echo $this->getTemplateContent($template_id); ?>
                             </div>
                         <?php endforeach; ?>
                     </div>
                 <?php endif; ?>
             </div>
         </div>

     <?php
     }
 }
