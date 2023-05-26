<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the scroll-to-top template.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Is back to the top enabled?
$back_to_top = ipress_get_option( 'back_to_top', true );
if ( ! $back_to_top ) { return; }

// Filterable back to top settings, @todo move filter options to customizer
$ip_back_to_top_title = apply_filters( 'ipress_back_to_top_title', __( 'Scroll back to top', 'ipress-child' ) );
$ip_back_to_top_scroll_speed = apply_filters( 'ipress_back_to_top_scroll_speed', 400 );
$ip_back_to_top_scroll_start = apply_filters( 'ipress_back_to_top_scroll_start', 300 );
$ip_back_to_top_icon = apply_filters( 'ipress_back_to_top_icon', IPRESS_ASSETS_URL . '/images/icons/back-to-top.png' );

// Display back to top link
echo sprintf(
	'<a title="%1$s" aria-label="%1$s" rel="nofollow" class="back-to-top-link" data-scroll-speed="%2$s" data-scroll-start="%3$s">
		<img src="%4$s" alt="%1$s" />
	</a>',
	esc_attr ( $ip_back_to_top_title ),
	absint( $ip_back_to_top_scroll_speed),
	absint(  $ip_back_to_top_scroll_start ),
	esc_attr(  $ip_back_to_top_icon )
);
