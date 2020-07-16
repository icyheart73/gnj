<?php namespace GanjeAddonsForElementor;

use DirectoryIterator;
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

/**
 * GanjeControlsManager
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeControlsManager
{
    /**
     * Singleton
     */
    public static function init($return = false)
    {
        static $self = null;

        if (null === $self) {
            $self = new self;
            add_action('elementor/controls/controls_registered', [$self,'_registerControls']);
        }

        if ($return) return $self;
    }

    /**
     * @internal  Used as a callback
     */
    public function _registerControls(Controls_Manager $manager)
    {
        $files = new DirectoryIterator(GNJE_DIR.'src/controls');

        foreach ($files as $file) {
            if ($file->isFile()) {
                $filename = $file->getFileName();
                if (false !== strpos($filename, '.php')) {
                    require GNJE_DIR.'src/controls/'.$filename;
                    $classname = $this->getWidgetClassName($filename);
                    $control = class_exists($classname) ? new $classname() : false;
                    if ($control && $control instanceof Base_Data_Control) {
                        $manager->register_control($control->get_type(), $control);
                    }
                }
            }
        }
    }

    /**
     * Extract classname from filename
     *
     * @param string $filename
     *
     * @return string
     */
    private function getWidgetClassName($filename)
    {
        $_filename = trim(str_replace(['class', '-', '.php'], ['', ' ', ''], $filename));

        return sprintf('%s\Controls\%s', __NAMESPACE__, str_replace(' ', '', ucwords($_filename)));
    }
}

// Init
GanjeControlsManager::init();
