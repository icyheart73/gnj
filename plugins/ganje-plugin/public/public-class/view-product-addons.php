<?php

class Ganje_Product_Addons {

    private static $instance = null;
    private $setting;

    public function __construct() {
        $this->get_Settings();
        if($this->setting['product_count'])
            add_action('woocommerce_product_meta_end', array($this, 'view_product_info'));

        if (isset($this->setting['related_product']) && $this->setting['related_product']=='on') {




                add_filter( 'woocommerce_output_related_products_args',array($this,'bbloomer_change_number_related_products'), 9999 );

                if (isset($this->setting['related_option']['0'])) {

                    add_filter('woocommerce_product_related_posts_relate_by_category', '__return_true', PHP_INT_MAX);
                } else {

                    add_filter('woocommerce_product_related_posts_relate_by_category', '__return_false', PHP_INT_MAX);
                }

                if (isset($this->setting['related_option']['1'])) {

                    add_filter('woocommerce_product_related_posts_relate_by_tag', '__return_true', PHP_INT_MAX);
                } else {

                    add_filter('woocommerce_product_related_posts_relate_by_tag', '__return_false', PHP_INT_MAX);
                }

        if(isset($this->setting['share_product']) && $this->setting['share_product']=='on')
        {
            add_action( 'woocommerce_after_add_to_cart_form', array($this , 'show_share_product'), 10 );
        }


           // var_dump($this->setting);
        }else
        {
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
        }
        if(isset($this->setting['product_instock']) && $this->setting['product_instock']=='on')
        add_filter( 'woocommerce_related_products', array($this,'instock_filter_related_products'), 10, 1 );
    }

    public function get_Settings(){
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }


    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Ganje_Product_Addons();
        }
        return self::$instance;
    }

    function instock_filter_related_products( $related_product_ids ) {

        foreach( $related_product_ids as $key => $value ) {
            $relatedProduct = wc_get_product( $value );
            if( ! $relatedProduct->is_in_stock() ) {
                unset( $related_product_ids["$key"] );
            }
        }

        return $related_product_ids;
    }

    public function view_product_info()
    {
        global $post;
        $count = get_post_meta($post->ID,'total_sales', true);
        $text = sprintf( ' بیش از %s نفر از خریداران این محصول را پیشنهاد داده‌اند', $count);
        ?>
        <div>
            <p><?= $text; ?></p>
        </div>

    <?php
    }


     public function bbloomer_change_number_related_products( $args ) {


            $args['posts_per_page'] = intval($this->setting['related_product_count']);
         return $args;

        }

    public function show_share_product()
    {

    }




}
Ganje_Product_Addons::getInstance();
