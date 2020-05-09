<?php
/**
 * Questions Template for YITH WooCommerce Questions and Answers
 *
 * @author        Yithemes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<input type="hidden" id="ywqa-questions-and-answers-product-id" name="ywqa-questions-and-answers" value="<?php echo $product_id; ?>">

<div id="ywqa-questions-and-answers" data-product-id="<?php echo $product_id; ?>" class="ywqa-container">

    <div class="ywqa-content">
        <?php do_action( 'gnj_questions_and_answers_content' ); ?>
    </div>

</div>
