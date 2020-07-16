<?php
/**
 * View template for Ganje Pricing Table
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$open_link = '';
$close_link = '';
$url = '#';
$target = '';
$follow = '';
if ($settings['link_type'] == 'page') {
    $url = get_permalink($settings['link_page']);
    if ($url) {
        $target = $settings['link_page_new_window'] == 'yes' ? 'target="_blank"' : '';
    } else {
        $url = '#';
    }
} else {
    if ($settings['link']['url'] != '') {
        $url = esc_url($settings['link']['url']);
        $target = $settings['link']['is_external'] == 'on' ? 'target="_blank"' : '';
        $follow = $settings['link']['nofollow'] == 'on' ? 'rel="nofollow"' : '';
    }
}
$icon_left = '';
$icon_right = '';
$button = '';
if ($settings['button_text'] != '' || $settings['button_icon'] != '') {
    if ($settings['button_icon'] != '') {
        if ($settings['button_icon_pos'] == 'before') {
            $icon_left = '<i class="' . $settings['button_icon'] . '"></i>';
        } else {
            $icon_right = '<i class="' . $settings['button_icon'] . '"></i>';
        }
    }
    $button = sprintf('<div class="gnje-wrap-button"><a href="%s" %s %s %s>%s %s %s</a></div>', $url, $target, $follow, $this->get_render_attribute_string('button_text'), $icon_left, $settings['button_text'], $icon_right);
}

    $header_block_class = 'gnje-wrap-block-heading';
    if ($settings['badge_text'] != '' || $settings['badge_icon']) {
        $badge_icon = '';
        $header_block_class .= ' badge-' . $settings['badge_type'];
        if ($settings['badge_icon'] != '') {
            $badge_icon = '<i class="' . $settings['badge_icon'] . '"></i>';
        }

        $badge_class = 'gnje-badge ' . $settings['badge_type'];
        $badge = '<div class="' . esc_attr($badge_class) . '"><span class="wrap-badge">';
        $badge .= sprintf('<span %s>%s %s</span>', $this->get_render_attribute_string('badge_text'), $badge_icon, $settings['badge_text']);
        $badge .= '</span></div>';
        echo $badge;
    }
?>
<div class="gnje-wrap-pricing-table <?php echo esc_attr($settings['general_style']); ?>">
    <div class="<?php echo esc_attr($header_block_class); ?>">
        <?php
        printf('<%s %s>%s</%s>', $settings['title_tag'], $this->get_render_attribute_string('title'), $settings['title'], $settings['title_tag']);
        if ($settings['des'] != '') {
            printf('<div %s>%s</div>', $this->get_render_attribute_string('des'), $settings['des']);
        }
        ?>
    </div>
    <div class="gnje-wrap-price">
        <?php
        $currency = '<span class="gnje-currency">' . $settings['currency'] . '</span>';
        if ($settings['original_price'] != '') {
            echo '<del class="gnje-original-price">' . $currency . $settings['original_price'] . '</del>';
        }
        if ($settings['price'] != '') {
            echo '<span class="gnje-price">' . $currency . $settings['price'] . '</span>';
        }
        if ($settings['duration'] != '') {
            echo '<span class="gnje-duration">' . $settings['duration'] . '</span>';
        }
        if ($settings['duration_des'] != '') {
            echo '<div class="gnje-duration-des">' . $settings['duration_des'] . '</div>';
        }
        ?>
    </div>
    <?php

    $gnje_features = $settings['features_list'];

    if ($gnje_features != '') {
        $list_text = array();
        ?>
        <ul class="gnje-wrap-list-features">
            <?php
            foreach ($gnje_features as $text) {
                $title = '';
                if ($text['icon'] != '') {
                    $title = '<i class="' . $text['icon'] . '"></i> ';
                }
                if ($text['title'] != '') {
                    $title .= $text['title'];
                }

                if ($title != '') {
                    ?>
                    <li class="elementor-repeater-item-<?php echo esc_attr($text['_id']); ?> gnje-feature"><?php echo $title ?></li>
                <?php }
            }
            ?>
        </ul>
        <?php
    }

    echo $button;
    ?>
</div>