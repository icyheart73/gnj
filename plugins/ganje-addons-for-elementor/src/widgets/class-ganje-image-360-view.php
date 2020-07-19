<?php namespace GanjeAddonsForElementor\Widgets;

use Elementor\Controls_Manager;

/**
 * Ganje Image 360 View
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE
 */
final class GanjeImage360View extends GanjeWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'ganje-image-360-view';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'نمای 360 درجه';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font ganje-icon-360-2';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('settings', [
            'label' => 'تنظیمات'
        ]);
        $this->add_control(
            'images',
            [
                'label' => 'افزودن تصویر',
                'type' => Controls_Manager::GALLERY,
                'default' => [],
                'show_label' => false,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control('width', [
            'label' => 'عرض',
            'type' => Controls_Manager::NUMBER,
            'description' => 'تنظیم عرض بر مبنای پیکسل',
        ]);
        $this->add_control('height', [
            'label' => 'ارتفاع',
            'type' => Controls_Manager::NUMBER,
            'description' => 'تنظیم ارتفاع بر مبنای پیکسل',
        ]);
        $this->add_control('des', [
            'label' => 'توضیحات',
            'placeholder' => 'توضیح کوتاه',
            'description' => 'توضیح کوتاه',
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'label_block' => false
        ]);
        $this->add_control('css_class', [
            'label'			=> 'کلاس سفارشی HTML',
            'type'			=> Controls_Manager::TEXT,
            'description'	=> 'کلاس سفارشی HTML برای این المان',
        ]);
        $this->end_controls_section();
    }
    /**
     * Load style
     */
    public function get_style_depends() {
        return [ 'gnje-style' ];
    }    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'spritespin','gnje-script' ];
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'images' => '',
            'width'=>'',
            'height'=>'',
            'des'=>'',
            'css_class'=>'',

        ], $this->get_settings_for_display());

        $this->add_inline_editing_attributes('des');

        $this->getViewTemplate('template', 'image-360-view', $settings);
    }
}
