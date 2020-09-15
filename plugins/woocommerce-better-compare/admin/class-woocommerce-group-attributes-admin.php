<?php


class WooCommerce_Group_Attributes_Admin {


	private $plugin_name;

	private $version;


	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function load_redux(){
	    // Load the theme/plugin options
	    if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/options-init.php' ) ) {
	        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/options-init.php';
	    }
	}


    public function enqueue_styles()
    {
        $screen = get_current_screen();
        if ( $screen->post_type != 'attribute_group' ) {
            return;
        }
        wp_enqueue_style($this->plugin_name.'-select2', plugin_dir_url(__FILE__).'css/select2.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name.'-select2-sortable', plugin_dir_url(__FILE__).'css/select2.sortable.css', array(), $this->version, 'all');
    }


    public function enqueue_scripts()
    {
    	wp_enqueue_media();
        wp_enqueue_script($this->plugin_name.'-admin', plugin_dir_url(__FILE__).'js/woocommerce-group-attributes-admin.js', array('jquery'), $this->version, true);

        $screen = get_current_screen();
        if ( $screen->post_type != 'attribute_group' ) {
            return;
        }
        wp_enqueue_script($this->plugin_name.'-select2', plugin_dir_url(__FILE__).'js/select2.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'-select2-sortable', plugin_dir_url(__FILE__).'js/select2.sortable.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'-html5-sortable', plugin_dir_url(__FILE__).'js/html.sortable.min.js', array('jquery'), $this->version, true);
    }


    public function add_admin_js_vars()
    {
    ?>
    <script type='text/javascript'>
        var woocommerce_group_attribute_settings = <?php echo json_encode(array(
            'ajax_url' => admin_url('admin-ajax.php')
        )); ?>
    </script>
    <?php
    }
}
