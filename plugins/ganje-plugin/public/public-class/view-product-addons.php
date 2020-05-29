<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

class Ganje_Product_Addons {

    private static $instance = null;
    private $setting;

    public function __construct()
    {
        $this->get_Settings();

        if ($this->setting['product_count'])
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
            $args['meta_key'] = '_stock_status';

           /* $args['meta_query']['key'] = '_stock_status';
            $args['meta_query']['value'] = 'instock';
            $args['meta_query']['compare'] = 'NOT IN';*/
         //   echo 'stock';

            return $args;


        }

    public function show_share_product()
    {

    }




}
Ganje_Product_Addons::getInstance();
