<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access forbidden.' );
}

if ( ! class_exists( 'Ganje_Answer' ) ) {
	class Ganje_Answer extends Ganje_Discussion {

		/**
		 * Initialize a question object
		 *
		 * @param int|array $args the question id or an array for initializing the object
		 */
		public function __construct( $args = null ) {
			parent::__construct( $args );

			$this->type = "answer";

		}

		/**
		 * Retrieve the question
		 *
		 * @return null
		 */
		public function get_question() {
			if ( ! isset( $this->parent_id ) ) {

				return null;
			}

			return new Gnj_Question( $this->parent_id );
		}
	}
}
