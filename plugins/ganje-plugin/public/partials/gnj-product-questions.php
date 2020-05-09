<?php
/**
 * Questions Template for YITH WooCommerce Questions and Answers
 *
 * @author        Yithemes
 */

if ( ! defined ( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$data = Ganje_Product_QA::get_instance();
$question_count = $data->get_questions_count ( $product_id );
$answered_count = $data->get_questions_count ( $product_id, true );

$unanswered_count = $question_count - $answered_count;

?>
<div id="ywqa-questions-and-answers" data-product-id="<?php echo $product_id; ?>" class="ywqa-product-questions">
    <div class="questions-section">
        <h3>پرسش و پاسخ های مشتریان راجع به محصول : </h3>

        <div id="ywqa_question_list">
            <?php if ( $question_count ) :
                $item_shown       = $data->show_questions ($product_id);
            else: ?>
                <p class="no-questions"><?php esc_html_e( "No question has still received an answer.", 'yith-woocommerce-questions-and-answers' ); ?></p>
            <?php endif; ?>

            <div class="clear"></div>
        </div>

        <div id="ask_question">
            <form id="ask_question_form" method="POST">
                <input type="hidden" name="ywqa_product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="add_new_question" value="1">
                <?php wp_nonce_field ( 'ask_question_' . $product_id, 'ywqa_ask_question' ); ?>
                <div class="ywqa-ask-question">

                    <p class="ywqa_ask_question_text">
                        <label
                                for="ywqa_user_content"><?php esc_html_e( 'Your question', 'yith-woocommerce-questions-and-answers' ); ?>
                            <span class="required">*</span></label>
                        <textarea id="ywqa_user_content" name="ywqa_user_content"
                                  placeholder="<?php esc_html_e( 'Do you have any questions? Ask now!', 'yith-woocommerce-questions-and-answers' ); ?>"
                                  class="ywqa-ask-question-text"></textarea>
                    </p>

                    <?php if ( ! get_current_user_id () ): ?>
                        <p class="ywqa-guest-name-section">
                            <label for="ywqa-guest-name"><?php esc_html_e( 'Name', 'yith-woocommerce-questions-and-answers' ); ?>
                            </label>
                            <input id="ywqa-guest-name" name="ywqa-guest-name" class="ywqa-guest-name required"
                                   type="text"
                                   placeholder="<?php esc_html_e( "Enter your name", 'yith-woocommerce-questions-and-answers' ); ?>"
                                   value="" aria-required="true">
                        </p>
                        <p class="ywqa-guest-email-section">
                            <label for="ywqa-guest-email"><?php esc_html_e( 'Email', 'yith-woocommerce-questions-and-answers' ); ?>
                            </label>
                            <input id="ywqa-guest-email" name="ywqa-guest-email"
                                   class="ywqa-guest-email required"
                                   type="text"
                                   placeholder="<?php esc_html_e( "Enter your email", 'yith-woocommerce-questions-and-answers' ); ?>"
                                   value="" aria-required="true">
                        </p>
                    <?php endif; ?>

                    <div class="notify-answers">
                        <input id="ywqa-notify-user" name="ywqa-notify-user" type="checkbox"
                               class="enable-notification"
                               checked="checked"><?php esc_html_e( "Send me a notification for each new answer.", 'yith-woocommerce-questions-and-answers' ); ?>

                        <input id="ywqa-submit-question" type="submit" class="ywqa_submit_question"
                               value="<?php esc_html_e( "Ask", 'yith-woocommerce-questions-and-answers' ); ?>"
                               title="<?php esc_html_e( "Ask your question", 'yith-woocommerce-questions-and-answers' ); ?>">
                    </div>
                </div>
            </form>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
