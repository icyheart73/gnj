<?php

namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Ganje Single Product
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if (class_exists('WooCommerce')):
    final class GanjeSingleProduct extends GanjeWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'ganje-single-product';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Ganje Single Product', 'gnje');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font ganje-icon-online-shopping';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section('content_settings', [
                'label' => __('Settings', 'gnje')
            ]);
            $this->add_control('id', [
                'label' => __('Product', 'gnje'),
                'default' => '',
                'description' => __('Select product you want display.', 'gnje'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_list_posts('product'),
            ]);
            $this->add_control('css_class', [
                'label' => __('Custom HTML Class', 'gnje'),
                'type' => Controls_Manager::TEXT,
                'description' => __('You may add a custom HTML class to style element later.', 'gnje'),
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
            return ['jquery-slick', 'gnje-script'];
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