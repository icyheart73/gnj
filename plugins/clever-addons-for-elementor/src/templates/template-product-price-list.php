<?php
/**
 * View template for Ganje Product List Price.
 *
 * @package CAFE\Templates
 * @copyright 2018 CleverSoft. All rights reserved.
 */
?>
<?php
$wc_attr    = array(
    'post_type'      => 'product',
    'product_cat'    => $settings['filter_categories'] != '' ? implode( ',', $settings['filter_categories'] ) : '',
    'posts_per_page' => -1,
    'orderby'        => $settings['orderby'],
    'order'          => $settings['order'],
    'post__not_in'   => $product_ids,
    'fields'        => 'ids',
);
switch ( $settings['asset_type'] ) {
    case 'featured':
        $meta_query[]         = array(
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
        $wc_attr['orderby']  = 'meta_value_num';
        $wc_attr['meta_key'] = '_wc_average_rating';
        $wc_attr['order']    = 'DESC';
        break;
    case 'deal':
        $product_ids_on_sale   = wc_get_product_ids_on_sale();
        $wc_attr['post__in']   = $product_ids_on_sale;
        $wc_attr['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key'     => '_sale_price_dates_to',
                'value'   => time(),
                'compare' => '>'
            )
        );
        break;
    default:
        break;
}

$product_query = new WP_Query( $wc_attr );
$ID_array = $product_query->posts;
?>
<div class="tcw_table_price"  style="max-height:<?php echo $settings['max_height_size'].'px' ? : 'auto' ?>; overflow: auto;">
    <?php echo '<div class="order-title"><h2>'.$settings['title'].'</h2></div>'; ?>
    <table class="wp-list-table widefat striped table-bordered">
        <thead>
        <tr>
            <th class="th-product-index">#</th>
            <th class="th-product-thumb">تصویر</th>
            <th class="th-product-title">نام محصول</th>
            <th class="th-product-old-price"><?= sprintf( 'قیمت قبل (%s)', get_woocommerce_currency_symbol() ) ?></th>
            <th class="th-product-new-price"><?= sprintf( 'قیمت جدید (%s)', get_woocommerce_currency_symbol() ) ?></th>
            <th class="th-product-price-change"><?= sprintf( 'تغییر قیمت (%s)', get_woocommerce_currency_symbol() ) ?></th>
            <th class="th-product-status">تغییرات</th>
        </tr>
        </thead>
        <tbody>
        <?php if ( !empty( $ID_array ) && is_array( $ID_array ) ): ?>
            <?php foreach ( $ID_array as $index => $id ): ?>
                <?php $data = $this->get_product( $id ); ?>
                <?php if ( is_wp_error( $data ) || !is_array( $data ) ) continue; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="no-items">
                <td colspan="7">محصولی پیدا نشد.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
wp_reset_postdata();
?>
