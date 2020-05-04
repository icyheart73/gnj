<?php namespace CleverAddonsForElementor;

use DirectoryIterator;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Elementor\Widgets_Manager;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * CleverWidgetsManager
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class WidgetsManager
{
    /**
     * Plugin settings
     */
    private $settings;

    /**
     * Nope constructor
     */
    private function __construct()
    {
        $this->settings = get_option(Plugin::OPTION_NAME) ? : [];

        add_action( 'elementor/element/image-carousel/section_style_image/after_section_start', function( $element, $args ) {
            /** @var \Elementor\Widgets\Widget_Image_Carousel $element */
            $element->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'label' => esc_html__( 'Filter', 'cafe' ),
                    'name' => 'css_filters',
                    'selector' => '{{WRAPPER}} img',
                ]
            );
            $element->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'label' => esc_html__( 'Filter on Hover', 'cafe' ),
                    'name' => 'hover_css_filters',
                    'selector' => '{{WRAPPER}} .slick-slide-inner:hover img',
                ]
            );
        }, 10, 2 );

        add_action( 'elementor/element/counter/section_number/after_section_start', function( $element, $args ) {
            /** @var \Elementor\Widgets\Widget_Counter $element */

            $element->add_control(
                'counter_align',
                [
                    'label' => __('Align', 'cafe'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'flex-start' => [
                            'title' => __('Left', 'cafe'),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'center' => __('Center', 'cafe'),
                            'icon' => 'fa fa-align-center',
                        ],
                        'flex-end' => [
                            'title' => __('Right', 'cafe'),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default'=>'center',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-number-wrapper' => 'justify-content: {{VALUE}};'
                    ]
                ]
            );
        }, 10, 2 );
        add_action( 'elementor/element/counter/section_title/after_section_start', function( $element, $args ) {
            /** @var \Elementor\Widgets\Widget_Counter $element */
            $element->add_control(
                'title_align',
                [
                    'label' => __('Align', 'cafe'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', 'cafe'),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'center' => __('Center', 'cafe'),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', 'cafe'),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default'=>'center',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-title' => 'text-align: {{VALUE}};'
                    ]
                ]
            );
        }, 10, 2 );
    }

    /**
     * Singleton
     */
    static function instance($return = false)
    {
        static $self = null;

        if (null === $self) {
            $self = new self;
            add_action('elementor/widgets/widgets_registered', [$self, '_registerWidgets']);
           
        }

        if ($return) {
            return $self;
        }
    }

    /**
     * Register widgets
     *
     * @internal Used as a callback.
     */
    function _registerWidgets(Widgets_Manager $widget_manager)
    {
        $files = new DirectoryIterator(CAFE_DIR.'src/widgets');

        if (!class_exists('CleverAddonsForElementor\CleverWidgetBase')) {
            require CAFE_DIR.'src/widgets/class-clever-widget-base.php';
        }

        foreach ($files as $file) {
            if ($file->isFile()) {
                $filename = $file->getFileName();
                if (false !== strpos($filename, '.php') && 'class-clever-widget-base.php' !== $filename) {
                    if (isset($this->settings[$filename]) && '1' === $this->settings[$filename]) {
                        continue;
                    }
                    require CAFE_DIR.'src/widgets/'.$filename;
                    $classname = $this->getWidgetClassName($filename);
                    $widget = class_exists($classname) ? new $classname() : false;
                    if ($widget && $widget instanceof Widget_Base) {
                        $widget_manager->register_widget_type($widget);
                    }
                }
            }
        }
    }

    /**
     * Add more controls to the built-in widgets of Elementor
     *
     * @internal Used as a callback.
     */


    /**
     * Render custom media queries
     *
     * @internal Used as a callback
     */


    /**
     * Get classname from filename
     *
     * @param string $filename
     *
     * @return string
     */
    private function getWidgetClassName($filename)
    {
        $_filename = trim(str_replace(['class', '-', '.php'], ['', ' ', ''], $filename));

        return sprintf('%s\Widgets\%s', __NAMESPACE__, str_replace(' ', '', ucwords($_filename)));
    }
}

// Initialize.
WidgetsManager::instance();
