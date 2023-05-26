<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality for Kirki Customiser fields.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	Kirki Functions
//	================
//
// ipress_kirki_active
// ipress_kirki_plugin_active
//----------------------------------------------

if ( ! function_exists( 'ipress_kirki_active' ) ) :

	/**
	 * Check for Kirki activation
	 */
	function ipress_kirki_active() : bool {
		return class_exists( 'Kirki', false );
	}
endif;


if ( ! function_exists( 'ipress_kirki_plugin_active' ) ) :

	/**
	 * Check for Kirki plugin activation
	 *
	 * @param boolean $pro Check pro as well as normal, default true
	 */
	function ipress_kirki_plugin_active( $pro = true ) : bool {

		// Checks to see if 'is_plugin_active' function exists, loads if not
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound 
		}

		// Checks to see if the kirki pro plugin is activated
		if ( $pro && is_plugin_active( 'kirki-pro/kirki.php' ) ) {
			return true;
		}

		// Checks to see if the standard kirki plugin is activated
		return is_plugin_active( 'kirki/kirki.php' );
	}
endif;

// End
