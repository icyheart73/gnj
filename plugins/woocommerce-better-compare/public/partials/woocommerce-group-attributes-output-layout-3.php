<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $woocommerce_group_attributes_options;
$divider = $woocommerce_group_attributes_options['attributeValueDivider'];

$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();

// Reassmble the attributes variable
// Add the grouped attributes
$args = array( 'posts_per_page' => -1, 'post_type' => 'attribute_group', 'post_status' => 'publish', 'orderby' => 'menu_order', 'suppress_filters' => 0);

$attribute_groups = get_posts( $args );
$temp = array();
$haveGroup = array();
if(!empty($attribute_groups)){
	foreach ($attribute_groups as $attribute_group) {

		// Attribut Group Name
		$attribute_group_name = $attribute_group->post_title;

		// Attribut Group Image
		$attributeGroupImage = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_image' , true);
		$img = "";
		if(!empty($attributeGroupImage)){
			$img = '<img src="' . $attributeGroupImage . '" alt="' . $attribute_group_name . '" class="attribute-group-image" />';
		}

		$attributes_in_group = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_attributes');
		if(is_array($attributes_in_group[0])) {
			$attributes_in_group = $attributes_in_group[0];
		} else {
			$attributes_in_group = $attributes_in_group;
		}

		if(!empty($attributes_in_group)){
			foreach ($attributes_in_group as $attribute_in_group) {

				$attribute_in_group = wc_attribute_taxonomy_name_by_id($attribute_in_group);

				foreach ($attributes as $attribute) {

					if($attribute['is_visible'] == 0){ 
						continue;
					}

					if($attribute_in_group == $attribute['name']){
						if($woocommerce_group_attributes_options['multipleAttributesInGroups'] !== "1") {
							unset($attributes[$attribute['name']]);
						}
						$temp[$attribute_group_name]['name'] = $attribute_group_name;
						$temp[$attribute_group_name]['img'] = $img;
						$temp[$attribute_group_name]['attributes'][] = $attribute;
						$haveGroup[] = $attribute['name'];
					} else {
						$temp[$attribute['name']] = $attribute;
					}
				}
			}
		} 
	}
} else {
	$temp = $attributes;
}

// Cleanup
foreach ($temp as $asd) {
	if(is_array($asd)) {
		continue;
	}
	$name = $asd->get_name();
	if(!in_array($name, $haveGroup)){
		$temp['other']['name'] = __('More', 'woocommerce-group-attributes');
		$temp['other']['img'] = '';
		$temp['other']['attributes'][] = $asd;
	}
	unset($temp[$name]);
}

ob_start();

?>
<table class="shop_attributes woocommerce-group-attributes-layout-3">
	
	<?php
	foreach ($temp as $key => $attribute_group) :
		?>
		<tr class="attribute_row <?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?> attribute_row_<?php echo $key ?>">
		<?php

		echo '<th class="attribute_group_name">';
			if(isset($attribute_group['img']) && !empty($attribute_group['img'])){
				echo $attribute_group['img'];
			}
			echo $attribute_group['name'];
		echo '</th>';

		echo '<td>';
		ksort($attribute_group['attributes']);
		foreach ( $attribute_group['attributes'] as $attribute ) {
			if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
				continue;
			} else {
				$has_row = true;
			}

			if(is_plugin_active( 'woocommerce-attribute-images/woocommerce-attribute-images.php')) {
				$hasImage = apply_filters('woocommerce_attribute_name_image', wc_attribute_label( $attribute->get_name() ), $attribute->get_id()); 
				if($hasImage) {
					$attribute_name = $hasImage;
				} else {
					$attribute_name = wc_attribute_label( $attribute->get_name() ) . ': ';
				}
			} else {
				$attribute_name = wc_attribute_label( $attribute->get_name() ) . ': ';
			}
			echo '<b class="attribute_name">' . $attribute_name . '</b>';
			
			$values = array();
			if ( $attribute->is_taxonomy() ) {
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

				foreach ( $attribute_values as $attribute_value ) {
					
					$hasImage = apply_filters('woocommerce_attribute_value_image', esc_html( $attribute_value->name ), $attribute_value->term_id);
					if(!empty($hasImage)) {
						$value_name = $hasImage;
					} else {
						$value_name = esc_html( $attribute_value->name );
					}

					if ( $attribute_taxonomy->attribute_public ) {
						$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
					} else {
						$values[] = $value_name;
					}
				}
			} else {
				$values = $attribute->get_options();

				foreach ( $values as &$value ) {
					$value = make_clickable( esc_html( $value ) );
				}
			}
			echo wptexturize( implode( $divider, $values ) );
			echo "<br/>";
			?>
			
		<?php 
		} 
		?>
		</tr>
		<?php
	endforeach; 
?>

	<?php if ( $display_dimensions && $product->has_weight() ) : ?>
		<tr class="attribute_row  <?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
			<th class="attribute_group_name"><?php _e( 'Weight', 'woocommerce' ) ?></th>
			<td class="product_weight"><?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( $display_dimensions && $product->has_dimensions() ) : ?>
		<tr class="attribute_row  <?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
			<th class="attribute_group_name"><?php _e( 'Dimensions', 'woocommerce' ) ?></th>
			<td class="product_dimensions"><?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?></td>
		</tr>
	<?php endif; ?>

</table>
<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}
