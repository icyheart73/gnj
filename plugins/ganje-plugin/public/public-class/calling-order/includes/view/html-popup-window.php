<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
ob_start();
?>
<div class="ganje-custom-order-wrap">
    <h2 class="ganje-form-custom-order-title"><?= $this->product_title($product) ?></h2>
    <div class="ganje-col-wrap">
        <div class="ganje-col columns-left">
            <div class="ganje-form-custom-order-img"><?= $this->product_image($product) ?></div>
            <div class="awooc-form-custom-order-price"><?= $this->product_price($product) ?> </div>
            <div class="ganje-form-custom-order-sku"><?= $this->the_product_sku($product) ?></div>
            <div class="ganje-form-custom-order-qty"></div>
        </div>
        <div class="ganje-col columns-right">
            <form class="place_calling_order_form" action="" method="post" name="place_calling_order">
                <div class="form-field">
                    <label>Name: </label>
                    <input name="name" type="text" placeholder="Type your name" required>
                </div>
                <div class="form-field">
                    <label>Mobile: </label>
                    <input name="mobile" type="text" placeholder="Type a valid email" required>
                </div>

                <input type="hidden" name="action" value="ganje_palce_calling_order">
                <input type="hidden" name="product_id" value="<?= $product->get_id() ?>">
                <input type="hidden" name="qty" value="<?= $_POST['qty'] ?>">
                <button class="place_calling_order" type="submit">Send message!</button>
            </form>
        </div>
    </div>
</div>
<?php
$output = ob_get_contents();
ob_end_clean();
?>
