<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access forbidden.' );
}

if ( ! class_exists( 'Gnj_Question' ) ) {
	class Gnj_Question extends Ganje_Discussion {

		/**
		 * Initialize a question object
		 *
		 * @param int|array $args the question id or an array for initializing the object
		 */
		public function __construct( $args = null ) {
			parent::__construct( $args );

			$this->type = "question";
		}

		public function has_answers() {
			global $wpdb;

			$query = $wpdb->prepare( "select count(ID)
				from {$wpdb->prefix}posts
				where post_status = 'publish' and post_type = %s and post_parent = %s", 'ganje_qa',
				$this->ID
			);

			$items = $wpdb->get_row( $query, ARRAY_N );

			return $items[0];
		}

        public function get_answers_count() {
            global $wpdb;

            $query = $wpdb->prepare( "select count(ID)
				from {$wpdb->prefix}posts
				where post_status = 'publish' and post_type = %s and post_parent = %s",
                'ganje_qa',
                $this->ID
            );

            $items = $wpdb->get_row( $query, ARRAY_N );

            return $items[0];
        }

		public function get_answers( $count = - 1 ) {

			$query_limit = '';
			if ( $count > 0 ) {
				$query_limit = "limit 0," . $count;
			}

			global $wpdb;

			$query = $wpdb->prepare( "select ID, post_author, post_date, post_content, post_title, post_parent
				from {$wpdb->prefix}posts
				where post_status = 'publish' and post_type = %s and post_parent = %s order by post_date DESC " . $query_limit,
				'ganje_qa',
				$this->ID
			);

			$items = $wpdb->get_results( $query, ARRAY_A );

			$answers = array();

			foreach ( $items as $item ) {
				$params = array(
                    "content" => $item["post_content"],
					"author_id"  => $item["post_author"],
					"product_id" => get_post_meta( $item["ID"], '_gnj_product_id', true ),
					"ID"         => $item["ID"],
					"parent_id"  => $item["post_parent"],
					"date"       => $item["post_date"]
				);

				$answers[] = new Ganje_Answer( $params );
			}

			return $answers;
		}
	}
}
