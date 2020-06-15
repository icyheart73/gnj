<?php
/**
 * Файл обработки данных на фронте
 *
 * @see     https://wpruse.ru/my-plugins/art-woocommerce-order-one-click/
 * @package art-woocommerce-order-one-click/includes
 * @version 1.8.0
 */

/**
 * Class Ganje_Front_End
 *
 * @author Artem Abramovich
 * @since  1.8.0
 */
class Ganje_Front_End {

    /**
     * Constructor.
     *
     * @since 1.8.0
     */
    public function __construct() {
        /**
         * WooCommerce hooks
         */
        add_filter( 'woocommerce_is_purchasable', array( $this, 'disable_add_to_cart_no_price' ), 10, 2 );
        add_filter( 'woocommerce_product_is_in_stock', array( $this, 'disable_add_to_cart_out_stock' ), 10, 2 );
        add_filter( 'woocommerce_hide_invisible_variations', array( $this, 'hide_variable_add_to_cart' ), 10, 3 );
        add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_custom_button' ), 15 );

    }


    public function disable_add_to_cart_no_price( $bool, $product ) {

        if ( 'variation' === $product->get_type() ) {
            return $bool;
        }

        if ( 'yes' === $product->get_meta( '_Ganje_button', true ) ) {
            return $bool;
        }

        return $bool;
    }



    public function disable_add_to_cart_out_stock( $status, $product ) {

        if ( 'variation' === $product->get_type() ) {
            return $status;
        }

        if ( 'yes' === $product->get_meta( '_Ganje_button', true ) ) {
            return $status;
        }

        return $status;
    }


    public function hide_variable_add_to_cart( $bool, $product_id, $variation ) {

        $product = wc_get_product( $product_id );

        if ( 'yes' === $product->get_meta( '_Ganje_button', true ) ) {
            return $bool;
        }

        return $bool;

    }


    public function add_custom_button() {

        $product = wc_get_product();

        $visible_button = $product->get_meta( '_Ganje_button', true );

        if ( ! isset( $visible_button ) || 'yes' !== $visible_button || true ) {

            ob_start();

            ?>
            <a id="ganje-custom-order-button" data-value-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                سفارش تلفنی
            </a>

            <?php

            echo ob_get_clean();//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

    }
}
