<?php
/**
 * Single question Template for YITH WooCommerce Questions and Answers
 *
 * @author        Yithemes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! function_exists( "answer_now_link" ) ) {

    function answer_now_link( $question, $label, $class = '' ) {

        $classes = "goto-question";
        if ( ! empty( $class ) ) {
            $classes .= " " . $class;
        }
        $link = '<a rel="nofollow" class="' . $classes . '" data-discussion-id="' . $question->ID . '" href="' . add_query_arg( array(
                "reply-to-question" => $question->ID,
                "qa"                => 1,
            ), remove_query_arg( "show-all-questions", get_permalink( $question->product_id ) ) ) . '">' . wc_trim_string(wp_strip_all_tags($label, 100 )) . '</a>';

        return $link;
    }
}

$all_answers = $question->get_answers();
$all_answers_ordered = array_reverse($all_answers);

$count = $question->get_answers_count();
$answers_to_show = 4;

?>

<li id="li-question-<?php echo $question->ID; ?>" class="question-container">
    <div class="question-text">
        <div class="question-content">
            <span class="question-symbol">Q</span>
            <span class="question"><?php echo answer_now_link( $question, $question->content ); ?>
                <?php echo answer_now_link( $question, "به این پرسش پاسخ دهید." , "answer-now" ); ?>
			</span>
            <div class="question-owner">
                <?php echo sprintf( "توسط %s در %s" , '<span class="question-author-name">' . $question->get_author_name() . '</span>',
                                '<span class="question-date">' . date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $question->date ) ) . '</span>' ); ?>
            </div>
        </div>

        <div class="answer-content">

            <?php if ( $all_answers_ordered ) :


                $cnt = 0;

                foreach ( $all_answers_ordered as $answer ){

                    if( $cnt >= $answers_to_show && $answers_to_show != 0 ){
                        break;
                    }

                    ?><div class="ywqa-answers-list">
                        <span class="answer-symbol">A</span>
                        <span class="answer"><?php echo $answer->content; ?></span>
                    </div>

                    <?php $cnt++ ?>

                <?php } ?>

            <?php else: ?>
                <span class="answer">تاکنون پاسخی برای این سوال ارسال نشده است.</span>

            <?php endif; ?>

            <div id="submit_answer">
                <form id="submit_answer_form" method="POST">
                    <input type="hidden" name="gnj_product_id" value="<?php echo $question->product_id; ?>">
                    <input type="hidden" name="gnj_question_id" value="<?php echo $question->ID; ?>">
                    <input type="hidden" name="add_new_answer" value="1">
                    <?php wp_nonce_field( 'submit_answer_' . $question->ID, 'send_answer' ); ?>

                    <div>
						<textarea placeholder="Type your answer here" class="ywqa-send-answer-text"
                                  id="gnj_send_answer_text"
                                  name="gnj_send_answer_text"></textarea>
                        <input id="ywqa-send-answer" type="submit" class="gnj_submit_answer"
                               value="<?php _e( "Answer", 'yith-woocommerce-questions-and-answers' ); ?>"
                               title="<?php _e( "Answer now to the question", 'yith-woocommerce-questions-and-answers' ); ?>">
                    </div>
                </form>
            </div>


        </div>
    </div>
</li>
