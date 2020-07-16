<?php namespace GanjeAddonsForElementor\Controls;

use Elementor\Base_Data_Control;

/**
 * GanjeIcon
 *
 * @author GanjeSoft <hello.ganjesoft@gmail.com>
 * @package GNJE\Controls
 */
final class GanjeIcon extends Base_Data_Control
{
    /**
     * Type
     *
     * @string
     */
    const TYPE = 'ganjeicon';

    /**
     * Get ganjeicon one area control type.
     *
     * Retrieve the control type, in this case `ganjeicon`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
        return self::TYPE;
    }

    /**
     * Enqueue ganje font one area control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by the ganje font one
     * area control.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue()
    {
        if(is_admin()) {

            wp_register_style('ganjefont', GNJE_URI.'assets/vendor/ganjefont/style.css', [], '7834y238');
            wp_register_script('gnje-control', GNJE_URI.'assets/js/control.js', ['jquery'], '');
            // Styles
            wp_enqueue_style('ganjefont');
            wp_enqueue_script('gnje-control');
        }
    }

    /**
     * Get icons control default settings.
     *
     * Retrieve the default settings of the icons control. Used to return the default
     * settings while initializing the icons control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
        return [
            'include' => '',
            'exclude' => '',
            'options' => ["cs-font ganje-icon-layout-2"=>" icon-layout-2","cs-font ganje-icon-button"=>" icon-button","cs-font ganje-icon-quote-3"=>" icon-quote-3","cs-font ganje-icon-page-builder"=>" icon-page-builder","cs-font ganje-icon-carousel"=>" icon-carousel","cs-font ganje-icon-banner"=>" icon-banner","cs-font ganje-icon-divider"=>" icon-divider","cs-font ganje-icon-click"=>" icon-click","cs-font ganje-icon-cookie"=>" icon-cookie","cs-font ganje-icon-tab"=>" icon-tab","cs-font ganje-icon-slider"=>" icon-slider","cs-font ganje-icon-recent-blog"=>" icon-recent-blog","cs-font ganje-icon-blog"=>" icon-blog","cs-font ganje-icon-wallet-1"=>" icon-wallet-1","cs-font ganje-icon-handshake"=>" icon-handshake","cs-font ganje-icon-undo-1"=>" icon-undo-1","cs-font ganje-icon-plane-3"=>" icon-plane-3","cs-font ganje-icon-plane-2"=>" icon-plane-2","cs-font ganje-icon-clock-4"=>" icon-clock-4","cs-font ganje-icon-play-4"=>" icon-play-4","cs-font ganje-icon-play-3"=>" icon-play-3","cs-font ganje-icon-face-1"=>" icon-face-1","cs-font ganje-icon-comment-1"=>" icon-comment-1","cs-font ganje-icon-comment-2"=>" icon-comment-2","cs-font ganje-icon-comment-3"=>" icon-comment-3","cs-font ganje-icon-comment-4"=>" icon-comment-4","cs-font ganje-icon-360-2"=>" icon-360-2","cs-font ganje-icon-360-1"=>" icon-360-1","cs-font ganje-icon-heart-6"=>" icon-heart-6","cs-font ganje-icon-heart-5"=>" icon-heart-5","cs-font ganje-icon-filter-3"=>" icon-filter-3","cs-font ganje-icon-refresh-5"=>" icon-refresh-5","cs-font ganje-icon-heart-4"=>" icon-heart-4","cs-font ganje-icon-heart-3"=>" icon-heart-3","cs-font ganje-icon-ruler"=>" icon-ruler","cs-font ganje-icon-help"=>" icon-help","cs-font ganje-icon-hand-up"=>" icon-hand-up","cs-font ganje-icon-hand-down"=>" icon-hand-down","cs-font ganje-icon-arrow-up"=>" icon-arrow-up","cs-font ganje-icon-arrow-down"=>" icon-arrow-down","cs-font ganje-icon-arrow-left-4"=>" icon-arrow-left-4","cs-font ganje-icon-arrow-right-4"=>" icon-arrow-right-4","cs-font ganje-icon-refresh-4"=>" icon-refresh-4","cs-font ganje-icon-refresh-3"=>" icon-refresh-3","cs-font ganje-icon-quote-2"=>" icon-quote-2","cs-font ganje-icon-pause"=>" icon-pause","cs-font ganje-icon-check"=>" icon-check","cs-font ganje-icon-caret-down"=>" icon-caret-down","cs-font ganje-icon-caret-left"=>" icon-caret-left","cs-font ganje-icon-caret-right"=>" icon-caret-right","cs-font ganje-icon-caret-up"=>" icon-caret-up","cs-font ganje-icon-caret-square-dow"=>" icon-caret-square-dow","cs-font ganje-icon-caret-square-left"=>" icon-caret-square-left","cs-font ganje-icon-caret-square-right"=>" icon-caret-square-right","cs-font ganje-icon-caret-square-up"=>" icon-caret-square-up","cs-font ganje-icon-check-circle-o"=>" icon-check-circle-o","cs-font ganje-icon-check-circle"=>" icon-check-circle","cs-font ganje-icon-check-square-o"=>" icon-check-square-o","cs-font ganje-icon-check-square"=>" icon-check-square","cs-font ganje-icon-circle-o"=>" icon-circle-o","cs-font ganje-icon-circle"=>" icon-circle","cs-font ganje-icon-dribbble"=>" icon-dribbble","cs-font ganje-icon-flickr"=>" icon-flickr","cs-font ganje-icon-foursquare"=>" icon-foursquare","cs-font ganje-icon-github"=>" icon-github","cs-font ganje-icon-linkedin"=>" icon-linkedin","cs-font ganje-icon-rss"=>" icon-rss","cs-font ganje-icon-square-o"=>" icon-square-o","cs-font ganje-icon-square"=>" icon-square","cs-font ganje-icon-star-o"=>" icon-star-o","cs-font ganje-icon-star"=>" icon-star","cs-font ganje-icon-tumblr"=>" icon-tumblr","cs-font ganje-icon-xing"=>" icon-xing","cs-font ganje-icon-twitter"=>" icon-twitter","cs-font ganje-icon-cart-16"=>" icon-cart-16","cs-font ganje-icon-heart-2"=>" icon-heart-2","cs-font ganje-icon-eye-5"=>" icon-eye-5","cs-font ganje-icon-facebook"=>" icon-facebook","cs-font ganje-icon-googleplus"=>" icon-googleplus","cs-font ganje-icon-instagram"=>" icon-instagram","cs-font ganje-icon-pinterest"=>" icon-pinterest","cs-font ganje-icon-skype"=>" icon-skype","cs-font ganje-icon-vimeo"=>" icon-vimeo","cs-font ganje-icon-youtube-1"=>" icon-youtube-1","cs-font ganje-icon-award-1"=>" icon-award-1","cs-font ganje-icon-clock-3"=>" icon-clock-3","cs-font ganje-icon-three-dots"=>" icon-three-dots","cs-font ganje-icon-share-2"=>" icon-share-2","cs-font ganje-icon-building"=>" icon-building","cs-font ganje-icon-faucet"=>" icon-faucet","cs-font ganje-icon-flower"=>" icon-flower","cs-font ganje-icon-house-1"=>" icon-house-1","cs-font ganje-icon-house"=>" icon-house","cs-font ganje-icon-pines"=>" icon-pines","cs-font ganje-icon-plant"=>" icon-plant","cs-font ganje-icon-sprout-1"=>" icon-sprout-1","cs-font ganje-icon-sprout"=>" icon-sprout","cs-font ganje-icon-trees"=>" icon-trees","cs-font ganje-icon-close-1"=>" icon-close-1","cs-font ganje-icon-list-2"=>" icon-list-2","cs-font ganje-icon-grid-5"=>" icon-grid-5","cs-font ganje-icon-menu-6"=>" icon-menu-6","cs-font ganje-icon-three-dots-o"=>" icon-three-dots-o","cs-font ganje-icon-list-1"=>" icon-list-1","cs-font ganje-icon-menu-5"=>" icon-menu-5","cs-font ganje-icon-menu-4"=>" icon-menu-4","cs-font ganje-icon-heart-1"=>" icon-heart-1","cs-font ganje-icon-user-6"=>" icon-user-6","cs-font ganje-icon-attachment"=>" icon-attachment","cs-font ganje-icon-cart-18"=>" icon-cart-18","cs-font ganje-icon-ball"=>" icon-ball","cs-font ganje-icon-battery"=>" icon-battery","cs-font ganje-icon-briefcase"=>" icon-briefcase","cs-font ganje-icon-car"=>" icon-car","cs-font ganje-icon-cpu-2"=>" icon-cpu-2","cs-font ganje-icon-cpu-1"=>" icon-cpu-1","cs-font ganje-icon-dress-woman"=>" icon-dress-woman","cs-font ganje-icon-drill-tool"=>" icon-drill-tool","cs-font ganje-icon-feeding-bottle"=>" icon-feeding-bottle","cs-font ganje-icon-fruit"=>" icon-fruit","cs-font ganje-icon-furniture-2"=>" icon-furniture-2","cs-font ganje-icon-furniture-1"=>" icon-furniture-1","cs-font ganje-icon-shoes-woman-2"=>" icon-shoes-woman-2","cs-font ganje-icon-shoes-woman-1"=>" icon-shoes-woman-1","cs-font ganje-icon-horse"=>" icon-horse","cs-font ganje-icon-laptop"=>" icon-laptop","cs-font ganje-icon-lipstick"=>" icon-lipstick","cs-font ganje-icon-iron"=>" icon-iron","cs-font ganje-icon-perfume"=>" icon-perfume","cs-font ganje-icon-baby-toy-2"=>" icon-baby-toy-2","cs-font ganje-icon-baby-toy-1"=>" icon-baby-toy-1","cs-font ganje-icon-paint-roller"=>" icon-paint-roller","cs-font ganje-icon-shirt"=>" icon-shirt","cs-font ganje-icon-shoe-man-2"=>" icon-shoe-man-2","cs-font ganje-icon-small-diamond"=>" icon-small-diamond","cs-font ganje-icon-tivi"=>" icon-tivi","cs-font ganje-icon-smartphone"=>" icon-smartphone","cs-font ganje-icon-lights"=>" icon-lights","cs-font ganje-icon-microwave"=>" icon-microwave","cs-font ganje-icon-wardrobe"=>" icon-wardrobe","cs-font ganje-icon-washing-machine"=>" icon-washing-machine","cs-font ganje-icon-watch-2"=>" icon-watch-2","cs-font ganje-icon-watch-1"=>" icon-watch-1","cs-font ganje-icon-slider-3"=>" icon-slider-3","cs-font ganje-icon-slider-2"=>" icon-slider-2","cs-font ganje-icon-slider-1"=>" icon-slider-1","cs-font ganje-icon-cart-15"=>" icon-cart-15","cs-font ganje-icon-cart-14"=>" icon-cart-14","cs-font ganje-icon-cart-13"=>" icon-cart-13","cs-font ganje-icon-cart-12"=>" icon-cart-12","cs-font ganje-icon-cart-11"=>" icon-cart-11","cs-font ganje-icon-cart-10"=>" icon-cart-10","cs-font ganje-icon-cart-9"=>" icon-cart-9","cs-font ganje-icon-cart-8"=>" icon-cart-8","cs-font ganje-icon-pause-1"=>" icon-pause-1","cs-font ganje-icon-arrow-left"=>" icon-arrow-left","cs-font ganje-icon-arrow-left-1"=>" icon-arrow-left-1","cs-font ganje-icon-arrow-left-2"=>" icon-arrow-left-2","cs-font ganje-icon-arrow-left-3"=>" icon-arrow-left-3","cs-font ganje-icon-arrow-right"=>" icon-arrow-right","cs-font ganje-icon-arrow-right-1"=>" icon-arrow-right-1","cs-font ganje-icon-arrow-right-2"=>" icon-arrow-right-2","cs-font ganje-icon-arrow-right-3"=>" icon-arrow-right-3","cs-font ganje-icon-plane-1"=>" icon-plane-1","cs-font ganje-icon-cart-17"=>" icon-cart-17","cs-font ganje-icon-filter-2"=>" icon-filter-2","cs-font ganje-icon-filter-1"=>" icon-filter-1","cs-font ganje-icon-grid-1"=>" icon-grid-1","cs-font ganje-icon-contract"=>" icon-contract","cs-font ganje-icon-expand"=>" icon-expand","cs-font ganje-icon-cart-7"=>" icon-cart-7","cs-font ganje-icon-quote-1"=>" icon-quote-1","cs-font ganje-icon-arrow-right-5"=>" icon-arrow-right-5","cs-font ganje-icon-arrow-left-5"=>" icon-arrow-left-5","cs-font ganje-icon-refresh-2"=>" icon-refresh-2","cs-font ganje-icon-truck"=>" icon-truck","cs-font ganje-icon-wallet"=>" icon-wallet","cs-font ganje-icon-electric-1"=>" icon-electric-1","cs-font ganje-icon-electric-2"=>" icon-electric-2","cs-font ganje-icon-lock"=>" icon-lock","cs-font ganje-icon-share-1"=>" icon-share-1","cs-font ganje-icon-check-box"=>" icon-check-box","cs-font ganje-icon-clock-2"=>" icon-clock-2","cs-font ganje-icon-analytics-laptop"=>" icon-analytics-laptop","cs-font ganje-icon-code-design"=>" icon-code-design","cs-font ganje-icon-competitive-chart"=>" icon-competitive-chart","cs-font ganje-icon-computer-monitor-and-cellphone"=>" icon-computer-monitor-and-cellphone","cs-font ganje-icon-consulting-message"=>" icon-consulting-message","cs-font ganje-icon-creative-process"=>" icon-creative-process","cs-font ganje-icon-customer-reviews"=>" icon-customer-reviews","cs-font ganje-icon-data-visualization"=>" icon-data-visualization","cs-font ganje-icon-document"=>" icon-document","cs-font ganje-icon-download-2"=>" icon-download-2","cs-font ganje-icon-download-1"=>" icon-download-1","cs-font ganje-icon-mail-6"=>" icon-mail-6","cs-font ganje-icon-file-sharing"=>" icon-file-sharing","cs-font ganje-icon-finger-touch-screen"=>" icon-finger-touch-screen","cs-font ganje-icon-horizontal-tablet-with-pencil"=>" icon-horizontal-tablet-with-pencil","cs-font ganje-icon-illustration-tool"=>" icon-illustration-tool","cs-font ganje-icon-keyboard-and-hands"=>" icon-keyboard-and-hands","cs-font ganje-icon-landscape-image"=>" icon-landscape-image","cs-font ganje-icon-layout-squares"=>" icon-layout-squares","cs-font ganje-icon-mobile-app-developing"=>" icon-mobile-app-developing","cs-font ganje-icon-online-purchase"=>" icon-online-purchase","cs-font ganje-icon-online-shopping"=>" icon-online-shopping","cs-font ganje-icon-online-video"=>" icon-online-video","cs-font ganje-icon-clock-1"=>" icon-clock-1","cs-font ganje-icon-padlock-key"=>" icon-padlock-key","cs-font ganje-icon-pc-monitor"=>" icon-pc-monitor","cs-font ganje-icon-place-localizer"=>" icon-place-localizer","cs-font ganje-icon-search-results"=>" icon-search-results","cs-font ganje-icon-search-tool"=>" icon-search-tool","cs-font ganje-icon-settings-tools"=>" icon-settings-tools","cs-font ganje-icon-sharing-symbol"=>" icon-sharing-symbol","cs-font ganje-icon-site-map"=>" icon-site-map","cs-font ganje-icon-smartphone-2"=>" icon-smartphone-2","cs-font ganje-icon-tablet-2"=>" icon-tablet-2","cs-font ganje-icon-thin-expand-arrows"=>" icon-thin-expand-arrows","cs-font ganje-icon-upload-2"=>" icon-upload-2","cs-font ganje-icon-upload-1"=>" icon-upload-1","cs-font ganje-icon-volume-off"=>" icon-volume-off","cs-font ganje-icon-volume-on"=>" icon-volume-on","cs-font ganje-icon-news-list"=>" icon-news-list","cs-font ganje-icon-desktop"=>" icon-desktop","cs-font ganje-icon-news-grid"=>" icon-news-grid","cs-font ganje-icon-setting"=>" icon-setting","cs-font ganje-icon-web-home"=>" icon-web-home","cs-font ganje-icon-web-link"=>" icon-web-link","cs-font ganje-icon-web-links"=>" icon-web-links","cs-font ganje-icon-website-protection"=>" icon-website-protection","cs-font ganje-icon-team"=>" icon-team","cs-font ganje-icon-zoom-in"=>" icon-zoom-in","cs-font ganje-icon-zoom-out"=>" icon-zoom-out","cs-font ganje-icon-arrow-1"=>" icon-arrow-1","cs-font ganje-icon-arrow-bold"=>" icon-arrow-bold","cs-font ganje-icon-arrow-light"=>" icon-arrow-light","cs-font ganje-icon-arrow-regular"=>" icon-arrow-regular","cs-font ganje-icon-cart-1"=>" icon-cart-1","cs-font ganje-icon-cart-2"=>" icon-cart-2","cs-font ganje-icon-cart-3"=>" icon-cart-3","cs-font ganje-icon-cart-4"=>" icon-cart-4","cs-font ganje-icon-cart-5"=>" icon-cart-5","cs-font ganje-icon-cart-6"=>" icon-cart-6","cs-font ganje-icon-chart"=>" icon-chart","cs-font ganje-icon-close"=>" icon-close","cs-font ganje-icon-compare-1"=>" icon-compare-1","cs-font ganje-icon-compare-2"=>" icon-compare-2","cs-font ganje-icon-compare-3"=>" icon-compare-3","cs-font ganje-icon-compare-4"=>" icon-compare-4","cs-font ganje-icon-compare-5"=>" icon-compare-5","cs-font ganje-icon-compare-6"=>" icon-compare-6","cs-font ganje-icon-compare-7"=>" icon-compare-7","cs-font ganje-icon-down"=>" icon-down","cs-font ganje-icon-grid"=>" icon-grid","cs-font ganje-icon-hand"=>" icon-hand","cs-font ganje-icon-layout-1"=>" icon-layout-1","cs-font ganje-icon-layout"=>" icon-layout","cs-font ganje-icon-light"=>" icon-light","cs-font ganje-icon-play-1"=>" icon-play-1","cs-font ganje-icon-list"=>" icon-list","cs-font ganje-icon-mail-1"=>" icon-mail-1","cs-font ganje-icon-mail-2"=>" icon-mail-2","cs-font ganje-icon-mail-3"=>" icon-mail-3","cs-font ganje-icon-mail-4"=>" icon-mail-4","cs-font ganje-icon-mail-5"=>" icon-mail-5","cs-font ganje-icon-map-1"=>" icon-map-1","cs-font ganje-icon-map-2"=>" icon-map-2","cs-font ganje-icon-map-3"=>" icon-map-3","cs-font ganje-icon-map-4"=>" icon-map-4","cs-font ganje-icon-map-5"=>" icon-map-5","cs-font ganje-icon-menu-1"=>" icon-menu-1","cs-font ganje-icon-menu-2"=>" icon-menu-2","cs-font ganje-icon-grid-3"=>" icon-grid-3","cs-font ganje-icon-grid-4"=>" icon-grid-4","cs-font ganje-icon-menu-3"=>" icon-menu-3","cs-font ganje-icon-grid-2"=>" icon-grid-2","cs-font ganje-icon-minus"=>" icon-minus","cs-font ganje-icon-next"=>" icon-next","cs-font ganje-icon-phone-1"=>" icon-phone-1","cs-font ganje-icon-phone-2"=>" icon-phone-2","cs-font ganje-icon-phone-3"=>" icon-phone-3","cs-font ganje-icon-phone-4"=>" icon-phone-4","cs-font ganje-icon-phone-5"=>" icon-phone-5","cs-font ganje-icon-phone-6"=>" icon-phone-6","cs-font ganje-icon-picture"=>" icon-picture","cs-font ganje-icon-pin"=>" icon-pin","cs-font ganje-icon-plus"=>" icon-plus","cs-font ganje-icon-prev"=>" icon-prev","cs-font ganje-icon-eye-4"=>" icon-eye-4","cs-font ganje-icon-eye-3"=>" icon-eye-3","cs-font ganje-icon-eye-2"=>" icon-eye-2","cs-font ganje-icon-eye-1"=>" icon-eye-1","cs-font ganje-icon-refresh-1"=>" icon-refresh-1","cs-font ganje-icon-youtube-2"=>" icon-youtube-2","cs-font ganje-icon-search-1"=>" icon-search-1","cs-font ganje-icon-search-2"=>" icon-search-2","cs-font ganje-icon-search-3"=>" icon-search-3","cs-font ganje-icon-search-4"=>" icon-search-4","cs-font ganje-icon-search-5"=>" icon-search-5","cs-font ganje-icon-support"=>" icon-support","cs-font ganje-icon-tablet-1"=>" icon-tablet-1","cs-font ganje-icon-play-2"=>" icon-play-2","cs-font ganje-icon-up"=>" icon-up","cs-font ganje-icon-user-1"=>" icon-user-1","cs-font ganje-icon-user-2"=>" icon-user-2","cs-font ganje-icon-user-3"=>" icon-user-3","cs-font ganje-icon-user-4"=>" icon-user-4","cs-font ganje-icon-user-5"=>" icon-user-5","cs-font ganje-icon-user"=>" icon-user","cs-font ganje-icon-vector1"=>" icon-vector1","cs-font ganje-icon-wishlist1"=>" icon-wishlist1"]
        ];
    }

    /**
     * Render icons control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
        $control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<select id="<?php echo $control_uid; ?>" class="elementor-control-icon" data-setting="{{ data.name }}" data-placeholder="<?php echo __( 'Select Icon', 'gnje' ); ?>">
					<option value=""><?php echo __( 'Select Icon', 'gnje' ); ?></option>
					<# _.each( data.options, function( option_title, option_value ) { #>
					<option value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{ data.description }}</div>
		<# } #>
		<?php
    }
}
