<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme functions & functionality
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Schema Functionality
//	
//	- ipress_schema
//	- ippres_has_schema
//----------------------------------------------

if ( ! function_exists( 'ipress_schema' ) ) :

	/**
	 * Schema functionality displaying Schema.org microdata
	 *
	 * @param	string	$context
	 * @param	array	$attr	default array
	 * @return	string
	 */
	function ipress_schema( $context, $attr = [] ) {

		// Generate filterable context related schema attributes
		$attr = (array) apply_filters( "ipress_schema_{$context}", $attr, $context );

		// Initiate schema markup
		$output = '';

		// Iterate through attributes
		foreach ( $attr as $key => $value ) {

			// Nothing to do...
			if ( ! $value ) { continue; }

			// Generate output by type
			$output .= ( true === $value ) ? esc_html( $key ) . ' ' : sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
		}

		// Filterable context related markup
		$output = apply_filters( "ipress_schema_{$context}_output", $output, $attr, $context );

		// Return formatted schema markup
		return trim( $output );
	}
endif;

if ( ! function_exists( 'ipress_has_schema' ) ) :

	/**
	 * Schema functionality displaying Schema.org microdata
	 *
	 * @return	boolean	default false
	 */
	function ipress_has_schema() {
		return (bool) apply_filters( 'ipress_schema_microdata', false );
	}
endif;

//end
