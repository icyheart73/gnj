# Clever-Addons-for-Elementor

Clever Addons is Fully Customizable and Ultimate elements library for Elementor WordPress Page Builder. Lots of useful and premium elements to complete your website quickly. Stunning design and neat and clean code. Option to enable/disable certain elements to improve page loading. No extra resources to slow down your website.


## Elements types
- [x] Autotyping
- [x] Banner (Similar FLATSOME does)
- [ ] Slider (Similar FLATSOME does)
- [ ] Advanced Tabs (Similar FLATSOME does)
- [ ] Grid (Similar FLATSOME does)
- [x] Blog
- [x] CountDown
- [x] ContactForm 7
- [ ] Icon Box
- [x] Images 360 View
- [x] Instagram
- [ ] Services
- [x] Revolution Slider.
- [x] Timeline
- [x] Team Member
- [x] Testimonial
- [x] Video Light Box

## WooCommerce Elements

- [x] Clever Advanced Product
    - Clever Grid Layout
    - Clever Products Ids
    - Product with Pagination
    - Clever Product Filter
- [x] Product Carousel
- [x] Products Carousel with Category Tabs
- [x] Products Deals
- [x] Products Deals with Asset Tabs
- [x] Product Grid Tabs (Asset/Categories)
- [x] Products Grid with Banner and Tabs
- [x] Product List Tags
- [x] Product List Categories
- [x] Single Product

## Dành cho nhà phát triển

### Thêm category

Category trong Elementor là gì?
[Phần đánh dấu đỏ này là 1 category](https://prnt.sc/loesk6)

Mặc định, CAFE đã thêm 1 category cho Elementor, gọi là **Clever Elements**. Việc thêm category hiện tại là ko cần thiết. Tham khảo: [Elementor - Widget Category](https://developers.elementor.com/widget-categories/)

### Thêm widget

Widget trong Elementor là gì?
[Phần đánh dấu đỏ này là 1 widget](https://prnt.sc/loesxk)

Mỗi widget này, khi kéo thả sang phần content đang edit sẽ cho bạn các controls để bạn lựa chọn việc hiển thị của widget: [Ảnh minh họa](https://prnt.sc/loew6k)

Để thêm 1 widget cho CAFE, các bạn chỉ cẩn tạo 1 PHP class, extends `CleverWidgetBase`, có tên filename dạng: `class-{abc-xyz}.php` và tên class là `AbcXyz`(viết hoa chữ cái đầu sau mỗi `-`) sau đó nhét vô folder `src/widgets`. file sẽ được load tự động và widget sẽ được tự động register vào category **Clever Elements**.

Ví dụ `class-clever-test.php`:

```php
<?php namespace CleverAddonsForElementor\Widgets; //  cố định bắt buộc.

use Elementor\Controls_Manager; // cố định bắt buộc.

/**
 * CleverTest
 */
final class CleverTest extends CleverWidgetBase
{
    /**
     * Trả về  slug của widget dạng string
     */
	public function get_name() {} // bắt buộc

    /**
     * Trả về title của widget dạng string
     */
	public function get_title() {} // bắt buộc

    /**
     * Trả về icon của widget dạng string, hiện tại support FontAwesome
     */
	public function get_icon() {} // bắt buộc

    /**
     * Thêm các controls cho widgets
     */
	protected function _register_controls() {} // bắt buộc

    /**
     * Hiển thị widget ngoài frontend
     */
	protected function render() {} // bắt buộc, [Chi tiết](#frontend-render)

    /**
     * Hiện thị custom editor UI
     */
    protected function _content_template() {} // ko bắt buộc, advanced, bỏ đi.
}
```

Mẫu widget [Clever Banner](https://github.com/cleversoft/Clever-Addons-for-Elementor/blob/dev/src/widgets/class-clever-banner.php)

Tham khảo [Elementor - Add new widget](https://developers.elementor.com/creating-a-new-widget) để biết thêm chi tiết.

### Thêm controls cho widget

Thêm controls cho Elementor Widget khá giống add params với `vc_map` của WPBakery Page Builder. Tham khảo [CleverBanner::_register_controls()](https://github.com/cleversoft/Clever-Addons-for-Elementor/blob/dev/src/widgets/class-clever-banner.php#L45)

Chọn `type` cho control dạng `Controls_Manager::{$type}`. `$type` có thể tham khảo từ [Elementor Controls](https://developers.elementor.com/elementor-controls/)

### Thêm assets (styles & scripts) cho widgets

Bạn có thể register & enqueue assets với [AssetsManager](https://github.com/cleversoft/Clever-Addons-for-Elementor/blob/dev/src/class-clever-assets-manager.php).

Assets thuộc về admin thì cho vào `_loadAdminAssets()`, frontend thì cho vào `_loadFrontendAssets()`.

Khi render widgets ngoài frontend, bạn thêm medthod `get_style_depends()` để  load CSS cho widget, thêm method `get_script_depends()` để  load CSS cho widget. Ví dụ, mình muốn load 1 registered script `clever-abc` cho widget `CleverAbc`, mình sẽ thêm đoạn code này vào `CleverAbc` class:

```php
/**
 * @return aray
 */
function get_script_depends()
{
    return ['clever-abc'];
}
```

### Frontend Render

Trong mỗi widget class, có method `render()` để hiển thị nội dung của widgets ngoài frontend. Để  render, trước tiên chúng ta cần lấy settings từ các controls của widget như sau: `$settings = $this->get_settings_for_display()`. Sau đó, các bạn render tùy ý.

Trong phần render này, Elementor cho phép chọn phần nội dung dạng text có thể edit trực tiếp (inline editing) ngoài frontend. Để có thế edit inline, chúng ta cần:

1. Thêm inline edit attributes cho control với method `$this->add_inline_editing_attributes($control_key)`.
2. Thêm render attributes khi render control với method `$this->get_render_attribute_string($control_key)`.

Ví dụ, lúc `_register_controls()` bạn có add 1 control dạng text với key là `widget_title`. Để cái control này có thể edit inline:

```php
protected function render()
{
    $default = [
        'widget_title' => __('Widget Title', 'textdomain')
    ];

    // Merge with default settings so that settings' values always exist.
    $settings = array_merge($default, $this->get_settings_for_display());

    $this->add_inline_editing_attributes('widget_title');

    printf('<h2 %s>%s</h2>', $this->get_render_attribute_string('widget_title'), $settings['widget_title']);
}
```

Để **thêm custom attributes cho inline editable HTML element**, bạn phải dùng method `add_render_attribute($control_key, $attribute_name, $attribute_value)`, ko được code trực tiếp vào element. Ví dụ:

**Cách làm sai**:

```php
printf('<h2 class="widget-title" %s>%s</h2>', $this->get_render_attribute_string('widget_title'), $settings['widget_title']);
```

**Cách làm đúng**:

```php
$this->add_render_attribute('widget_title', 'class', 'widget-title');

printf('<h2 %s>%s</h2>', $this->get_render_attribute_string('widget_title'), $settings['widget_title']);
```

Nếu control dạng text advanced kiểu như `WYSIWYG`, bạn có thể thêm kiểu của inline editor bằng 'advanced' argument: `$this->add_inline_editing_attributes($control_key, 'advanced');`

Tham khảo thêm tại [Add Inline Editing](https://developers.elementor.com/add-inline-editing/)

### Frontend Template Overriding

Để override 1 template của Clever Elementor Addon từ theme, bạn chỉ cần tạo 1 folder với tên `clever-addons-for-elementor` và đặt tên file template giống với file template ở trong plugin.

Ví dụ, để override template `template-banner.php`, tạo template file với tên `template-banner.php` rồi nhét vào folder `clever-addons-for-elementor` trong theme của bạn. 

## Custom control
- Clever Icon control, call in widget by `'type' => 'clevericon'`
## Coding standard

### Widget.

- Must starting by prefix `Clever` uppercase with first Charactor. Example: `CleverBanner`
- Check posttype exists, Class exists before register widget. ex: check Class `WooCommerce` exists before register all widget use WooCommerce.

### Css
- All widget will control by one wrap class. Example:'cafe-banner'
- All class must starting with prefix `cafe`

### Js
- Data Js config of widget in html must add inside this attribute `data-cafe-config` with data type is json
- Js function must starting with prefix `cafe`

### Variables

#### Section
- Must starting with prefix `section_`

#### Option enable/disable feature: SWITCHER
- Must starting with prefix `enable_`

#### Columns:number
- cols

If responsive, use this `$this->add_responsive_control`. Check this demo:
```php
	$slides_to_show = range( 1, 10 );
	$slides_to_show = array_combine( $slides_to_show, $slides_to_show );
	$this->add_responsive_control(
		'slides_to_show',
		[
			'label' => __( 'Slides to Show', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => __( 'Default', 'elementor' ),
			] + $slides_to_show,
			'frontend_available' => true,
		]
	);
```
#### Categories (post categories, woocommerce categories, testimonial categories...):string
- cat

#### Id (post/product id): number
- id (single id)
- ids (multiable ids)

#### Custom class: string
- css_class

#### Link: url
- link

#### Title: string
- title

#### Desciption: string
- des

#### Effect: select
- effect

#### Style: select
- style
