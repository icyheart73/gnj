<?php 
namespace GanjeAddonsForElementor\Widgets;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

/**
 * GanjeMultiBanner
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeMultiBanner extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-multi-banner';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return __('Ganje Multi Banner', 'gnje');
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-news-grid';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $repeater = new \Elementor\Repeater();

        $this->start_controls_section(
            'content_settings', [
                'label' => __('Multi Banners', 'gnje')
            ]);
            
            $repeater->add_control('image', [
                'label' => __('Upload Image', 'gnje'),
                'description' => __('Select an image for the banner.', 'gnje'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'show_external' => true,
                'default' => [
                    'url' => GNJE_URI . '/assets/img/banner-placeholder.png'
                ]
            ]);
            $repeater->add_control('link', [
                'label' => __('Link', 'gnje'),
                'type' => Controls_Manager::URL,
                'description' => __('Redirect link when click to banner.', 'gnje'),
            ]);
            $repeater->add_control('title', [
                'label' => __('Title', 'gnje'),
                'placeholder' => __('What is the title of this banner.', 'gnje'),
                'description' => __('What is the title of this banner.', 'gnje'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => __('Ganje Multi Banner', 'gnje'),
                'label_block' => false
            ]);
            $repeater->add_control('title_tag',[
                'label' => __('HTML Tag', 'gnje'),
                'description' => __('Select a heading tag for the title. Headings are defined with H1 to H6 tags.', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p'  => 'P'
                ],
                'label_block' => true,
            ]);
            $repeater->add_control('des', [
                'label' => __('Description', 'gnje'),
                'description' => __('Give a description to this banner.', 'gnje'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'default' => __('A web banner or banner ad is a form of advertising. It is intended to attract traffic to a website by linking to the website of the advertiser. - Wikipedia', 'gnje'),
                'label_block' => true
            ]);
            $repeater->add_control('button_label', [
                'label' => __('Button Label', 'gnje'),
                'placeholder' => __('Button', 'gnje'),
                'description' => __('Leave it blank if don\'t use it', 'gnje'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => __('Button', 'gnje'),
                'label_block' => false
            ]);
            $repeater->add_control('button_icon', [
                'label' => __('Icon', 'gnje'),
                'type' => 'ganjeicon'
            ]);
            $repeater->add_control('button_icon_pos', [
                'label' => __('Icon position', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => __('Before', 'gnje'),
                    'after' => __('After', 'gnje'),
                ]
            ]);
            $repeater->add_control('button_style', [
                'label' => __('Button style', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => __('Normal', 'gnje'),
                    'underline' => __('Underline', 'gnje'),
                    'outline' => __('Outline', 'gnje'),
                ]
            ]);
            $this->add_control('repeater',[
                'label' => __( 'Add Banner', 'gnje' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]);
        $this->end_controls_section();

        $this->start_controls_section(
            'section_setting', [
                'label' => __('Setting', 'gnje')
            ]);

            $this->add_control('layout', [
                'label'         => __('Layout', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'carousel',
                'options' => [
                    'carousel' => __( 'Carousel', 'gnje' ),
                    'grid'  => __( 'Grid', 'gnje' ),
                ],
            ]);
                // Grid
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
                'condition'     => [
                    'layout' => 'grid',
                ],
                
            ]);
                // Carousel
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
                'condition'     => [
                    'layout' => 'carousel',
                ],
                
            ]);

            $this->add_control('speed', [
                'label'         => __('Carousel: Speed to Scroll', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 5000,
                'condition'     => [
                    'layout' => 'carousel',
                ],
                
            ]);
            $this->add_control('scroll', [
                'label'         => __('Carousel: Slide to Scroll', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 1,
                'condition'     => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('autoplay', [
                'label'         => __('Carousel: Auto Play', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'gnje' ),
                'label_off' => __( 'Hide', 'gnje' ),
                'return_value' => 'true',
                'default' => 'true',
                'condition'     => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('show_pag', [
                'label'         => __('Carousel: Pagination', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'gnje' ),
                'label_off' => __( 'Hide', 'gnje' ),
                'return_value' => 'true',
                'default' => 'true',
                'condition'     => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_responsive_control('show_nav', [
                'label'         => __('Carousel: Navigation', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'gnje' ),
                'label_off' => __( 'Hide', 'gnje' ),
                'return_value' => 'true',
                'default' => 'true',
                'condition'     => [
                    'layout' => 'carousel',
                ],
            ]);
            $this->add_control('nav_position', [
                'label'         => __('Carousel: Navigation position', 'gnje'),
                'description'   => __('', 'gnje'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'middle-nav',
                'options' => [
                    'top-nav'       => __( 'Top', 'gnje' ),
                    'middle-nav'    => __( 'Middle', 'gnje' ),
                ],
                'condition'     => [
                    'show_nav'  => 'true',
                    'layout'    => 'carousel',
                ],

            ]);
        $this->end_controls_section();

        $this->start_controls_section(
            'normal_style_settings', [
                'label' => __('Normal', 'gnje'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]);
            $this->add_control('overlay_banner', [
                'label' => __('Overlay banner', 'gnje'),
                'type' => Controls_Manager::SWITCHER,
                'description' => __('Content will show up on image banner.', 'gnje'),
                'return_value' => 'true',
                'default' => 'true',
            ]);
            $this->add_control('effect', [
                'label' => __('Hover Effect', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'condition' => [
                    'overlay_banner' => 'true'
                ],
                'options' => [
                    'normal' => __('Normal', 'gnje'),
                    'lily' => __('Lily', 'gnje'),
                    'layla' => __('Layla', 'gnje'),
                    'sadie' => __('Sadie', 'gnje'),
                    'oscar' => __('Oscar', 'gnje'),
                    'chico' => __('Chico', 'gnje'),
                    'ruby' => __('Ruby', 'gnje'),
                    'roxy' => __('Roxy', 'gnje'),
                    'marley' => __('Marley', 'gnje'),
                    'sarah' => __('Sarah', 'gnje'),
                    'milo' => __('Milo', 'gnje'),
                ]
            ]);
            $this->add_control('content_align', [
                'label' => __('Vertical Align', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'flex-start',
                'options' => [
                    'flex-start' => __('Top', 'gnje'),
                    'center' => __('Middle', 'gnje'),
                    'flex-end' => __('Bottom', 'gnje'),
                ],
                'condition' => [
                    'overlay_banner' => 'true'
                ],
                'selectors' => [
                    '{{WRAPPER}} .gnje-wrap-content' => 'justify-content: {{VALUE}};'
                ]
            ]);
            $this->add_control('text_align', [
                'label' => __('Text Align', 'gnje'),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __('Left', 'gnje'),
                    'center' => __('Center', 'gnje'),
                    'right' => __('Right', 'gnje'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .gnje-wrap-content' => 'text-align: {{VALUE}};'
                ]
            ]);
            $this->add_responsive_control('dimensions', [
                'label' => __('Dimensions', 'gnje'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .gnje-wrap-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]);
            $this->add_control(
                'title_color_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
            );
            $this->add_control('title_color_heading', [
                'label' => __('Title', 'gnje'),
                'type' => Controls_Manager::HEADING
            ]);
            $this->add_control('title_color', [
                'label' => __('Title Color', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner-title, {{WRAPPER}} .gnje-wrap-content' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .gnje-banner-title',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );

            $this->add_control(
                'des_color_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
            );
            $this->add_control('des_color_heading', [
                'label' => __('Description', 'gnje'),
                'type' => Controls_Manager::HEADING
            ]);
            $this->add_control('des_color', [
                'label' => __('Description Color', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner .gnje-banner-description' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'des_typography',
                    'selector' => '{{WRAPPER}} .gnje-banner .gnje-banner-description',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );

            $this->add_control(
                'button_style_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
            );
            $this->add_control('button_style_heading', [
                'label' => __('Button', 'gnje'),
                'type' => Controls_Manager::HEADING
            ]);
            $this->add_control('button_color', [
                'label' => __('Button Color', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner .gnje-button' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('button_bg', [
                'label' => __('Button Background', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner .gnje-button.outline::after,{{WRAPPER}}  .gnje-banner .gnje-button.normal::after' => 'background: {{VALUE}};'
                ]
            ]);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'selector' => '{{WRAPPER}} .gnje-banner .gnje-button',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                ]
            );

            $this->add_control('overlay_bg_heading', [
                'label' => __('Background Overlay', 'gnje'),
                'type' => Controls_Manager::HEADING
            ]);
            $this->add_control(
                'overlay_bg_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'overlay_bg',
                    'label' => __('Background Overlay', 'gnje'),
                    'types' => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .gnje-wrap-content',
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
            'hover_style_settings', [
                'label' => __('Hover', 'gnje'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]);
            $this->add_control('title_color_hover', [
                'label' => __('Title Color', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner:hover .gnje-wrap-content,{{WRAPPER}} .gnje-banner.gnje-overlay-content:hover .gnje-banner-title, {{WRAPPER}} .gnje-banner:not(.gnje-overlay-content) .gnje-banner-title:hover' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('des_color_hover', [
                'label' => __('Description Color', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner.gnje-overlay-content:hover .gnje-banner-description,{{WRAPPER}} .gnje-banner:not(.gnje-overlay-content) .gnje-banner-description:hover' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('button_color_hover', [
                'label' => __('Button Color', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner .gnje-button:hover' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control('button_bg_hover', [
                'label' => __('Button Background', 'gnje'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gnje-banner .gnje-button.outline:hover:after,{{WRAPPER}}  .gnje-banner .gnje-button.normal:hover:after' => 'background: {{VALUE}};'
                ]
            ]);
            $this->add_control(
                'overlay_bg_hover_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
            );
            $this->add_control('overlay_bg_hover_heading', [
                'label' => __('Background Overlay', 'gnje'),
                'type' => Controls_Manager::HEADING
            ]);
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'overlay_bg_hover',
                    'label' => __('Background Overlay', 'gnje'),
                    'types' => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .gnje-banner.gnje-overlay-content:hover .gnje-wrap-content',
                ]
            );
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
            'image' => GNJE_URI . 'assets/img/banner-placeholder.png',
            'auto_size' => 'true',
            'link' => '',
            'css_class' => '',
            'title' => '',
            'title_tag' => 'h3',
            'des' => '',
            'button_label' => '',
            'button_icon' => '',
            'button_icon_pos' => 'after',
            'button_style' => 'normal',
            'overlay_banner' => 'true',
            'effect' => 'normal',

            'columns'               => '',
            'slides_to_show'        => 4,
            'speed'                 => 5000,
            'scroll'                => 1,
            'autoplay'              => 'true',
            'show_pag'              => 'true',
            'show_nav'              => 'true',
            'nav_position'          => 'middle-nav',

        ], $this->get_settings_for_display());

        $this->add_inline_editing_attributes('title');
        $this->add_inline_editing_attributes('description');
        $this->add_inline_editing_attributes('button_label');

        $this->add_render_attribute('title', 'class', 'gnje-banner-title');
        $this->add_render_attribute('des', 'class', 'gnje-banner-description');
        $button_class = 'gnje-button ' . $settings['button_style'];
        $this->add_render_attribute('button_label', 'class', $button_class);

        $this->getViewTemplate('template', 'multi-banner', $settings);
    }
}
