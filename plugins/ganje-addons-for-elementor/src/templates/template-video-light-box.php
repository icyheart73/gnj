<?php
/**
 * View template for Video Light Box widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$url = $settings['source_url'];
$aparat_url = $settings['source_aparat'];
if ($url != '') {
    $url = $settings['source_url']['url'];
    $css_class = 'gnje-video-light-box';
    $img = $settings['image'];
    if ($img['url'] == '') {
        $css_class .= ' no-thumb';
    }
    $css_class .= ' ' . $settings['css_class'];
    ?>
    <div class="<?php echo esc_attr($css_class); ?>">
        <?php
        if ($img['url'] != '') {
            printf('<img class="gnje-video-thumb" src="%s"/>', $img['url']);
        }
        $data_config = '{"width":' . $settings['width'] . ',"height":' . $settings['height'] . '}';
        $color = $settings['color'];
        ?>
        <div class="ganje-video-frame">
        <div class="gnje-wrap-content-video">
            <a href="<?php echo esc_url($url) ?>"
               class="gnje-video-button <?php echo esc_attr($settings['button_type']); ?>"
               data-gnje-config="<?php echo esc_attr($data_config); ?>">
                <svg version="1.1" class="play" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="100px" width="100px"
                     viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                    <path class="stroke-solid" fill="none" stroke="<?php echo esc_attr($color) ?>" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                          C97.3,23.7,75.7,2.3,49.9,2.5"></path>
                    <path class="stroke-dotted" fill="none" stroke="<?php echo esc_attr($color) ?>" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                          C97.3,23.7,75.7,2.3,49.9,2.5"></path>
                    <path class="icon" fill="<?php echo esc_attr($color) ?>"
                          d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z">
                    </path>
                 </svg>
            </a>
            <?php
            if ($settings['title'] != '')
                printf('<h3 class="gnje-title" %s>%s</h3>', $this->get_render_attribute_string('title'), $settings['title']);
            if ($settings['des'] != '')
                printf('<div class="gnje-description" %s>%s</div>', $this->get_render_attribute_string('des'), $settings['des']);
            ?>
        </div>
        </div>
    </div>
    <?php
}
if($aparat_url!=''){?>
<div class="ganje-video-frame">
    <?=$aparat_url; ?>
</div>
<?php
}
