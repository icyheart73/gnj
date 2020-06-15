<?php

/**
 * Class Ganje_Admin_Meta_Box
 *
 * @author Artem Abramovich
 * @since  2.3.0
 */
class Ganje_Admin_Meta_Box {


	public function __construct() {

        add_filter( 'product_type_options', array( $this, 'meta_box' ), 10, 1 );
        add_action( 'woocommerce_process_product_meta_simple', array( $this, 'save_meta_box' ), 10, 1 );
        add_action( 'woocommerce_process_product_meta_variable', array( $this, 'save_meta_box' ), 10, 1 );
	}



	public static function meta_box( $options ) {

		$new_option['Ganje_button'] = array(
			'id'            => '_Ganje_button',
			'wrapper_class' => 'show_if_simple show_if_variable',
			'label'         => __( 'Disable Order One Click Button', 'art-woocommerce-order-one-click' ),
			'description'   => __(
				'If enabled, then on this product the Order button will not be visible. Product will return to its original condition.',
				'art-woocommerce-order-one-click'
			),
			'default'       => 'no',
		);

		return array_slice( $options, 0, 0 ) + $new_option + $options;
	}


	/**
	 * Сохраняем данные
	 *
	 * @param int $post_id ID продукта.
	 *
	 * @since 2.3.0
	 */
	public static function save_meta_box( $post_id ) {

		$product = wc_get_product( $post_id );

		// @codingStandardsIgnoreStart
		$button = isset( $_POST['_Ganje_button'] ) ? 'yes' : 'no';
		// @codingStandardsIgnoreEnd

		$product->update_meta_data( '_Ganje_button', $button );

		$product->save();

	}

}

new Ganje_Admin_Meta_Box;
