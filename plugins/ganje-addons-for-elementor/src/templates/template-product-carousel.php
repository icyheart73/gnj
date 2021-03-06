<?php

$product_ids = '';
if ($settings['product_ids'] && is_array($settings['product_ids'])) {
    $product_ids = $settings['product_ids'];
}

if (is_front_page()) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
$meta_query = WC()->query->get_meta_query();
$wc_attr = array(
    'post_type' => 'product',
    'product_cat' => $settings['filter_categories'] != '' ? implode(',', $settings['filter_categories']) : '',
    'posts_per_page' => $settings['posts_per_page'],
    'paged' => $paged,
    'orderby' => $settings['orderby'],
    'order' => $settings['order'],
    'post__not_in' => $product_ids,
);
switch ($settings['asset_type']) {
    case 'featured':
        $meta_query[] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
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
        $wc_attr['orderby'] = 'meta_value_num';
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

$settings['autoplay'] ? $settings['autoplay'] : $settings['autoplay'] = 'false';
$settings['autoplay_tablet'] ? $settings['autoplay_tablet'] : $settings['autoplay_tablet'] = 'false';
$settings['autoplay_mobile'] ? $settings['autoplay_mobile'] : $settings['autoplay_mobile'] = 'false';


$settings['speed'] ? $settings['speed'] : $settings['speed'] = 3000;

$product_query = new WP_Query($settings['wc_attr']);



?>
<section class="gnje-product-slider">

    <div class="gnje-widget-header">
        <div class="gnje-widget-title">
            <?php if (isset($settings['title']) && $settings['title'] != '') :
                echo '<h2>'.$settings['title'].'</h2><a>( نمایش بیشتر )</a><p>'.$settings['title-desc'].'</p>';
            endif; ?>
        </div>
        <!-- Add Arrows -->
        <div class="gnje-widget-arrow">
            <?php
            if ($settings['show_nav']) { ?>
                <div class="swiper-gnj-prev"><i class="fal fa-arrow-right"></i></i></div>
                <div class="swiper-gnj-next"><i class="fal fa-arrow-left"></i></div>
            <?php } ?>
        </div>
    </div>

    <!-- Swiper -->

    <div class="swiper-container product-slider"
         data-row="<?php echo $settings['slides_to_show_row']['size']; ?>"
         data-rowmobile="<?php echo $settings['slides_to_show_row_mobile']['size']; ?>"
         data-column="<?php echo $settings['slides_to_show_columns']['size']; ?>"
         data-columnmobile="<?php echo $settings['slides_to_show_columns_mobile']['size']; ?>"
         data-autoplay="<?php echo $settings['autoplay']; ?>">
        <div class="swiper-wrapper" itemscope itemtype="http://schema.org/ItemList">
            <?php
            while ($product_query->have_posts()) : $product_query->the_post(); ?>
            <div <?php wc_product_class('swiper-slide'); ?>>
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_product_link_open - 10
                 */
                do_action('woocommerce_before_shop_loop_item');

                /**
                 * Hook: woocommerce_before_shop_loop_item_title.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action('woocommerce_before_shop_loop_item_title');

                /**
                 * Hook: woocommerce_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_product_title - 10
                 */
                do_action('woocommerce_shop_loop_item_title');

                /**
                 * Hook: woocommerce_after_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action('woocommerce_after_shop_loop_item_title');

                /**
                 * Hook: woocommerce_after_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_product_link_close - 5
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action('woocommerce_after_shop_loop_item');
                ?>
                </div><?php endwhile;
            ?>

        </div>

        <!-- Add Pagination -->
        <?php if ($settings['show_pag']) {
            echo '<div class="swiper-pagination"></div></div>';

        }
        ?>
    </div>
</section>
<?php


$this->admin_editor_js = "<script>(function ($) {
    $('.product-slider').each(function() {

        // Configuration
        var row_count = $(this).data('row');
        var row_countMobile = $(this).data('rowmobile');
        var column_count = $(this).data('column');
        var column_countMobile = $(this).data('columnmobile');
        var slider_autoplay = $(this).data('autoplay');
        var brkpnt = {640 : {slidesPerView: column_countMobile, spaceBetween: 20, slidesPerColumn : row_countMobile}};

        var conf_slider 	= {};
        conf_slider.slidesPerView = column_count;
        conf_slider.slidesPerColumn = row_count;
        conf_slider.spaceBetween = 30;
        conf_slider.pagination = {el: '.swiper-pagination',clickable: true,};
        conf_slider.navigation = {nextEl: '.swiper-gnj-next', prevEl: '.swiper-gnj-prev',};
        conf_slider.breakpoints = brkpnt;
        console.log(conf_slider);
        if(slider_autoplay)
           conf_slider.autoplay = { delay : 5000 , disableOnInteraction : false};
         //Initialize
        var slider = new Swiper( this , conf_slider);
    });
})(jQuery);</script>";

if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
    add_action('elementor/frontend/after_enqueue_scripts', $this->editor_js());
}
wp_reset_postdata();
?>
