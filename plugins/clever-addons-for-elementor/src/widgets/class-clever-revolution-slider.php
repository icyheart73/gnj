<?php namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Clever Revolution Slider
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
if (class_exists('RevSlider')):
    final class CleverRevolutionSlider extends CleverWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'clever-revolution-slider';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Clever Revolution Slider', 'cafe');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font clever-icon-slider';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section('settings', [
                'label' => __('Settings', 'cafe')
            ]);
            $this->add_control('id', [
                'label' => __('Slider', 'cafe'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getListRevSlider(),
                'description' => __('Select slider you want display.', 'cafe'),
            ]);

            $this->add_control('css_class', [
                'label' => __('Custom HTML Class', 'cafe'),
                'type' => Controls_Manager::TEXT,
                'description' => __('You may add a custom HTML class to style element later.', 'cafe'),
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