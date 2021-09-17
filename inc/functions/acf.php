<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality for Advanced Custom Fields
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	ACF Functions
//
// ipress_acf_active
// ipress_acf_plugin_active
// ipress_acf_field
// ipress_acf_field_repeater
// ipress_acf_field_category_term
//----------------------------------------------

if ( ! function_exists( 'ipress_acf_active' ) ) :

	/**
	 * Check for Advanced Custom Fields activation
	 *
	 * @return boolean true if Advanced CustomFields plugin is active
	 */
	function ipress_acf_active() {
		return class_exists( 'ACF', false );
	}
endif;


if ( ! function_exists( 'ipress_acf_plugin_active' ) ) :

	/**
	 * Check for Advanced Custom Fields plugin activation
	 *
	 * @param boolean $pro Check pro as well as normal, default true
	 * @return boolean true if Advanced Custom Fields plugin is active
	 */
	function ipress_acf_plugin_active( $pro = true ) {

		// Checks to see if 'is_plugin_active' function exists, loads if not
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound 
		}

		// Checks to see if the acf pro plugin is activated
		if ( $pro && is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			return true;
		}

		// Checks to see if the acf plugin is activated
		if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
			return true;
		}

		// Default return
		return false;
	}
endif;

if ( ! function_exists( 'ipress_acf_field' ) ) :

	/**
	 * Return Advanced Custom Fields field value
	 *
	 * @param string $field Field name
	 * @param boolean|integer $pid Post ID, current post if false
	 * @return boolean|array|string|integer
	 */
	function ipress_acf_field( $field, $pid = false ) {
		$pid = ( false === $pid ) ? get_the_ID() : absint( $pid );
		return get_post_meta( $pid, $field, true );
	}
endif;

if ( ! function_exists( 'ipress_acf_field_repeater' ) ) :

	/**
	 * Return Advanced Custom Fields repeater field values
	 *
	 * @param string $field Main repeater field value
	 * @param array $fields Repeater subfield values
	 * @param boolean|integer $pid Post ID, current post if false
	 * @return array $result Associative list of repeater field values
	 */
	function ipress_acf_field_repeater( $field, $fields, $pid = false ) {

		// Initialise result
		$result = [];

		// Set the post ID
		$pid = ( false === $pid ) ? get_the_ID() : absint( $pid );

		// Get main repeater value, with ID if needed
		$repeat = get_post_meta( $pid, $fields, true );
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

if ( ! function_exists( 'ipress_acf_field_category_term' ) ) :

	/**
	 * Return Advanced Custom Fields category tern field values
	 *
	 * @param string $category Category name
	 * @param string $term Term name
	 * @return array $result Field values
	 */
	function ipress_acf_field_category_term( $term, $category = false ) {

		// In a category archive?
		if ( false === $category && ! is_category() ) {
			return;
		}

		// Sanitize category name
		$category = ( false === $category ) ? get_query_var( 'category_name' ) : sanitize_key( $category );

		// Get the category by slug name
		$category = get_term_by( 'slug', $category, 'category' );

		// Return category term
		return get_option( 'category_' . $category->term_id . '_' . sanitize_key( $term ) );
	}
endif;
