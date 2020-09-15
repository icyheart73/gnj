<?php


class WooCommerce_Group_Attributes_Public {


	private $plugin_name;


	private $version;


	private $options;


	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	public function enqueue_styles() {

		global $woocommerce_group_attributes_options;

		$this->options = $woocommerce_group_attributes_options;

		wp_enqueue_style( $this->plugin_name.'-public', plugin_dir_url( __FILE__ ) . 'css/woocommerce-group-attributes-public.css', array('woocommerce-general'), $this->version, 'all' );

		$css = ".shop_attributes tr, .shop_attributes tr td { 
					background-color: " . $woocommerce_group_attributes_options['oddBackgroundColor'] . " !important;
					color: " . $woocommerce_group_attributes_options['oddTextColor'] . " !important;
				} 
				.shop_attributes tr.alt, .shop_attributes tr.alt td { 
					background-color: " . $woocommerce_group_attributes_options['evenBackgroundColor'] . " !important;
					color: " . $woocommerce_group_attributes_options['evenTextColor'] . " !important;
				}
				";

		$customCSS = $this->get_option('customCSS');
		if(!empty($customCSS))
		{
			$css = $css . $customCSS;
		}

		file_put_contents( __DIR__  . '/css/woocommerce-group-attributes-custom.css', $css);

		wp_enqueue_style( $this->plugin_name.'-custom', plugin_dir_url( __FILE__ ) . 'css/woocommerce-group-attributes-custom.css', array('woocommerce-general'), $this->version, 'all' );

	}


	public function enqueue_scripts() {

		global $woocommerce_group_attributes_options;

		$this->options = $woocommerce_group_attributes_options;

		$customJS = $this->get_option('customJS');
		if(empty($customJS))
		{
			return false;
		}

		file_put_contents( __DIR__  . '/js/woocommerce-group-attributes-custom.js', $customJS);

		wp_enqueue_script( $this->plugin_name.'-custom', plugin_dir_url( __FILE__ ) . 'js/woocommerce-group-attributes-custom.js', array( 'jquery' ), $this->version, false );

	}


    private function get_option($option)
    {
    	if(!is_array($this->options)) {
    		return false;
    	}
    	if(!array_key_exists($option, $this->options))
    	{
    		return false;
    	}
    	return $this->options[$option];
    }


    public function init()
    {

		global $woocommerce_group_attributes_options;

		$this->options = $woocommerce_group_attributes_options;

		if (!$this->get_option('enable'))
		{
			return false;
		}

		add_filter( 'wc_get_template', array($this, 'modify_attribute_template'), 10, 5 );

    }

	public function modify_attribute_template( $located, $template_name)
	{
		global $post;

		if( 'single-product/product-attributes.php' === $template_name){
			$layout = $this->get_option('layout');

			$layout = apply_filters('woocommerce_group_attributes_layout', $layout, $post->ID);

			return  __DIR__  . '/partials/woocommerce-group-attributes-output-layout-' . $layout . '.php';
		}

		return $located;
	}

}
