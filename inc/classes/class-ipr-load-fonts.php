<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Initialisation for theme external Google fonts using API v2
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
	 *
	 * @todo: Add ability to load downloaded fonts locally via header style
	 */
	final class IPR_Load_Fonts extends IPR_Registry {

		/**
		 * Font processing error
		 *
		 * @var array $font_error default []
		 */
		private $font_error = [];

		/**
		 * List of enqueued font IDs
		 *
		 * @var array $font_id default []
		 */
		private $font_id = [];

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Fonts & typography
			add_action( 'wp_enqueue_scripts', [ $this, 'load_fonts' ], 12 );
			
			// Preload font resources
			add_filter( 'wp_resource_hints', [ $this, 'resource_hints' ], 10, 2 );

			// Activate admin notices, process errors if set
			add_action( 'admin_notices', [ $this, 'admin_notices' ] );
		}

		//------------------------------------------------
		// Initialisation & Hook Functions
		//------------------------------------------------

		/**
		 * Load custom fonts, via Google Fonts API v2
		 *
		 * [
		 *   [
		 *   	'family' => 'Montserrat',
		 *   	'weight'=> [
		 *   		'normal' => [ 300, 500, '600:900' ],
		 *   		'italic' => [ 400, 600 ]
		 *   	],
		 *   	'display' => 'swap',
		 *   	'media' => 'screen'
		 *   ],
		 *   [
		 *   	'family' => 'Roboto',
		 *   	'weight' => [ 
		 *   		'normal' => [ 300, 500 ] 
		 *   	],
		 *   	'display' => 'swap',
		 *   ],
		 *   [
		 *   	'family' => 'Crimson Pro',
		 *   	'weight' => [ 
		 *   		'italic' => [ 300, '500:700' ] 
		 *   	]
		 *   ],
		 *   [
		 *   	'family' => 'Poppins',
		 *   	'weight' => [ 300, '500:700' ] 
		 *   	]
		 *   ],
		 *   [
		 *   	'family' => 'Open Sans',
		 *   ]
		 * ]
		 */
		public function load_fonts() {

			// Retrieve theme fonts, if used
			$ip_fonts = (array) apply_filters( 'ipress_fonts', [] );

			// Iterate fonts, enqueue font urls
			$ip_fonts && array_walk( $ip_fonts, function( $font, $key ) {
			
				// Must be an array... set the font error
				if ( ! is_array( $font ) ) {
					$this->font_error[] = 'Config Error: Font sub-items must be an array';
					return;
				}

				// We have requirements... admin notice
				if ( ! isset( $font['family'] ) ) {
					$this->font_error[] = 'Config Error: Font family must be an set';
					return;		
				}

				// Process font family
				$font_family = $this->set_font_family( $font );

				// Construct font: family & subset
				$query_args = [
					'family' => $font_family
				];

				// Set font display?
				if ( isset( $font['display'] ) && in_array( $font['display'], [ 'auto', 'block', 'swap', 'fallback', 'optional' ], true ) ) {
					$query_args['display'] = $font['display'];
				} else {
					// Filterable per font option to display if not set, default browser define (auto)
					$ip_font_display = apply_filters( 'ip_font_display', false, $font['family'] );
					if ( false !== $ip_font_display ) {
						$query_args['display'] = $ip_font_display;
					}
				}

				// Set fonts url
				$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );

				// Sanitize multi-family arguments forcing array indeces in url: [d+], deprecated			
				$font_url = preg_replace( '/%5B\d+%5D/', '', $font_url );

				// Set media type: 'all|screen|print|handheld'
				$font_media = ( isset( $font['media'] ) && in_array( $font['media'], [ 'all', 'screen', 'print', 'handheld' ], true ) ) ? $font['media'] : 'all';

				// Set font ID
				$font_id = sprintf( 'ipress-font-%s', strtolower( str_replace( ' ', '_', $font['family'] ) ) );

				// Add to running total...
				$this->font_id[] = $font_id;

				// Register & enqueue css style file for later use, one per font with unique ID
				wp_enqueue_style( $font_id, $font_url, [], null, $font_media );
			} );
		}

		/**
		 * Process font family to:
		 *
		 * Montserrat:ital,wght@0,300;0,500;0,600..900;1,400;1,600&display=swap
		 * Roboto:wght@300;500&display=auto
		 * Crimson+Pro:ital,wght@1,300;1,500..9007&display=auto
		 * Poppins:wght@300;500..700&display=auto
		 * Open+Sans&display=auto
		 *
		 * @param array $font List of fonts to process
		 * @return string
		 */
		private function set_font_family( $font ) {

			// Set the family...
			$font_family = str_replace( ' ', '+', $font['family'] );

			// No font weight?
			if ( ! isset( $font['weight'] ) ) {
				return $font_family;
			}

			// Process italic font
			if ( array_key_exists( 'italic', $font['weight'] ) ) {
				return $this->set_font_italic( $font_family, $font['weight'] );
			}

			return $this->set_font_normal( $font_family, $font['weight'] );
		}

		/**
		 * Process normal font
		 *
		 * @param string $font_family List of fonts to process
		 * @param array $font_weight Font weights
		 * @return string
		 */
		private function set_font_italic( $font_family, $font_weights ) {

			// Initialise weights
			$n_weights = $i_weights = [];

			// Initialise weight
			$font_weight = 'ital,wght@';

			// Process normal if available
			if ( isset( $font_weights['normal'] ) ) {

				// Get values
				$normal = $font_weights['normal'];

				// Iterate weights 
				foreach ( $normal as $k => $weight ) {

					// Test for range...
					if ( false !== strpos( $weight, ':' ) ) {
						$n_weights[] = join( '..', array_map( 'trim', explode( ':', $weight ) ) );
						continue;
					}

					// Otherwise standard value...
					$n_weights[] = trim( $weight );
				}

				// Sort weights alpha-numerically
				natsort( $n_weights );

				// Format weights
				$n_weights = array_map( function( $weight ) {
					return '0,' . $weight;
				}, $n_weights );
			}

			// Process Italics
			$italic = $font_weights['italic'];

			// Iterate weights 
			foreach ( $italic as $k => $weight ) {

				// Test for range...
				if ( false !== strpos( $weight, ':' ) ) {
					$i_weights[] = join( '..', array_map( 'trim', explode( ':', $weight ) ) );
					continue;
				}

				// Otherwise standard value...
				$i_weights[] = trim( $weight );
			}

			// Sort weights alpha-numerically
			natsort( $i_weights );

			// Format weights
			$i_weights = array_map( function( $weight ) {
				return '1,' . $weight;
			}, $i_weights );
			$weights = ( empty( $n_weights ) ) ? $i_weights : array_merge( $n_weights, $i_weights ); 

			return sprintf( '%1$s:%2$s%3$s', $font_family, $font_weight, join( ';', $weights ) );
		}

		/**
		 * Process normal font
		 *
		 * @param string $font_family List of fonts
		 * @param array $font_weight
		 * @return string
		 */
		private function set_font_normal( $font_family, $font_weights ) {

			// Normal or just values
			$normal = ( array_key_exists( 'normal', $font_weights ) ) ? $font_weights['normal'] : $font_weights;

			// Initialise weight
			$font_weight = 'wght@';

			// Initialise weights
			$weights = [];

			// Iterate weights 
			foreach ( $normal as $k => $weight ) {

				// Test for range...
				if ( false !== strpos( $weight, ':' ) ) {
					$weights[] = join( '..', array_map( 'trim', explode( ':', $weight ) ) );
					continue;
				}

				// Otherwise standard value...
				$weights[] = trim( $weight );
			}

			// Sort weights alpha-numerically
			natsort( $weights );

			return sprintf( '%1$s:%2$s%3$s', $font_family, $font_weight, join( ';', $weights ) );
		}

		/**
		 * Add preconnect for Google Fonts
		 *
		 * @param array $urls URLs to print for resource hints
		 * @param string $relation_type The relation type the URLs are printed
		 * @return array $urls
		 */
		public function resource_hints( $urls, $relation_type ) {

			// Make sure we're using the right type, default preconnect
			$ip_font_resource_hint_type = apply_filters( 'ipress_font_resource_hint_type', 'preconnect' );
			$has_crossorigin_support = version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' );

			// If we have queued fonts...
			if ( $this->has_font_style() ) {

				if ( $ip_font_resource_hint_type === $relation_type ) {

					if ( $has_crossorigin_support && 'preconnect' === $ip_font_resource_hint_type ) {
						$urls[] = [
							'href' => 'https://fonts.gstatic.com',
							'crossorigin',
						];

						$urls[] = [
							'href' => 'https://fonts.googleapis.com',
							'crossorigin',
						];
					} else {
						$urls[] = 'https://fonts.gstatic.com';
						$urls[] = 'https://fonts.googleapis.com';
					}
				}

				if ( 'dns-prefetch' !== $ip_font_resource_hint_type ) {
					$googleapis_index = array_search( 'fonts.googleapis.com', $urls );

					if ( false !== $googleapis_index ) {
						unset( $urls[ $googleapis_index ] );
					}
				}
			}

			return (array) apply_filters( 'ipress_font_resource_hints', $urls );
		}

		/**
		 * Check the queued styles for valid google fonts
		 */
		private function has_font_style() : bool {
			foreach ( $this->font_id as $font_id ) {
				if ( wp_style_is( $font_id, 'queue' ) ) {
					return true;
				}
			}
			return false;
		}

		//----------------------------------------------
		//	Font Error
		//----------------------------------------------

		/**
		 * Adds a message if a font processing error occurs
		 */
		public function admin_notices() {
			if ( $this->font_error ) {
				$message = array_reduce( $this->font_error, function( $carry, $item ) {
					return sprintf( '%1$s<span>%2$s</span>', $carry, trim( $item ) );
				} );
				echo sprintf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
			}
		}

		/**
		 * Get the version error
		 */
		public function has_error() : bool {
			return empty( $this->font_error ) ? false : true;
		}

		/**
		 * Get the version error
		 */
		public function get_error() : array {
			return $this->font_error;
		}
	}

endif;

// Instantiate Font Loader class
return IPR_Load_fonts::Init();
