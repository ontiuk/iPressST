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
	 * @return integer
	 */
	 function ipress_sanitize_image( $image ) {
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

if ( ! function_exists( 'ipress_sanitize_hex_color' ) ) {

	/**
	 * Sanitize colors, allowing blank and custom css variables
	 *
	 * @param string $color The input color
	 * @return string | boolean
	 */
	function ipress_sanitize_hex_color( $color ) {

		// No colour passed
		if ( '' === $color ) {
			return '';
		}

		// Hex values - 3 or 6 digits
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		// Sanitize CSS variables as text field
		if ( strpos( $color, 'var(' ) !== false ) {
			return sanitize_text_field( $color );
		}

		// Sanitize rgb() values
		if ( strpos( $color, 'rgb(' ) !== false ) {
			$color = str_replace( ' ', '', $color );

			sscanf( $color, 'rgb(%d,%d,%d)', $red, $green, $blue );
			return 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
		}

		// Sanitize rgba() values
		if ( strpos( $color, 'rgba' ) !== false ) {
			$color = str_replace( ' ', '', $color );
			sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

			return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
		}

		return '';
	}
}

if ( ! function_exists( 'ipress_sanitize_rgb_color' ) ) {

	/**
	 * Sanitize standard RGB colors, allowing blank
	 *
	 * @param string $color The input color
	 * @return string
	 */
	function ipress_sanitize_rgb_color( $color ) {

		// No colour passed
		if ( '' === $color ) {
			return '';
		}

		// Sanitize rgb() values.
		if ( strpos( $color, 'rgb(' ) !== false ) {
			$color = str_replace( ' ', '', $color );

			sscanf( $color, 'rgb(%d,%d,%d)', $red, $green, $blue );
			return 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
		}

		return '';
	}
}

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
			return ipress_sanitize_hex_color( $color );
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
			$validity->add( 'categories_format', __( 'Comma separated list of category IDs only.', 'ipress-standalone' ) );
		}
		return $validity;
	}
endif;
