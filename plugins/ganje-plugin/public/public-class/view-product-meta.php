<?php
class Ganje_Product_Meta {
    private static $instance = null;
    public $settings = array();

    public function __construct() {

        add_action('woocommerce_before_single_product' , array($this , 'get_meta_settings'));
        add_action('woocommerce_before_single_product' , array($this , 'load_action'));
    }
    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Ganje_Product_Meta();
        }
        return self::$instance;
    }

    public function load_action()
    {
        if($this->settings['type_video'])
            add_action( 'woocommerce_product_thumbnails', array($this , 'product_intro_video'), 10 );
        if($this->settings['product_catalog'])
            add_action( 'woocommerce_product_thumbnails', array($this , 'product_catalog'), 10 );
        if($this->settings['product_alert'])
            add_action( 'woocommerce_after_add_to_cart_form', array($this , 'product_alert'), 10 );
    }

    public function get_meta_settings(){
        global $post;
        $this->settings['type_video']= get_post_meta($post->ID, 'type_video',true);
        $this->settings['direct_link_url'] = get_post_meta($post->ID, 'direct_link_url',true);
        $this->settings['aparat_embed'] = get_post_meta($post->ID, 'aparat_embed',true);
        $this->settings['direct_link_title'] = get_post_meta($post->ID, 'direct_link_title',true);
        $this->settings['product_catalog'] = get_post_meta($post->ID, 'product_catalog',true);
        $this->settings['product_alert'] = get_post_meta($post->ID, 'product_alert',true);
        $this->settings['attention_text'] = get_post_meta($post->ID, 'attention_text',true);
    }

    public function product_intro_video()
    {

        var_dump(is_product());
       var_dump( $this->settings);



            if($this->settings['type_video']=='direct_link'){?>
                <div>
                    <p><?=$this->settings['direct_link_title']?></p>
                <video width="320" height="240" controls>
                    <source src="<?=$this->settings['direct_link_url'];?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                </div>
<?php

            }
        else {
            echo $this->settings['aparat_embed'];
        }

    }

    public function product_catalog()
    {?>
            <a href="<?=$this->settings['product_catalog'] ?> " >کاتالوگ</a>

    <?php  }

    public function product_alert()
    { ?>
        <div class="woocommerce-<?=$this->settings['product_alert']; ?>" role="alert"><?= $this->settings['attention_text']; ?></div>
<?php
    }
}
Ganje_Product_Meta::getInstance();
