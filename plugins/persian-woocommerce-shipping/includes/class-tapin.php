<?php
/**
 * Developer : MahdiY
 * Web Site  : MahdiY.IR
 * E-Mail    : M@hdiY.IR
 */

class PWS_Tapin extends PWS_Core {

	protected static $gateway = 'tapin';

	protected static $gateways = [
		'tapin'      => 'tapin.ir',
		'posteketab' => 'posteketab.com'
	];

	/**
	 * Ensures only one instance of PWS_Tapin is loaded or can be loaded.
	 *
	 * @return PWS_Tapin
	 * @see PWS()
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {

		self::$methods = [
			'WC_Courier_Method',
			'WC_Tipax_Method',
			'Tapin_Sefareshi_Method',
			'Tapin_Pishtaz_Method',
		];

		add_filter( 'wooi_ticket_header_path', function() {
			return PWS_DIR . '/assets/template/header.php';
		}, 100 );
		add_filter( 'wooi_ticket_body_path', function() {
			return PWS_DIR . '/assets/template/body.php';
		}, 100 );
		add_filter( 'wooi_ticket_footer_path', function() {
			return PWS_DIR . '/assets/template/footer.php';
		}, 100 );
		add_filter( 'wooi_ticket_per_page', function() {
			return 10000;
		}, 100 );

		add_action( 'admin_footer', [ $this, 'admin_footer' ] );

		parent::init_hooks();
	}

	public function state_city_admin_menu() {
		// Hide menu
	}

	public function enqueue_select2_scripts() {
		if ( ! is_checkout() ) {
			return false;
		}

		wp_register_script( 'selectWoo', WC()->plugin_url() . '/assets/js/selectWoo/selectWoo.full.min.js', [ 'jquery' ], '4.0.3' );
		wp_enqueue_script( 'selectWoo' );
		wp_register_style( 'select2', WC()->plugin_url() . '/assets/css/select2.css' );
		wp_enqueue_style( 'select2' );

		wp_register_script( 'pwsCheckout', PWS_URL . 'assets/js/pws-tapin.js', [ 'selectWoo' ], '1.0.0' );
		wp_localize_script( 'pwsCheckout', 'pws_settings', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'types'    => $this->types()
		] );
		wp_enqueue_script( 'pwsCheckout' );
	}

	public function checkout_update_order_meta( $order_id ) {

		$types  = $this->types();
		$fields = [ 'state', 'city' ];

		foreach ( $types as $type ) {

			foreach ( $fields as $field ) {

				$term_id = get_post_meta( $order_id, "_{$type}_{$field}", true );
				$term    = self::{'get_' . $field}( intval( $term_id ) );

				if ( ! is_null( $term ) ) {
					update_post_meta( $order_id, "_{$type}_{$field}", $term );
					update_post_meta( $order_id, "_{$type}_{$field}_id", $term_id );
				}

			}
		}

		if ( wc_ship_to_billing_address_only() ) {

			foreach ( $fields as $field ) {

				$label = get_post_meta( $order_id, "_billing_{$field}", true );
				$id    = get_post_meta( $order_id, "_billing_{$field}_id", true );

				update_post_meta( $order_id, "_shipping_{$field}", $label );
				update_post_meta( $order_id, "_shipping_{$field}_id", $id );

			}

		}

		/** @var WC_Order $order */
		$order = wc_get_order( $order_id );

		foreach ( $order->get_shipping_methods() as $shipping_item ) {

			if ( in_array( $shipping_item->get_method_id(), [ 'Tapin_Pishtaz_Method', 'Tapin_Sefareshi_Method' ] ) ) {

				$instance_id = $shipping_item->get_instance_id();

				$data = get_option( "woocommerce_{$shipping_item->get_method_id()}_{$instance_id}_settings" );

				$packaging_cost = intval( $data['extra_cost'] ?? 0 );

				if ( $shipping_item->get_total() && $packaging_cost ) {
					update_post_meta( $order_id, 'packaging_cost', $packaging_cost );
				}
			}
		}
	}

	public function checkout_process() {

		$types = $this->types();

		$fields = array(
			'state' => 'استان',
			'city'  => 'شهر',
		);

		$type_label = [
			'billing'  => 'صورتحساب',
			'shipping' => 'حمل و نقل'
		];

		if ( ! isset( $_POST['ship_to_different_address'] ) && count( $types ) == 2 ) {
			unset( $types[1] );
		}

		foreach ( $types as $type ) {

			$label = $type_label[ $type ];

			foreach ( $fields as $field => $name ) {

				$key = $type . '_' . $field;

				if ( isset( $_POST[ $key ] ) && strlen( $_POST[ $key ] ) ) {

					$value = intval( $_POST[ $key ] );

					if ( $value == 0 ) {
						$message = sprintf( 'لطفا <b>%s %s</b> خود را انتخاب نمایید.', $name, $label );
						wc_add_notice( $message, 'error' );

						continue;
					}

					$invalid = is_null( self::{'get_' . $field}( $value ) );

					if ( $invalid ) {
						$message = sprintf( '<b>%s %s</b> انتخاب شده معتبر نمی باشد.', $name, $label );
						wc_add_notice( $message, 'error' );

						continue;
					}

					if ( $field == 'state' ) {

						$pkey = $type . '_city';

						$cities = self::cities( $value );

						if ( isset( $_POST[ $pkey ] ) && ! empty( $_POST[ $pkey ] ) && ! isset( $cities[ $_POST[ $pkey ] ] ) ) {
							$message = sprintf( '<b>استان</b> با <b>شهر</b> %s انتخاب شده همخوانی ندارند.', $label );
							wc_add_notice( $message, 'error' );

							continue;
						}
					}

				}

			}

		}
	}

	public function localisation_address_formats( $formats ) {

		$formats['IR'] = "{company}\n{first_name} {last_name}\n{country}\n{state}\n{city}\n{address_1}\n{address_2}\n{postcode}";

		return $formats;
	}

	public function formatted_address_replacements( $replace, $args ) {

		$replace = parent::formatted_address_replacements( $replace, $args );

		if ( ctype_digit( $args['city'] ) ) {
			$city              = $this->get_city( $args['city'] );
			$replace['{city}'] = is_null( $city ) ? $args['city'] : $city;
		}

		return $replace;
	}

	public function admin_footer() {

		if ( ! isset( $_GET['page'], $_GET['tab'], $_GET['instance_id'] ) || $_GET['tab'] != 'shipping' ) {
			return false;
		}

		?>
        <script type="text/javascript">
			let courier = jQuery("#woocommerce_WC_Courier_Method_destination");

			if( courier.length ) {
				courier.select2();
			}

			let tipax = jQuery("#woocommerce_WC_Tipax_Method_destination");

			if( tipax.length ) {
				tipax.select2();
			}
        </script>
		<?php
	}

	public static function is_enable() {
		return self::get_option( 'tapin.enable', false ) == 1;
	}

	public static function request( $path, $data = [], $absolute_url = null ) {

		$path = trim( $path, ' / ' );

		$url = sprintf( 'https://api.%s/api/%s/', self::$gateways[ self::$gateway ], $path );

		if ( ! is_null( $absolute_url ) ) {
			$url = $absolute_url;
		}

		$curl = curl_init();

		curl_setopt_array( $curl, [
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => json_encode( $data ),
			CURLOPT_HTTPHEADER     => [
				"Content-type: application/json",
				"Accept: application/json",
				"Authorization: " . PWS()->get_option( 'tapin.token' )
			],
		] );

		$response = curl_exec( $curl );

		if ( $response === false ) {

			$error = curl_error( $curl );

			PWS()->log( __METHOD__ . ' Line: ' . __LINE__ );
			PWS()->log( $url );
			PWS()->log( $data );
			PWS()->log( $error );

			curl_close( $curl );

			return new WP_Error( '', $error );
		}

		curl_close( $curl );

		return json_decode( $response );
	}

	public static function zone() {

		$zone = get_transient( 'pws_tapin_zone' );

		if ( $zone === false || count( (array) $zone ) == 0 ) {

			$response = wp_remote_get( 'https://public.api.tapin.ir/api/v1/public/state/tree/' );

			if ( is_wp_error( $response ) ) {
				$zone = get_option( 'pws_tapin_zone', null );

				if ( is_null( $zone ) ) {
					$zone = file_get_contents( PWS_DIR . '/data/tapin.json' );
				}

			} else {
				$data = $response['body'];

				$data = json_decode( $data, true )['entries'];

				$zone = [];

				foreach ( $data as $state ) {

					$zone[ $state['code'] ] = [
						'title'  => trim( $state['title'] ),
						'cities' => []
					];

					foreach ( $state['cities'] as $city ) {
						$title = trim( str_replace( '-' . $state['title'], '', $city['title'] ) );

						$zone[ $state['code'] ]['cities'][ $city['code'] ] = $title;
					}

				}

				set_transient( 'pws_tapin_zone', $zone, WEEK_IN_SECONDS );
				update_option( 'pws_tapin_zone', $zone );
			}
		}

		return $zone;
	}

	public static function states() {

		$states = get_transient( 'pws_tapin_states' );

		if ( $states === false || count( (array) $states ) == 0 ) {

			$zone = self::zone();

			$states = [];

			foreach ( $zone as $code => $state ) {
				$states[ $code ] = trim( $state['title'] );
			}

			uasort( $states, [ self::class, 'pws_sort_state' ] );

			set_transient( 'pws_tapin_states', $states, DAY_IN_SECONDS );
		}

		return $states;
	}

	public static function cities( $state_id = null ) {

		$cities = get_transient( 'pws_tapin_cities_' . $state_id );

		if ( $cities === false || count( (array) $cities ) == 0 ) {

			$zone = self::zone();

			if ( is_null( $state_id ) ) {

				$state_cities = array_column( self::zone(), 'cities' );

				$cities = [];

				foreach ( $state_cities as $state_city ) {
					$cities += $state_city;
				}

			} else if ( isset( $zone[ $state_id ]['cities'] ) ) {
				$cities = $zone[ $state_id ]['cities'];

				asort( $cities );
			} else {
				return [];
			}

			set_transient( 'pws_tapin_cities_' . $state_id, $cities, DAY_IN_SECONDS );
		}

		return $cities;
	}

	public static function get_city( $city_id ) {

		$cities = self::cities();

		return $cities[ $city_id ] ?? null;
	}

	public static function shop() {

		$shop = get_transient( 'pws_tapin_shop' );

		if ( $shop === false || count( (array) $shop ) == 0 ) {

			$shop = self::request( 'v2/public/shop/detail', [
				'shop_id' => PWS()->get_option( 'tapin.shop_id' )
			] );

			if ( is_wp_error( $shop ) ) {
				return get_option( 'pws_tapin_shop' );
			} else {
				$shop = $shop->entries;
			}

			set_transient( 'pws_tapin_shop', $shop, DAY_IN_SECONDS );
			update_option( 'pws_tapin_shop', $shop );
		}

		return $shop;
	}

	public static function price( $data ) {

		$url = 'https://public.api.tapin.ir/api/v1/public/check-price/';

		$data['rate_type'] = self::$gateway;

		return self::request( '', $data, $url );
	}

	public static function get_cart_weight() {

		$weight = floatval( PWS()->get_option( 'tapin.package_weight', 500 ) );

		foreach ( WC()->cart->get_cart() as $cart_item ) {

			if ( $cart_item['data']->is_virtual() ) {
				continue;
			}

			if ( $cart_item['data']->has_weight() ) {
				$weight += wc_get_weight( $cart_item['data']->get_weight() * $cart_item['quantity'], 'g' );
			} else {
				$weight += floatval( PWS()->get_option( 'tapin.product_weight', 500 ) ) * $cart_item['quantity'];
			}
		}

		return $weight;
	}

	public static function set_gateway( string $gateway ) {

		if ( in_array( $gateway, array_keys( self::$gateways ) ) ) {
			self::$gateway = $gateway;
		}

	}

}