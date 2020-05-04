<?php
class Ganje_PB_Wc_Persian {

    private $setting;
    public $currencies;

    public function __construct() {

        $this->get_Settings();
        $this->currencies = array(
            'IRR'  => __( 'ریال', 'woocommerce' ),
            'IRHR' => __( 'هزار ریال', 'woocommerce' ),
            'IRT'  => __( 'تومان', 'woocommerce' ),
            'IRHT' => __( 'هزار تومان', 'woocommerce' )
        );

        add_filter( 'woocommerce_currencies', array( $this, 'currencies' ) );
        add_filter( 'woocommerce_currency_symbol', array( $this, 'currencies_symbol' ), 10, 2 );

        if ( $this->setting['empty_price'] == 'on' ) {
            add_filter( 'woocommerce_empty_price_html', array( $this, 'on_empty_price' ), 999 );
        }

        if ( $this->setting['persian_price'] == 'on' ) {
            add_filter( 'wc_price', array( $this, 'persian_number' ) );
            add_filter( 'woocommerce_get_price_html', array( $this, 'persian_number' ) );

            add_filter( 'woocommerce_cart_item_price', array( $this, 'persian_number' ) );
            add_filter( 'woocommerce_cart_item_subtotal', array( $this, 'persian_number' ) );
            add_filter( 'woocommerce_cart_subtotal', array( $this, 'persian_number' ) );
            add_filter( 'woocommerce_cart_totals_coupon_html', array( $this, 'persian_number' ) );
            add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'persian_number' ) );
            add_filter( 'woocommerce_cart_total', array( $this, 'persian_number' ) );
        }

    }

    public function get_Settings(){
        $this->setting = get_option( 'option_tree' );
    }

    public function persian_number( $price ) {
        return  str_replace( range( 0, 9 ), array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ), $price );
    }

    public function on_empty_price( $price ) {

        return $this->setting['empty_price_text'];

    }
    public function currencies( $currencies ) {

        foreach ( $this->currencies as $key => $value ) {
            unset( $currencies[ $key ] );
        }

        return array_merge( $currencies, $this->currencies );
    }

    public function currencies_symbol( $currency_symbol, $currency ) {

        if ( in_array( $currency, array_keys( $this->currencies ) ) ) {
            return $this->currencies[ $currency ];
        }

        return $currency_symbol;
    }
}
new Ganje_PB_Wc_Persian();
