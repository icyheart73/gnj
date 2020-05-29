<?php namespace CleverAddonsForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * Clever Video Light box
 *
 * @author CleverSoft <hello.cleversoft@gmail.com>
 * @package CAFE
 */
final class CleverVideoLightBox extends CleverWidgetBase
{
    /**
     * @return string
     */
    function get_name()
    {
        return 'clever-video-light-box';
    }

    /**
     * @return string
     */
    function get_title()
    {
        return 'ویدئو پلیر گنجه';
    }

    /**
     * @return string
     */
    function get_icon()
    {
        return 'cs-font clever-icon-play-1';
    }

    /**
     * Register controls
     */
    protected function _register_controls()
    {
        $this->start_controls_section('settings', [
            'label' => 'تنظیمات',
        ]);
	    $this->add_control('aparat_video', [
		    'label' => 'انتخاب نوع ویدئو',
		    'type' => Controls_Manager::SELECT,
		    'default' => 'direct',
		    'options' => [
			    'direct' => 'لینک مستقیم',
			    'aparat' => 'آپارات',
		    ],
	    ]);
        $this->add_control('source_url', [
            'label' => 'لینک مستقیم',
            'type' => Controls_Manager::URL,
            'condition' => [
	            'aparat_video' => 'direct'
            ],
        ]);
	    $this->add_control('source_aparat', [
		    'label' => 'کد اسکریپت (embed)',
		    'type' => Controls_Manager::TEXTAREA,
		    'condition' => [
			    'aparat_video' => 'aparat'
		    ],
	    ]);
        $this->add_control('title', [
            'label' => 'عنوان',
            'type' => Controls_Manager::TEXT,
            'dynamic' => ['active' => true],
            'label_block' => false,
            'condition' => [
	            'aparat_video' => 'direct'
            ],

        ]);
        $this->add_control('des', [
            'label' => 'توضیحات',
            'type' => Controls_Manager::TEXTAREA,
            'dynamic' => ['active' => true],
            'label_block' => false,
            'condition' => [
	            'aparat_video' => 'direct'
            ],
        ]);
        $this->add_control('image', [
            'label' => 'تصویر ویدئو',
            'type' => Controls_Manager::MEDIA,
            'condition' => [
	            'aparat_video' => 'direct'
            ],
        ]);
        $this->add_control('width', [
            'label' => 'عرض تصویر',
            'type' => Controls_Manager::NUMBER,
            'default' => '800',
            'description' => 'عرض تصویر در دسکتاپ',
            'condition' => [
	            'aparat_video' => 'direct'
            ],
        ]);
        $this->add_control('height', [
            'label' => 'ارتفاع تصویر',
            'type' => Controls_Manager::NUMBER,
            'default' => '450',
            'description' => 'ارتفاع تصویر در دسکتاپ',
            'condition' => [
	            'aparat_video' => 'direct'
            ],
        ]);

	    $this->add_control('css_class', [
		    'label' => 'کلاس HTML سفارشی',
		    'type' => Controls_Manager::TEXT,
		    'description' => __('', 'cafe'),
		    'condition' => [
			    'aparat_video' => 'direct'
		    ],
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
        return ['cafe-script'];
    }

    /**
     * Render
     */
    protected function render()
    {
        $settings = array_merge([ // default settings
            'source_url' => '',
            'title' => '',
            'des' => '',
            'width' => '800',
            'height' => '450',
            'image' => '',
            'color' => '#fff',
            'button_type' => 'round',
            'css_class' => '',

        ], $this->get_settings_for_display());

        $this->add_inline_editing_attributes('title');
        $this->add_inline_editing_attributes('des');

        $this->getViewTemplate('template', 'video-light-box', $settings);
    }
}
