<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for theme and plugin styles.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Load_Styles' ) ) :

	/**
	 * Set up theme and plugin styles
	 */
	final class IPR_Load_Styles extends IPR_Registry {

		/**
		 * Styles settings
		 *
		 * @var array $settings
		 */
		protected $settings = [
			'core' 			=> [],
			'admin' 		=> [],
			'external' 		=> [],
			'styles' 		=> [],
			'page' 			=> [],
			'post_type' 	=> [],
			'taxonomy' 		=> [],
			'store'			=> [],
			'front' 		=> [],
			'login' 		=> [],
			'custom' 		=> [],
			'inline' 		=> [],
			'attr' 			=> [],
		];

		/**
		 * Media load types
		 *
		 * @var array $media
		 */
		private $media = [
			'all',
			'screen',
			'print',
			'handheld',
		];

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Set up styles
			add_action( 'wp', [ $this, 'settings' ] );
			add_action( 'admin_init', [ $this, 'admin_settings' ] );

			// Load admin styles
			add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_styles' ], 10 );

			// Login page styles
			add_action( 'login_enqueue_scripts', [ $this, 'load_login_styles' ], 10 );

			// Add styles attributes
			add_filter( 'style_loader_tag', [ $this, 'add_styles_attr' ], 10, 3 );

			// Header Inline CSS
			add_action( 'admin_head', [ $this, 'header_admin_styles' ], 12 );

			// Front-end only
			if ( is_admin() ) {
				return;
			}

			// Core styles
			add_action( 'wp_enqueue_scripts', [ $this, 'load_core_styles' ], 10 );

			// Main styles
			add_action( 'wp_enqueue_scripts', [ $this, 'load_styles' ], 12 );

			// Header Inline CSS
			add_action( 'wp_head', [ $this, 'header_styles' ], 12 );
		}

		//------------------------------------------------
		// Core Registry Functions
		//------------------------------------------------

		/**
		 * Set a style setting by key
		 *
		 * @param string $key Style key type
		 * @param mixed $value Style key value
		 */
		public function __set( $key, $value ) {
			throw new Exception( __( 'Style settings should be set via initialisation function', 'ipress' ) );
		}

		/**
		 * Get a style setting by key
		 *
		 * @param string $key Style key type
		 * @return mixed
		 */
		public function __get( $key ) {
			return ( array_key_exists( $key, $this->settings ) ) ? $this->settings[$key] : null;
		}

		/**
		 * Test if a setting exists
		 *
		 * @param string $key Style key type
		 * @return boolean
		 */
		public function __isset( $key ) {
			return isset( $this->settings[$key] );
		}

		//------------------------------------------------
		// Initialisation
		//------------------------------------------------

		/**
		 * Initialise main style settings
		 *
		 * - Set to config value if available or [] if not
		 */
		public function settings() {

			// Retrieve config: styles
			$ip_styles = (array) apply_filters( 'ipress_styles', [] );
			if ( $ip_styles ) {

				// Filter non-admin settings
				$settings = array_filter( $this->settings, function( $v, $k ) { 
					return $k !== 'admin'; 
				}, ARRAY_FILTER_USE_BOTH );

				// Initialise settings key:value pairs
				array_walk( $settings, function( $item, $key, $styles ) {
					$this->settings[$key] = ( array_key_exists( $key, $styles ) && is_array( $styles[$key] ) ) ? $styles[$key] : [];
				}, $ip_styles );
				
				// Pre-sanitize inline values
				$inline = [];
				foreach( $this->inline as $key => $value ) {
					$handle = sanitize_key( $key );
					$inline[$handle] = $value;
				}
				$this->settings['inline'] = $inline;
			}
		}

		/**
		 * Initialise admin style settings
		 *
		 * - Set to config value if available or [] if not
		 */
		public function admin_settings() {

			// Retrieve config: styles & initialise admin setting
			$ip_styles = (array) apply_filters( 'ipress_styles', [] );
			if ( $ip_styles ) {
				$this->settings['admin'] = ( array_key_exists( 'admin', $ip_styles ) && is_array( $ip_styles['admin'] ) ) ? $ip_styles['admin'] : [];
			}
		}

		//----------------------------------------------
		//	Core Styles
		//----------------------------------------------

		/**
		 * Load Theme CSS styles files in hierarchy order
		 */
		public function load_core_styles() {

			// Set up core styles
			$ip_styles_core = (array) apply_filters( 'ipress_styles_core', array_map( 'sanitize_key', $this->core ) );
				
			// Enqueue styles, pre-sanitized
			$ip_styles_core && array_walk( $ip_styles_core, function( $style, $k ) {
				wp_enqueue_style( $style );
			} );
		}

		//----------------------------------------------
		//	Admin Styles
		//----------------------------------------------

		/**
		 * Load admin styles
		 *
		 * @param string $hook Style hook to validate
		 */
		public function load_admin_styles( $hook ) {

			// Register & enqueue admin styles if available
			$admin_styles = $this->admin;
			$admin_styles && array_walk( $admin_styles, function( $style, $handle ) use ( $hook ) {

				// Get hook page
				$hook_page = array_shift( $style );

				// Check hook page & enqueue if matches
				if ( $hook_page === $hook ) {

					// Register and enqueue style in header by default
					$this->enqueue_style( $style, $handle, false );
				}
			} );
		}

		//----------------------------------------------
		//	Styles
		//----------------------------------------------

		/**
		 * Load Theme CSS styles files in hierarchy order
		 */
		public function load_styles() {
			
			// Register & enqueue external library styles, no inline
			$external_styles = $this->external;
			$external_styles && array_walk( $external_styles, function( $style, $handle ) {
				$this->enqueue_style( $style, $handle );
			}, false );

			// Register & enqueue main styles
			$main_styles = $this->styles;
			$main_styles && array_walk( $main_styles, function( $style, $handle ) {
				$this->enqueue_style( $style, $handle );
			} );

			// Register and enqueue page template styles
			$page_styles = $this->page;
			$page_styles && array_walk( $page_styles, function( $style, $handle ) {

				// Get style path
				$path = array_shift( $style );

				// Check for active page template
				if ( is_page_template( $path ) ) {
					$this->enqueue_style( $style, $handle );
				}
			} );

			// Register and enqueue post-type styles
			$post_type_styles = $this->post_type;
			$post_type_styles && array_walk( $post_type_styles, function( $style, $handle ) {

				// Get style path
				$post_type = array_shift( $style );

				// Check for active page template
				if ( is_post_type_archive( $post_type ) || is_singular( $post_type ) ) {
					$this->enqueue_style( $style, $handle );
				}
			} );

			// Register and enqueue taxonomy styles
			$taxonomy_styles = $this->taxonomy;
			$taxonomy_styles && array_walk( $taxonomy_styles, function( $style, $handle ) {

				// Get style path
				$tax_term = array_shift( $style );
				
				// Check for active page template
				if ( is_array( $tax_term ) ) {
					[ $taxonomy, $term ] = $tax_term;
					if ( is_tax( $taxonomy, $term ) ) {
						$this->enqueue_style( $style, $handle );
					}
				} else {
					if ( is_tax( $tax_term ) ) {
						$this->enqueue_style( $style, $handle );
					}
				}
			} );

			// Register & enqueue WooCommerce store page template styles
			if ( ipress_wc_active() ) {

				$store_styles = $this->store;
				$store_styles && array_walk( $store_styles, function( $style, $handle ) {

					// Get style pathn
					$path = array_shift( $style );

					// Check condition
					switch ( $path ) {
						case 'shop':
							if ( is_shop() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;
						case 'cart':
							if ( is_cart() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;
						case 'checkout':
							if ( is_checkout() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;
						case 'account':
							if ( is_account_page() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;
						case 'product':
							if ( is_product() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;
						case 'store':
							if ( is_woocommerce() || is_shop() || is_product() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;
						case 'front':
							if ( is_front_page() ) {
								$this->enqueue_style( $style, $handle );
							}
							break;							
						case 'front-store':
							if ( is_front_page() || ( is_woocommerce() || is_shop() || is_product() ) ) {
								$this->enqueue_style( $style, $handle );
							}
							break;														
						case 'all':
							$this->enqueue_style( $style, $handle );
							break;														
						default:
							break;
					}
				} );
			}

			// Register & enqueue front page styles
			if ( is_front_page() ) {
				$front_page_styles = $this->front;
				$front_page_styles && array_walk( $front_page_styles, function( $style, $handle ) {
					$this->enqueue_style( $style, $handle );
				} );
			}

			// Register & enqueue custom styles
			$custom_styles = $this->custom;
		   	$custom_styles && array_walk( $custom_styles, function( $style, $handle ) {

				// Register style
				$this->enqueue_style( $style, $handle );

				// Add style data
				wp_style_add_data( $handle, 'rtl', 'replace' );
			} );
		}

		/**
		 * Enqueue & register styles
		 *
		 * @param string $style Style name to process
		 * @param string $handle Handle to associate with style
		 * @param boolean $inline Process inline, default true
		 */
		private function enqueue_style( $style, $handle, $inline = true ) {

			// Sanitize $handle
			$handle = sanitize_key( $handle );

			// Set media type, default 'all', or force print style
			$media = ( isset( $style[3] ) && in_array( $style[3], $this->media, true ) ) ? $style[3] : 'all';

			// Register and enqueue style
			wp_register_style( $handle, $style[0], $style[1], $style[2], $media );
			wp_enqueue_style( $handle );

			// Set optional style attribute
			if ( array_key_exists( $handle, $this->attr ) ) {
				$this->set_style_attr( $handle );
			}

			// Inject associated inline style
			if ( $inline && array_key_exists( $handle, $this->inline ) ) {
				$this->set_inline_style( $handle );
			}
		}

		/**
		 * Set script attributes to matching handles
		 *
		 * @param string $handle Script handle to process
		 */
		private function set_script_attr( $handle ) {

			// Get attributes if set, pre-sanitized. non-empty
			$attr = $this->attr[$handle];
			if ( ! $attr ) { return; }

			// Sort attr into types, should not have async and defer for the same handle
			$defer = ( isset( $attr['defer'] ) && $attr['defer'] ) ? true : false;
			$async = ( isset( $attr['async'] ) && $attr['async'] ) ? true : false;

			// Add defer or async, can't have both
			if ( true === $defer ) {
				wp_style_add_data( $handle, 'defer', true );
			} elseif ( true === $async ) {
				wp_style_add_data( $handle, 'async', true );
			}

			// Add integrity & crossorigin, attribute required
			$integrity = ( isset( $attr['integrity'] ) ) ? $attr['integrity'] : false;
			if ( $integrity ) {
				wp_style_add_data( $handle, 'integrity', $integrity );
				wp_style_add_data( $handle, 'crossorigin', 'anonymous' );
			}
			
			// Add crossorigin if not already done, attribute required
			$crossorigin = ( isset( $attr['crossorigin'] ) ) ? $attr['crossorigin'] : false;
			if ( $crossorigin ) {
				wp_style_add_data( $handle, 'crossorigin', $crossorigin );
			}		
		}

		/**
		 * Add inline styles
		 *
		 * @param string $handle Style handle to process
		 */
		private function set_inline_style( $handle ) {

			// Get inline handle if set, pre-sanitized
			$data = $this->inline[$handle];

			// Inject inline style inc handle
			if ( $data ) {
				$data = html_entity_decode( (string) $data, ENT_QUOTES, 'UTF-8' );
				wp_add_inline_style( $handle, $data );
			}
		}

		//----------------------------------------------
		//	Header & Footer Styles
		//----------------------------------------------

		/**
		 * Load inline header css
		 * - No <style></style> tag
		 */
		public function header_styles() {

			// Use filter to add styles, required
			$ip_header_styles = (string) apply_filters( 'ipress_header_styles', ipress_get_option( 'ipress_header_styles', '' ) );
			if ( $ip_header_styles ) {

				// Display output, in <style></style> tag
				echo sprintf( '<style>%s</style>', wp_filter_nohtml_kses( $ip_header_styles ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Load inline header admin css
		 * - No <style></style> tag
		 */
		public function header_admin_styles() {

			// Use filter to add styles
			$ip_header_admin_styles = (string) apply_filters( 'ipress_header_admin_styles', ipress_get_option( 'ipress_header_admin_styles', '' ) );
			if ( $ip_header_admin_styles ) {
		
				// Display output, in <style></style> tag
				echo sprintf( '<style>%s</style>', wp_filter_nohtml_kses( $ip_header_admin_styles ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		//----------------------------------------------
		//	Login Page Styles
		//----------------------------------------------

		/**
		 * Load login styles
		 */
		public function load_login_styles() {
			$login_styles = $this->login;
			$login_styles && array_walk( $login_styles, function( $style, $handle ) {
				$this->enqueue_style( $style, $handle );
			} );
		}

		//----------------------------------------------
		//	Style attributes - defer, async, integrity
		//----------------------------------------------

		/**
		 * Tag on style attributes to matching handles
		 *
		 * @param string $tag Script type
		 * @param string $handle Script handle to associate
		 * @param string $src Script src url
		 * @return string $tag
		 */
		public function add_styles_attr( $tag, $handle, $src ) {

			// Add async or defer
			foreach ( [ 'async', 'defer' ] as $attr ) {

				// Test if attribute set for handle
				if ( ! wp_styles()->get_data( $handle, $attr ) ) {
					continue;
				}

				// Prevent adding attribute when already added in trac #12009
				if ( ! preg_match( ":\s$attr(=|/>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=/>):', "$attr ", $tag, 1 );
				}

				// Only allow async or defer, not both
				break;
			}

			// OK, check integrity & add integrity SHA string
			$integrity = wp_styles()->get_data( $handle, 'integrity' );
			if ( $integrity ) {
				$tag = preg_replace( ':(?=/>):', 'integrity="' . $integrity . '" ', $tag, 1 );
			}

			// Add crossorigin for integrity if not already done
			$crossorigin = wp_styles()->get_data( $handle, 'crossorigin' );
			if ( $crossorigin ) {
				$tag = preg_replace( ':(?=/>):', 'crossorigin="' . $crossorigin . '" ', $tag, 1 );
			}

			return $tag;
		}
	}

endif;

// Instantiate Styles Loader class
return IPR_Load_Styles::Init();
