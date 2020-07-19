<?php
/**
 * View template for Ganje Product Deal and Tabs.
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$product_ids = $default_asset = '';

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

$default_asset = $settings['default_asset'];

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

$gnje_wrap_class         = "woocommerce gnje-products-wrap gnje-deal-wrap";
$class                  = 'grid-layout';
$grid_class = '  gnje-grid-lg-' . $settings['columns']['size'] . '-cols gnje-grid-md-' . $settings['columns_tablet']['size'] . '-cols gnje-grid-' . $settings['columns_mobile']['size'] .'-cols';
        $gnje_wrap_class .= $grid_class;

if(function_exists('zoo_product_hover_effect')) {
	$class .= ' hover-effect-' . zoo_product_hover_effect();
}

$product_query = new WP_Query($settings['wc_attr']);

$filter_arr = array(

    'product_ids'           => $settings['product_ids'],
    'orderby'               => $settings['orderby'],
    'order'                 => $settings['order'],
    'posts_per_page'        => $settings['posts_per_page'],
);

?>
<div class="<?php echo esc_attr($gnje_wrap_class) ?>">
    <?php if($settings['show_deal_position'] == 'left') : ?>
    <div class="gnje-module-1">
        <div class="gnje-head-product-filter has-tabs <?php echo esc_attr($settings['title'] ? 'has-border' : '');?>">
            <?php if (isset($settings['title_deal']) && $settings['title_deal'] != '') :
                printf('<h3 %s>%s</h3>',$this->get_render_attribute_string('title_deal'), $settings['title_deal']); 
            endif; ?>
            
        </div>
        <ul class="products deal <?php echo esc_attr($class) ?>">
            <?php 
            $wc_attr2 = array(
                'post_type' => 'product',
                'posts_per_page' => 1,
                'post__in' => array($settings['deal_id']),
            );
            $deal_query = new WP_Query($wc_attr2);
            add_action('zoo_after_shop_loop_item_title','zoo_sold_bar', 15);
            remove_action('woocommerce_before_shop_loop_item_title', 'zoo_loop_sale_countdown', 10);
            add_action('zoo_after_shop_loop_item', 'zoo_loop_sale_countdown', 50);
            while ($deal_query->have_posts()) : $deal_query->the_post(); ?>
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
        <?php wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>
    <div class="gnje-module-2 append-class"
        data-args='<?php echo json_encode($filter_arr); ?>'
        data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
        <div class="gnje-head-product-filter">
            <?php if (isset($settings['title']) && $settings['title'] != '') : 
                printf('<h3 %s>%s</h3>',$this->get_render_attribute_string('title'), $settings['title']); 
            endif; ?>
            <?php if($settings['filter_assets']) : ?>
            <ul class="gnje-ajax-load filter-asset">
                <?php
                $asset_title = '';
                switch ($settings['default_asset']) {
                    case 'featured':
                        $asset_title =  esc_html__('Featured','gnje');
                        break;
                    case 'onsale':
                        $asset_title =  esc_html__('On Sale','gnje');
                        break;
                    case 'deal':
                        $asset_title =  esc_html__('Deal','gnje');
                        break;
                    case 'latest':
                        $asset_title =  esc_html__('New Arrivals','gnje');
                        break;
                    case 'best-selling':
                        $asset_title =  esc_html__('Best Seller','gnje');
                        break;
                    case 'toprate':
                        $asset_title =  esc_html__('Top Rate','gnje');
                        break;
                    default:
                        break;
                } 
                if($asset_title) { ?>
                    <li class="cvca-ajax-load">
                        <a href="#" class="active" data-type="asset_type" data-value="<?php echo esc_attr($settings['default_asset']) ?>" title="<?php echo esc_attr($asset_title); ?>"><?php echo esc_attr($asset_title); ?></a>
                    </li>
                
                <?php 
                } 
            
                $html = '';
                foreach ($settings['filter_assets'] as $val) {
                    switch ($val) {
                        case 'featured':
                            $html .= $settings['default_asset'] != 'featured'? '<li><a href="#" data-type="asset_type" data-value="featured" title="'.esc_html__('Featured','gnje').'">'.esc_html__('Featured','gnje').'</a></li>' : '';
                            break;
                        case 'onsale':
                            $html .= $settings['default_asset'] != 'onsale'? '<li><a href="#" data-type="asset_type" data-value="onsale" title="'.esc_html__('On Sale','gnje').'">'.esc_html__('On Sale','gnje').'</a></li>' : '';
                            break;
                        case 'deal':
                            $html .= $settings['default_asset'] != 'deal'? '<li><a href="#" data-type="asset_type" data-value="deal" title="'.esc_html__('Deal','gnje').'">'.esc_html__('Deal','gnje').'</a></li>' : '';
                            break;
                        case 'latest':
                            $html .= $settings['default_asset'] != 'latest'? '<li><a href="#" data-type="asset_type" data-value="latest" title="'.esc_html__('New Arrivals','gnje').'">'.esc_html__('New Arrivals','gnje').'</a></li>' : '';
                            break;
                        case 'best-selling':
                            $html .= $settings['default_asset'] != 'best-selling'? '<li><a href="#" data-type="asset_type" data-value="best-selling" title="'.esc_html__('Best Seller','gnje').'">'.esc_html__('Best Seller','gnje').'</a></li>' : '';
                            break;
                        case 'toprate':
                            $html .= $settings['default_asset'] != 'toprate'? '<li><a href="#" data-type="asset_type" data-value="toprate" title="'.esc_html__('Top Rate','gnje').'">'.esc_html__('Top Rate','gnje').'</a></li>' : '';
                            break;
                        default:
                            break;
                    }
                } 

                echo ent2ncr($html); ?>

            </ul>
            <?php endif; ?>
        </div>
        <ul class="products <?php echo esc_attr($class) ?>">
            <?php 
            remove_action('zoo_after_shop_loop_item_title','zoo_sold_bar', 15);
            remove_action('zoo_before_shop_loop_item_title', 'zoo_loop_sale_countdown', 10);
            remove_action('zoo_after_shop_loop_item', 'zoo_loop_sale_countdown', 50);
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
    </div>
    <?php if($settings['show_deal_position'] == 'right') : ?>
    <div class="gnje-module-1">
        <div class="gnje-head-product-filter">
            <?php if (isset($settings['title_deal']) && $settings['title_deal'] != '') :
                printf('<h3 %s>%s</h3>',$this->get_render_attribute_string('title_deal'), $settings['title_deal']); 
            endif; ?>
            
        </div>
        <ul class="products deal <?php echo esc_attr($class) ?>">
            <?php 
            $wc_attr2 = array(
                'post_type' => 'product',
                'posts_per_page' => 1,
                'post__in' => array($settings['deal_id']),
            );
            $deal_query = new WP_Query($wc_attr2);
            add_action('zoo_after_shop_loop_item_title','zoo_sold_bar', 15);
            remove_action('zoo_before_shop_loop_item_title', 'zoo_loop_sale_countdown', 10);
            add_action('zoo_after_shop_loop_item', 'zoo_loop_sale_countdown', 50);
            while ($deal_query->have_posts()) : $deal_query->the_post(); ?>
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
        <?php wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>
</div>
<?php
wp_reset_postdata();
?>