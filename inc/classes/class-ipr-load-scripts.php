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

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Load_Scripts' ) ) :

	/**
	 * Set up theme scripts
	 */
	final class IPR_Load_Scripts extends IPR_Registry {

		/**
		 * Script settings
		 *
		 * @var array $settings
		 */
		protected $settings = [
			'core' 			=> [],
			'admin' 		=> [],
			'external' 		=> [],
			'scripts' 		=> [],
			'page' 			=> [],
			'post_type' 	=> [],
			'taxonomy' 		=> [],
			'store'			=> [],
			'conditional' 	=> [],
			'front' 		=> [],
			'login' 		=> [],
			'custom' 		=> [],
			'inline' 		=> [],
			'local' 		=> [],
			'attr' 			=> [],
		];

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Set up scripts
			add_action( 'wp', [ $this, 'settings' ] );
			add_action( 'admin_init', [ $this, 'admin_settings' ] );

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

			// Load core scripts
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
		 * Set a script setting by key
		 *
		 * @param string $key Script key type
		 * @param mixed $value Script key value
		 */
		public function __set( $key, $value ) {
			throw new Exception( __( 'Script settings should be set via initialisation function', 'ipress' ) );
		}

		/**
		 * Get a script setting by key
		 *
		 * @param string $key Script key type
		 * @return mixed
		 */
		public function __get( $key ) {
			return ( array_key_exists( $key, $this->settings ) ) ? $this->settings[$key] : null;
		}

		/**
		 * Test if a script setting key exists
		 *
		 * @param string $key Script key type
		 * @return boolean
		 */
		public function __isset( $key ) {
			return isset( $this->settings[$key] );
		}

		//------------------------------------------------
		// Initialisation
		//------------------------------------------------

		/**
		 * Initialise main script settings
		 *
		 * - Set to config value if available or [] if not
		 */
		public function settings() {

			// Register scripts
			$ip_scripts = (array) apply_filters( 'ipress_scripts', [] );
			if ( $ip_scripts  ) {

				// Filter non-admin settings
				$settings = array_filter( $this->settings, function( $v, $k ) { 
					return $k !== 'admin'; 
				}, ARRAY_FILTER_USE_BOTH );

				// Initialise settings key:value pairs
				array_walk( $settings, function( $item, $key, $scripts ) {
					$this->settings[$key] = ( array_key_exists( $key, $scripts ) && is_array( $scripts[$key] ) ) ? $scripts[$key] : [];
				}, $ip_scripts );

				// Pre-sanitize local values
				$local = [];
				foreach( $this->local as $key => $value ) {
					$handle = sanitize_key( $key );
					$local[$handle] = $value;
				}
				$this->settings['local'] = $local;

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
		 * Initialise admin script settings
		 *
		 * - Set to config value if available or [] if not
		 */
		public function admin_settings() {

			// Register theme config: scripts & initialise admin setting
			$ip_scripts = (array) apply_filters( 'ipress_scripts', [] );
			if ( $ip_scripts ) {
				$this->settings['admin'] = ( array_key_exists( 'admin', $ip_scripts ) && is_array( $ip_scripts['admin'] ) ) ? $ip_scripts['admin'] : [];
			}
		}

		//----------------------------------------------
		//	Core Scripts
		//----------------------------------------------

		/**
		 * Load core, header & footer scripts
		 */
		public function load_core_scripts() {

			// Set up core scripts
			$ip_scripts_core = (array) apply_filters( 'ipress_scripts_core', array_map( 'sanitize_key', $this->core ) );
				
			// Enqueue scripts, pre-sanitized
			$ip_scripts_core && array_walk( $ip_scripts_core, function( $script, $k ) {
				wp_enqueue_script( $script );
			} );
		}

		//----------------------------------------------
		//	Admin Scripts
		//----------------------------------------------

		/**
		 * Load admin scripts, default in header
		 *
		 * @param string $hook Script hook to validate
		 */
		public function load_admin_scripts( $hook ) {

			// Register & enqueue admin scripts if available
			$admin_scripts = $this->admin;
			$admin_scripts && array_walk( $admin_scripts, function( $script, $handle ) use ( $hook ) {

				// Get hook page
				$hook_page = array_shift( $script );

				// Check hook page & enqueue if matches
				if ( $hook_page === $hook ) {

					// Register and enqueue scripts in header by default
					$this->enqueue_script( $script, $handle, false );
				}
			} );
		}

		//----------------------------------------------
		//	Scripts
		//----------------------------------------------

		/**
		 * Load header & footer scripts
		 */
		public function load_scripts() {

			// Register & enqueue external library scripts, no localisation, no attributes
			$external_scripts = $this->external;
		 	$external_scripts && array_walk( $external_scripts, [ $this, 'enqueue_script' ], false );

			// Register & enqueue main scripts
			$main_scripts = $this->scripts;
			$main_scripts && array_walk( $main_scripts, function( $script, $handle ) {
				$this->enqueue_script( $script, $handle );
			} );

			// Register & enqueue page template scripts
			$page_scripts = $this->page;
			$page_scripts && array_walk( $page_scripts, function( $script, $handle ) {

				// Get script path & locale
				$path = array_shift( $script );

				// Check for active page template
				if ( is_page_template( $path ) ) {
					$this->enqueue_script( $script, $handle );
				}
			} );

			// Register and enqueue post-type scripts
			$post_type_scripts = $this->post_type;
			$post_type_scripts && array_walk( $post_type_scripts, function( $script, $handle ) {

				// Get script post type
				$post_type = array_shift( $script );

				// Check for active page template
				if ( is_post_type_archive( $post_type ) || is_singular( $post_type ) ) {
					$this->enqueue_script( $script, $handle );
				}
			} );

			// Register and enqueue taxonomy term scripts
			$taxonomy_scripts = $this->taxonomy;
			$taxonomy_scripts && array_walk( $taxonomy_scripts, function( $script, $handle ) {

				// Get script taxonomy & term
				$tax_term = array_shift( $script );
		
				// Check for active page template
				if ( is_array( $tax_term ) ) {
					[ $taxonomy, $term ] = $tax_term;
					if ( is_tax( $taxonomy, $term ) ) {
						$this->enqueue_script( $script, $handle );
					}
				} else {
					if ( is_tax( $tax_term ) ) {
						$this->enqueue_script( $script, $handle );
					}
				}
			} );

			// Register & enqueue Woocommerce store page template scripts
			if ( ipress_wc_active() ) {

				$store_scripts = $this->store;
				$store_scripts && array_walk( $store_scripts, function( $script, $handle ) {

					// Get script path & locale
					$path = array_shift( $script );
	
					// Check condition
					switch ( $path ) {
						case 'shop':
							if ( is_shop() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;
						case 'cart':
							if ( is_cart() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;
						case 'checkout':
							if ( is_checkout() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;
						case 'account':
							if ( is_account_page() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;
						case 'product':
							if ( is_product() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;
						case 'store':
							if ( is_woocommerce() || is_shop() || is_product() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;
						case 'front':
							if ( is_front_page() ) {
								$this->enqueue_script( $script, $handle );
							}
							break;							
						case 'front-store':
							if ( is_front_page() || ( is_woocommerce() || is_shop() || is_product() ) ) {
								$this->enqueue_script( $script, $handle );
							}
							break;														
						case 'all':
							$this->enqueue_script( $script, $handle );
							break;														
						default:
							break;
					}
				} );
			}

			// Conditional scripts in footer
			$conditional_scripts = $this->conditional;
			$conditional_scripts && array_walk( $conditional_scripts, function( $script, $handle ) {

				// Check for valid callback & call for result
				$callback = array_shift( $script );
				if ( is_array( $callback ) ) {
					$result = ( isset( $callback[1] ) ) ? call_user_func_array( $callback[0], (array) $callback[1] ) : call_user_func( $callback[0] );
				} else {
					$result = call_user_func( $callback );
				}

				// Register and enqueue script in footer
				if ( $result ) {
					$this->enqueue_script( $script, $handle );
				}
			} );

			// Register & enqueue front page scripts
			if ( is_front_page() ) {
				$front_page_scripts = $this->front;
				$front_page_scripts && array_walk( $front_page_scripts, function( $script, $handle ) {
					$this->enqueue_script( $script, $handle );
				} );
			}

			// Register & enqueue base scripts in footer
			$custom_scripts = $this->custom;
			$custom_scripts && array_walk( $custom_scripts, function( $script, $handle ) {
				$this->enqueue_script( $script, $handle );
			} );

			// Inject comment reply scripts if enabled, default false
			$ip_comment_reply = (bool) apply_filters( 'ipress_comment_reply', false );
			if ( true === $ip_comment_reply && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Enqueue & register scripts
		 *
		 * @param array $script Script to process
		 * @param string $handle Handle to associate with script
		 * @param bool $attr Process inline script data
		 */
		private function enqueue_script( $script, $handle, $inline = true ) {

			// Sanitize handle
			$handle = sanitize_key( $handle );

			// Set script locale
			$in_footer = ( isset( $script[3] ) && true === $script[3] ) ? true : false;

			// Register script, default in header
			wp_register_script( $handle, $script[0], $script[1], $script[2], $in_footer );

			// Inject associated inline script
			if ( array_key_exists( $handle, $this->local ) ) {
				$this->localize( $handle );
			}

			// Enqueue script
			wp_enqueue_script( $handle );

			// Set optional script attributes
			if ( array_key_exists( $handle, $this->attr ) ) {
				$this->set_script_attr( $handle );
			}

			// Set optional inline script
			if ( $inline && array_key_exists( $handle, $this->inline ) ) {
				$this->set_inline_script( $handle );
			}
		}

		/**
		 * Localize script
		 *
		 * @param string $handle Script handle to process
		 */
		private function localize( $handle ) {

			// Get local handle if set, pre-sanitised
			$local = $this->local[$handle];

			// Validate & Localize
			if ( isset( $local['name'] ) && isset( $local['trans'] ) ) {
				wp_localize_script( $handle, $local['name'], $local['trans'] );
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
				wp_script_add_data( $handle, 'defer', true );
			} elseif ( true === $async ) {
				wp_script_add_data( $handle, 'async', true );
			}

			// Add integrity & crossorigin, attribute required
			$integrity = ( isset( $attr['integrity'] ) ) ? $attr['integrity'] : false;
			if ( $integrity ) {
				wp_script_add_data( $handle, 'integrity', $integrity );
				wp_script_add_data( $handle, 'crossorigin', 'anonymous' );
			}
			
			// Add crossorigin if not already done, attribute required
			$crossorigin = ( isset( $attr['crossorigin'] ) ) ? $attr['crossorigin'] : false;
			if ( $crossorigin ) {
				wp_script_add_data( $handle, 'crossorigin', $crossorigin );
			}		
		}
		
		/**
		 * Add inline scripts
		 *
		 * @param string $handle Script handle to process
		 */
		private function set_inline_script( $handle ) {

			// Get inline handle if set, pre-sanitised
			$inline = $this->inline[$handle];

			// Process source
			if ( isset( $inline['src'] ) && ! empty( $inline['src'] ) ) {

				// Set position
				$position = ( isset( $inline['position'] ) && 'before' === $inline['position'] ) ? 'before' : 'after';

				// Construct source
				if ( is_array( $inline['src'] ) ) {
					$src = '';
					foreach ( $inline['src'] as $k => $script ) {
						$src .= html_entity_decode( (string) $script, ENT_QUOTES, 'UTF-8' );
					}
				} else {
					$src = html_entity_decode( (string) $inline['src'], ENT_QUOTES, 'UTF-8' );
				}

				// Inject inline script
				wp_add_inline_script( $handle, $src, $position );
			}
		}

		/**
		 * Load localized scripts to enqueued handles
		 */
		public function load_local_scripts() {

			// Set up script localization, if required
			$ip_scripts_local = (array) apply_filters( 'ipress_scripts_local', [] );

			// Sanitize handle array
			foreach ( $ip_scripts_local as $handle => $scripts ) {
				foreach ( (array) $scripts as $script ) {
					$ip_scripts_local[$handle][$script] = html_entity_decode( (string) $script, ENT_QUOTES, 'UTF-8' );
				}
			}

			// Parse & inject inline script
			array_walk( $ip_scripts_local, function( $scripts, $handle ) {
				$src = sprintf( 'var %s = %s', sanitize_key( $handle ), json_encode( $scripts ) );
				wp_add_inline_script( $handle, $src, 'before' );
			} );
		}

		//----------------------------------------------
		//	Header & Footer Scripts
		//----------------------------------------------

		/**
		 * Load inline header scripts
		 * - Must have <script></script> tag
		 */
		public function header_scripts() {

			// Get option & format in <script></script> tag if set
			$ip_header_js = apply_filters( 'ipress_header_js', ipress_get_option( 'ipress_header_js', '' ) );
			if ( $ip_header_js ) {

				// Wrap with <script></script>
				$ip_header_js = sprintf( '<script>%s</script>', esc_js( $ip_header_js ) );
				echo $ip_header_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Load inline footer scripts
		 * - Must have <script></script> tag
		 */
		public function footer_scripts() {

			// Get option & format in <script></script> tag if set
			$ip_footer_js = apply_filters( 'ipress_footer_js', ipress_get_option( 'ipress_footer_js', '' ) );
			if ( $ip_footer_js ) {

				// Wrap with <script></script>
				$ip_footer_js = sprintf( '<script>%s</script>', esc_js( $ip_footer_js ) );
				echo $ip_footer_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Load inline header admin scripts
		 * - Must have <script></script> tag
		 */
		public function header_admin_scripts() {

			// Get option & format in <script></script> tag if set
			$ip_header_admin_js = apply_filters( 'ipress_header_admin_js', ipress_get_option( 'ipress_header_admin_js', '' ) );
			if ( $ip_header_admin_js ) {

				// Wrap with <script></script>
				$ip_header_admin_js = sprintf( '<script>%s</script>', esc_js( $ip_header_admin_js ) );
				echo $ip_header_admin_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		
		/**
		 * Load inline footer admin admin scripts
		 * - Must have <script></script> tag
		 */
		public function footer_admin_scripts() {

			// Get option & format in <script></script> tag if set
			$ip_footer_admin_js = apply_filters( 'ipress_footer_admin_js', ipress_get_option( 'ipress_footer_admin_js', '' ) );
			if ( $ip_footer_admin_js ) {
	
				// Wrap with <script></script>
				$ip_footer_admin_js = sprintf( '<script>%s</script>', esc_js( $ip_footer_admin_js ) );
				echo $ip_footer_admin_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		
		//----------------------------------------------
		//	Login Page Scripts
		//----------------------------------------------

		/**
		 * Load login scripts
		 */
		public function load_login_scripts() {
			$login_scripts = $this->login;
			$login_scripts && array_walk( $login_scripts, function( $script, $handle ) {
				$this->enqueue_script( $script, $handle );
			}, false );
		}

		//----------------------------------------------
		//	Script attributes - defer, async, integrity
		//----------------------------------------------

		/**
		 * Tag on script attributes to matching handles
		 *
		 * @param string $tag Attribute to process
		 * @param string $handle Script handle
		 * @param string $src Script src url
		 * @return string $tag
		 */
		public function add_scripts_attr( $tag, $handle, $src ) {

			// Add async or defer
			foreach ( [ 'async', 'defer' ] as $attr ) {

				// Test if attribute set for handle
				if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
					continue;
				}

				// Prevent adding attribute when already added in trac #12009
				if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
				}

				// Only allow async or defer, not both.
				break;
			}

			// OK, check integrity & add integrity SHA string
			$integrity = wp_scripts()->get_data( $handle, 'integrity' );
			if ( $integrity ) {
				$tag = preg_replace( ':(?=></script>):', ' integrity="' . $integrity . '"', $tag, 1 );
			}

			// Add crossorigin for integrity if not already done
			$crossorigin = wp_scripts()->get_data( $handle, 'crossorigin' );
			if ( $crossorigin ) {
				$tag = preg_replace( ':(?=></script>):', ' crossorigin="' . $crossorigin . '"', $tag, 1 );
			}
			
			return $tag;
		}
	}

endif;

// Instantiate Scripts Loader class
return IPR_Load_Scripts::Init();
