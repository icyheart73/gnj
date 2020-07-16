<?php
/**
 * View template for Ganje Product Banner and Tabs.
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$product_ids = $default_asset = $html_image = $target = $nofollow = '';

if($settings['product_ids'] && is_array($settings['product_ids'])){
    $product_ids = $settings['product_ids'];
}

if ( is_front_page() ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;   
} else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
}
$meta_query = WC()->query->get_meta_query();

$wc_attr = array(
    'post_type' => 'product',
    'posts_per_page' => $settings['posts_per_page'],
    'paged' => $paged,
    'orderby' => $settings['orderby'],
    'order' => $settings['order'],
    'post__not_in'=> $product_ids,
);

if($settings['default_category'] != '' && $settings['default_category'] != 'all'){
    $wc_attr['product_cat'] = $settings['default_category'];
}
else{
    if($settings['filter_categories']){
        $wc_attr['product_cat'] = implode(',', $settings['filter_categories']);
    }
}
$default_asset = $settings['asset_type'];

switch ($default_asset) {
    case 'featured':
        $meta_query[] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN'
            ),
        );
        $wc_attr['tax_query'] = $meta_query;
        break;
    case 'onsale':
        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $wc_attr['post__in'] = $product_ids_on_sale;
        break;
    case 'best-selling':
        $wc_attr['meta_key'] = 'total_sales';
        $wc_attr['orderby']  = 'meta_value_num';
        break;
    case 'latest':
        $wc_attr['orderby'] = 'date';
        break;
    case 'toprate':
	    $wc_attr['orderby'] = 'meta_value_num';
	    $wc_attr['meta_key'] = '_wc_average_rating';
	    $wc_attr['order'] = 'DESC';
        break;
    case 'deal':
        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $wc_attr['post__in'] = $product_ids_on_sale;
        $wc_attr['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_sale_price_dates_to',
                'value' => time(),
                'compare' => '>'
            )
        );
        break;
    default:
        break;
}
$settings['wc_attr'] = $wc_attr; 

$gnje_wrap_class         = "woocommerce gnje-products-wrap append-class";
$gnje_wrap_class         .= ' gnje-product-banner-and-tabs '.$settings['show_image'].' '.$settings['style'];
$class                  = 'grid-layout';
$grid_class = '  gnje-grid-lg-' . $settings['columns']['size'] . '-cols gnje-grid-md-' . $settings['columns_tablet']['size'] . '-cols gnje-grid-' . $settings['columns_mobile']['size'] .'-cols';
        $gnje_wrap_class .= $grid_class;

if(function_exists('zoo_product_hover_effect')) {
	$class .= ' hover-effect-' . zoo_product_hover_effect();
}

$product_query = new WP_Query($settings['wc_attr']);

$filter_arr = array(

    'asset_type'            => $settings['asset_type'],
    'product_ids'           => $settings['product_ids'],
    'orderby'               => $settings['orderby'],
    'order'                 => $settings['order'],
    'posts_per_page'        => $settings['posts_per_page'],
);
if(isset($settings['link']['is_external']) && $settings['link']['is_external']){
    $target = 'target="_blank"';
}
if(isset($settings['link']['nofollow']) && $settings['link']['nofollow']){
    $nofollow = 'rel="nofollow"';
}
$html_content = '';
$html_des = '';
$html_button = '';
if(isset($settings['content_title']) && $settings['content_title']){
    $html_content .= '<h3 class="title">'.$settings['content_title'].'</h3>';
}
if(isset($settings['content_description']) && $settings['content_description']){
    $html_des .= '<div class="des">'.$settings['content_description'].'</div>';
}
if(isset($settings['link']) && $settings['link']){
    $html_button .= '<a class="button" href="'.$settings['link']['url'].'" '.$target.' '.$nofollow.' >'.$settings['button_text'].'</a>';
}
$html_image .= '<div class="gnje-product-banner" style="background-image:url('.wp_get_attachment_image_src($settings['image']['id'], 'full')[0].')">';
$html_image .= '<div class="wrap-content">' . $html_content . $html_des . $html_button . '</div>';
$html_image .= '</div>';

$list_sub_cat='';
?>
<div class="<?php echo esc_attr($gnje_wrap_class) ?> " 
    data-args='<?php echo json_encode($filter_arr); ?>'
    data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
    <?php if($settings['style'] == 'style-1') { ?>
        <?php if($settings['show_image'] == 'left'){
            echo ent2ncr($html_image);
        } ?>
        <div class="gnje-head-product-filter has-tabs <?php echo esc_attr($settings['title'] ? 'has-border' : '');?>">
            <?php if (isset($settings['title']) && $settings['title'] != '') : 
                printf('<h3 %s>%s</h3>',$this->get_render_attribute_string('title'), $settings['title']); 
            endif;
            $gnje_list_cat_css="gnje-ajax-load filter-cate";
            $accordion_button='';
	        if($settings['show_sub']=='yes'&&$settings['enable_accordion']=='yes'){
		        $gnje_list_cat_css.=' gnje-accordion';
		        $accordion_button='<span class="gnje-btn-accordion"><i class="cs-font ganje-icon-down"></i></span>';
            }
            ?>
            <ul class="<?php echo esc_attr($gnje_list_cat_css);?>">
                <?php
                if($settings['default_category'] && isset(get_term_by('slug',$settings['default_category'], 'product_cat')->name)){
                    echo '<li><a href="'.get_term_link($settings['default_category'], 'product_cat').'" class="active" data-type="product_cat" data-value="'.$settings['default_category'].'" >' . get_term_by('slug',$settings['default_category'], 'product_cat')->name . '</a></li>';
                }
                if($settings['filter_categories']){
                    foreach ($settings['filter_categories'] as $product_cat_slug) {
                        $product_cat = get_term_by('slug', $product_cat_slug, 'product_cat');
                        $selected = '';
                        if(isset($product_cat->slug)){
                            if (isset($settings['wc_attr']['product_cat']) && $settings['wc_attr']['product_cat'] == $product_cat->slug) {
                                $selected = 'gnje-selected';
                            }
                            if($settings['show_sub']=='yes'){
	                            $list_sub_cat=$this->getListProductSubCat($product_cat->term_id,$settings['wc_attr']['product_cat']);
	                            if($list_sub_cat!=''){
		                            $list_sub_cat=$accordion_button.$list_sub_cat;
                                }
                            }
                            echo '<li class="gnje-cat-item"><a href="' . esc_url(get_term_link($product_cat->slug, 'product_cat')) . '"
                                class="' . esc_attr($selected) . '" 
                                data-type="product_cat" data-value="' . esc_attr($product_cat->slug) . '" 
                                title="' . esc_attr($product_cat->name) . '">' . esc_html($product_cat->name) . '</a>'.$list_sub_cat.'</li>';
                        }
                        
                    } 
                }

                ?>
                <?php if($settings['shop_all_link']['url']){ ?>
                <li class="shop-now-button"> <a href="<?php echo $settings['shop_all_link']['url'] ?>" target="<?php echo $settings['shop_all_link']['is_external']?'_blank': ''; ?>" rel="<?php echo $settings['shop_all_link']['nofollow']?'nofollow':''; ?>"><?php echo $settings['shop_all_label'] ?><i class="<?php echo $settings['shop_all_icon'] ?>"></i></a></li>
            <?php 
            } ?>
            </ul>    
            
        </div>
        <?php if($settings['show_image'] == 'center'){
            echo ent2ncr($html_image);
        } ?>
        <ul class="products <?php echo esc_attr($class) ?>">
            <?php 
            while ($product_query->have_posts()) : $product_query->the_post(); ?>
                 <li <?php wc_product_class( ); ?>>
                    <?php
                        /**
                         * Hook: zoo_before_shop_loop_item.
                         *
                         * @hooked zoo_template_loop_product_link_open - 10
                         */
                        do_action( 'zoo_before_shop_loop_item' );

                        /**
                         * Hook: zoo_before_shop_loop_item_title.
                         *
                         * @hooked zoo_show_product_loop_sale_flash - 10
                         * @hooked zoo_template_loop_product_thumbnail - 10
                         */
                        do_action( 'zoo_before_shop_loop_item_title' );

                        /**
                         * Hook: zoo_shop_loop_item_title.
                         *
                         * @hooked zoo_template_loop_product_title - 10
                         */
                        do_action( 'zoo_shop_loop_item_title' );

                        /**
                         * Hook: zoo_after_shop_loop_item_title.
                         *
                         * @hooked zoo_template_loop_rating - 5
                         * @hooked zoo_template_loop_price - 10
                         */
                        do_action( 'zoo_after_shop_loop_item_title' );

                        /**
                         * Hook: zoo_after_shop_loop_item.
                         *
                         * @hooked zoo_template_loop_product_link_close - 5
                         * @hooked zoo_template_loop_add_to_cart - 10
                         */
                        do_action( 'zoo_after_shop_loop_item' );
                    ?>
                </li>
            <?php endwhile;
            ?>
        </ul>
        <?php if($settings['show_image'] == 'right'){
            echo ent2ncr($html_image);
        } ?>
    <?php } else { ?>
        
        <div class="gnje-head-product-filter has-tabs <?php echo esc_attr($settings['title'] ? 'has-border' : '');?>">
            <?php if (isset($settings['title']) && $settings['title'] != '') : 
                printf('<h3 %s>%s</h3>',$this->get_render_attribute_string('title'), $settings['title']); 
            endif; ?>
            <ul class="gnje-ajax-load filter-cate">
                <?php
                if($settings['default_category'] && isset(get_term_by('slug',$settings['default_category'], 'product_cat')->name)){
                    echo '<li><a href="'.get_term_link($settings['default_category'], 'product_cat').'" class="active" data-type="product_cat" data-value="'.$settings['default_category'].'" >' . get_term_by('slug',$settings['default_category'], 'product_cat')->name . '</a></li>';
                }
                if($settings['filter_categories']){
                    foreach ($settings['filter_categories'] as $product_cat_slug) {
                        $product_cat = get_term_by('slug', $product_cat_slug, 'product_cat');
                        $selected = '';
                        if(isset($product_cat->slug)){
                            if (isset($settings['wc_attr']['product_cat']) && $settings['wc_attr']['product_cat'] == $product_cat->slug) {
                                $selected = 'gnje-selected';
                            }
                            echo '<li><a href="' . esc_url(get_term_link($product_cat->slug, 'product_cat')) . '"
                                class="' . esc_attr($selected) . '" 
                                data-type="product_cat" data-value="' . esc_attr($product_cat->slug) . '" 
                                title="' . esc_attr($product_cat->name) . '">' . esc_html($product_cat->name) . '</a></li>';
                        }
                        
                    } 
                }

                ?>
            </ul>    
        </div>
        <?php if($settings['show_image'] != 'right' ){
            echo ent2ncr($html_image);
        } ?>
        <ul class="products <?php echo esc_attr($class) ?>">
            <?php 
            while ($product_query->have_posts()) : $product_query->the_post(); ?>
                <li <?php wc_product_class( ); ?>>
                    <?php
                        /**
                         * Hook: zoo_before_shop_loop_item.
                         *
                         * @hooked zoo_template_loop_product_link_open - 10
                         */
                        do_action( 'zoo_before_shop_loop_item' );

                        /**
                         * Hook: zoo_before_shop_loop_item_title.
                         *
                         * @hooked zoo_show_product_loop_sale_flash - 10
                         * @hooked zoo_template_loop_product_thumbnail - 10
                         */
                        do_action( 'zoo_before_shop_loop_item_title' );

                        /**
                         * Hook: zoo_shop_loop_item_title.
                         *
                         * @hooked zoo_template_loop_product_title - 10
                         */
                        do_action( 'zoo_shop_loop_item_title' );

                        /**
                         * Hook: zoo_after_shop_loop_item_title.
                         *
                         * @hooked zoo_template_loop_rating - 5
                         * @hooked zoo_template_loop_price - 10
                         */
                        do_action( 'zoo_after_shop_loop_item_title' );

                        /**
                         * Hook: zoo_after_shop_loop_item.
                         *
                         * @hooked zoo_template_loop_product_link_close - 5
                         * @hooked zoo_template_loop_add_to_cart - 10
                         */
                        do_action( 'zoo_after_shop_loop_item' );
                    ?>
                </li>
            <?php endwhile;
            ?>
        </ul>
        <?php if($settings['show_image'] == 'right'){
            echo ent2ncr($html_image);
        } ?>
    <?php } ?>
</div>
<?php
wp_reset_postdata();
?>