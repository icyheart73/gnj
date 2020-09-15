<?php
/**
 * View template for Count Down widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */


?>
<div class="gnje-countdown">
    <div class="gnje-countdown-block" data-countdown="countdown" data-date="<?php echo esc_attr(date("m-d-Y-G-i-s", strtotime($settings['date']))) ?>">
    </div>
</div>
