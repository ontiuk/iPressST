<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Links and Edit Shortcodes.
 *
 * @package		iPress\Shortcodes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

//---------------------------------------------
//	Links Shortcodes
//
//	ipress_backtotop
//	ipress_copyright
//	ipress_link
//	ipress_wordpress_link
//	ipress_loginout
//---------------------------------------------

/**
 *	Return to Top link
 *
 * @param	array|string $atts Shortcode attributes - Empty string if no attributes
 * @return	string
 */
function ipress_backtotop_shortcode( $atts ) {

	$defaults = [
		'after'    => '',
		'before'   => '',
		'href'	   => '#top',
		'nofollow' => true,
		'text'	   => __( 'Return to top', 'ipress' ),
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_backtotop_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_backtotop' );

	// Generate filterable output
	$nofollow 	= ( $atts['nofollow'] ) ? 'rel="nofollow"' : '';
	$output 	= sprintf( '%s<a href="%s" %s>%s</a>%s', sanitize_text_field( $atts['before'] ), esc_url( $atts['href'] ), $nofollow, sanitize_text_field( $atts['text'] ), sanitize_text_field ( $atts['after'] ) );
	$output 	= (string) apply_filters( 'ipress_backtotop_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Back To Top Shortcode
add_shortcode( 'ipress_backtotop', 'ipress_backtotop_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Adds the visual copyright notice
 *
 * @param	array|string 
 * @return	string 
 */
function ipress_copyright_shortcode( $atts ) {

	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'copyright' => '&#x000A9;',
		'first'		=> '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_copyright_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_copyright' );

	// Generate filterable output
	$output = sanitize_text_field( $atts['before'] . $atts['copyright'] ) . '&nbsp;';
	if ( '' !== $atts['first'] && date( 'Y' ) !== $atts['first'] ) {
		$output .= sanitize_text_field( $atts['first'] ) . '&#x02013;';
	}
	$output .= date( 'Y' ) . sanitize_text_field( $atts['after'] );
	$output = (string) apply_filters( 'ipress_copyright_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Copyright Shortcode
add_shortcode( 'ipress_copyright', 'ipress_copyright_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Adds link to the iPress Homepage
 *
 * @param	array|string $atts 
 * @return	string Shortcode output
 */
function ipress_link_shortcode( $atts ) {

	$defaults = [
		'after'  => '',
		'before' => '',
		'url'	 => 'https://ipress.uk/',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_link_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_link' );

	// Generate filterable output
	$output = sprintf( '%s<a href="%s">%s</a>%s', sanitize_text_field( $atts['before'] ), esc_url( $atts['url'] ), __( 'iPress', 'ipress' ), sanitize_text_field( $atts['after'] ) );
	$outpur = (string) apply_filters( 'ipress_link_shortcode', $output, $atts );

	// Return  output
	return trim( $output );
}

// iPress Site Shortcode
add_shortcode( 'ipress_link', 'ipress_link_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Adds link to WordPress - http://wordpress.org/
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_wordpress_link_shortcode( $atts ) {

	$defaults = [
		'after'  => '',
		'before' => '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_wordpress_link_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_wordpress_link' );

	// Generate filterable output
	$output = sprintf( '%s<a href="%s">%s</a>%s', sanitize_text_field( $atts['before'] ), 'https://wordpress.org/', 'WordPress', sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_wordpress_link_shortcode', $output, $atts );

	// Return filterable attributes
	return trim( $output );
}

// WordPress Link Shortcode
add_shortcode( 'ipress_wordpress_link', 'ipress_wordpress_link_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Adds admin login / logout link
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_loginout_shortcode( $atts ) {

	$defaults = [
		'after'    => '',
		'before'   => '',
		'redirect' => '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_loginout_shortcode_defaults', $defaults );

	// Get ahortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'footer_loginout' );

	$log_in  = sprintf( '<a href="%s">%s</a>', esc_url( wp_login_url( $atts['redirect'] ) ), __( 'Log in', 'ipress' ) );
	$log_out = sprintf( '<a href="%s">%s</a>', esc_url( wp_logout_url( $atts['redirect'] ) ), __( 'Log out', 'ipress' ) );

	// Set the link
	$link = ( ! is_user_logged_in() ) ? $log_in : $log_out;

	// Generate output
	$output = sanitize_text_field( $atts['before'] ) . apply_filters( 'loginout', $link ) . sanitize_text_field( $atts['after'] );
	$output = (string) apply_filters( 'ipress_loginout_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Login / Logout Link Shortcode 
add_shortcode( 'ipress_loginout', 'ipress_loginout_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//end
