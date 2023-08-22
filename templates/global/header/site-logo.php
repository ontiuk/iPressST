<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the site logo.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Retrieve logo if set & available, theme support by default
$ip_logo_url = apply_filters( 'ipress_logo_url', ( get_theme_mod( 'custom_logo' ) ) ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) : false );
if ( ! $ip_logo_url ) {
	return;
}

// Destruct logo attributes
[ $logo_url, $logo_width, $logo_height ] = $ip_logo_url;

// Set logo attributes
$ip_attr = apply_filters(
	'ipress_logo_attributes',
	[
		'class'	 => 'logo-image',
		'alt'	 => esc_attr( apply_filters( 'ipress_logo_title', get_bloginfo( 'name', 'display' ) ) ),
		'src'	 => $logo_url
	]
);

// Set additional sizing attributes
if ( $logo_width ) {
	$ip_attr['width'] = $logo_width;
}

if ( $logo_height ) {
	$ip_attr['height'] = $logo_height;
}

// Retina logo? Set attribute
$ip_retina_logo_url = esc_url( apply_filters( 'ipress_retina_logo_url', ipress_get_option( 'retina_logo' ) ) );
if ( $ip_retina_logo_url ) {
	$ip_attr['srcset'] = $logo_url . ' 1x, ' . $ip_retina_logo_url . ' 2x';
}

// Set default classnames
$logo_defaults = [
	'logo_class' => 'site-logo',
	'title_class' => 'site-title',
	'description_class' => 'site-description'
];

// Filterable site logo & title arguments
$ip_logo_class = (array) apply_filters( 'ipress_logo_class', [ 'site-logo' ] );

// Sanitize attributes
$ip_attr = array_map( 'esc_attr', $ip_attr );

// Condense attributes to key : value html
$html_attr = ''; 
array_walk( $ip_attr, function( $item, $key ) use( &$html_attr ) {
	$html_attr .= " $key=" . '"' . $item . '"';
} );

do_action( 'ipress_before_logo' );

// Display logo
echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'ipress_logo_output',
	sprintf(
		'<div class="%1$s">
			<a href="%2$s" rel="home">
				<img %3$s />
			</a>
			<span class="screen-reader-text">%4$s</span>
		</div>',
		join( ' ', $ip_logo_class ),
		esc_url( apply_filters( 'ipress_logo_href', home_url( '/' ) ) ),
		$html_attr,
		get_bloginfo( 'name' )
	),
	$ip_logo_url,
	$ip_attr
);

do_action( 'ipress_after_logo' );
