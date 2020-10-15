<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for theme and plugin scripts.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
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
		protected $settings = [];

		/**
		 * Styles registry instance
		 *
		 * @var object $instance
		 */
		private static $instance = null;

		/**
		 * Class constructor
		 */
		public final function __construct() {

			// Just in case we try and instantiate a class
			if ( self::$instance !== null ) { return; }

			// Set up theme scripts
			add_action( 'init', [ $this, 'init' ] );

			// Load admin scripts
			add_action( 'admin_enqueue_scripts', 		[ $this, 'load_admin_scripts' ] ); 

			// Login page scripts
			add_action( 'login_enqueue_scripts', 		[ $this, 'load_login_scripts' ], 1 );

			// Add attributes to scripts if there			
			add_filter( 'script_loader_tag', 			[ $this, 'add_scripts_attr' ], 10, 3 );
			
			// Inline admin header scripts 
			add_action( 'admin_head', 					[ $this, 'header_admin_scripts' ], 99 );

			// Inline admin footer scripts 
			add_action( 'admin_footer', 				[ $this, 'footer_admin_scripts' ], 3 );

			// Block editor scripts
			add_action( 'enqueue_block_editor_assets', 	[ $this, 'block_editor_assets'], 1, 1 );

			// Front end only
			if ( is_admin() ) { return; }

			// Load parent scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'load_core_scripts' ], 10 ); 

			// Load scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'load_scripts' ], 12 ); 

			// Load localized scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'load_local_scripts' ], 15 ); 

			// Inline header scripts 
			add_action( 'wp_head', 					[ $this, 'header_scripts' ], 99 );

			// Footer Scripts
			add_action( 'wp_footer', 				[ $this, 'footer_scripts' ], 99 );
		}

		//------------------------------------------------
		// Core Registry Functions
		//------------------------------------------------

		/**
		 * Generate and store styles registry instance
		 *
		 * @return 	object	$instance
		 */
		public final static function getInstance() {

			// Test for instance and generate if required
 			if ( self::$instance == null ) {
				self::$instance = new Self();
    		}
			return self::$instance;
		}
		
		/**
		 * Set a scripts setting
		 *
		 * @param	string 	$key
		 * @param	mixed	$value
		 */
		public final function __set( $key, $value ) {
			$this->settings[$key] = $value;
		}

		/**
		 * Get a scripts setting
		 *
		 * @return	mixed
		 */
		public final function __get( $key ) {
			return ( isset( $this->settings[$key] ) ) ? $this->settings[$key] : null;
		}

		/**
		 * Test if a settings exists
		 *
		 * @param	string	$key
		 * @return  boolean
		 */
		public final function __isset( $key ) {
	        return array_key_exists( $key, $this->settings );
    	}

		/**
		 * Stop cloning
		 */
		public final function __clone() {}

		/**
		 * Wakeup
		 */
		private final function __wakeup() {}

		//------------------------------------------------
		// Initialisation & Hook Functions
		//------------------------------------------------

		/**
		 * Initialise main scripts
		 */
		public function init() {

			// Register theme scripts
			$ip_scripts = (array) apply_filters( 'ipress_scripts', [] );
			if ( empty( $ip_scripts ) ) { return; }

			// Admin scripts: [ 'label' => [ 'hook', 'src', (array)deps, 'ver' ] ... ]
			$this->admin = $this->set_key( $ip_scripts, 'admin' );

			// Core scripts: [ 'script-name', 'script-name2' ... ]
			$this->core = $this->set_key( $ip_scripts, 'core' );

			// External scripts: [ 'script-name', 'script-name2' ... ]
			$this->external = $this->set_key( $ip_scripts, 'external' );

			// Header scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->header = $this->set_key( $ip_scripts, 'header' );

			// Footer scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->footer = $this->set_key( $ip_scripts, 'footer' );

			// Plugin scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->plugins = $this->set_key( $ip_scripts, 'plugins' );

			// Page scripts: [ 'label' => [ 'template', 'src', (array)deps, 'ver' ] ... ];
			$this->page = $this->set_key( $ip_scripts, 'page' );

			// Conditional scripts: [ 'label' => [ [ 'callback', [ args ] ], 'src', (array)deps, 'ver' ] ... ];
			$this->conditional = $this->set_key( $ip_scripts, 'conditional' );

			// Front Page scripts: [ 'label' => [ 'template', 'src', (array)deps, 'ver' ] ... ];
			$this->front = $this->set_key( $ip_scripts, 'front' );

			// Custom scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ];
			$this->custom = $this->set_key( $ip_scripts, 'custom' );

			// Login scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->login = $this->set_key( $ip_scripts, 'login' );
			
			// Block editor scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->block = $this->set_key( $ip_scripts, 'block' );

			// Localize scripts: [ 'handle' => [ 'name' => name, trans => function/src ] ]
			$this->local = $this->set_key( $ip_scripts, 'local' );

			// Inline scripts: [ 'handle' => [ 'src' => function/src ] ]
			$this->inline = $this->set_key( $ip_scripts, 'inline' );

			// Script attributes: [ 'label' => [ 'handle' ] ]
			$this->attr = $this->set_key( $ip_scripts, 'attr' );
		}

		/**
		 * Validate and set key
		 *
		 * @param 	array 	$scripts
		 * @param 	string 	$key
		 * @return 	array	$scripts
		 */
		private function set_key( $scripts, $key ) {
			return ( isset ( $scripts[$key] ) && is_array( $scripts[$key] ) ) ? $scripts[$key] : [];
		}

		//----------------------------------------------
		//	Admin Scripts
		//----------------------------------------------

		/**
		 * Load admin scripts, default in header
		 *
		 * @param	string	$hook_suffix
		 */
		public function load_admin_scripts( $hook_suffix ) {

			// Initial validation
			if ( empty( $this->admin ) ) { return; }

			// Register & enqueue admin scripts
			foreach ( $this->admin as $k => $v ) { 
				
				// Set script position, default header
				$position 	= ( isset( $v[3] ) && true === $v[3] ) ? true : false;
				$hook_page	= ( isset( $v[4] ) && ! empty( $v[4] ) ) ? $v[4] : '';
		
				// Register and enqueue scripts in header by default
				if ( empty( $hook_page ) ) {
					wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 
					wp_enqueue_script( $k );
				} elseif ( $hook_page === $hook_suffix ) {
					wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 
					wp_enqueue_script( $k );
				} else { continue; }

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}
		}

		//----------------------------------------------
		//	Scripts, Styles & Fonts
		//----------------------------------------------

		/**
		 * Load core, header & footer scripts 
		 */
		public function load_core_scripts() { 

			// Set up other core scripts, if required
			$ip_scripts_core = (array) apply_filters( 'ipress_scripts_core', $this->core );
			if ( empty( $ip_scripts_core ) ) { return; }

			// Enqueue scripts
			foreach ( $ip_scripts_core as $script ) {
				wp_enqueue_script( $script );
			}
		}

		/**
		 * Load theme header & footer scripts 
		 */
		public function load_scripts() { 
	 
			// Register & enqueue header scripts
			foreach ( $this->external as $k => $v ) { 

				// Set script position
				$position = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register & enqueue scripts
				wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 
				wp_enqueue_script( $k );

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}

			// Register & enqueue header scripts
			foreach ( $this->header as $k => $v ) { 

				// Register script in header
				wp_register_script( $k, $v[0], $v[1], $v[2], false ); 

				// Inject associated inline script
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}

				// Enqueue script
				wp_enqueue_script( $k );

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}

			// Register & enqueue footer scripts
			foreach ( $this->footer as $k => $v ) { 

				// Register scripts in footer
				wp_register_script( $k, $v[0], $v[1], $v[2], true ); 

				// Inject associated inline script
				if ( array_key_exists( $k, $this->local ) && ! empty( $this->local[$k] ) ) {
					$this->localize( $k );
				}

				// Enqueue scripts
				wp_enqueue_script( $k );

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}

			// Register & enqueue plugin scripts
			foreach ( $this->plugins as $k => $v ) { 

				// Set script position
				$position = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register script, default in header
				wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 

				// Inject associated inline script
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}
				
				// Enqueue script
				wp_enqueue_script( $k );

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}

			// Register & enqueue page template scripts
			foreach ( $this->page as $k => $v ) {

				// Check for active page template
				if ( is_page_template( $v[0] ) ) {

					// Set script position 
					$position = ( isset( $v[4] ) && true === $v[4] ) ? true : false;

					// Register script, default in header
					wp_register_script( $k, $v[1], $v[2], $v[3], $position ); 

					// Inject associated inline script
					if ( array_key_exists( $k, $this->local ) ) {
						$this->localize( $k );
					}

					// Enqueue script
					wp_enqueue_script( $k );

					// Set optional script attributes
					$this->set_script_attr( $k );

					// Set optional inline script 
					if ( array_key_exists( $k, $this->inline ) ) {
						$this->set_inline_script( $k );
					}
				}
			}

			// Conditional scripts in footer
			foreach ( $this->conditional as $k => $v ) {

				// Check for valid callback
				$callback = $v[0];
				if ( is_array( $callback ) ) {
					$r = ( isset( $callback[1] ) ) ? call_user_func_array ( $callback[0] , (array) $callback[1] ) : call_user_func ( $callback[0] );
				} else {
					$r = call_user_func ( $callback );
				}

				// Register and enqueue script in footer
				if ( $r ) {
					wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
					wp_enqueue_script( $k );
				}
			}

			// Register & enqueue front page scripts
			foreach ( $this->front as $k => $v ) {

				// First test
				if ( ! is_front_page() ) { continue; }
				
				// Set script position 
				$position = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register script, default in header
				wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 

				// Inject associated inline script
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}

				// Enqueue script
				wp_enqueue_script( $k );

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}

			// Register & enqueue base scripts in footer
			foreach ( $this->custom as $k => $v ) {

				// Register script in footer
				wp_register_script( $k, $v[0], $v[1], $v[2], true ); 

				// Inject associated inline script
				if ( array_key_exists( $k, $this->local ) && ! empty( $this->local[$k] ) ) {
					$this->localize( $k );
				}

				// Enqueue script
				wp_enqueue_script( $k );

				// Set optional script attributes
				$this->set_script_attr( $k );

				// Set optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}

			// Inject comment reply scripts if enabled, default false
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				$ip_comment_reply = (bool) apply_filters( 'ipress_comment_reply', false );
				if ( true === $ip_comment_reply ) {
					wp_enqueue_script( 'comment-reply' );
				}
			}
		}
		
		/**
		 * Load localized scripts to enqueued handles
		 */
		public function load_local_scripts() {
			
			// Set up script localization, if required
			$ip_scripts_local = (array) apply_filters( 'ipress_scripts_local', [] );
			if ( empty( $ip_scripts_local ) ) { return; }

			// Sanitize handle array
			foreach ( $ip_scripts_local as $k => $v ) {
				if ( ! is_array( $v ) || empty( $v ) ) { continue; }
				foreach ( $v as $s ) {
					$ip_scripts_local[$k][$s] = html_entity_decode( (string) $s, ENT_QUOTES, 'UTF-8' );
				}
			}

			// Parse & inject inline script
			foreach ( $ip_scripts_local as $k => $v ) {
				$src = sprintf( 'var %s = %s', $k, json_encode( $v ) );
				wp_add_inline_script( $k, $src, 'before' ); 
			}
		}

		/**
		 * Localize script
		 *
		 * @param string $key
		 */
		private function localize( $key ) {

			// Get local key
			$l = $this->local[$key]; 

			// Validate & Localize
			if ( isset( $l['name'] ) && isset( $l['trans'] ) )  { 
				wp_localize_script( $key, $l['name'], $l['trans'] ); 		
			}
		}

		/**
		 * Add inline scripts
		 *
		 * @param string $key
		 */
		private function set_inline_script( $key ) {
	
			// Get local key
			$l = $this->inline[$key]; 

			// Process source
			if ( isset( $l['src'] ) && ! empty( $l['src'] ) ) {

				// Set position
				$position = ( isset( $l['position'] ) && $l['position'] === 'before' ) ? 'before' : 'after';  

				// Construct source
				if ( is_array( $l['src'] ) ) {
					$src = ''; 
					foreach ( $l['src'] as $k => $v ) {
						$src .= html_entity_decode( (string) $v, ENT_QUOTES, 'UTF-8' );
					}
				} else {
					$src = html_entity_decode( (string) $l['src'], ENT_QUOTES, 'UTF-8' );
				}

				// Inject inline script
				wp_add_inline_script( $key, $src, $position ); 
			}
		}

		/**
		 * Set script attributes to matching handles
		 *
		 * @param	string	$handle
		 */
		private function set_script_attr( $handle ) {

			// Nothing set?
			if ( empty( $this->attr ) ) { return; }

			// Sort attr into types, should not have async and defer for the same handle
			$defer 		= ( isset( $this->attr['defer'] ) && is_array( $this->attr['defer'] ) ) ? $this->attr['defer'] : [];
			$async 		= ( isset( $this->attr['async'] ) && is_array( $this->attr['async'] ) ) ? $this->attr['async'] : [];
			$integrity 	= ( isset( $this->attr['integrity'] ) && is_array( $this->attr['integrity'] ) ) ? $this->attr['integrity'] : [];

			// Ok, do defer or async, can't have both
			if ( in_array( $handle, $defer ) ) {
				wp_script_add_data( $handle, 'defer', true ); 
			} elseif ( in_array( $handle, $async ) ) {
				wp_script_add_data( $handle, 'async', true ); 
			}

			// Ok, do integrity
			foreach ( $integrity as $k => $v ) {
				foreach ( $v as $h => $a ) {
					if ( $handle === $h ) {
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
			if ( empty( $ip_header_scripts ) ) { return; }

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
			if ( empty( $ip_footer_scripts ) ) { return; }

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
			if ( empty( $ip_header_admin_scripts ) ) { return; }

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
			if ( empty( $ip_footer_admin_scripts ) ) { return; }

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

			// Initial validation
			if ( empty( $this->login ) ) { return; }

			// Register & enqueue admin scripts
			foreach ( $this->login as $k => $v ) { 

				// Set script position, default header				
				$position = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register and enqueue script in header by default
				wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 
				wp_enqueue_script( $k );

				// Add optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}
		}
		
		//----------------------------------------------
		//	Block Editor Scripts
		//----------------------------------------------

		/**
		 * Load block editor scripts
		 */
		public function block_editor_assets() {

			// Initial validation
			if ( empty( $this->block ) ) { return; }

			// Register & enqueue admin scripts
			foreach ( $this->block as $k => $v ) { 

				// Set script position, default header				
				$position = ( isset( $v[3] ) && true === $v[3] ) ? true : false;

				// Register and enqueue script in header by default
				wp_register_script( $k, $v[0], $v[1], $v[2], $position ); 
				wp_enqueue_script( $k );

				// Add optional inline script 
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_script( $k );
				}
			}
		}

		//----------------------------------------------
		//	Script attributes - defer, async, integrity
		//----------------------------------------------

		/**
		 * Tag on script attributes to matching handles
		 *
		 * @param	string	$tag
		 * @param	string	$handle
		 * @param	string	$src
		 */
		public function add_scripts_attr( $tag, $handle, $src ) {

			// Add async or defer
			foreach ( [ 'async', 'defer' ] as $attr ) {

				// Test if attribute set for handle 
				if ( ! wp_scripts()->get_data( $handle, $attr ) ) {	continue; }

				// Prevent adding attribute when already added in trac #12009.
				if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
				}

				// Only allow async or defer, not both.
				break;
			}

			// OK, check integrity
			if ( $integrity = wp_scripts()->get_data( $handle, 'integrity' ) ) {

				// Add integrity SHA string.
				$tag = preg_replace( ':(?=></script>):', ' integrity="' . $integrity . '"', $tag, 1 );

				// Add anonymous crossorigin for integrity				
				if ( $crossorigin = wp_scripts()->get_data( $handle, 'crossorigin' ) ) {
					$tag = preg_replace( ':(?=></script>):', ' crossorigin="' . $crossorigin . '"', $tag, 1 );
				}
			}			

			return $tag;
		}
	}

endif;

// Instantiate Scripts Loader class
return IPR_Load_Scripts::getInstance();

//end
