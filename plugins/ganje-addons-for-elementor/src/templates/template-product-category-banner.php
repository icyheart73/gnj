<?php
/**
 * View template for Ganje Product Category Banner widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$cat = get_term_by( 'slug', $settings['cat'], 'product_cat' );
if ( ! empty( $cat ) && ! is_wp_error( $cat ) ) {
	$cat_url = get_term_link( $cat );
	$cat_img = $settings['image']['url'] != '' ? $settings['image']['url'] : wp_get_attachment_image_src( get_term_meta( $cat->term_id, 'thumbnail_id', true ), 'full' );
	$title   = $settings['title'] != '' ? $settings['title'] : $cat->name;

	$count     = $cat->count;
	$css_class = 'gnje-product-category-banner';
	if ( $settings['overlap'] == 'true' ) {
		$css_class .= ' gnje-overlay-content';
		if($settings['button_label']!=''){
			$css_class .= ' gnje-button-active';
		}
	}
	$css_class .= ' ' . $settings['css_class'];
	?>
    <div class="<?php echo esc_attr( $css_class ) ?>">
        <a href="<?php echo esc_url( $cat_url ); ?>" title="<?php echo esc_attr( $title ) ?>">
			<?php
			if ( $cat_img ) {
				?>
                <div class="gnje-wrap-image">
                    <img src="<?php echo esc_url( $cat_img ) ?>" alt="<?php echo esc_attr( $title ) ?>"/>
                </div>
				<?php
			}
			?>
            <div class="gnje-wrap-product-category-content">
                <div class="gnje-product-category-content">
					<?php
					printf( '<h3 %s>%s</h3>', $this->get_render_attribute_string( 'title' ),$title );
					if ( $settings['show_des'] == 'true' ) {
						$des = $settings['des'] != '' ? $settings['des'] : $cat->description;
						printf( '<div class="gnje-description">%s</div>', $des );
					}
					if ( $settings['show_count'] == 'true' ) {
						$des         = $settings['des'] != '' ? $settings['des'] : $cat->description;
						$label_count = esc_html__( 'Product', 'gnje' );
						if ( $count > 1 ) {
							$label_count = esc_html__( 'Products', 'gnje' );
						}
						printf( '<div class="product-count"><span class="count">%s</span> %s</div>', $count, $label_count );
					}
					if($settings['button_label']!=''){
						$icon_left='';
						$icon_right='';
						if($settings['button_icon']!=''){
							if($settings['button_icon_pos']=='before'){
								$icon_left='<i class="'.$settings['button_icon'].'"></i>';
							}else{
								$icon_right='<i class="'.$settings['button_icon'].'"></i>';
							}
						}
						printf('<div class="gnje-wrap-button"><span %s>%s %s %s</span></div>', $this->get_render_attribute_string('button_label'),$icon_left, $settings['button_label'], $icon_right);
					}
					?>
                </div>
            </div>
        </a>
    </div>
	<?php
}