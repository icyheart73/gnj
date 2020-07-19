<?php 
namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
/**
 * GanjeProductGridTabs
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
if (class_exists('WooCommerce')):
    final class GanjeProductGridTabs extends GanjeWidgetBase
    {
        /**
         * @return string
         */
        function get_name()
        {
            return 'ganje-product-grid-tabs';
        }

        /**
         * @return string
         */
        function get_title()
        {
            return __('Ganje Product Grid Tabs', 'gnje');
        }

        /**
         * @return string
         */
        function get_icon()
        {
            return 'cs-font ganje-icon-tab';
        }

        /**
         * Register controls
         */
        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_title', [
                    'label' => __('Title', 'gnje')
                ]);

                $this->add_control('title', [
                    'label'		    => __('Title', 'gnje'),
                    'type'		    => Controls_Manager::TEXT,
                    'default'       => __( 'GNJE Woo', 'gnje' ),
                ]);

            $this->end_controls_section();

            $this->start_controls_section(
                'section_filter', [
                    'label' => __('Filter', 'gnje')
                ]);

                $this->add_control('cate_asset', [
                    'label'         => __('Category / Asset type', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'cate',
                    'options' => [
                        'cate'  => __( 'Category', 'gnje' ),
                        'asset' => __( 'Asset type', 'gnje' ),
                    ],
                ]);
                //Cate
                $this->add_control('filter_categories', [
                    'label'         => __('Categories', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'multiple'      => true,
                    'options'       => $this->get_categories_for_gnje('product_cat', 2),
                    
                ]);
                $this->add_control('default_category', [
                    'label'         => __('Default categories', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => $this->get_categories_for_gnje('product_cat'),
                    'condition'     => [
                        'cate_asset' => 'cate',
                    ],
                ]);
                $this->add_control('asset_type', [
                    'label'         => __('Asset type', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'all',
                    'options'       => $this->get_woo_asset_type_for_gnje(),
                    'condition'     => [
                        'cate_asset' => 'cate',
                    ],
                ]);

                // Asset
                $this->add_control('filter_assets', [
                    'label'         => __('Asset type', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'multiple'      => true,
                    'options'       => $this->get_woo_asset_type_for_gnje(2),
                    'condition'     => [
                        'cate_asset' => 'asset',
                    ],
                ]);
                $this->add_control('default_asset', [
                    'label'         => __('Default asset', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => $this->get_woo_asset_type_for_gnje(),
                    'condition'     => [
                        'cate_asset' => 'asset',
                    ],
                ]);
                
                // Filter default
                $this->add_control('product_ids', [
                    'label'         => __('Exclude product IDs', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT2,
                    'multiple'      => true,
                    'options'       => $this->get_list_posts('product'),
                ]);
                $this->add_control('orderby', [
                    'label'         => __('Order by', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'date',
                    'options'       => $this->get_woo_order_by_for_gnje(),
                ]);
                $this->add_control('order', [
                    'label'         => __('Order', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'desc',
                    'options'       => $this->get_woo_order_for_gnje(),
                ]);

                $this->add_control('posts_per_page', [
                    'label'         => __('Products per pages', 'gnje'),
                    'description'   => __('', 'gnje'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 6,
                ]);
                $this->add_responsive_control('columns',[
                    'label'         => __( 'Columns for row', 'gnje' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range' => [
                        'col' =>[
                            'min' => 1,
                            'max' => 6,
                        ]
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default' => [
                        'size' => 4,
                        'unit' => 'col',
                    ],
                    'tablet_default' => [
                        'size' => 3,
                        'unit' => 'col',
                    ],
                    'mobile_default' => [
                        'size' => 2,
                        'unit' => 'col',
                    ],
                    
                ]);
                
            $this->end_controls_section();

            $this->start_controls_section(
                'normal_style_settings', [
                    'label' => __('Layout', 'gnje'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]);
                
                $this->add_control('title_color', [
                    'label' => __('Title Color', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-title' => 'color: {{VALUE}};'
                    ]
                ]);
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => 'title_typography',
                        'selector' => '{{WRAPPER}} .gnje-title',
                        'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    ]
                );
                $this->add_control('title_background', [
                    'label' => __('Title Background', 'gnje'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gnje-title' => 'background: {{VALUE}};'
                    ]
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
            return ['gnje-script'];
        }
        /**
         * Render
         */
        protected function render()
        {
            // default settings
            $settings = array_merge([ 
                'title'                 => '',
                'cate_asset'            => 'cate',
                'filter_categories'     => '',
                'default_category'      => '',
                'asset_type'            => 'all',
                'filter_assets'         => '',
                'default_asset'         => '',
                'product_ids'           => '',
                'orderby'               => 'date',
                'order'                 => 'desc',
                'posts_per_page'        => 6,
                'columns'               => '',
                
            ], $this->get_settings_for_display());

            $this->add_inline_editing_attributes('title');

            $this->add_render_attribute('title', 'class', 'gnje-title');

            $this->getViewTemplate('template', 'product-grid-tabs', $settings);
        }
    }
endif;