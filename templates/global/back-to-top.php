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
if ( $back_to_top ) {
	
	echo apply_filters(
		'ipress_back_to_top_html',
		sprintf(
			'<a title="%1$s" aria-label="%1$s" rel="nofollow" class="back-to-top" data-scroll-speed="%2$s" data-scroll-start="%3$s">
				<img src="%4$s" alt="%1$s" />
			</a>',
			esc_attr__( 'Scroll back to top', 'ipress' ),
			absint( apply_filters( 'ipress_back_to_top_scroll_speed', 400 ) ),
			absint( apply_filters( 'ipress_back_to_top_scroll_start', 300 ) ),
			esc_attr( apply_filters( 'ipress_back_to_top_icon', IPRESS_ASSETS_URL . '/images/icons/back-to-top.png' ) )
		)
	);
}
