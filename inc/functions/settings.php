<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme customizer settings functions.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
// Theme Settings & Options
// - Map custom settings in customizer
//----------------------------------------------

if ( ! function_exists( 'ipress_get_defaults' ) ) :
	
	/**
	 * Set default theme options
	 * 
	 * @return array
	 */
	function ipress_get_defaults() {
		return (array) apply_filters(
			'ipress_option_defaults',
			[ 
				'retina_logo' => '',
				'title_and_tagline' => true,
				'breadcrumbs' => false,
				'back_to_top' => true,
				'header_js' => false,
				'footer_js' => false,
				'header_admin_js' => false,
				'footer_admin_js' => false,
				'theme_colors' => [],
				'hero_title' => '',
				'hero_description' => '',
				'hero_button_link' => '',
				'hero_button_text' => '',
				'hero_image' => '',
				'hero_background_color' => '',
				'hero_overlay' => '',
				'hero_overlay_color' => '',
				'hero_overlay_opacity' => '',
				'woocommerce_breadcrumbs' => false,
				'woocommerce_product_pagination' => true,
				'woocommerce_product_search' => true,
			]
		);
	}
endif;

if ( ! function_exists( 'ipress_get_color_defaults' ) ) :
	
	/**
	 * Set default theme color options, via scss mapping
	 *
	 * @return array
	 */
	function ipress_get_color_defaults() {
		return (array) apply_filters( 'ipress_color_option_defaults', [] );
	}
endif;

if ( ! function_exists( 'ipress_get_default_color_palette' ) ) :
	
	/**
	 * Set up filterable palette for the color picker
	 *
	 * @return array
	 */
	function ipress_get_default_color_palette() {
		return (array) apply_filters(
			'ipress_default_color_palette',
			[
				'#000000',
				'#FFFFFF',
				'#F1C40F',
				'#E74C3C',
				'#1ABC9C',
				'#1e72bd',
				'#8E44AD',
				'#00CC77',
			]
 		);
	}
endif;

if ( ! function_exists( 'ipress_get_options' ) ) :

	/**
	 * Retrieve theme setting
	 *
	 * @param boolean $merge_defaults Merge stored options with defaults, default true
	 * @return array
	 */
	function ipress_get_options( $merge_defaults = true ) {

		// Retrieve theme settings
		$defaults = ipress_get_defaults();

		// Merge defaults with stored settings if set, or just stored options
		$options = ( true === $merge_defaults ) ? wp_parse_args(
			get_option( 'ipress_settings', [] ),
			$defaults
		) : get_option( 'ipress_settings', [] );
		return $options;
	}
endif;

if ( ! function_exists( 'ipress_get_option' ) ) :

	/**
	 * Retrieve single theme setting
	 *
	 * @param string $option Option name to look up
	 * @param string $default Default value if no option value set
	 * @return string
	 */
	function ipress_get_option( $option, $default = null ) {

		// Retrieve theme settings
		$defaults = ipress_get_defaults();

		// Not a valid default setting? 
		if ( ! array_key_exists( $option, $defaults ) ) { 
			return $default;
		}

		// Merge defaults with stored settings
		$options = wp_parse_args(
			get_option( 'ipress_settings', [] ),
			$defaults
		);
		return $options[ $option ];
	}
endif;

if ( ! function_exists( 'ipress_get_theme_colors' ) ) :

	/**
	 * Retrieve theme colors
	 * 
	 * - mapped to scss
	 * 
	 * @return array $colors
	 */
	function ipress_get_theme_colors() {

		// Get theme colours from theme defaults
		$theme_colors = ipress_get_option( 'theme_colors' );
		if ( empty( $theme_colors ) ) { return []; }

		// Construct & return array of colours 
		return array_map( function ( $color ) {
			return [
				'slug' => $color['slug'],
				'color' => $color['color']
			];
		}, $theme_colors );
	}
endif;

// End
