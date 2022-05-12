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
	 * Set up theme styles
	 */
	final class IPR_Load_Styles {

		/**
		 * Styles settings
		 *
		 * @var array $settings
		 */
		protected $settings = [
			'core',
			'admin',
			'external',
			'header',
			'plugins',
			'page',
			'store',
			'front',
			'login',
			'print',
			'theme',
			'inline',
			'attr',
		];

		/**
		 * Styles registry instance
		 *
		 * @var object $instance
		 */
		private static $instance = null;

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
		 * Class constructor
		 */
		public function __construct() {

			// Just in case we try and instantiate a class
			if ( null !== self::$instance ) {
				return;
			}

			// Set up theme styles
			add_action( 'init', [ $this, 'init' ] );

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

			// Main styles
			add_action( 'wp_enqueue_scripts', [ $this, 'load_styles' ], 10 );

			// Header Inline CSS
			add_action( 'wp_head', [ $this, 'header_styles' ], 12 );
		}

		//------------------------------------------------
		// Core Registry Functions
		//------------------------------------------------

		/**
		 * Generate and store styles registry instance
		 *
		 * @return object $instance
		 */
		public static function getInstance() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid

			// Test for instance and generate if required
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Set a style setting by key
		 *
		 * @param string $key
		 * @param mixed $value
		 */
		public function __set( $key, $value ) {
			$this->settings[ $key ] = $value;
		}

		/**
		 * Get a style setting by key
		 *
		 * @return mixed
		 */
		public function __get( $key ) {
			return ( array_key_exists( $key, $this->settings ) ) ? $this->settings[ $key ] : null;
		}

		/**
		 * Test if a setting exists
		 *
		 * @param string $key
		 * @return boolean
		 */
		public function __isset( $key ) {
			return isset( $this->settings[ $key ] );
		}

		/**
		 * Stop cloning
		 */
		public function __clone() {
			throw new Exception( 'Cannot clone styles class.' );
		}

		/**
		 * Stop wakeup & serialisation
		 */
		public function __wakeup() {
			throw new Exception( 'Cannot unserialize styles class.' );
		}

		//------------------------------------------------
		// Initialisation & Hook Functions
		//------------------------------------------------

		/**
		 * Initialise main styles
		 */
		public function init() {

			// Retrieve theme config: styles
			$ip_styles = (array) apply_filters( 'ipress_styles', [] );
			if ( empty( $ip_styles ) ) {
				return;
			}

			// Initialise settings key value pairs
			foreach ( $this->settings as $setting ) {
				$this->$setting = $this->set_key( $ip_styles, $setting );
			}
		}

		/**
		 * Validate and set key
		 *
		 * @param array $styles
		 * @param string $key
		 * @return array
		 */
		private function set_key( $styles, $key ) {
			return ( isset( $styles[ $key ] ) && is_array( $styles[ $key ] ) && ! empty( $styles[ $key ] ) ) ? $styles[ $key ] : [];
		}

		//----------------------------------------------
		//	Admin Styles
		//----------------------------------------------

		/**
		 * Load admin styles
		 *
		 * @param string $hook
		 */
		public function load_admin_styles( $hook ) {

			// Register & enqueue admin styles
			foreach ( $this->admin as $k => $v ) {

				// Get hook page
				$hook_page = ( isset( $v[4] ) && ! empty( $v[4] ) ) ? $v[4] : '';

				// Check hook page?
				if ( ! empty( $hook_page ) && $hook_page !== $hook ) {
					continue;
				}

				// Register and enqueue styles
				$this->enqueue_style( $k, $v, false, false );
			}
		}

		//----------------------------------------------
		//	Styles
		//----------------------------------------------

		/**
		 * Load Theme CSS styles files in hierarchy order
		 */
		public function load_styles() {

			// Register & enqueue core styles
			foreach ( $this->core as $style ) {
				wp_enqueue_style( $style );
			}

			// Register & enqueue header styles
			foreach ( $this->external as $k => $v ) {
				$this->enqueue_style( $k, $v );
			}

			// Register & enqueue header styles
			foreach ( $this->header as $k => $v ) {
				$this->enqueue_style( $k, $v );
			}

			// Register & enqueue plugin styles
			foreach ( $this->plugins as $k => $v ) {
				$this->enqueue_style( $k, $v );
			}

			// Register and enqueue page template styles
			foreach ( $this->page as $k => $v ) {

				// Get script path
				$path = array_shift( $v );

				// Check for active page template
				if ( is_page_template( $path ) ) {
					$this->enqueue_style( $k, $v );
				}
			}

			// Register & enqueue WooCommerce store page template styles
			if ( ipress_wc_active() ) {

				foreach ( $this->store as $k => $v ) {

					// Get style pathn
					$path = array_shift( $v );

					// Check condition
					switch ( $path ) {
						case 'shop':
							if ( is_shop() ) {
								$this->enqueue_style( $k, $v );
							}
							break;
						case 'cart':
							if ( is_cart() ) {
								$this->enqueue_style( $k, $v );
							}
							break;
						case 'checkout':
							if ( is_checkout() ) {
								$this->enqueue_style( $k, $v );
							}
							break;
						case 'account':
							if ( is_account_page() ) {
								$this->enqueue_style( $k, $v );
							}
							break;
						case 'product':
							if ( is_product() ) {
								$this->enqueue_style( $k, $v );
							}
							break;
						case 'woocommerce':
							if ( is_woocommerce() || is_shop() || is_product() ) {
								$this->enqueue_style( $k, $v );
							}
							break;
						case 'front':
							if ( is_front_page() ) {
								$this->enqueue_style( $k, $v );
							}
							break;							
						case 'front-woocommerce':
							if ( is_front_page() || ( is_woocommerce() || is_shop() || is_product() ) ) {
								$this->enqueue_style( $k, $v );
							}
							break;														
						case 'all':
							$this->enqueue_style( $k, $v );
							break;														
						default:
							break;
					}
				}
			}

			// Register & enqueue front page styles
			if ( is_front_page() ) {
				foreach ( $this->front as $k => $v ) {
					$this->enqueue_style( $k, $v );
				}
			}

			// Register & enqueue print media styles
			foreach ( $this->print as $k => $v ) {
				$this->enqueue_style( $k, $v, true );
			}

			// Register & enqueue core styles
			foreach ( $this->theme as $k => $v ) {

				// Register style
				$this->enqueue_style( $k, $v );

				// Add style data
				wp_style_add_data( $k, 'rtl', 'replace' );
			}
		}

		/**
		 * Enqueue styles
		 *
		 * @param string $key
		 * @param string $style
		 * @param boolean $print default false
		 * @param boolean $inline default true
		 */
		private function enqueue_style( $key, $style, $print = false, $inline = true ) {

			// Sanitize key
			$key = sanitize_key( $key );

			// Set media type, default 'all', or force print style
			$media = ( true === $print ) ? 'print' : ( ( isset( $style[3] ) && in_array( $style[3], $this->media, true ) ) ? $style[3] : 'all' );

			// Register and enqueue style
			wp_register_style( $key, $style[0], $style[1], $style[2], $media );
			wp_enqueue_style( $key );

			// Set optional style attribute
			$this->set_style_attr( $key );

			// Inject associated inline script
			if ( true === $inline && array_key_exists( $key, $this->inline ) ) {
				$this->set_inline_style( $key );
			}
		}

		/**
		 * Add inline styles
		 *
		 * @param string $key
		 */
		private function set_inline_style( $key ) {

			// Get inline key data
			$data = $this->inline[ $key ];

			// Inject inline style inc handle
			if ( ! empty( $data ) ) {
				$data = html_entity_decode( (string) $data, ENT_QUOTES, 'UTF-8' );
				wp_add_inline_style( $key, $data );
			}
		}

		/**
		 * Set style attributes to matching handles
		 *
		 * @param string $handle
		 */
		private function set_style_attr( $handle ) {

			// Nothing set?
			if ( empty( $this->attr ) ) {
				return;
			}

			// Sort attr into types, should not have async and defer for the same handle
			$defer     = ( isset( $this->attr['defer'] ) && is_array( $this->attr['defer'] ) ) ? $this->attr['defer'] : [];
			$async     = ( isset( $this->attr['async'] ) && is_array( $this->attr['async'] ) ) ? $this->attr['async'] : [];
			$integrity = ( isset( $this->attr['integrity'] ) && is_array( $this->attr['integrity'] ) ) ? $this->attr['integrity'] : [];

			// Ok, do defer or async, can't have both
			if ( in_array( $handle, $defer, true ) ) {
				wp_style_add_data( $handle, 'defer', true );
			} elseif ( in_array( $handle, $async, true ) ) {
				wp_style_add_data( $handle, 'async', true );
			}

			// Ok, do integrity
			foreach ( $integrity as $k => $v ) {
				foreach ( $v as $h => $a ) {
					if ( sanitize_key( $h ) === $handle ) {
						wp_style_add_data( $handle, 'integrity', $a );
						wp_style_add_data( $handle, 'crossorigin', 'anonymous' );
						break;
					}
				}
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
			$ip_header_styles = (string) apply_filters( 'ipress_header_styles', get_theme_mod( 'ipress_header_styles', '' ) );
			if ( empty( $ip_header_styles ) ) {
				return;
			}

			// Display output, in <style></style> tag
			echo sprintf( '<style>%s</style>', wp_filter_nohtml_kses( $ip_header_styles ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Load inline header admin css
		 * - No <style></style> tag
		 */
		public function header_admin_styles() {

			// Use filter to add styles
			$ip_header_admin_styles = (string) apply_filters( 'ipress_header_admin_styles', get_theme_mod( 'ipress_header_admin_styles', '' ) );
			if ( empty( $ip_header_admin_styles ) ) {
				return;
			}

			// Display output, in <style></style> tag
			echo sprintf( '<style>%s</style>', wp_filter_nohtml_kses( $ip_header_admin_styles ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		//----------------------------------------------
		//	Login Page Styles
		//----------------------------------------------

		/**
		 * Load login styles
		 */
		public function load_login_styles() {

			// Register & enqueue admin styles
			foreach ( $this->login as $k => $v ) {
				$this->enqueue_style( $k, $v );
			}
		}

		//----------------------------------------------
		//	Add Styles Attributes
		//----------------------------------------------

		/**
		 * Tag on script attributes to matching handles
		 *
		 * @param string $tag
		 * @param string $handle
		 * @param string $src
		 */
		public function add_styles_attr( $tag, $handle, $src ) {

			// Add async or defer
			foreach ( [ 'async', 'defer' ] as $attr ) {

				// Test if attribute set for handle
				if ( ! wp_styles()->get_data( $handle, $attr ) ) {
					continue;
				}

				// Prevent adding attribute when already added in trac #12009.
				if ( ! preg_match( ":\s$attr(=|/>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=/>):', "$attr ", $tag, 1 );
				}

				// Only allow async or defer, not both.
				break;
			}

			// OK, check integrity
			$integrity = wp_styles()->get_data( $handle, 'integrity' );
			if ( $integrity ) {

				// Add integrity SHA string.
				$tag = preg_replace( ':(?=/>):', 'integrity="' . $integrity . '" ', $tag, 1 );

				// Add anonymous crossorigin for integrity
				$crossorigin = wp_styles()->get_data( $handle, 'crossorigin' );
				if ( $crossorigin ) {
					$tag = preg_replace( ':(?=/>):', 'crossorigin="' . $crossorigin . '" ', $tag, 1 );
				}
			}

			return $tag;
		}
	}

endif;

// Instantiate Styles Loader class
return IPR_Load_Styles::getInstance();
