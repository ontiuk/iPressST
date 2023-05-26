<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Customizer functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
// Customizer Control Sanitization Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_sanitize_select' ) ) :

	/**
	 * Sanitize select
	 *
	 * @param string $input The input from the setting
	 * @param object $setting The selected setting
	 * @return string
	 */
	function ipress_sanitize_select( $input, $setting ) {
		$input = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ) ? $input : $setting->default;
	}
endif;

if ( ! function_exists( 'ipress_sanitize_checkbox' ) ) :
	
	/**
	 * Sanitize boolean for checkbox
	 *
	 * @param bool $checked Whether or not a box is checked
	 */
	 function ipress_sanitize_checkbox( $checked ) : bool {
		return ( isset( $checked ) && true === $checked ) ? true : false;
	}
endif;

if ( ! function_exists( 'ipress_sanitize_image' ) ) :
	
	/**
	 * Sanitize integer for image ID
	 *
	 * @param integer $image Image ID
	 * @param object $setting The selected setting
	 * @return integer
	 */
	 function ipress_sanitize_image( $image, $setting ) {
		return intval( $image );
	}
endif;

if ( ! function_exists( 'ipress_sanitize_integer' ) ) :
	
	/**
	 * Sanitize integer
	 *
	 * @param string $input The input from the setting
	 * @return integer
	 */
	 function ipress_sanitize_integer( $input ) {
		return absint( $input );
	}
endif;

if ( ! function_exists( 'ipress_sanitize_decimal_integer' ) ) :
	
	/**
	 * Sanitize integers that can use decimals
	 *
	 * @param string $input The input from the setting
	 * @return integer
	 */
	 function ipress_sanitize_decimal_integer( $input ) {
		return abs( floatval( $input ) );
	}
endif;

if ( ! function_exists( 'ipress_sanitize_empty_decimal_integer' ) ) :
	
	/**
	 * Sanitize integers that can use decimals
	 *
	 * @param string $input The input from the setting
	 * @return int|float
	 */
	 function ipress_sanitize_empty_decimal_integer( $input ) {
		return ( '' === $input ) ? '' : abs( floatval( $input ) );
	}
endif;

if ( ! function_exists( 'ipress_sanitize_empty_negative_decimal_integer' ) ) :
	
	/**
	 * Sanitize integers that can use negative decimals
	 *
	 * @param string $input The input from the setting
	 * @return float
	 */
	 function ipress_sanitize_empty_negative_decimal_integer( $input ) {
		return ( '' === $input ) ? '' : floatval( $input );
	}
endif;

if ( ! function_exists( 'ipress_sanitize_empty_absint' ) ) :
	
	/**
	 * Sanitize a positive number, but allow an empty value
	 *
	 * @param string $input The input from the setting
	 * @return integer | string
	 */
	 function ipress_sanitize_empty_absint( $input ) {
		return ( '' === $input ) ? '' : absint( $input );
	}
endif;

if ( ! function_exists( 'ipress_sanitize_rgba_color' ) ) :
	
	/**
	 * Sanitize RGBA color
	 *
	 * @param string $input The color from the setting
	 * @return string
	 */
	 function ipress_sanitize_rgba_color( $color ) {

		// Make sure we're passing something
		if ( '' === $color ) {
			return '';
		}

		// If string does not start with 'rgba', then treat as hex
		if ( false === strpos( $color, 'rgba' ) ) {
			return sanitize_hex_color( $color );
		}

		// Sanitize rgba formatted text
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

		// Return valid rgba format
		return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
	}
endif;

if ( ! function_exists( 'ipress_sanitize_choices' ) ) :
	
	/**
	 * Sanitize select choices
	 *
	 * @param string $input The input from the setting
	 * @param object $setting The setting object
	 * @return string
	 */
	 function ipress_sanitize_choices( $input, $setting ) {
		
		// Ensure input is a slug
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it, otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
endif;

//----------------------------------------------
// Customizer Control Validation Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_validate_categories' ) ) :
	
	/**
	 * Validate categories list
	 *
	 * @param object $validity
	 * @param string $categories
	 * @return bool $validity
	 */
	 function ipress_validate_categories( $validity, $categories ) {

		// Must be format xx,xx,xx +/- spaces
		if ( ! preg_match( '/^[\d\s,]+$/', $categories ) ) {
			$validity->add( 'categories_format', __( 'Comma separated list of category IDs only.', 'ipress' ) );
		}
		return $validity;
	}
endif;
