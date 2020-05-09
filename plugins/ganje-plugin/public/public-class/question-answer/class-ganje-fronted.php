<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'Ganje_fronted' ) ) {

    /**
     *
     * @class   YITH_YWQA_Frontend
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     */
    class Ganje_fronted {

        /**
         * Single instance of the class
         *
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @since 1.0.0
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor
         *
         * Initialize plugin and registers actions and filters to be used
         *
         * @since  1.0
         * @author Lorenzo Giuffrida
         */
        protected function __construct() {

            $this->init_hooks();

        }

        public function init_hooks() {
            add_action( 'wp_ajax_show_question_list', array($this, 'show_questions_callback') );

            add_action( 'wp_ajax_nopriv_show_question_list', array($this, 'show_questions_callback',) );

            add_action( 'gnj_questions_and_answers_content', array($this, 'show_questions') );
        }


        public function show_questions_callback() {
            if ( isset( $_POST['product_id'] ) ) {
                $product_id = intval( $_POST['product_id'] );
            } else {
                global $product;
                $product_id = $product->get_id();
            }

            ob_start();
            $this->show_question_list($product_id);

            $content = ob_get_contents();
            ob_end_clean();

            wp_send_json( array(
                "code"  => 1,
                "items" => $content,
            ) );
        }

        public function show_questions() {

            global $product;
            $product_id = $product->get_id();

            $this->show_question_list( $product_id );
        }

        /**
         * Show a list of question related to a specific product
         */
        public function show_question_list( $product_id ) {

            wc_get_template( 'gnj-product-questions.php',
                array(
                    'max_items'     => -1,
                    'only_answered' => false,
                    'product_id'    => $product_id,
                ),
                '', GNJ_PATH.'/public/partials/' );
        }
    }
}

Ganje_fronted::get_instance();
