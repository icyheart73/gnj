<?php
/**
 * View template for Team member widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$css_class = 'gnje-team-member ' . $settings['style'];
if ($settings['member_social'] != '') {
    $css_class .= ' has-social';
}
if ($settings['member_bio'] != '') {
    $css_class .= ' has-member-bio';
}

$social_html = '<ul class="gnje-member-social">';
foreach ($settings['member_social'] as $social) {
    $social_html .= sprintf('<li class="gnje-member-social-item"><a href="%s" title="%s"><i class="%s"></i></a></li>', $social['url']["url"], $social['social_title'], $social['social']);
}
$social_html .= '</ul>';
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php
    if ($settings['member_ava'] != '') {
        ?>
        <div class="gnje-member-ava">
            <?php
            printf('<div class="mask-color"></div><img src="%s" alt="%s"/>', $settings['member_ava']['url'], $settings['member_name']);
            if ($settings['member_social'] != '' && $settings['style'] == 'style-2') {
                ?>
                <div class="gnje-wrap-team-member">
                    <?php
                    echo $social_html;
                    ?>
                </div>
                <?php
            }
            if ($settings['style'] == 'style-4') {
                echo $social_html;
            }
            ?>
        </div>
        <?php
    }
    if ($settings['style'] == 'style-1') :
        ?>
        <div class="gnje-wrap-team-member">
            <?php
            printf('<h3 %s>%s</h3>', $this->get_render_attribute_string('member_name'), $settings['member_name']);
            printf('<div class="gnje-member-des" %s>%s</div>', $this->get_render_attribute_string('member_des'), $settings['member_des']);
            printf('<div class="gnje-member-bio" %s>%s</div>', $this->get_render_attribute_string('member_bio'), $settings['member_bio']);
            if ($settings['member_social'] != '') {
                echo $social_html;
            }
            ?>
        </div>
    <?php
    else:
        if ($settings['member_social'] != '' && $settings['style'] == 'style-3') {
            $social_html_p = $social_html;
        }
        printf('<h3 class="gnje-member-name" %s>%s</h3>', $this->get_render_attribute_string('member_name'), $settings['member_name']);
        printf('<div class="gnje-member-des" %s>%s</div>', $this->get_render_attribute_string('member_des'), $settings['member_des']);
        if ($settings['member_social'] != '' && $settings['style'] == 'style-3') {
            ?>
            <div class="wrap-member-bio">
            <?php
        }
        printf('<div class="gnje-member-bio" %s>%s</div>', $this->get_render_attribute_string('member_bio'), $settings['member_bio']);
        if ($settings['member_social'] != '' && $settings['style'] == 'style-3') {
            echo $social_html;
            ?>
            </div>
            <?php
        }
    endif;
    ?>
</div>

