<?php namespace GanjeAddonsForElementor;

use DirectoryIterator;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Elementor\Widgets_Manager;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * GanjeWidgetsManager
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
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
        $files = new DirectoryIterator(GNJE_DIR.'src/widgets');

        if (!class_exists('GanjeAddonsForElementor\GanjeWidgetBase')) {
            require GNJE_DIR.'src/widgets/class-ganje-widget-base.php';
        }

        foreach ($files as $file) {
            if ($file->isFile()) {
                $filename = $file->getFileName();
                if (false !== strpos($filename, '.php') && 'class-ganje-widget-base.php' !== $filename) {
                    if (isset($this->settings[$filename]) && '1' === $this->settings[$filename]) {
                        continue;
                    }
                    require GNJE_DIR.'src/widgets/'.$filename;
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
