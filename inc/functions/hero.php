<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Child theme front-page hero functions.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------
// Hero CSS
//----------------------------------

if ( ! function_exists( 'ipress_hero_css' ) ) :
	
	/**
	 * Retrieve hero image if set
	 *
	 * @return string
	 */
	function ipress_hero_css() {

		// Get theme values, default ''
		$ip_hero_background_color = get_theme_mod( 'ipress_hero_background_color', '' );
		$ip_hero_overlay_color = get_theme_mod( 'ipress_hero_overlay_color', '' );
		$ip_hero_overlay_opacity = get_theme_mod( 'ipress_hero_overlay_opacity', 0 );

		// Initiate CSS
		$css = new IPR_CSS;

		// Add selector and property: .hero
		if ( $ip_hero_background_color ) {
			$css->set_selector( '.hero' );
			$css->add_property( 'background-color', $ip_hero_background_color );
		}

		// Add selector and properties: .hero-overlay
		if ( $ip_hero_overlay_color || $ip_hero_overlay_opacity ) {
			$css->set_selector( '.hero-overlay' );
		}

		if ( $ip_hero_overlay_color ) {
			$css->add_property( 'background-color', $ip_hero_overlay_color );
		}

		if ( $ip_hero_overlay_opacity ) {
			$css->add_property( 'opacity', $ip_hero_overlay_opacity );
		}
		return ( $css->has_css() ) ? $css->css_output() : '';
	}
endif;

if ( ! function_exists( 'ipress_hero_css_output' ) ) :

	/**
	 * Output header css for hero section if in use
	 */
	function ipress_hero_css_output() {

		// Process Hero CSS if active
		$ip_custom_hero = (bool) apply_filters( 'ipress_custom_hero', true );
		if ( true === $ip_custom_hero ) {

			// Output CSS if set
			$ip_hero_css = ipress_hero_css();
			if ( $ip_hero_css ) {
				echo sprintf( '<style id="hero-css">%s</style>', esc_html( wp_strip_all_tags( $ip_hero_css ) ) );
			}
		}
	}
endif;

//----------------------------------
// Hero Image & Background
//----------------------------------

if ( ! function_exists( 'ipress_hero_image' ) ) :
	
	/**
	 * Retrieve hero image if set
	 *
	 * @return string
	 */
	function ipress_hero_image() {

		// Get hero image if set default 0
		$ip_hero_image_id = (int) get_theme_mod( 'ipress_hero_image', 0 );
		if ( $ip_hero_image_id > 0 ) {

			// Hero image details
			$hero_image = wp_get_attachment_image_src( $ip_hero_image_id, 'hero-image' );
			$hero_image_alt = trim( strip_tags( get_post_meta( $ip_hero_image_id, '_wp_attachment_image_alt', true ) ) );

			// Reconstruct image params
			list( $hero_image_src, $hero_image_width, $hero_image_height ) = $hero_image;

			// Set hero image class, default none
			$ip_hero_image_class = (array) apply_filters( 'ipress_hero_image_class', [] );
			if ( $ip_hero_image_class ) {
				$ip_hero_image_class = sprintf( 'class="%1$s"', join( ', ', array_map( 'sanitize_html', $ip_hero_image_class ) ) );
			}	
					
			// Set hero image
			$hero_image_hw = image_hwstring( $hero_image_width, $hero_image_height );

			return sprintf( '<img %1$s src="%2$s" %3$s alt="%4$s" />', $ip_hero_image_class, $hero_image_src, trim( $hero_image_hw ), $hero_image_alt );
		}

		return false;
	}
endif;

if ( ! function_exists( 'ipress_hero_image_size' ) ) :

	/**
	 * Add custom hero image size
	 *
	 * @param array $sizes Image sizes
	 * @return array $sizes
	 */
	function ipress_hero_image_size( $sizes ) {
		$ip_custom_hero = (bool) apply_filters( 'ipress_custom_hero', true );
		if ( true === $ip_custom_hero ) {
			$sizes['hero-image'] = [ 1080 ];
		}
		return $sizes;
	}
endif;

// End
