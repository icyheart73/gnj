<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Ganje Contact Form 7
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if (class_exists('WPCF7')):
    final class GanjeContactForm7 extends GanjeWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'ganje-contact-form-7';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Ganje Contact Form 7', 'gnje');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font ganje-icon-horizontal-tablet-with-pencil';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            //Get list contact form
            $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
            $contact_forms = array();
            if ( $cf7 ) {
                foreach ( $cf7 as $cform ) {
                    $contact_forms[$cform->ID] = $cform->post_title;
                }
            } else {
                $contact_forms[0] = esc_html__( 'No forms found', 'gnje' );
            }

            $this->start_controls_section('settings', [
                'label' => __('Settings', 'gnje')
            ]);
            $this->add_control('ct7_form_id', [
                'label' => __('Contact form', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'options' => $contact_forms,
                'description' => __('Select contact from 7 you want display', 'gnje'),
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
                'ct7_form_id' => 0,
                'css_class' => '',

            ], $this->get_settings_for_display());

            $this->getViewTemplate('template', 'contact-form-7', $settings);
        }
    }
endif;