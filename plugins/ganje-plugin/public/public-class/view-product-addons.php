<?php

class Ganje_Product_Addons {

    private static $instance = null;
    private $setting;

    public function __construct() {
        $this->get_Settings();
        var_dump($this->setting);
        if($this->setting['product_count']) {
            add_action('woocommerce_product_meta_end', array($this, 'view_product_info'));
            echo 'const';
        }
    }

    public function get_Settings(){
        $this->setting = get_option( 'option_tree' );
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
        echo $post->ID;
        $count = get_post_meta($post->ID,'total_sales', true);
        $text = sprintf( ' بیش از %s نفر از خریداران این محصول را پیشنهاد داده‌اند', $count);
        ?>
        <div>
            <p><?= $text; ?></p>
        </div>

    <?php
    }



}
Ganje_Product_Addons::getInstance();
