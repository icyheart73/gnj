<?php

namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Clever Single Product
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
if (class_exists('WooCommerce')):
    final class CleverSingleProduct extends CleverWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'clever-single-product';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Clever Single Product', 'cafe');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font clever-icon-online-shopping';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section('content_settings', [
                'label' => __('Settings', 'cafe')
            ]);
            $this->add_control('id', [
                'label' => __('Product', 'cafe'),
                'default' => '',
                'description' => __('Select product you want display.', 'cafe'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_list_posts('product'),
            ]);
            $this->add_control('css_class', [
                'label' => __('Custom HTML Class', 'cafe'),
                'type' => Controls_Manager::TEXT,
                'description' => __('You may add a custom HTML class to style element later.', 'cafe'),
            ]);
            $this->end_controls_section();
        }

        /**
         * Load style
         */
        public function get_style_depends()
        {
            return ['cafe-style'];
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
            return ['jquery-slick', 'cafe-script'];
        }

        /**
         * Render
         */
        protected function render()
        {
            $settings = array_merge([ // default settings
                'id' => '',
                'css_class' => '',

            ], $this->get_settings_for_display());

            $this->getViewTemplate('template', 'single-product', $settings);
        }
    }
endif;