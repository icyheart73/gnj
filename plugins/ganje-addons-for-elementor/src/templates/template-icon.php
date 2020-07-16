<?php
/**
 * View template for Ganje Icon widget
 *
 * @package GNJE\Templates
 * @copyright 2018 GanjeSoft. All rights reserved.
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
		printf( '<a href="%s" class="gnje-icon" %s %s>%s</a>', $url, $target, $follow, $icon);
	}else{
		printf( '<span class="gnje-icon">%s</span>', $icon);
	}
}
