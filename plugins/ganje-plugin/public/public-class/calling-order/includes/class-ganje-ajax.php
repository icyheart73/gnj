<?php

/**
 * Class GANJE_Ajax
 * @since  1.8.0
 */
class GANJE_Ajax {


    public function __construct() {

        add_action( 'wp_ajax_nopriv_ganje_ajax_product_form', array( $this, 'ajax_scripts_callback' ) );
        add_action( 'wp_ajax_ganje_ajax_product_form', array( $this, 'ajax_scripts_callback' ) );

        add_action( 'wp_ajax_nopriv_ganje_palce_calling_order', array( $this, 'ganje_ajax_palce_calling_order' ) );
        add_action( 'wp_ajax_ganje_palce_calling_order', array( $this, 'ganje_ajax_palce_calling_order' ) );
    }



    public function ajax_scripts_callback() {

        if ( false === defined( 'WP_CACHE' ) ) {
            check_ajax_referer( 'ganje-nonce', 'nonce' );
        }

        $product = wc_get_product( sanitize_text_field( wp_unslash( $_POST['id'] ) ) );
        if(!$product) {
            echo 'یک متغیر را انتخاب کنید';
            wp_die();
        }
        include GNJ_PATH . '/public/public-class/calling-order/includes/view/html-popup-window.php';


        echo $output;
        wp_die();
    }


    public function ganje_ajax_palce_calling_order()
    {
        global $woocommerce;

        $address = array(
            'first_name' => 'call',
            'last_name'  => 'call',
            'company'    => 'call',
            'email'      => 'call@testing.com',
            'phone'      => '760-555-1212',
            'address_1'  => '123 Main st.',
            'address_2'  => '104',
            'city'       => 'esfahan',
            'state'      => 'Ca',
            'postcode'   => '92121',
            'country'    => 'IR'
        );

        // Now we create the order
        $order = wc_create_order();

        // The add_product() function below is located in /plugins/woocommerce/includes/abstracts/abstract_wc_order.php
        $order->add_product( get_product($_POST['product_id']), $_POST['qty']); // This is an existing SIMPLE product
        $order->set_address( $address, 'billing' );
        //
        $order->calculate_totals();
        $order->update_status("Pending", 'Imported order', TRUE);

    }



    public function product_title( $product ) {

        return $product->get_title();
    }



    public function product_image( $product ) {

        $image = '';

        $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );

        if ( ! $post_thumbnail_id ) {
            $post_thumbnail_id = get_post_thumbnail_id( $product->get_parent_id() );
        }

        $full_size_image = wp_get_attachment_image_src( $post_thumbnail_id, apply_filters( 'ganje_thumbnail_name', 'shop_single' ) );

        if ( $full_size_image ) {
            $image =
                sprintf(
                    '<img src="%s" alt="%s" class="%s" width="%s" height="%s">',
                    esc_url( $full_size_image[0] ),
                    apply_filters( 'ganje_popup_image_alt', '' ),
                    apply_filters( 'ganje_popup_image_classes', esc_attr( 'ganje-form-custom-order-img' ) ),
                    esc_attr( $full_size_image[1] ),
                    esc_attr( $full_size_image[2] )
                );
        }

        return $image;
    }



    public function product_id( $product ) {

        if ( 'simple' === $product->get_type() ) {
            $product_id = $product->get_id();
        } else {
            $product_id = $product->get_parent_id();
        }

        return $product_id;
    }



    public function product_sku( $product ) {

        if ( ! wc_product_sku_enabled() && ( ! $product->get_sku() || ! $product->is_type( 'variable' ) ) ) {
            return false;
        }

        return $product->get_sku() ? $product->get_sku() : __( 'N/A', 'woocommerce' );
    }




    public function product_attr( $product ) {

        if ( $product->is_type( 'simple' ) ) {
            return false;
        }

        $attributes       = $product->get_attributes();
        $product_variable = new WC_Product_Variable( $product->get_parent_id() );
        $variations       = $product_variable->get_variation_attributes();
        $attr_name        = array();

        foreach ( $attributes as $attr => $value ) {

            $attr_label = wc_attribute_label( $attr );
            $meta       = get_post_meta( $product->get_id(), wc_variation_attribute_name( $attr ), true );
            $term       = get_term_by( 'slug', $meta, $attr );

            if ( false !== $term ) {
                $attr_name[] = $attr_label . ': ' . $term->name;
            }
        }

        if ( empty( $attr_name ) && isset( $variations ) ) {
            foreach ( $variations as $key => $item ) {

                $attr_name[] = wc_attribute_label( $key ) . ' &mdash; ' . implode( array_intersect( $item, $attributes ) );
            }
        }

        $allowed_html = array(
            'br'   => array(),
            'span' => array(),
        );

        $product_var_attr = wp_kses( implode( '; </span><span>', $attr_name ), $allowed_html );

        if ( ! isset( $variations ) ) {
            return false;
        }

        return $product_var_attr;

    }



    public function the_product_attr( $product ) {

        return sprintf(
            '%s</br><span class="ganje-attr-wrapper"><span>%s</span></span>',
            apply_filters( 'ganje_popup_attr_label', esc_html__( 'Attributes: ', 'art-woocommerce-order-one-click' ) ),
            $this->product_attr( $product )
        );
    }


    public function product_price( $product ) {

        if ( ! $product->get_price() ) {
            return false;
        }

        return apply_filters(
            'ganje_popup_price_html',
            sprintf(
                '%s<span class="ganje-price-wrapper">%s</span></div>',
                apply_filters( 'ganje_popup_price_label', __( 'Price: ', 'art-woocommerce-order-one-click' ) ),
                wc_price( $product->get_price() )
            ),
            $product
        );

    }



    public function select_form() {

        $form = 'select_form';
        return $form;
    }



    public function the_product_cat( $product ) {

        return wc_get_product_category_list(
            $this->product_id( $product ),
            ', ',
            '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'art-woocommerce-order-one-click' ) . ' ',
            '</span>'
        );

    }



    public function product_cat( $product ) {

        $term  = '';
        $terms = get_the_terms( $this->product_id( $product ), 'product_cat' );

        if ( false === $terms ) {
            return false;
        }

        if ( $terms ) {
            $term = array_shift( $terms );
        }

        return $term->name;
    }



    public function product_link( $product ) {

        return sprintf(
            '<span class="ganje-form-custom-order-link ganje-hide">Ссылка на товар: %s</span>',
            esc_url( get_permalink( $this->product_id( $product ) ) )
        );

    }



    public function the_product_sku( $product ) {

        return wp_kses_post(
            apply_filters(
                'ganje_popup_sku_html',
                sprintf(
                    '<span class="ganje-sku-wrapper">%s</span><span class="ganje-sku">%s</span>',
                    apply_filters( 'ganje_popup_sku_label', __( 'SKU: ', 'art-woocommerce-order-one-click' ) ),
                    $this->product_sku( $product )
                ),
                $product
            )
        );
    }

}
new GANJE_Ajax;
