<?php
class Ganje_Single_Product_Free_Price{

    private static $instance = null;
    private $setting;

    function __construct() {

        $this->get_Settings();
        add_filter( 'woocommerce_get_price_html', array($this,'free_price_custom_label') , 999, 2);
        add_filter( 'woocommerce_variable_price_html', array($this,'free_variation_price_custom_label'), 20, 2 );
        add_filter( 'woocommerce_cart_item_subtotal', array($this,'free_cart_item_price_custom_label'), 20, 3 );
        add_filter( 'woocommerce_cart_item_price', array($this,'free_cart_item_price_custom_label'), 20, 3 );
        add_filter( 'woocommerce_order_formatted_line_subtotal', array($this,'free_order_item_price_custom_label'), 20, 3 );
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Ganje_Single_Product_Free_Price();
        }
        return self::$instance;
    }

    public function free_price_custom_label( $price, $product ) {
        if ( is_shop() || is_product_category() || is_product_tag() || is_product() ) {
            // HERE your custom free price label
            $free_label = '<span class="amount">' . $this->setting['free_price_text'] . '</span>';

            if( $product->is_type('variable') )
            {
                $price_min  = wc_get_price_to_display( $product, array( 'price' => $product->get_variation_price('min') ) );
                $price_max  = wc_get_price_to_display( $product, array( 'price' => $product->get_variation_price('max') ) );


                if( $price_min != $price_max ){
                    if( $price_min == 0 && $price_max > 0 )
                        $price = wc_price( $price_max );
                    elseif( $price_min > 0 && $price_max == 0 )
                        $price = wc_price( $price_min );
                    else
                        $price = wc_format_price_range( $price_min, $price_max );
                } else {
                    if( $price_min > 0 )
                        $price = wc_price( $price_min);
                    else
                        $price = $free_label;
                }
            }
            elseif( $product->is_on_sale() )
            {
                $regular_price = wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) );
                $sale_price = wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) );
                if( $sale_price > 0 )
                    $price = wc_format_sale_price( $regular_price, $sale_price );
                else
                    $price = $free_label;
            }
            else
            {
                $active_price = wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) );
                if( $active_price > 0 )
                    $price = wc_price($active_price);
                else
                    $price = $free_label;
            }
        }
        return $price;
    }

    public function free_variation_price_custom_label( $price, $product ) {
        // HERE your custom free price label
        $free_label = '<span class="amount">' . $this->setting['free_price_text']. '</span>';

        if( $product->is_on_sale() )
        {
            $regular_price = wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) );
            $sale_price = wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) );
            if( $sale_price > 0 )
                $price = wc_format_sale_price( $regular_price, $sale_price );
            else
                $price = $free_label;
        }
        else
        {
            $active_price = wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) );
            if( $active_price > 0 )
                $price = wc_price($active_price);
            else
                $price = $free_label;
        }
        return $price;
    }


    public function free_cart_item_price_custom_label( $price, $cart_item, $cart_item_key ) {
        // HERE your custom free price label
        $free_label = '<span class="amount">' .$this->setting['free_price_text']. '</span>';

        if( $cart_item['data']->get_price() > 0 )
            return $price;
        else
            return $free_label;
    }

    public function free_order_item_price_custom_label( $subtotal, $item, $order ) {
        // HERE your custom free price label
        $free_label = '<span class="amount">' . $this->setting['free_price_text'] . '</span>';

        if( $order->get_line_subtotal( $item ) > 0 )
            return $subtotal;
        else
            return $free_label;
    }

    public function get_Settings(){

        $this->setting = get_option( 'option_tree' );
    }

}
Ganje_Single_Product_Free_Price::getInstance();
