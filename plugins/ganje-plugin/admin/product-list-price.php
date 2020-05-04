<?php

use CleverAddonsForElementor\Widgets\GanjeProductListPrice;

class Ganjge_product_list_price{

    public function __construct() {

        add_action( 'woocommerce_product_options_pricing', [ $this, 'woocommerce_product_options_pricing' ] );
        add_action( 'woocommerce_process_product_meta', [ $this, 'woocommerce_process_product_meta' ] );
        add_action( 'woocommerce_variation_options_pricing', [ $this, 'woocommerce_variation_options_pricing' ], 10, 3 );
        add_action( 'woocommerce_save_product_variation', [ $this, 'woocommerce_save_product_variation' ], 10, 2 );
    }

    public function woocommerce_product_options_pricing() {

        // Field: Old Price
        $label = 'قیمت قبلی';
        woocommerce_wp_text_input( array(
            'id'        => '_tcw_old_price',
            'label'     => $label,
            'data_type' => 'price',
        ) );
    }

    public function woocommerce_process_product_meta( $post_id ) {
        // Field: Old Price
        $old_price = wc_clean( $_POST['_tcw_old_price'] );
        $this->set_old_price( $post_id, $old_price );
    }

    public function woocommerce_variation_options_pricing( $loop, $variation_data, $variation ) {

        // Field: Old Price
        $label =  'قیمت قبلی';
        woocommerce_wp_text_input( array(
            'id'            => "variable_tcw_old_price_{$loop}",
            'name'          => "variable_tcw_old_price[{$loop}]",
            'label'         => $label,
            'data_type'     => 'price',
            'wrapper_class' => 'form-row form-row-first',
            'placeholder'   => __( 'Variation Old price', '' ),
            'value'         => get_post_meta( $variation->ID, '_tcw_old_price', true ),
        ) );
    }

    public function woocommerce_save_product_variation( $variation_id, $i ) {
        // Field: Old Price
        $old_price = wc_clean( $_POST['variable_tcw_old_price'][$i] );
        $this->set_old_price( $variation_id, $old_price );
    }

    public function set_old_price( $product_id, $value ) {
        $product = wc_get_product( $product_id );
        $product->update_meta_data( '_tcw_old_price', $value );
        $product->save();
    }


}

new Ganjge_product_list_price();
