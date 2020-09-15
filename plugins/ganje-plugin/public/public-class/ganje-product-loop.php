<?php

class Ganje_Product_Loop
{
    private static $instance = null;
    private $setting;

    public function __construct()
    {
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        add_action('woocommerce_before_shop_loop_item_title',array($this,'ganje_template_loop_product_thumbnail'),12,1);
    }

    public function get_Settings()
    {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Ganje_Product_Loop();
        }
        return self::$instance;
    }

    public function ganje_template_loop_product_thumbnail($size = 'woocommerce_thumbnail')
    {
        global $product;
        $attachment_ids = $product->get_gallery_image_ids();
        $image_link = wp_get_attachment_image($attachment_ids[0] , $size = 'woocommerce_thumbnail', "",array( "class" => "gnj-second-image" ));
        echo '<div class="image_section">'.$product->get_image( 'woocommerce_thumbnail' ).$image_link.'</div>';
    }
}
Ganje_Product_Loop::getInstance();
