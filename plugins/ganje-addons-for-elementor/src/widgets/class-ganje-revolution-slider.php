<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Ganje Revolution Slider
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if (class_exists('RevSlider')):
    final class GanjeRevolutionSlider extends GanjeWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'ganje-revolution-slider';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Ganje Revolution Slider', 'gnje');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font ganje-icon-slider';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section('settings', [
                'label' => __('Settings', 'gnje')
            ]);
            $this->add_control('id', [
                'label' => __('Slider', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getListRevSlider(),
                'description' => __('Select slider you want display.', 'gnje'),
            ]);

            $this->add_control('css_class', [
                'label' => __('Custom HTML Class', 'gnje'),
                'type' => Controls_Manager::TEXT,
                'description' => __('You may add a custom HTML class to style element later.', 'gnje'),
            ]);
            $this->end_controls_section();
        }

        /**
         * Render
         */
        protected function render()
        {
            $settings = array_merge([ // default settings
                'id' => '0',
                'css_class' => '',

            ], $this->get_settings_for_display());

            $this->getViewTemplate('template', 'revolution-slider', $settings);
        }
    }
endif;