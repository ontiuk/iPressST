<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the generic site title with logo.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Are we displaying the title & tagline?
$show_title_tagline = ( true === ipress_get_option( 'title_and_tagline', true ) );
if ( ! $show_title_tagline ) {
	return;
}

// Set the site title
$site_title = apply_filters(
	'ipress_site_title_html',
	sprintf(
		'<%1$s class="%4$s">
			<a href="%2$s" rel="home">
				%3$s
			</a>',
		( is_front_page() && is_home() ) ? 'h1' : 'p',
		esc_url( apply_filters( 'ipress_site_title_link', home_url( '/' ) ) ),
		get_bloginfo( 'name' ),
		sanitize_html_class( apply_filters( 'ipress_title_class', 'site-title' ), 'site-title' )
	)
);

// Set the site tagline
$site_tagline = apply_filters(
	'ipress_site_tagline_html',
	sprintf(
		'<p class="%2$s">
			%1$s
		</p>',
		html_entity_decode( get_bloginfo( 'description', 'display' ) ),
		sanitize_html_class( apply_filters( 'ipress_tagline_class', 'site-description' ), 'site-description' )
	) // phpcs:ignore
);

// Set the site title & tagline
$site_branding = apply_filters(
	'ipress_site_branding_html',
	sprintf(
		'<div class="%3$s">
			%1$s
			%2$s
		</div>',
		$site_title,
		$site_tagline,
		sanitize_html_class( apply_filters( 'ipress_branding_class', 'site-branding' ), 'site-branding' )
	)
);

// Display branding
if ( $site_branding ) {
	echo $site_branding; // phpcs:ignore WordPress.Security.EscapeOutput
}

// ipress_site_branding hook
do_action( 'ipress_site_branding' );
