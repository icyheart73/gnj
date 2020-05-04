<?php
class Ganje_Product_QA{
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
        if ( is_null ( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct() {

        add_filter ( 'woocommerce_product_tabs', array( $this, 'show_question_answer_tab' ), 20 );

        add_action ( 'init', array( $this, 'on_plugin_init' ) );

        // Add to admin_init function
        add_filter ( 'manage_edit-question_answer_columns', array( $this, 'add_custom_columns_title' ) );

        // Add to admin_init function
        add_action ( 'manage_question_answer_posts_custom_column', array(
            $this,
            'add_custom_columns_content'
        ), 10, 2 );

        /**
         * Add metabox to question and answer post type
         */
        add_action ( 'add_meta_boxes', array( $this, 'add_plugin_metabox' ) );

        /**
         * Save data from question and answer post type metabox
         */
        add_action ( 'save_post', array( $this, 'save_plugin_metabox' ), 1, 2 );
        add_filter ( 'wp_insert_post_data', array( $this, 'before_insert_discussion' ), 99, 2 );

        add_action ( 'wp_ajax_submit_answer', array( $this, 'submit_answer_callback' ) );

        add_action ( 'admin_head-post-new.php', array( $this, 'limit_products_creation' ) );
        add_action ( 'admin_head-edit.php', array( $this, 'limit_products_creation' ) );
        add_action ( 'admin_menu', array( $this, 'remove_add_product_link' ) );
        /*
			 * Avoid "View Post" link when a Q&A custom post type is saved
			 */
        add_filter ( 'post_updated_messages', array( $this, 'avoid_view_post_link' ) );



    }
    /**
     * Add custom columns to custom post type table
     *
     * @param $defaults current columns
     *
     * @return array new columns
     */
    public function add_custom_columns_title( $defaults ) {

        $columns = array_slice ( $defaults, 0, 1 );

        $columns["image_type"] = '';

        return apply_filters ( 'yith_questions_answers_custom_column_title', array_merge ( $columns, array_slice ( $defaults, 1 ) ) );
    }

    public function submit_answer_callback() {

        $args = array(
            "content"    => $_POST["answer_content"],
            "author_id"  => get_current_user_id (),
            "product_id" => $_POST["product_id"],
            "parent_id"  => $_POST["question_id"]
        );

        $answer         = new YWQA_Answer( $args );
        $answer->status = "publish";
        $result         = $answer->save ();
        if ( ! $result ) {
            wp_send_json ( array(
                "code" => - 1
            ) );
        }

        wp_send_json ( array(
            "code" => 1
        ) );
    }

    public function limit_products_creation() {
        global $post_type;

        if ( 'ganje_qa' != $post_type ) {
            return;
        }
    }

    public function remove_add_product_link() {
        global $post_type;

        if ( 'ganje_qa' != $post_type ) {
            return;
        }

        echo '<style>.add-new-h2{ display: none; }</style>';
    }

    public function get_questions_count( $product_id ) {
        global $wpdb;

        $query = $wpdb->prepare ( "select count(que.ID)
				from {$wpdb->prefix}posts as que left join {$wpdb->prefix}posts as pro
				on que.post_parent = pro.ID
				where que.post_status = 'publish'
				and que.post_type = %s
				and pro.post_type = 'product'
				and pro.ID = %d",
            'ganje_qa',
            $product_id
        );

        $items = $wpdb->get_row ( $query, ARRAY_N );

        return $items[0];
    }

    /**
     * Show the reviews for a specific product
     *
     * @param $product_id product id for whose should be shown the reviews
     */
    public function show_questions( $product_id, $items = 'auto', $only_answered = false ) {

        $questions = $this->get_questions ( $product_id, $items, $only_answered );

        foreach ( $questions as $question ) {

            $this->show_question ( $question );
        }

        return count ( $questions );
    }

    /**
     * Show the reviews for a specific product
     *
     * @param $product_id product id for whose should be shown the reviews
     */
    public function show_answers( $question ) {

        foreach ( $question->get_answers () as $answer ) {

            $this->show_answer ( $answer );
        }
    }
    /**
     * Create new answer
     *
     * @param $args
     */
    public function create_answer( $args ) {
        $answer = new YWQA_Answer( $args );
        $answer = apply_filters ( "yith_questions_answers_before_new_answer", $answer );
        $answer->save ();
        do_action ( "yith_questions_answers_after_new_answer", $answer );

        return $answer;
    }

    /**
     * Call the question template file and show the content
     *
     * @param $question question to be shown
     */
    public function show_answer( $answer, $classes = '' ) {

        wc_get_template ( 'ywqa-answer-template.php', array(
            'answer'  => $answer,
            'classes' => $classes
        ), '', GNJ_PATH.'/public/partials/' );
    }

    /**
     * retrieve the number of questions for the product
     *
     * @param $product_id the product id requested
     */
    public function get_questions( $product_id, $items = 'auto', $only_answered = false ) {
        global $wpdb;

        if ( 'auto' === $items ) {
            $items = 0;
        }

        $query_limit = '';
        if ( $items > 0 ) {
            $query_limit = sprintf ( " limit 0,%d ", $items );
        }

        $order_by_query = " order by que.post_date DESC ";

        $answered_query = '';
        if ( $only_answered ) {
            $answered_query = " and que.ID in (select distinct(post_parent) from {$wpdb->prefix}posts) ";
        }

        $query = $wpdb->prepare ( "select que.ID
				from {$wpdb->prefix}posts as que left join {$wpdb->prefix}posts as pro
				on que.post_parent = pro.ID
				where que.post_status = 'publish'
				and que.post_type = %s
				and pro.post_type = 'product'
				and pro.ID = %d" . $answered_query . $order_by_query . $query_limit,
            'ganje_qa',
            $product_id
        );

        $post_ids = $wpdb->get_results ( $query, ARRAY_A );

        $questions = array();

        foreach ( $post_ids as $item ) {
            $questions[] = new YWQA_Question( $item["ID"] );
        }

        return $questions;
    }

    /**
     * Call the question template file and show the content
     *
     * @param $question question to be shown
     */
    public function show_question( $question, $classes = '' ) {

        wc_get_template ( 'ywqa-question-template.php', array(
            'question' => $question,
            'classes'  => $classes
        ), '', GNJ_PATH.'/public/partials/' );
    }

    /*
		 * Avoid "View Post" link when a Q&A custom post type is saved
		 */
    public function avoid_view_post_link( $messages ) {
        $messages['post'][1] = __ ( 'Content updated.', 'yith-woocommerce-questions-and-answers' );
        $messages['post'][4] = __ ( 'Content updated.', 'yith-woocommerce-questions-and-answers' );
        $messages['post'][6] = __ ( 'Content published.', 'yith-woocommerce-questions-and-answers' );
        $messages['post'][7] = __ ( 'Content saved.', 'yith-woocommerce-questions-and-answers' );
        $messages['post'][8] = __ ( 'Content submitted.', 'yith-woocommerce-questions-and-answers' );

        return $messages;
    }

    /**
     * Update the title for the custom post type, trimming the discussion content
     *
     * @param $data array current data being saved
     * @param $postarr
     *
     * @return mixed
     * @author Lorenzo Giuffrida
     * @since  1.0.0
     */
    function before_insert_discussion( $data, $postarr ) {
        if ( $data['post_type'] == 'ganje_qa' ) {

            if ( isset( $postarr["select_product"] ) ) {
                $data["post_parent"] = $postarr["select_product"];
            }

            /*
             * Update the title for the custom post type, trimming the discussion content
             */
            $data["post_title"] = wc_trim_string(wp_strip_all_tags($data["post_content"]), 50);
        }

        return $data;
    }

    /**
     * Save the Metabox Data
     *
     * @param $post_id
     * @param $post
     *
     * @return mixed
     */
    function save_plugin_metabox( $post_id, $post ) {

        if ( 'ganje_qa' != $post->post_type ) {
            return;
        }

        // verify this is not an auto save routine.
        if ( defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        /**
         * Update the discussion inserted
         */
        if ( isset( $_POST["select_product"] ) ) {

            update_post_meta ( $post_id, '_ywqa_product_id', $_POST["select_product"] );
            update_post_meta ( $post_id, '_ywqa_type', "question" );
        }
    }

    // Add the Events Meta Boxes
    function add_plugin_metabox() {
        add_meta_box ( 'ywqa_metabox', 'Questions & Answers', array(
            $this,
            'display_plugin_metabox'
        ), 'question_answer', 'normal', 'default' );
    }
    /**
     * show content for custom columns
     *
     * @param $column_name column shown
     * @param $post_ID     post to use
     */
    public function add_custom_columns_content( $column_name, $post_ID ) {

        switch ( $column_name ) {
            case 'image_type' :

                $discussion = $this->get_discussion ( $post_ID );
                if ( $discussion instanceof YWQA_Question ) {
                    echo '<span class="dashicons dashicons-admin-comments"></span>';
                } else if ( $discussion instanceof YWQA_Answer ) {
                    echo '<span class="dashicons dashicons-admin-page"></span>';
                }
                break;

            default:
                do_action ( "yith_questions_answers_custom_column_content", $column_name, $post_ID );
        }

    }
    /**
     * Retrieve the instance of the correct object based on the content type of
     * the post.
     *
     * @param $post_id
     *
     * @return null|YWQA_Answer|YWQA_Question
     */
    public function get_discussion( $post_id ) {

        $discussion_type = get_post_meta ( $post_id, '_ywqa_type', true );

        if ( "question" === $discussion_type ) {
            return new YWQA_Question( $post_id );
        } else if ( "answer" === $discussion_type ) {
            return new YWQA_Answer( $post_id );
        }

        return null;
    }
    /**
     * Add a tab for question & answer
     *
     * @param array $tabs tabs with description for product reviews
     *
     * @return mixed
     */
    public function show_question_answer_tab( $tabs ) {
        global $product;

        $tab_title = 'پرسش و پاسخ ';

        $product_id = $product->get_id();
        if ( isset($product_id) ) {
            $count = $this->get_questions_count ( $product_id);

            if ( $count ) {
                $tab_title .= sprintf ( " (%d)", $count );
            }
        }

        if ( ! isset( $tabs["questions"] ) ) {
            $tabs["questions"] = array(
                'title'    => $tab_title,
                'priority' => 99,
                'callback' => array( $this, 'show_question_answer_template' )
            );
        }

        return $tabs;
    }
    /**
     * Show the question or answer template file
     */
    public function show_question_answer_template() {

        wc_get_template ( 'ywqa-questions-template.php', array(
            'max_items'     => 10,
            'only_answered' => 1,
        ), '', GNJ_PATH.'/public/partials/' );

        if ( isset( $_GET["reply-to-question"] ) ) {
            $question = new YWQA_Question( $_GET["reply-to-question"] );
            wc_get_template ( 'ywqa-answers-template.php', array( 'question' => $question ), '', GNJ_PATH.'/public/partials/' );
        } else if ( isset( $_GET["show-all-questions"] ) ) {
            wc_get_template ( 'ywqa-questions-template.php', array(
                'max_items'     => - 1,
                'only_answered' => 0,
            ), '', GNJ_PATH.'/public/partials/' );
        } else {
            wc_get_template ( 'ywqa-questions-template.php', array(
                'max_items'     => 10,
                'only_answered' => 1,
            ), '', GNJ_PATH.'/public/partials/' );
        }
    }

    /**
     *  Execute all the operation need when the plugin init
     */
    public function on_plugin_init() {

        $this->init_post_type ();

        if ( $this->is_new_question () ) {
            return;
        }

        if ( $this->is_new_answer () ) {
            return;
        }
    }

    public function init_post_type() {

        // Set UI labels for Custom Post Type
        $labels = array(
            'name'               => _x ( 'Questions & Answers', 'Post Type General Name', 'yith-woocommerce-questions-and-answers' ),
            'singular_name'      => _x ( 'Question', 'Post Type Singular Name', 'yith-woocommerce-questions-and-answers' ),
            'menu_name'          => __ ( 'Questions & Answers', 'yith-woocommerce-questions-and-answers' ),
            'parent_item_colon'  => __ ( 'Parent discussion', 'yith-woocommerce-questions-and-answers' ),
            'all_items'          => __ ( 'All discussion', 'yith-woocommerce-questions-and-answers' ),
            'view_item'          => __ ( 'View discussions', 'yith-woocommerce-questions-and-answers' ),
            'add_new_item'       => __ ( 'Add new question', 'yith-woocommerce-questions-and-answers' ),
            'add_new'            => __ ( 'Add new', 'yith-woocommerce-questions-and-answers' ),
            'edit_item'          => __ ( 'Edit discussion', 'yith-woocommerce-questions-and-answers' ),
            'update_item'        => __ ( 'Update discussion', 'yith-woocommerce-questions-and-answers' ),
            'search_items'       => __ ( 'Search discussion', 'yith-woocommerce-questions-and-answers' ),
            'not_found'          => __ ( 'Not found', 'yith-woocommerce-questions-and-answers' ),
            'not_found_in_trash' => __ ( 'Not found in the bin', 'yith-woocommerce-questions-and-answers' ),
        );

        // Set other options for Custom Post Type

        $args = array(
            'label'               => __ ( 'Questions & Answers', 'yith-woocommerce-questions-and-answers' ),
            'description'         => __ ( 'YITH Questions and Answers', 'yith-woocommerce-questions-and-answers' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array(
                //'title',
                'editor',
                //'author',
            ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 9,
            'can_export'          => false,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'menu_icon'           => 'dashicons-clipboard',
            'query_var'           => false
        );

        // Registering your Custom Post Type
        register_post_type ( 'ganje_qa', $args );
    }

    /**
     * Check if there is a new question or answer from the user
     *
     * @return bool it's a new question
     */
    public function is_new_question() {

        if ( ! isset( $_POST["add_new_question"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["ywqa_product_id"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["ywqa_ask_question_text"] ) || empty( $_POST["ywqa_ask_question_text"] ) ) {
            return false;
        }

        if (
            ! isset( $_POST['ask_question'] )
            || ! wp_verify_nonce ( $_POST['ask_question'], 'ask_question_' . $_POST["ywqa_product_id"] )
        ) {

            _e ( "Please retry submitting your question or answer.", 'yith-woocommerce-questions-and-answers' );
            exit;
        }

        $product_id = intval ( $_POST['ywqa_product_id'] );
        if ( ! $product_id ) {
            _e ( "No product ID selected, the question will not be created.", 'yith-woocommerce-questions-and-answers' );
            exit;
        }

        $args = array(
            'content'    => sanitize_text_field ( $_POST["ywqa_ask_question_text"] ),
            'author_id'  => get_current_user_id (),
            'product_id' => $product_id,
            'parent_id'  => $product_id
        );

        $this->create_question ( $args );
    }
    /**
     * Create a new question
     *
     * @param $args array Parameters used to create the question
     *
     * @return mixed|void|YWQA_Question
     * @author Lorenzo Giuffrida
     * @since  1.0.0
     */
    public function create_question( $args ) {

        $question = new YWQA_Question( $args );
        $question = apply_filters ( "yith_questions_answers_before_new_question", $question );
        $question->save ();
        do_action ( "yith_questions_answers_after_new_question", $question );

        return $question;
    }

    /**
     * Check if there is a new answer
     *
     * @return bool it's a new answer
     */
    public function is_new_answer() {
        if ( ! isset( $_POST["add_new_answer"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["ywqa_product_id"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["ywqa_question_id"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["ywqa_send_answer_text"] ) || empty( $_POST["ywqa_send_answer_text"] ) ) {
            return false;
        }

        if (
            ! isset( $_POST['send_answer'] )
            || ! wp_verify_nonce ( $_POST['send_answer'], 'submit_answer_' . $_POST["ywqa_question_id"] )
        ) {

            _e ( "Please retry submitting your question or answer.", 'yith-woocommerce-questions-and-answers' );
            exit;
        }

        $args = array(
            'content'    => sanitize_text_field ( $_POST["ywqa_send_answer_text"] ),
            'author_id'  => get_current_user_id (),
            'product_id' => $_POST["ywqa_product_id"],
            'parent_id'  => $_POST["ywqa_question_id"]
        );

        $this->create_answer ( $args );
    }


}
Ganje_Product_QA::get_instance();
