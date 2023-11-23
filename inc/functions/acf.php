<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality for Advanced Custom Fields.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	ACF Functions
//	=============
//
// ipress_acf_active
// ipress_acf_plugin_active
// ipress_acf_fields
// ipress_acf_field
// ipress_acf_field_option
// ipress_acf_field_meta
// ipress_acf_field_repeater
//----------------------------------------------

if ( ! function_exists( 'ipress_acf_active' ) ) :

	/**
	 * Check for Advanced Custom Fields activation
	 */
	function ipress_acf_active() : bool {
		return class_exists( 'ACF', false );
	}
endif;


if ( ! function_exists( 'ipress_acf_plugin_active' ) ) :

	/**
	 * Check for Advanced Custom Fields plugin activation
	 *
	 * @param boolean $pro Check pro as well as normal, default true
	 */
	function ipress_acf_plugin_active( $pro = true ) : bool {

		// Checks to see if 'is_plugin_active' function exists, loads if not
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound 
		}

		// Check if the acf pro plugin is activated
		if ( $pro && is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			return true;
		}

		// Check if the standard acf plugin is activated
		return is_plugin_active( 'advanced-custom-fields/acf.php' );
	}
endif;

if ( ! function_exists( 'ipress_acf_fields' ) ) :

	/**
	 * Retrieve all fields into array
	 *
	 * @param integer $pid post_ID default to 0
	 * @param bool $format default true
	 * @return array
	 */
	function ipress_acf_fields( $pid = 0, $format = true ) {
		return ( 0 === $pid ) ? get_fields( get_the_ID(), $format ) : get_fields( $pid , $format );
	}
endif;

if ( ! function_exists( 'ipress_acf_field' ) ) :

	/**	
	 * Retrieve data by field name
	 *
	 * @param string $field ACF field name
	 * @param integer $pid default 0
	 * @return mixed
	 */
	function ipress_acf_field( $field, $pid = 0 ) {
		return ( 0 === $pid ) ? get_field( $field, get_the_ID() ) : get_field( $field, $pid );
	}
endif;

if ( ! function_exists( 'ipress_acf_field_option' ) ) :
	
	/**
	 * Retrieve options page data by field name
	 *
	 * @param string $field ACF Option field name
	 * @return mixed
	 */
	function ipress_acf_field_option( $field ) {
		return get_field( $field, 'option' );
	}
endif;

if ( ! function_exists( 'ipress_acf_field_meta' ) ) :

	/**
	 * Return field post_meta value
	 *
	 * @param string $field ACF field name
	 * @param integer $pid Post_ID, current post if 0
	 * @return boolean|array|string|integer
	 */
	function ipress_acf_field_meta( $field, $pid = 0 ) {
		return ( 0 === $pid ) ? get_post_meta( get_the_ID(), $field, true ) : get_post_meta( $pid, $field, true );
	}
endif;

if ( ! function_exists( 'ipress_acf_field_repeater' ) ) :

	/**
	 * Return repeater field values
	 *
	 * @param string $field Repeater field value
	 * @param array $fields Repeater subfield values
	 * @param integer $pid Post ID, current post if 0
	 * @return array $result
	 */
	function ipress_acf_field_repeater( $field, $fields, $pid = 0 ) {

		// Initialise result
		$result = [];

		// Get main repeater value, with ID if needed
		$repeat = ( 0 === $pid ) ? get_post_meta( get_the_ID(), $fields, true ) : get_post_meta( $pid, $fields, true );
		if ( ! $repeat ) {
			return;
		}

		// Iterate repeat field values
		foreach ( $repeat as $r ) {
			$result[ $r ] = get_post_meta( $pid, $r, true );
		}
		return $result;
	}
endif;
