<?php
/**
 * Display the answer template
 *
 * @author        Yithemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$ywqa = Ganje_Product_QA::get_instance();
?>

<?php //do_action( 'yith_question_answer_before_question_list_section' ); ?>
<div id="new-answer-header">
	<div id="parent-question">
		<div class="parent-question"><?php echo $question->content; ?><a class="back-to-product"
		                                                                 href="<?php echo remove_query_arg( array(
			                                                                 "show-all-questions",
			                                                                 "reply-to-question"
		                                                                 ) ); ?>"
		                                                                 title="<?php _e( "Back to product", 'yith-woocommerce-questions-and-answers' ); ?>"><?php _e( "Back to product", 'yith-woocommerce-questions-and-answers' ); ?></a>
		</div>

		<div
			class="question-owner"><?php echo sprintf( __( "asked by %s on %s", 'yith-woocommerce-questions-and-answers' ), '<span class="question-author-name">' . $question->get_author_name() . '</span>',
				'<span class="question-date">' . $question->date . '</span>' ); ?>
		</div>
	</div>

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

<div id="gnj_answer_list">

	<?php if ( $question_count = $question->has_answers() ) : ?>
		<span
			class="answer-list-count"><?php echo sprintf( __( "%s answers shown", 'yith-woocommerce-questions-and-answers' ), $question_count ); ?></span>

		<ol class="ywqa-answer-list">
			<?php $ywqa->show_answers( $question ); ?>
		</ol>

		<p class="woocommerce-noreviews"><?php _e( 'There are no answers to this question, be the first to respond.', 'yith-woocommerce-questions-and-answers' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>