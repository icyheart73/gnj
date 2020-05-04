<?php 
namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
/**
 * CleverProductListTags
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
if (class_exists('WooCommerce')):
    final class CleverProductListTags extends CleverWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'clever-product-list-tags';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Clever Product List Tags', 'cafe');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font clever-icon-cart-3';
        }
        
        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_title', [
                    'label' => __('Title', 'cafe')
                ]);

                $this->add_control('title', [
                    'label'		    => __('Title', 'cafe'),
                    'type'		    => Controls_Manager::TEXT,
                    'default'       => __( 'CAFE Woo', 'cafe' ),
                ]);

            $this->end_controls_section();

            $this->start_controls_section(
                'section_filter', [
                    'label' => __('Filter', 'cafe')
                ]);

                $this->add_control('filter_tags', [
                    'label'         => __('Tags', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'multiple'      => true,
                    'options'       => $this->get_categories_for_cafe('product_tag', 2 ),
                ]);
                
            $this->end_controls_section();

            $this->start_controls_section(
                'section_carousel', [
                    'label' => __('Options', 'cafe')
                ]);
                $this->add_responsive_control('slides_to_show',[
                    'label'         => __( 'Slides to Show', 'elementor' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range' => [
                        'px' =>[
                            'min' => 1,
                            'max' => 10,
                        ]
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default' => [
                        'size' => 4,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 3,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 2,
                        'unit' => 'px',
                    ],
                    
                ]);

                $this->add_control('speed', [
                    'label'         => __('Carousel: Speed to Scroll', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 5000,
                ]);
                $this->add_control('scroll', [
                    'label'         => __('Carousel: Slide to Scroll', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 1,
                ]);
                $this->add_responsive_control('autoplay', [
                    'label'         => __('Carousel: Auto Play', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'cafe' ),
                    'label_off' => __( 'Hide', 'cafe' ),
                    'return_value' => 'true',
                    'default' => 'true',
                ]);
                $this->add_responsive_control('show_pag', [
                    'label'         => __('Carousel: Pagination', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'cafe' ),
                    'label_off' => __( 'Hide', 'cafe' ),
                    'return_value' => 'true',
                    'default' => 'true',
                ]);
                $this->add_responsive_control('show_nav', [
                    'label'         => __('Carousel: Navigation', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'cafe' ),
                    'label_off' => __( 'Hide', 'cafe' ),
                    'return_value' => 'true',
                    'default' => 'true',
                ]);
                $this->add_control('nav_position', [
                    'label'         => __('Carousel: Navigation position', 'cafe'),
                    'description'   => __('', 'cafe'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'middle-nav',
                    'options' => [
                        'top-nav'  => __( 'Top', 'cafe' ),
                        'middle-nav' => __( 'Middle', 'cafe' ),
                    ],
                    'condition'     => [
                        'show_nav' => 'true',
                    ],
                ]);

                


            $this->end_controls_section();

            $this->start_controls_section(
                'normal_style_settings', [
                    'label' => __('Layout', 'cafe'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]);
                
                $this->add_control('title_color', [
                    'label' => __('Title Color', 'cafe'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cafe-title' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => 'title_typography',
                        'selector' => '{{WRAPPER}} .cafe-title',
                        'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    ]
                );
                $this->add_control('title_background', [
                    'label' => __('Title Background', 'cafe'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cafe-title' => 'background: {{VALUE}};'
                    ]
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
            // default settings
            $settings = array_merge([ 
                'title'                 => '',

                'filter_tags'     => '',
                
                'slides_to_show'        => 4,
                'speed'                 => 5000,
                'scroll'                => 1,
                'autoplay'              => 'true',
                'show_pag'              => 'true',
                'show_nav'              => 'true',
                'nav_position'          => 'middle-nav',
                
            ], $this->get_settings_for_display());

            $this->add_inline_editing_attributes('title');

            $this->add_render_attribute('title', 'class', 'cafe-title');

            $this->getViewTemplate('template', 'product-list-tags', $settings);
        }
    }
    
endif;