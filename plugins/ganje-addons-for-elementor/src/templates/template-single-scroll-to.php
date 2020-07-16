<?php
/**
 * View template for Ganje Icon widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

if ($settings['target_id'] != '') {
    if ($settings['icon'] != 'font-icon') {
        $icon = '<i class="icon-' . $settings['icon'] . '"></i>';
    } else {
        $icon = '<i class="' . $settings['font_icon'] . '"></i>';
    }
    ?>
    <div class="gnje-wrap-single-scroll-button">
        <?php
        printf('<a class="gnje-single-scroll-button" href="%s"><span class="bg-box"><i class="edge-left"></i></span><span class="gnje-scroll-icon %s">%s</span></a>', $settings['target_id'], $settings['button_animation'], $icon);
        ?>
    </div>
    <?php
}