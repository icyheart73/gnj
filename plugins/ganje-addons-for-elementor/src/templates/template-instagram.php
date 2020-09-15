<?php
/**
 * View template for Ganje Instagram
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
 */

$gnje_json_config = $target = $limit = $img_size = $count = '';
if ( !empty( $settings['link_target'] ) && $settings['link_target'] == '_blank' ) {
    $target = 'target="_blank"';
}
$limit = !empty( $settings['number'] ) ? $settings['number'] : 8;
$img_size = !empty( $settings['img_size'] ) ? $settings['img_size'] : 'large';

$gnje_wrap_class = "woocommerce gnje-products-wrap";
$gnje_json_config = '';
if($settings['layout'] == 'carousel'){
    $class                  = 'grid-layout carousel';
    $class                  .= ' ' . $settings['nav_position'];
    $gnje_wrap_class         .= ' gnje-carousel';

    $settings['autoplay'] ? $settings['autoplay'] : $settings['autoplay'] = 'false';
    $settings['autoplay_tablet'] ? $settings['autoplay_tablet'] : $settings['autoplay_tablet'] = 'false';
    $settings['autoplay_mobile'] ? $settings['autoplay_mobile'] : $settings['autoplay_mobile'] = 'false';

    $settings['show_pag'] ? $settings['show_pag'] : $settings['show_pag'] = 'false';
    $settings['show_pag_tablet'] ? $settings['show_pag_tablet'] : $settings['show_pag_tablet'] = 'false';
    $settings['show_pag_mobile'] ? $settings['show_pag_mobile'] : $settings['show_pag_mobile'] = 'false';

    $settings['show_nav'] ? $settings['show_nav'] : $settings['show_nav'] = 'false';
    $settings['show_nav_tablet'] ? $settings['show_nav_tablet'] : $settings['show_nav_tablet'] = 'false';
    $settings['show_nav_mobile'] ? $settings['show_nav_mobile'] : $settings['show_nav_mobile'] = 'false';
    $settings['speed']?$settings['speed']:$settings['speed']=3000;
    $gnje_json_config = '{
        "slides_to_show" : ' . $settings['slides_to_show']['size'] . ',
        "slides_to_show_tablet" : ' . $settings['slides_to_show_tablet']['size'] . ',
        "slides_to_show_mobile" : ' . $settings['slides_to_show_mobile']['size'] . ',

        "speed": ' . $settings['speed'] . ',
        "scroll": ' . $settings['scroll'] . ',

        "autoplay": ' . $settings['autoplay'] . ',
        "autoplay_tablet": ' . $settings['autoplay_tablet'] . ',
        "autoplay_mobile": ' . $settings['autoplay_mobile'] . ',

        "show_pag": ' . $settings['show_pag'] . ',
        "show_pag_tablet": ' . $settings['show_pag_tablet'] . ',
        "show_pag_mobile": ' . $settings['show_pag_mobile'] . ',

        "show_nav": ' . $settings['show_nav'] . ',
        "show_nav_tablet": ' . $settings['show_nav_tablet'] . ',
        "show_nav_mobile": ' . $settings['show_nav_mobile'] . ',
        "wrap": ".wrap-instagram"
    }';
}else{
    $gnje_wrap_class         = "woocommerce gnje-products-wrap";
    $class                  = 'grid-layout';
    $grid_class = '  gnje-grid-lg-' . $settings['columns']['size'] . '-cols gnje-grid-md-' . $settings['columns_tablet']['size'] . '-cols gnje-grid-' . $settings['columns_mobile']['size'] .'-cols';
    $gnje_wrap_class .= $grid_class;
}

if ( !empty( $settings['username'] ) ) : ?>
    <?php $media_array = gnje_scrape_instagram( $settings['username'] ); ?>

    <?php if ( is_wp_error( $media_array ) ) : ?>

        <?php echo wp_kses_post( $media_array->get_error_message() ); ?>

        <?php else : ?>
            <?php
            if ( $images_only = apply_filters( 'gnje_instagram_images_only', FALSE ) ) {
                $media_array = array_filter( $media_array, 'gnje_images_only' );
            }
            ?>
            <div class="<?php echo esc_attr($gnje_wrap_class) ?> " data-gnje-config='<?php echo esc_attr($gnje_json_config) ?>'>
                <?php if (isset($settings['title']) && $settings['title'] != '') :?>

        <?php
                    printf('<h3 class="instagram-title" %s> <img class="instagram-logo" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGxpbmVhckdyYWRpZW50IGlkPSJTVkdJRF8xXyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSItNDYuMDA0MSIgeTE9IjYzNC4xMjA4IiB4Mj0iLTMyLjkzMzQiIHkyPSI2NDcuMTkxNyIgZ3JhZGllbnRUcmFuc2Zvcm09Im1hdHJpeCgzMiAwIDAgLTMyIDE1MTkgMjA3NTcpIj4NCgk8c3RvcCAgb2Zmc2V0PSIwIiBzdHlsZT0ic3RvcC1jb2xvcjojRkZDMTA3Ii8+DQoJPHN0b3AgIG9mZnNldD0iMC41MDciIHN0eWxlPSJzdG9wLWNvbG9yOiNGNDQzMzYiLz4NCgk8c3RvcCAgb2Zmc2V0PSIwLjk5IiBzdHlsZT0ic3RvcC1jb2xvcjojOUMyN0IwIi8+DQo8L2xpbmVhckdyYWRpZW50Pg0KPHBhdGggc3R5bGU9ImZpbGw6dXJsKCNTVkdJRF8xXyk7IiBkPSJNMzUyLDBIMTYwQzcxLjY0OCwwLDAsNzEuNjQ4LDAsMTYwdjE5MmMwLDg4LjM1Miw3MS42NDgsMTYwLDE2MCwxNjBoMTkyDQoJYzg4LjM1MiwwLDE2MC03MS42NDgsMTYwLTE2MFYxNjBDNTEyLDcxLjY0OCw0NDAuMzUyLDAsMzUyLDB6IE00NjQsMzUyYzAsNjEuNzYtNTAuMjQsMTEyLTExMiwxMTJIMTYwYy02MS43NiwwLTExMi01MC4yNC0xMTItMTEyDQoJVjE2MEM0OCw5OC4yNCw5OC4yNCw0OCwxNjAsNDhoMTkyYzYxLjc2LDAsMTEyLDUwLjI0LDExMiwxMTJWMzUyeiIvPg0KPGxpbmVhckdyYWRpZW50IGlkPSJTVkdJRF8yXyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSItNDIuMjk3MSIgeTE9IjYzNy44Mjc5IiB4Mj0iLTM2LjY0MDQiIHkyPSI2NDMuNDg0NiIgZ3JhZGllbnRUcmFuc2Zvcm09Im1hdHJpeCgzMiAwIDAgLTMyIDE1MTkgMjA3NTcpIj4NCgk8c3RvcCAgb2Zmc2V0PSIwIiBzdHlsZT0ic3RvcC1jb2xvcjojRkZDMTA3Ii8+DQoJPHN0b3AgIG9mZnNldD0iMC41MDciIHN0eWxlPSJzdG9wLWNvbG9yOiNGNDQzMzYiLz4NCgk8c3RvcCAgb2Zmc2V0PSIwLjk5IiBzdHlsZT0ic3RvcC1jb2xvcjojOUMyN0IwIi8+DQo8L2xpbmVhckdyYWRpZW50Pg0KPHBhdGggc3R5bGU9ImZpbGw6dXJsKCNTVkdJRF8yXyk7IiBkPSJNMjU2LDEyOGMtNzAuNjg4LDAtMTI4LDU3LjMxMi0xMjgsMTI4czU3LjMxMiwxMjgsMTI4LDEyOHMxMjgtNTcuMzEyLDEyOC0xMjgNCglTMzI2LjY4OCwxMjgsMjU2LDEyOHogTTI1NiwzMzZjLTQ0LjA5NiwwLTgwLTM1LjkwNC04MC04MGMwLTQ0LjEyOCwzNS45MDQtODAsODAtODBzODAsMzUuODcyLDgwLDgwDQoJQzMzNiwzMDAuMDk2LDMwMC4wOTYsMzM2LDI1NiwzMzZ6Ii8+DQo8bGluZWFyR3JhZGllbnQgaWQ9IlNWR0lEXzNfIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9Ii0zNS41NDU2IiB5MT0iNjQ0LjU3OTMiIHgyPSItMzQuNzkxOSIgeTI9IjY0NS4zMzMxIiBncmFkaWVudFRyYW5zZm9ybT0ibWF0cml4KDMyIDAgMCAtMzIgMTUxOSAyMDc1NykiPg0KCTxzdG9wICBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiNGRkMxMDciLz4NCgk8c3RvcCAgb2Zmc2V0PSIwLjUwNyIgc3R5bGU9InN0b3AtY29sb3I6I0Y0NDMzNiIvPg0KCTxzdG9wICBvZmZzZXQ9IjAuOTkiIHN0eWxlPSJzdG9wLWNvbG9yOiM5QzI3QjAiLz4NCjwvbGluZWFyR3JhZGllbnQ+DQo8Y2lyY2xlIHN0eWxlPSJmaWxsOnVybCgjU1ZHSURfM18pOyIgY3g9IjM5My42IiBjeT0iMTE4LjQiIHI9IjE3LjA1NiIvPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />  %s    <a href="https://www.instagram.com/%s">دنبال کردن</a> </h3>',$this->get_render_attribute_string('title'), $settings['title'],$settings['username']);
                endif; ?>
                <div class="wrap-instagram">
                    <?php foreach ( $media_array as $item ) : $count++; if($count > $limit){break;} ?>
                        <div class="instagram-item post">
                            <div class="instagram-item-inner">
                                <?php
                            $type =  $item['type']; // image, video
                            $comments = gnje_abbreviate_total_count( $item['comments'], 10000 );
                            $likes = gnje_abbreviate_total_count( $item['likes'], 10000 );
                            $time =  gnje_time_elapsed_string( '@' . $item['time'] );

                            $gmt = get_option('gmt_offset');;
                            $time_zone = get_option( 'timezone_string' );
                            if ( !empty( $settings['date_format'] ) ) {
                                $date_format = $settings['date_format'];
                            } else {
                                $date_format = get_option( 'date_format' );
                            }
                            ?>
                            <a href="<?php echo esc_url( $item['link'] ); ?>"<?php echo $target; ?>>
                                <?php if ( !empty( $settings['show_type'] ) && $settings['show_type'] == '1' ) : ?>
                                    <?php if ( $type == 'video' ) : ?>
                                        <span class="type type-video"><i class="cs-font ganje-icon-triangle"></i></span>
                                        <?php else : ?>
                                            <span class="type type-image"><i class="cs-font ganje-icon-compare-6"></i></span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <span class="group-items">
                                        <?php if ( !empty( $settings['show_likes'] ) && $settings['show_likes'] ) : ?>
                                            <span class="likes"><i class="fal fa-heart"></i><?php echo $likes; ?></span>
                                        <?php endif; ?>

                                        <?php if ( !empty( $settings['show_comments'] ) && $settings['show_comments'] ) : ?>
                                            <span class="comments"><i class="fal fa-comment-alt-smile"></i><?php echo $comments; ?></span>
                                        <?php endif; ?>
                                    </span>

                                    <?php if ( !empty( $settings['show_time'] ) && $settings['show_time'] ) : ?>
                                        <?php if ( !empty( $settings['time_layout'] ) && $settings['time_layout'] == 'elapsed' ) : ?>
                                            <span class="time elapsed-time"><?php echo $time; ?></span>
                                        <?php endif; ?>

                                        <?php if ( !empty( $settings['time_layout'] ) && $settings['time_layout'] == 'date' ) : ?>
                                            <span class="time date-time"><?php echo date_i18n( $date_format, $item['time'], $gmt ); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <img src="<?php echo esc_url( $item[$img_size] ); ?>"  alt="<?php echo esc_attr( $item['description'] ); ?>"  class="instagram-photo"/>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php endif; ?>
