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
// ipress_acf_field_category_term
// ipress_acf_field_social
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
	 * @param boolean|integer $pid post_ID
	 * @param bool $format default true
	 * @return array
	 */
	function ipress_acf_fields( $pid = false, $format = true ) {
		$pid = ( false === $pid ) ? get_the_ID() : absint( $pid );
		return get_fields( $pid , $format );
	}
endif;

if ( ! function_exists( 'ipress_acf_field' ) ) :

	/**	
	 * Retrieve data by field name
	 *
	 * @param string $field ACF field name
	 * @param boolean|integer $pid default false
	 * @return mixed
	 */
	function ipress_acf_field( $field, $pid = false ) {
		$pid = ( false === $pid ) ? get_the_ID() : absint( $pid );
		return get_field( $field, $pid );
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
	 * @param boolean|integer $pid Post_ID, current post if false
	 * @return boolean|array|string|integer
	 */
	function ipress_acf_field_meta( $field, $pid = false ) {
		$pid = ( false === $pid ) ? get_the_ID() : absint( $pid );
		return get_post_meta( $pid, $field, true );
	}
endif;

if ( ! function_exists( 'ipress_acf_field_repeater' ) ) :

	/**
	 * Return repeater field values
	 *
	 * @param string $field Repeater field value
	 * @param array $fields Repeater subfield values
	 * @param boolean|integer $pid Post ID, current post if false
	 * @return array $result
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
	 * Return category term field values
	 *
	 * @param string $category Category name
	 * @param string $term Term name
	 * @return array $result
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
		return get_option( 'category_' . $category->term_id . '_' . sanitize_key( $term ) );
	}
endif;

if ( ! function_exists( 'ipress_acf_field_social' ) ) :

	/**
	 * Retrieve social media details from options page
	 *
	 * @return array
	 */
	function ipress_acf_field_social() {
		return apply_filters( 'ipress_acf_field_social', [
			'facebook' => get_field( 'facebook', 'option' ),
			'twitter'  => get_field( 'twitter', 'option' ),
			'youtube'  => get_field( 'youtube', 'option' ),
			'linkedin' => get_field( 'linkedin', 'option' )
		] );
	}	
endif;
