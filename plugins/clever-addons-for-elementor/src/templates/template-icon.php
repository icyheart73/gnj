<?php
/**
 * View template for Clever Icon widget
 *
 * @package CAFE\Templates
 * @copyright 2018 CleverSoft. All rights reserved.
 */

$open_link  = '';
$close_link = '';
$url        = '#';
$target     = '';
$follow     = '';
if ( $settings['icon'] != '' ) {
	$icon = '<i class="' . $settings['icon'] . '"></i>';
	if ( $settings['link']['url'] != '' ) {
		$url    = esc_url( $settings['link']['url'] );
		$target = $settings['link']['is_external'] == 'on' ? 'target="_blank"' : '';
		$follow = $settings['link']['nofollow'] == 'on' ? 'rel="nofollow"' : '';
		printf( '<a href="%s" class="cafe-icon" %s %s>%s</a>', $url, $target, $follow, $icon);
	}else{
		printf( '<span class="cafe-icon">%s</span>', $icon);
	}
}
