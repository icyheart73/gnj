<?php
/**
 * View template for Ganje Categories widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

if ( $settings['cats'] ) {

	$list_sub_cat     = '';
	$accordion_button = '';
	$gnje_list_cat_css = 'gnje-product-categories';
	if($settings['css_class']!=''){
		$gnje_list_cat_css.=' '.$settings['css_class'];
    }
	if ( $settings['show_sub'] == 'yes' && $settings['enable_accordion'] == 'yes' ) {
		$gnje_list_cat_css .= ' gnje-accordion';
		$accordion_button = '<span class="gnje-btn-accordion"><i class="cs-font ganje-icon-down"></i></span>';
	}
	?>
    <div class="<?php echo esc_attr($gnje_list_cat_css);?>">
        <?php
        printf('<h3 %s>%s</h3>', $this->get_render_attribute_string('title'), $settings['title']);
        ?>
        <ul class="gnje-wrap-product-categories">
			<?php
			foreach ( $settings['cats'] as $product_cat_slug ) {
				$product_cat = get_term_by( 'slug', $product_cat_slug, 'product_cat' );
				$selected    = '';
				if ( isset( $product_cat->slug ) ) {
					if ( $settings['show_sub'] == 'yes' ) {
						$list_sub_cat = $this->getListProductSubCat( $product_cat->term_id, $settings['wc_attr']['product_cat'] );
						if ( $list_sub_cat != '' ) {
							$list_sub_cat = $accordion_button . $list_sub_cat;
						}
					}
					echo '<li class="gnje-cat-item"><a href="' . esc_url( get_term_link( $product_cat->slug, 'product_cat' ) ) . '"
                                title="' . esc_attr( $product_cat->name ) . '">' . esc_html( $product_cat->name ) . '</a>' . $list_sub_cat . '</li>';
				}

			} ?>
        </ul>
    </div>
	<?php
}