<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * User functionality shortcodes.
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
//	User Shortcodes 
//
//	ipress_user_info
//	ipress_user_id
//	ipress_user_name
//	ipress_user_level
//---------------------------------------------

/**
 *	Retrieve current user info
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_user_info_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'    => '',
		'before'   => ''
	];
	
	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_user_info_defaults', $defaults );

	// Get user data
	$userdata = wp_get_current_user();

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_user_info' );

	// Extras
	$before = sanitize_text_field( $atts['before'] );
	$after 	= sanitize_text_field( $atts['after'] );

	// Generate filterable output
	$output = sprintf( '<span class="ipress-user-info">%s</span>', $before . join( ' ', $userdata ) . $after );
	$output = (string) apply_filters( 'ipress_user_info_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Get current user - should be used via do_shortcode
add_shortcode( 'ipress_user_info', 'ipress_user_info_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 *	Retrieve current user ID
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_user_id_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'    => '',
		'before'   => ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_user_id_defaults', $defaults );

	// Get user data
	$userdata = wp_get_current_user();

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_user_id' );

	// Extras
	$before = sanitize_text_field( $atts['before'] );
	$after 	= sanitize_text_field( $atts['after'] );

	// Generate output
	$output = sprintf( '<span class="ipress-user-id">%s</span>', $before . $userdata->ID . $after );
	$output = (string) apply_filters( 'ipress_user_id_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Get current user id 
add_shortcode( 'ipress_user_id', 'ipress_user_id_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 *	Retrieve current user name
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_user_name_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'    => '',
		'before'   => ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_user_name_defaults', $defaults );

	// Get user data
	$userdata = wp_get_current_user();

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_user_name' );

	// Extras
	$before = sanitize_text_field( $atts['before'] );
	$after 	= sanitize_text_field( $atts['after'] );

	// Generate filterable output
	$output = sprintf( '<span class="ipress-user-name">%s</span>', $before . $userdata->user_login . $after );
	$output = (string) apply_filters( 'ipress_user_name_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Get current user name 
add_shortcode( 'ipress_user_name', 'ipress_user_name_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 *	Retrieve current user level
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_user_level_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'    => '',
		'before'   => ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_user_level_defaults', $defaults );

	// Get user data
	$userdata = wp_get_current_user();

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_user_level' );

	// Extras
	$before = sanitize_text_field( $atts['before'] );
	$after 	= sanitize_text_field( $atts['after'] );

	// Generate filterable output
	$output = sprintf( '<span class="ipress-user-level">%s</span>', $before . $userdata->user_level . $after );
	$output = (string) apply_filters( 'ipress_user_level_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Get current user level 
add_shortcode( 'ipress_user_level', 'ipress_user_level_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//end
