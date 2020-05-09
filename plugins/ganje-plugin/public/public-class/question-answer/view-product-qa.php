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


        add_filter( 'manage_ganje_qa_posts_columns', array( $this, 'gnj_filter_posts_columns') );
        add_action( 'manage_ganje_qa_posts_custom_column', array( $this, 'gnj_realestate_column'), 10, 2 );


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



    public function gnj_realestate_column( $column, $post_id ) {

        $discussion = $this->get_discussion( $post_id );
        if ( null == $discussion ) {
            return;
        }

        switch ( $column ) {
            case 'qora' :

                $discussion = $this->get_discussion( $post_id );
                if ( $discussion instanceof YWQA_Question ) {
                    echo '<span class="question">سوال</span>';
                } else {
                    if ( $discussion instanceof YWQA_Answer ) {
                        echo '<span class="answer">جواب</span>';
                    }
                }
                break;

            case 'actions' :
                if ( strcmp( $discussion->product_id, '0' ) != 0 ) {
                    $product = wc_get_product( $discussion->product_id );
                } else {
                    $product = '';
                }

                if ( ! $product ) {
                    echo 'محصولی پیدا نشد.';

                    return;
                }

                $product_title     = $product->get_title();
                $product_edit_link = get_permalink( $discussion->product_id );

                echo sprintf( '<span class="for-product">%s</span><a class="view-product" target="_blank" href="%s" title="%s">%s</a>',
                    'نام محصول : ',
                    $product_edit_link,
                    $product_title,
                    $product_title );

                if ( $discussion instanceof YWQA_Answer ) {
                    $question       = $discussion->get_question();
                    $question_title = wc_trim_string(wp_strip_all_tags($question->content));


                    $question_edit_link = get_edit_post_link( $question->ID );

                    echo " <br>" . sprintf( '<span class="response-to">%s</span><a class="response-to" href="%s" title="%s">%s</a>',
                            'در جواب به سوال : ',
                            $question_edit_link,
                            $question_title,
                            $question_title );
                }
                break;

            default:
        }

    }



    public function gnj_filter_posts_columns( $columns ) {
        $columns = array(
            'cb' => $columns['cb'],
            'qora' => '',
            'title' => 'عنوان',
            'actions' => '',
        );
        return $columns;
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
        $result         = $answer->save();
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

    public function get_questions_count( $product_id, $only_answered = false ) {
        global $wpdb;

        $answered_query = '';
        if ( $only_answered ) {
            $answered_query = " and que.ID in (select distinct(post_parent) from {$wpdb->prefix}posts where post_status = 'publish') ";
        }

        $query = $wpdb->prepare( "select count(que.ID)
				from {$wpdb->prefix}posts as que left join {$wpdb->prefix}posts as pro
				on que.post_parent = pro.ID
				where que.post_status = 'publish'
				and que.post_type = %s
				and pro.post_type = 'product'
				and pro.ID = %d" . $answered_query,
            'ganje_qa',
            $product_id
        );

        $items = $wpdb->get_row( $query, ARRAY_N );

        return $items[0];
    }

    /**
     * Show questions by product
     *
     * @param int    $product_id
     * @param string $items
     * @param int    $page
     * @param bool   $only_answered
     *
     * @return int
     * @author Lorenzo Giuffrida
     * @since  1.0.0
     */
    public function show_questions( $product_id ) {

        $questions = $this->get_questions( $product_id );

        foreach ( $questions as $question ) {
            $this->show_question( $question );
        }

        return count( $questions );
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
    public function get_questions( $product_id ) {
        global $wpdb;

        $query = $wpdb->prepare( "select ID
				from {$wpdb->posts}
				where post_status = 'publish' and
				      post_type = %s and
				      post_parent = %d " . " order by post_date DESC ",
            'ganje_qa',
            $product_id
        );

        $post_ids = $wpdb->get_results( $query, ARRAY_A );

        $questions = array();

        foreach ( $post_ids as $item ) {
            $questions[] = new Gnj_Question( $item["ID"] );
        }

        return $questions;
    }

    /**
     * Call the question template file and show the content
     *
     * @param $question question to be shown
     */
    public function show_question( $question, $classes = '' ) {

        wc_get_template ( 'gnj-single-question.php', array(
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

            update_post_meta ( $post_id, '_gnj_product_id', $_POST["select_product"] );
            update_post_meta ( $post_id, '_gnj_type', "question" );
        }
    }

    // Add the Events Meta Boxes
    public function add_plugin_metabox() {
        add_meta_box ( 'gnj_metabox', 'پرسش و پاسخ ها', array( $this, 'display_plugin_metabox' ), 'ganje_qa', 'normal', 'default' );
    }

    public function display_plugin_metabox() {
        //  Display different metabox content when it's a new question or answer
        if ( isset( $_GET["post"] ) ) {
            $discussion = $this->get_discussion ( $_GET["post"] );

            if ( $discussion instanceof YWQA_Question ) {
                ?>
                <div id="question-content-div">
                    <label>نام محصول : </label>
                    <a target="_blank"
                       href="<?php echo get_permalink ( $discussion->product_id ); ?>"><?php echo wc_get_product ( $discussion->product_id )->get_title (); ?></a>
                    <input type="hidden" id="product_id" name="product_id"
                           value="<?php echo $discussion->product_id ?>">
                    <input type="hidden" id="discussion_type" name="discussion_type" value="edit-question">
                    <textarea id="respond-to-question" name="respond-to-question" placeholder="پاسخ خود را وارد کنید ..."
                              rows="5"></textarea>
                    <input id="submit-answer" class="button button-primary button-large" type="submit"
                           value="ارسال پاسخ">
                </div>
                <?php

            } else if ( $discussion instanceof YWQA_Answer ) {
                $question = $discussion->get_question ();
                ?>
                <input type="hidden" id="discussion_type" name="discussion_type" value="edit-answer">
                <fieldset>
                    <label><?php _e ( "Product: ", 'yith-woocommerce-questions-and-answers' ); ?></label>
                    <a target="_blank"
                       href="<?php echo get_permalink ( $discussion->product_id ); ?>"><?php echo wc_get_product ( $discussion->product_id )->get_title (); ?></a>
                </fieldset>
                <fieldset>
                    <label><?php _e ( "Question: ", 'yith-woocommerce-questions-and-answers' ); ?></label>
                    <span><?php echo $question->content; ?></span>
                </fieldset>
                <?php
            }
        } else {
            //  it's a new question, let it choose the product to be related to
            global $wpdb;

            $products = $wpdb->get_results ( "select ID, post_title
				from {$wpdb->prefix}posts
				where post_type = 'product'
				order by post_title" );

            ?>
            <input type="hidden" id="discussion_type" name="discussion_type" value="new-question">
            <table class="form-table">
                <tbody>
                <tr valign="top" class="titledesc">
                    <th scope="row">
                        <label for="product"><?php _e ( 'Select product', 'yith-woocommerce-questions-and-answers' ); ?></label>
                    </th>
                    <td class="forminp yith-choosen">

                        <select id="select_product" name="select_product" class="chosen-select"
                                style="width: 80%" placeholder="Select product">
                            <option value="-1"></option>
                            <?php

                            foreach ( $products as $product ) {
                                ?>
                                <option
                                    value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>

            <?php
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

        $discussion_type = get_post_meta ( $post_id, '_gnj_type', true );

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
        global $product;

        wc_get_template( 'gnj-base.php',
            array(
                'max_items'     => -1 ,
                'only_answered' => 0 ,
                'product_id'    => $product_id = $product->get_id(),
            ),
            '', GNJ_PATH.'/public/partials/' );
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
            'name'               => 'پرسش و پاسخ',
            'singular_name'      => 'پرسش',
            'menu_name'          => 'پرسش و پاسخ',
            'parent_item_colon'  => __ ( 'Parent discussion', 'yith-woocommerce-questions-and-answers' ),
            'all_items'          => 'همه پرسش و پاسخ ها',
            'view_item'          => 'نمایش پرسش و پاسخ ها',
            'add_new_item'       => 'افزودن پرسش جدید',
            'add_new'            => 'افزودن جدید',
            'edit_item'          => 'ویرایش',
            'update_item'        => 'بروزرسانی',
            'search_items'       => 'جستجو',
            'not_found'          => 'چیزی پیدا نشد',
            'not_found_in_trash' => 'چیزی پیدا نشد',
        );

        // Set other options for Custom Post Type

        $args = array(
            'label'               => 'پرسش و پاسخ',
            'description'         => 'پرسش و پاسخ های محصولات',
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

        if ( ! isset( $_POST["gnj_product_id"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["gnj_ask_question_text"] ) || empty( $_POST["gnj_ask_question_text"] ) ) {
            return false;
        }

        if (! isset( $_POST['ask_question'] ) || ! wp_verify_nonce ( $_POST['ask_question'], 'ask_question_' . $_POST["gnj_product_id"] )) {

            echo 'متاسفانه در ثبت سوال مشکلی بوجود آمده است. لطفا مجدد امتحان کنید.';
            exit;
        }

        $product_id = intval ( $_POST['gnj_product_id'] );
        if ( ! $product_id ) {
            echo 'متاسفانه در ثبت سوال مشکلی بوجود آمده است. لطفا مجدد امتحان کنید.';
            exit;
        }

        $args = array(
            'content'    => sanitize_text_field ( $_POST["gnj_ask_question_text"] ),
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
        $question->save();
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

        if ( ! isset( $_POST["gnj_product_id"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["gnj_question_id"] ) ) {
            return false;
        }

        if ( ! isset( $_POST["gnj_send_answer_text"] ) || empty( $_POST["gnj_send_answer_text"] ) ) {
            return false;
        }

        if (
            ! isset( $_POST['send_answer'] )
            || ! wp_verify_nonce ( $_POST['send_answer'], 'submit_answer_' . $_POST["gnj_question_id"] )
        ) {

            _e ( "Please retry submitting your question or answer.", 'yith-woocommerce-questions-and-answers' );
            exit;
        }

        $args = array(
            'content'    => sanitize_text_field ( $_POST["gnj_send_answer_text"] ),
            'author_id'  => get_current_user_id (),
            'product_id' => $_POST["gnj_product_id"],
            'parent_id'  => $_POST["gnj_question_id"]
        );

        $this->create_answer ( $args );
    }


}
Ganje_Product_QA::get_instance();
