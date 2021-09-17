<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for theme and plugin scripts.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Load_Scripts' ) ) :

	/**
	 * Set up theme scripts
	 */
	final class IPR_Load_Scripts {

		/**
		 * Script settings
		 *
		 * @var array $settings
		 */
		protected $settings = [
			'core',
			'admin',
			'external',
			'header',
			'footer',
			'plugins',
			'page',
			'store',
			'conditional',
			'front',
			'login',
			'custom',
			'inline',
			'local',
			'attr',
		];

		/**
		 * Styles registry instance
		 *
		 * @var object $instance
		 */
		private static $instance = null;

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Just in case we try and instantiate a class
			if ( null !== self::$instance ) {
				return;
			}

			// Set up theme scripts
			add_action( 'init', [ $this, 'init' ] );

			// Load admin scripts
			add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_scripts' ], 10 );

			// Login page scripts
			add_action( 'login_enqueue_scripts', [ $this, 'load_login_scripts' ], 1 );

			// Add attributes to scripts if there
			add_filter( 'script_loader_tag', [ $this, 'add_scripts_attr' ], 10, 3 );

			// Inline admin header scripts
			add_action( 'admin_head', [ $this, 'header_admin_scripts' ], 99 );

			// Inline admin footer scripts
			add_action( 'admin_footer', [ $this, 'footer_admin_scripts' ], 3 );

			// Front end only
			if ( is_admin() ) {
				return;
			}

			// Load parent scripts
			add_action( 'wp_enqueue_scripts', [ $this, 'load_core_scripts' ], 10 );

			// Load scripts
			add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ], 12 );

			// Load localized scripts
			add_action( 'wp_enqueue_scripts', [ $this, 'load_local_scripts' ], 15 );

			// Inline header scripts
			add_action( 'wp_head', [ $this, 'header_scripts' ], 99 );

			// Footer Scripts
			add_action( 'wp_footer', [ $this, 'footer_scripts' ], 99 );
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
		 * Set a script setting by key
		 *
		 * @param string $key
		 * @param mixed $value
		 */
		public function __set( $key, $value ) {
			$this->settings[ $key ] = $value;
		}

		/**
		 * Get a script setting by key
		 *
		 * @return mixed
		 */
		public function __get( $key ) {
			return ( array_key_exists( $key, $this->settings ) ) ? $this->settings[ $key ] : null;
		}

		/**
		 * Test if a script setting key exists
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
			throw new Exception( 'Cannot clone scripts class.' );
		}

		/**
		 * Stop wakeup & serialisation
		 */
		public function __wakeup() {
			throw new Exception( 'Cannot unserialize scripts class.' );
		}

		//------------------------------------------------
		// Initialisation & Hook Functions
		//------------------------------------------------

		/**
		 * Initialise main scripts
		 */
		public function init() {

			// Register theme scripts
			$ip_scripts = (array) apply_filters( 'ipress_scripts', [] );
			if ( empty( $ip_scripts ) ) {
				return;
			}

			// Initialise settings key value pairs
			foreach ( $this->settings as $setting ) {
				$this->$setting = $this->set_key( $ip_scripts, $setting );
			}
		}

		/**
		 * Validate and set key
		 *
		 * @param array $scripts
		 * @param string $key
		 * @return array
		 */
		private function set_key( $scripts, $key ) {
			return ( isset( $scripts[ $key ] ) && is_array( $scripts[ $key ] ) && ! empty( $scripts[ $key ] ) ) ? $scripts[ $key ] : [];
		}

		//----------------------------------------------
		//	Admin Scripts
		//----------------------------------------------

		/**
		 * Load admin scripts, default in header
		 *
		 * @param string $hook
		 */
		public function load_admin_scripts( $hook ) {

			// Register & enqueue admin scripts
			foreach ( $this->admin as $k => $v ) {

				// Get hook page
				$hook_page = ( isset( $v[4] ) && ! empty( $v[4] ) ) ? $v[4] : '';

				// Check hook page
				if ( ! empty( $hook_page ) && $hook_page !== $hook ) {
					continue;
				}

				// Set script locale
				$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register and enqueue scripts in header by default
				$this->enqueue_script( $k, $v, $locale, false );
			}
		}

		//----------------------------------------------
		//	Scripts
		//----------------------------------------------

		/**
		 * Load core, header & footer scripts
		 */
		public function load_core_scripts() {

			// Set up core scripts
			$ip_scripts_core = (array) apply_filters( 'ipress_scripts_core', array_map( 'sanitize_key', $this->core ) );

			// Enqueue scripts, pre-sanitized
			foreach ( $ip_scripts_core as $script ) {
				wp_enqueue_script( $script );
			}
		}

		/**
		 * Load theme header & footer scripts
		 */
		public function load_scripts() {

			// Register & enqueue external library scripts, no localisation
			foreach ( $this->external as $k => $v ) {

				// Set script locale
				$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register script, default in header
				$this->enqueue_script( $k, $v, $locale, false );
			}

			// Register & enqueue header scripts
			foreach ( $this->header as $k => $v ) {
				$this->enqueue_script( $k, $v, false );
			}

			// Register & enqueue footer scripts
			foreach ( $this->footer as $k => $v ) {
				$this->enqueue_script( $k, $v, true );
			}

			// Register & enqueue plugin scripts
			foreach ( $this->plugins as $k => $v ) {

				// Set script locale
				$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register script, default in header
				$this->enqueue_script( $k, $v, $locale );
			}

			// Register & enqueue page template scripts
			foreach ( $this->page as $k => $v ) {

				// Get script path & locale
				$path   = array_shift( $v );
				$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Check for active page template
				if ( is_page_template( $path ) ) {
					$this->enqueue_script( $k, $v, $locale );
				}
			}

			// Register & enqueue Woocommerce store page template scripts
			if ( ipress_wc_active() ) {

				foreach ( $this->store as $k => $v ) {

					// Get script path & locale
					$path   = array_shift( $v );
					$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

					// Check condition
					switch ( $path ) {
						case 'shop':
							if ( is_shop() ) {
								$this->enqueue_script( $k, $v, $locale );
							}
							break;
						case 'cart':
							if ( is_cart() ) {
								$this->enqueue_script( $k, $v, $locale );
							}
							break;
						case 'checkout':
							if ( is_checkout() ) {
								$this->enqueue_script( $k, $v, $locale );
							}
							break;
						case 'account':
							if ( is_account_page() ) {
								$this->enqueue_script( $k, $v, $locale );
							}
							break;
						case 'product':
							if ( is_product() ) {
								$this->enqueue_script( $k, $v, $locale );
							}
							break;
						case 'all':
							if ( is_woocommerce() || is_shop() || is_product() ) {
								$this->enqueue_script( $k, $v, $locale );
							}
							break;
						default:
							break;
					}
				}
			}

			// Conditional scripts in footer
			foreach ( $this->conditional as $k => $v ) {

				// Sanitize key
				$key = sanitize_key( $k );

				// Check for valid callback & call for result
				$callback = $v[0];
				if ( is_array( $callback ) ) {
					$result = ( isset( $callback[1] ) ) ? call_user_func_array( $callback[0], (array) $callback[1] ) : call_user_func( $callback[0] );
				} else {
					$result = call_user_func( $callback );
				}

				// Register and enqueue script in footer
				if ( $result ) {
					wp_register_script( $key, $v[1], $v[2], $v[3], true );
					wp_enqueue_script( $key );
				}
			}

			// Register & enqueue front page scripts
			if ( is_front_page() ) {

				foreach ( $this->front as $k => $v ) {

					// Set script locale
					$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

					// Register script, default in header
					$this->enqueue_script( $k, $v, $locale );
				}
			}

			// Register & enqueue base scripts in footer
			foreach ( $this->custom as $k => $v ) {
				$this->enqueue_script( $k, $v, true );
			}

			// Inject comment reply scripts if enabled, default false
			$ip_comment_reply = (bool) apply_filters( 'ipress_comment_reply', false );
			if ( true === $ip_comment_reply && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Enqueue & register scripts
		 *
		 * @param string $key
		 * @param array $script
		 * @param bool $locale default true, output in footer
		 * @param bool $local default true
		 * @param bool $attr default true
		 */
		private function enqueue_script( $key, $script, $locale = true, $local = true, $attr = true ) {

			// Sanitize key
			$key = sanitize_key( $key );

			// Register script, default in header
			wp_register_script( $key, $script[0], $script[1], $script[2], $locale );

			// Inject associated inline script
			if ( true === $local && array_key_exists( $key, $this->local ) ) {
				$this->localize( $key );
			}

			// Enqueue script
			wp_enqueue_script( $key );

			// Set optional script attributes
			if ( true === $attr ) {
				$this->set_script_attr( $key );
			}

			// Set optional inline script
			if ( array_key_exists( $key, $this->inline ) ) {
				$this->set_inline_script( $key );
			}
		}

		/**
		 * Load localized scripts to enqueued handles
		 */
		public function load_local_scripts() {

			// Set up script localization, if required
			$ip_scripts_local = (array) apply_filters( 'ipress_scripts_local', [] );

			// Sanitize handle array
			foreach ( $ip_scripts_local as $k => $v ) {
				foreach ( (array) $v as $s ) {
					$ip_scripts_local[ $k ][ $s ] = html_entity_decode( (string) $s, ENT_QUOTES, 'UTF-8' );
				}
			}

			// Parse & inject inline script
			foreach ( $ip_scripts_local as $k => $v ) {

				// Sanitize key
				$key = sanitize_key( $k );

				// Construct script and assign to handle
				$src = sprintf( 'var %s = %s', $key, json_encode( $v ) );
				wp_add_inline_script( $key, $src, 'before' );
			}
		}

		/**
		 * Localize script
		 *
		 * @param string $key
		 */
		private function localize( $key ) {

			// Get local key if set, pre-sanitised
			$local = $this->local[ $key ];

			// Validate & Localize
			if ( isset( $local['name'] ) && isset( $local['trans'] ) ) {
				wp_localize_script( $key, $local['name'], $local['trans'] );
			}
		}

		/**
		 * Add inline scripts
		 *
		 * @param string $key
		 */
		private function set_inline_script( $key ) {

			// Get inline key if set, pre-sanitised
			$inline = $this->inline[ $key ];

			// Process source
			if ( isset( $inline['src'] ) && ! empty( $inline['src'] ) ) {

				// Set position
				$position = ( isset( $inline['position'] ) && 'before' === $inline['position'] ) ? 'before' : 'after';

				// Construct source
				if ( is_array( $inline['src'] ) ) {
					$src = '';
					foreach ( $inline['src'] as $k => $v ) {
						$src .= html_entity_decode( (string) $v, ENT_QUOTES, 'UTF-8' );
					}
				} else {
					$src = html_entity_decode( (string) $inline['src'], ENT_QUOTES, 'UTF-8' );
				}

				// Inject inline script
				wp_add_inline_script( $key, $src, $position );
			}
		}

		/**
		 * Set script attributes to matching handles
		 *
		 * @param string $handle
		 */
		private function set_script_attr( $handle ) {

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
				wp_script_add_data( $handle, 'defer', true );
			} elseif ( in_array( $handle, $async, true ) ) {
				wp_script_add_data( $handle, 'async', true );
			}

			// Ok, do integrity
			foreach ( $integrity as $k => $v ) {
				foreach ( $v as $h => $a ) {
					if ( sanitize_key( $h ) === $handle ) {
						wp_script_add_data( $handle, 'integrity', $a );
						wp_script_add_data( $handle, 'crossorigin', 'anonymous' );
						break;
					}
				}
			}
		}

		//----------------------------------------------
		//	Header & Footer Scripts
		//----------------------------------------------

		/**
		 * Load inline header scripts
		 * - Must have <script></script> tag
		 */
		public function header_scripts() {

			// Get theme mod & format in <script></script> tag if set
			$ip_theme_mod = (string) get_theme_mod( 'ipress_header_js', '' );
			$ip_theme_mod = ( empty( $ip_theme_mod ) ) ? '' : sprintf( '<script>%s</script>', $ip_theme_mod );

			// Get content?
			$ip_header_scripts = (string) apply_filters( 'ipress_header_scripts', $ip_theme_mod );
			if ( empty( $ip_header_scripts ) ) {
				return;
			}

			// Needs script tag, display output
			if ( false !== stripos( $ip_header_scripts, '</script>' ) ) {
				echo $ip_header_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Load inline footer scripts
		 * - Must have <script></script> tag
		 */
		public function footer_scripts() {

			// Get theme mod & format in <script></script> tag if set
			$ip_theme_mod = (string) get_theme_mod( 'ipress_footer_js', '' );
			$ip_theme_mod = ( empty( $ip_theme_mod ) ) ? '' : sprintf( '<script>%s</script>', $ip_theme_mod );

			// Get content?
			$ip_footer_scripts = (string) apply_filters( 'ipress_footer_scripts', $ip_theme_mod );
			if ( empty( $ip_footer_scripts ) ) {
				return;
			}

			// Needs script tag, display output
			if ( false !== stripos( $ip_footer_scripts, '</script>' ) ) {
				echo $ip_footer_scripts;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Load inline header admin scripts
		 * - Must have <script></script> tag
		 */
		public function header_admin_scripts() {

			// Get theme mod & format in <script></script> tag if set
			$ip_theme_mod = (string) get_theme_mod( 'ipress_header_admin_js', '' );
			$ip_theme_mod = ( empty( $ip_theme_mod ) ) ? '' : sprintf( '<script>%s</script>', $ip_theme_mod );

			// Get content?
			$ip_header_admin_scripts = (string) apply_filters( 'ipress_header_admin_scripts', $ip_theme_mod );
			if ( empty( $ip_header_admin_scripts ) ) {
				return;
			}

			// Needs script tag, display output
			if ( false !== stripos( $ip_header_admin_scripts, '</script>' ) ) {
				echo $ip_header_admin_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Load inline footer admin admin scripts
		 * - Must have <script></script> tag
		 */
		public function footer_admin_scripts() {

			// Get theme mod & format in <script></script> tag if set
			$ip_theme_mod = (string) get_theme_mod( 'ipress_footer_admin_js', '' );
			$ip_theme_mod = ( empty( $ip_theme_mod ) ) ? '' : sprintf( '<script>%s</script>', $ip_theme_mod );

			// Get content?
			$ip_footer_admin_scripts = (string) apply_filters( 'ipress_footer_admin_scripts', $ip_theme_mod );
			if ( empty( $ip_footer_admin_scripts ) ) {
				return;
			}

			// Needs script tag, display output
			if ( false !== stripos( $ip_footer_admin_scripts, '</script>' ) ) {
				echo $ip_footer_admin_scripts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		//----------------------------------------------
		//	Login Page Scripts
		//----------------------------------------------

		/**
		 * Load login scripts
		 */
		public function load_login_scripts() {

			// Register & enqueue login scripts
			foreach ( $this->login as $k => $v ) {

				// Set script locale in header by default
				$locale = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register and enqueue script
				$this->enqueue_script( $k, $v, $locale, false, false );
			}
		}

		//----------------------------------------------
		//	Script attributes - defer, async, integrity
		//----------------------------------------------

		/**
		 * Tag on script attributes to matching handles
		 *
		 * @param string $tag
		 * @param string $handle
		 * @param string $src
		 */
		public function add_scripts_attr( $tag, $handle, $src ) {

			// Add async or defer
			foreach ( [ 'async', 'defer' ] as $attr ) {

				// Test if attribute set for handle
				if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
					continue;
				}

				// Prevent adding attribute when already added in trac #12009.
				if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
				}

				// Only allow async or defer, not both.
				break;
			}

			// OK, check integrity
			$integrity = wp_scripts()->get_data( $handle, 'integrity' );
			if ( $integrity ) {

				// Add integrity SHA string.
				$tag = preg_replace( ':(?=></script>):', ' integrity="' . $integrity . '"', $tag, 1 );

				// Add anonymous crossorigin for integrity
				$crossorigin = wp_scripts()->get_data( $handle, 'crossorigin' );
				if ( $crossorigin ) {
					$tag = preg_replace( ':(?=></script>):', ' crossorigin="' . $crossorigin . '"', $tag, 1 );
				}
			}

			return $tag;
		}
	}

endif;

// Instantiate Scripts Loader class
return IPR_Load_Scripts::getInstance();
