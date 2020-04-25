<?php

class Ganje_Wc_Persian {
	public function __construct() {

		add_filter( 'override_unload_textdomain', array( $this, 'unload_textdomain' ), 9999 , 2 );
		add_filter( 'load_textdomain_mofile', array( $this, 'load_textdomain' ), 10, 2 );

	}

	public function unload_textdomain( $override, $domain ) {
		return get_locale() == 'fa_IR' && $domain === 'woocommerce' ? true : $override;
	}

	public function load_textdomain( $mo_file, $domain ) {
		if ( get_locale() == 'fa_IR' && $domain === 'woocommerce' ) {
			$mo_file = GNJ_PATH . '/languages/woocommerce-fa_IR.mo';
		}

		return $mo_file;
	}
}
new Ganje_Wc_Persian();
