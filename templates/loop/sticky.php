<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying sticky post section.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( 'post' !== get_post_type() ) {
	return;
}

if ( is_sticky() && is_home() && ! is_paged() ) :
	$featured_title = sprintf(
		/* translators: %s: featured post */
		'<span class="sticky-post">%s</span>',
		esc_html_x( 'Featured', 'post', 'ipress-standalone' )
	);
	echo wp_kses_post( $featured_title );
endif;
