<?php
/**
 * Questions Template for YITH WooCommerce Questions and Answers
 *
 * @author        Yithemes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $product;
?>

<input type="hidden" id="ywqa-questions-and-answers-product-id" name="ywqa-questions-and-answers" value="<?php echo $product_id; ?>">

<div id="ywqa-questions-and-answers" data-product-id="<?php echo $product_id; ?>" class="ywqa-container">

    <div class="ywqa-content">
        <?php

        $product_id = $product->get_id();
        wc_get_template( 'gnj-product-questions.php',
            array(
                'max_items'     => -1,
                'only_answered' => false,
                'product_id'    => $product_id,
            ),
            '', GNJ_PATH.'/public/partials/' );
        ?>
    </div>

</div>
