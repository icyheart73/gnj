<?php
/**
 * View template for Ganje Image 360 View widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

if (isset($settings['images'])) {
    $gnje_content = $settings['images'];
    $css_class = 'gnje-image-360-view';
    $css_class .= ' ' . $settings['css_class'];
    $width = $settings['width'] != '' ? $settings['width'] : '100%';
    $height = $settings['height'] != '' ? $settings['height'] : '100%';

    $imgs = array();
    foreach ($gnje_content as $img) {
        if ($img['url'] != '')
            $imgs[] = $img['url'];
    }
    $imgs = implode(",", $imgs);
    $gnje_json_config = '{"width":"' . $width . '","height":"' . $height . '","source":"' . $imgs . '"}';

    ?>
    <div class="<?php echo esc_attr($css_class) ?>" data-gnje-config='<?php echo esc_attr($gnje_json_config) ?>'>
        <div class="gnje-wrap-img-360-view">
            <div class="gnje-wrap-content-view">
            </div>
            <ul class="gnje-wrap-control-view">
                <li class="gnje-control-view gnje-prev-item"><i class="cs-font ganje-icon-arrow-left-5"></i></li>
                <li class="gnje-control-view gnje-center"><i class="cs-font ganje-icon-360-2"></i></li>
                <li class="gnje-control-view gnje-next-item"><i class="cs-font ganje-icon-arrow-right-5"></i></li>
            </ul>
        </div>
        <?php
        printf('<div class="gnje-description" %s>%s</div>', $this->get_render_attribute_string('des'), $settings['des']);
        ?>
    </div>
    <?php
    if (is_admin()) {
        ?>
        <script>
            if (typeof window.gnje != "undefined") {
                window.gnje.init();
            }</script>
    <?php }
} ?>

