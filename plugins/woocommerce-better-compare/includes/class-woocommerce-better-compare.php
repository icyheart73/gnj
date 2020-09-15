<?php


class WooCommerce_Better_Compare {


	protected $loader;


	protected $plugin_name;


	protected $version;



	public function __construct($version) {

		$this->plugin_name = 'woocommerce-better-compare';
		$this->version = $version;

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}


	private function load_dependencies() {


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-better-compare-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-better-compare-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-better-compare-public.php';


		$this->loader = new WooCommerce_Better_Compare_Loader();

	}

	private function define_admin_hooks() {

		$this->plugin_admin = new WooCommerce_Better_Compare_Admin();

		$this->loader->add_action('init', $this->plugin_admin, 'init', 1);
		$this->loader->add_action('plugins_loaded', $this->plugin_admin, 'load_extensions');
		$this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles', 999);
		$this->loader->add_action('widgets_init', $this->plugin_admin, 'register_widgets');
	}

	private function define_public_hooks() {

		$this->plugin_public = new WooCommerce_Better_Compare_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts');

		$this->loader->add_action( 'init', $this->plugin_public, 'init', 10 );
		$this->loader->add_action( 'init', $this->plugin_public, 'single_product_page', 25 );
		$this->loader->add_action( 'template_redirect', $this->plugin_public, 'maybe_show_compare_button_on_single_product', 25 );
		$this->loader->add_action( 'wp_footer', $this->plugin_public, 'compare_bar', 10 );

		add_shortcode( 'woocommerce_better_compare', array($this->plugin_public, 'compare_products_shortcode'));
		add_shortcode( 'woocommerce_better_compare_button', array($this->plugin_public, 'compare_button_shortcode'));
		add_shortcode( 'woocommerce_better_compare_autocomplete', array($this->plugin_public, 'autocomplete_shortcode'));

		// AJAX
        $this->loader->add_action('wp_ajax_nopriv_compare_products_get_single', $this->plugin_public, 'get_single_product');
        $this->loader->add_action('wp_ajax_compare_products_get_single', $this->plugin_public, 'get_single_product');

        $this->loader->add_action('wp_ajax_nopriv_compare_products_get_all', $this->plugin_public, 'get_all_products');
        $this->loader->add_action('wp_ajax_compare_products_get_all', $this->plugin_public, 'get_all_products');

		$this->loader->add_action('wp_ajax_nopriv_compare_check_product', $this->plugin_public, 'check_product');
        $this->loader->add_action('wp_ajax_compare_check_product', $this->plugin_public, 'check_product');

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

    protected function get_option($option)
    {
        if (!is_array($this->options)) {
            return false;
        }

        if (!array_key_exists($option, $this->options)) {
            return false;
        }

        return $this->options[$option];
    }
}
