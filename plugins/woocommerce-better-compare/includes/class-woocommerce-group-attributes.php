<?php


class WooCommerce_Group_Attributes {


	protected $loader;


	protected $plugin_name;


	protected $version;


	public function __construct($version) {

		$this->plugin_name = 'woocommerce-group-attributes';
		$this->version = $version;

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}


	private function load_dependencies() {


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-group-attributes-loader.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-group-attributes-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-group-attributes-post-type.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-group-attributes-public.php';

		$this->loader = new WooCommerce_Group_Attributes_Loader();

	}



	private function define_admin_hooks() {

		$this->plugin_admin = new WooCommerce_Group_Attributes_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugins_loaded', $this->plugin_admin, 'load_redux' );

		$this->loader->add_action('admin_head', $this->plugin_admin, 'add_admin_js_vars', 10);
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles', 999);
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts', 999);

		$this->group_attributes_post_type = new WooCommerce_Group_Attributes_Post_Type();
		$this->loader->add_action( 'init', $this->group_attributes_post_type, 'init' );
		$this->loader->add_filter( 'manage_attribute_group_posts_columns', $this->group_attributes_post_type, 'columns_head');
		$this->loader->add_action( 'manage_attribute_group_posts_custom_column', $this->group_attributes_post_type, 'columns_content', 10, 1);

		$this->loader->add_action( 'woocommerce_product_options_attributes', $this->group_attributes_post_type, 'show_attribute_group_toolbar');
		$this->loader->add_action( 'wp_ajax_get_attributes_by_attribute_group_id', $this->group_attributes_post_type, 'get_attributes_by_attribute_group_id');

		$this->loader->add_action( 'pre_get_posts', $this->group_attributes_post_type, 'attribute_group_order', 10 );
        $this->loader->add_action( 'add_meta_boxes', $this->group_attributes_post_type, 'add_custom_metaboxes', 10, 2);
        $this->loader->add_action( 'save_post', $this->group_attributes_post_type, 'save_custom_metaboxes', 1, 2);

	}


	private function define_public_hooks() {

		$this->plugin_public = new WooCommerce_Group_Attributes_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'woocommerce_init', $this->plugin_public, 'init' );
	}


	public function run() {
		$this->loader->run();
	}


	public function get_plugin_name() {
		return $this->plugin_name;
	}


	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
