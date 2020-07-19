<?php
/**
 * View template for RevSlider widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */


if ($settings['id'] != '0'):
    $rev_slider = '[rev_slider alias="'.$settings['id'].'"]';
    $class_css = 'gnje-rev-slider ' . $settings['css_class'];
    ?>
    <div class="<?php echo esc_attr($class_css) ?>">
        <?php
        echo do_shortcode($rev_slider);
        ?>
    </div>
<?php
endif;