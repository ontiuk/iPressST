<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Initialisation for theme external Google fonts.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Load_Fonts' ) ) :

	/**
	 * Set up theme fonts
	 */
	final class IPR_Load_Fonts {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Fonts & typography
			add_action( 'wp_enqueue_scripts', [ $this, 'load_fonts' ], 12 );
		}

		//------------------------------------------------
		// Initialisation & Hook Functions
		//------------------------------------------------

		/**
		 * Load custom font families, default google fonts.
		 *
		 * [
		 *   'family' => [
		 *   	[
		 *   		'font-family' 	=> 'Font-name',
		 *   		'font-weight'	=> [ 300, 500 ]
		 *   		'font-style'	=> 'normal'
		 *   	],
		 *   	[
		 *   		'font-family' 	=> 'Font-name',
		 *   		'font-weight'	=> [ 300, 500 ]
		 *   		'font-style'	=> 'normal'
		 *   	]
		 *   ],
		 *   media = 'all'
		 * ]
		 */
		public function load_fonts() {

			// Retrieve theme fonts, if used
			$ip_fonts = (array) apply_filters( 'ipress_fonts', [] );
			if ( empty( $ip_fonts ) ) {
				return;
			}

			// Process font families
			$family = $this->set_font_family( $ip_fonts['family'] );

			// Construct font: family & subset
			$query_args = [
				'family' 	=> $family,
				'display' 	=> 'swap'
			];

			// Set fonts url
			$ip_fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );

			// Sanitize multi family arguments forcing array indeces in url: [d+]			
			$ip_fonts_url = preg_replace( '/%5B\d+%5D/', '', $ip_fonts_url );

			// Set media type: 'all|screen|print|handheld'
			$ip_fonts_media = ( isset( $ip_fonts['media'] ) && in_array( $ip_fonts['media'], [ 'all', 'screen', 'print', 'handheld' ], true ) ) ? $ip_fonts['media'] : 'all';

			// Register & enqueue css style file for later use
			wp_enqueue_style( 'ipress-fonts', $ip_fonts_url, [], null, $ip_fonts_media );
		}

		/**
		 * Process font family
		 *
		 *  [
		 *  	'font-family' 	=> 'Font-name',
		 *  	'font-weight'	=> [ 300, 500 ]
		 *  ]
		 *  to
		 *	[
		 *		Montserrat:wght@600;700,
		 *		Roboto:wght@300;400;500
		 *	]
		 *
		 * @param array $args
		 * @return array
		 */
		private function set_font_family( $args ) {
			
			// Return an array of families
			$families = [];
			
			// Process font families
			foreach ( $args as $family ) {
				$families[] = $family['font-family'] . ':' . 'wght@' . join( ';', $family['font-weight'] );
			}

			// Ok, done
			return $families;
		}
	}

endif;

// Instantiate Font Loader class
return new IPR_Load_fonts;
