<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for theme and plugin styles.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.co.uk
 * @license		GPL-2.0+
 */

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
		protected $settings = [];

		/**
		 * Styles registry instance
		 *
		 * @var object $instance
		 */
		private static $instance = null;

		/**
		 * Media load types
		 */
		private $media = [ 'all', 'screen', 'print', 'handheld' ];

		/**
		 * Class constructor
		 */
		public final function __construct() {

			// Just in case we try and instantiate a class
			if ( self::$instance !== null ) { return; }
			
			// Set up theme styles
			add_action( 'init', [ $this, 'init' ] );

			// Load admin styles
			add_action( 'admin_enqueue_scripts', 				[ $this, 'load_admin_styles' ] ); 

			// Login page styles
			add_action( 'login_enqueue_scripts', 				[ $this, 'load_login_styles' ], 10 );			

			// Add styles attributes
			add_filter( 'style_loader_tag',  					[ $this, 'add_styles_attr' ], 10, 3 );

			// Header Inline CSS
			add_action( 'admin_head', 							[ $this, 'header_admin_styles' ], 12 );

			// Add block editor styles
			add_action( 'enqueue_block_editor_assets', 			[ $this, 'block_editor_assets' ], 1, 1 );

			// Front-end only
			if ( is_admin() ) { return; }

			// Main styles 
			add_action( 'wp_enqueue_scripts', 					[ $this, 'load_styles' ], 10 ); 

			// Fonts & typography 
			add_action( 'wp_enqueue_scripts', 					[ $this, 'load_fonts' ], 12 ); 

			// Header Inline CSS
			add_action( 'wp_head', 								[ $this, 'header_styles' ], 12 );
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
				self::$instance = new Self;
    		}
			return self::$instance;
		}

		/**
		 * Set a styles setting
		 *
		 * @param	string 	$key
		 * @param	mixed	$value
		 */
		public function __set( $key, $value ) {
			$this->settings[$key] = $value;
		}

		/**
		 * Get a styles setting
		 *
		 * @return	mixed
		 */
		public function __get( $key ) {
			return ( isset( $this->settings[$key] ) ) ? $this->settings[$key] : null;
		}
		
		/**
		 * Test if a settings exists
		 *
		 * @param	string	$key
		 * @return  boolean
		 */
		public function __isset( $key ) {
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
		 * Initialise main styles
		 */
		public function init() {

			// Retrieve theme config: styles
			$ip_styles = (array) apply_filters( 'ipress_styles', [] );
			if ( empty( $ip_styles ) ) { return; }

			// Admin styles: [ 'label' => [ 'hook', 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->admin = $this->set_key( $ip_styles, 'admin' );

			// Core styles: [ 'style-name', 'style-name' ... ];
			$this->core = $this->set_key( $ip_styles, 'core' );

			// External styles: [ 'style-name', 'style-name2' ... ]
			$this->external = $this->set_key( $ip_styles, 'external' );

			// Header styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->header = $this->set_key( $ip_styles, 'header' );

			// Plugin styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->plugins = $this->set_key( $ip_styles, 'plugins' );

			// Page styles: [ 'label' => [ 'template', 'src', (array)deps, 'version', 'media' ] ... ];
			$this->page = $this->set_key( $ip_styles, 'page' );

			// Front Page styles: [ 'label' => [ 'template', 'src', (array)deps, 'version', 'media' ] ... ];
			$this->front = $this->set_key( $ip_styles, 'front' );

			// Theme styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ];
			$this->theme = $this->set_key( $ip_styles, 'theme' );

			// Login page styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->login = $this->set_key( $ip_styles, 'login' );

			// Print only styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->print = $this->set_key( $ip_styles, 'print' );

			// Block editor styles: [ 'label' => [ 'src', (array)deps, 'ver', 'media' ] ... ]
			$this->block = $this->set_key( $ip_styles, 'block' );

			// Inline styles: [ 'handle' => [ 'src' => function/src ] ]
			$this->inline = $this->set_key( $ip_styles, 'inline' );
			
			// Styles attributes: [ 'label' => [ 'handle' ] ... ]
			$this->attr = $this->set_key( $ip_styles, 'attr' );
		}

		/**
		 * Validate and set key
		 *
		 * @param 	array 	$styles
		 * @param 	string 	$key
		 * @return 	array
		 */
		private function set_key( $styles, $key ) {
			return ( isset ( $styles[$key] ) && is_array( $styles[$key] ) ) ? $styles[$key] : [];
		}

		//----------------------------------------------
		//	Admin Styles
		//----------------------------------------------

		/**
		 * Load admin styles
		 */
		public function load_admin_styles() {

			// Initial validation
			if ( empty( $this->admin ) ) { return; }

			// Register & enqueue admin styles
			foreach ( $this->admin as $k => $v ) { 
				
				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media );
        		wp_enqueue_style( $k );
			}
		}

		//----------------------------------------------
		//	Scripts, Styles & Fonts
		//----------------------------------------------

		/**
		 * Load Theme CSS styles files in hierarchy order
		 */
		public function load_styles() { 

			// Register & enqueue core styles
			foreach ( $this->core as $style ) { wp_enqueue_style( $style ); }

			// Register & enqueue header styles
			foreach ( $this->external as $k => $v ) {
				
				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_style( $k );
				
				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline style
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}				
			}

			// Register & enqueue header styles
			foreach ( $this->header as $k => $v ) {

				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_style( $k );

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline style
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}				
			}
		
			// Register & enqueue plugin styles 
			foreach ( $this->plugins as $k => $v ) { 

				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_style( $k ); 

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline style
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}								
			}

			// Register and enqueue page template styles
			foreach ( $this->page as $k => $v ) {

				// Check for valid page template
				if ( is_page_template( $v[0] ) ) {
					
					// Set media type, default 'all'
					$media = ( isset( $v[4] ) && in_array( $v[4], $this->media ) ) ? $v[4] : 'all';

					// Register and enqueue style
					wp_register_style( $k, $v[1], $v[2], $v[3], $media ); 
					wp_enqueue_style( $k );
					
					// Set optional style attribute
					$this->set_style_attr( $k );

					// Inject associated inline style
					if ( array_key_exists( $k, $this->inline ) ) {
						$this->set_inline_style( $k );
					}				
				}
			}
			
			// Register & enqueue front page styles
			foreach ( $this->front as $k => $v ) {

				// First test
				if ( ! is_front_page() ) { continue; }

				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_script( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_script( $k );

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline script
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}
			}
			
			// Register & enqueue print media styles
			foreach ( $this->print as $k => $v ) {

				// Register and enqueue style
				wp_register_script( $k, $v[0], $v[1], $v[2], 'print' ); 
				wp_enqueue_script( $k );

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline script
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}
			}

			// Register & enqueue core styles
			foreach ( $this->theme as $k => $v ) { 
				
				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_style( $k ); 

				// Data processing
				wp_style_add_data( $k, 'rtl', 'replace' );

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline script
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}
			}
		}

		/**
		 * Add inline styles
		 *
		 * @param string $key
		 */
		private function set_inline_style( $key ) {
	
			// Get inline key data
			$data = $this->inline[$key]; 

			// Inject inline style inc handle
			if ( ! empty( $data ) ) {
				wp_add_inline_style( $key, $data ); 
			}		
		}

		/**
		 * Set style attributes to matching handles
		 *
		 * @param	string	$handle
		 */
		private function set_style_attr( $handle ) {

			// Nothing set?
			if ( empty( $this->attr ) ) { return; }

			// Sort attr into types, should not have async and defer for the same handle
			$defer 		= ( isset( $this->attr['defer'] ) && is_array( $this->attr['defer'] ) ) ? $this->attr['defer'] : [];
			$async 		= ( isset( $this->attr['async'] ) && is_array( $this->attr['async'] ) ) ? $this->attr['async'] : [];
			$integrity 	= ( isset( $this->attr['integrity'] ) && is_array( $this->attr['integrity'] ) ) ? $this->attr['integrity'] : [];

			// Ok, do defer or async, can't have both
			if ( in_array( $handle, $defer ) ) {
				wp_style_add_data( $handle, 'defer', true ); 
			} elseif ( in_array( $handle, $async ) ) {
				wp_style_add_data( $handle, 'async', true ); 
			}

			// Ok, do integrity
			foreach ( $integrity as $k => $v ) {
				foreach ( $v as $h => $a ) {
					if ( $handle === $h ) {
						wp_style_add_data( $handle, 'integrity', $a ); 
						wp_style_add_data( $handle, 'crossorigin', 'anonymous' );
						break;
					}
				}
			}
		}

		//----------------------------------------------
		// Load Theme Fonts
		//----------------------------------------------

		/**
		 * Load custom font families, default google fonts.
		 */
		public function load_fonts() { 

			// Retrieve theme config: styles
			$ip_fonts = (array) apply_filters( 'ipress_fonts', [] );
			if ( empty( $ip_fonts ) ) { return; }

			// No font family set?
			if ( ! isset( $ip_fonts['family'] ) || empty( $ip_fonts['family'] ) ) { return; }

			// Filterable fonts url, required
			$ip_fonts_url = (string) apply_filters( 'ipress_fonts_url', 'https://fonts.googleapis.com/css' );
			$ip_fonts_url = ( empty( $ip_fonts_url ) ) ? '' : esc_url_raw( $ip_fonts_url );
			if ( empty( $ip_fonts_url ) ) { return; }

			// Construct font: family
			$query_args = [
				'family' => ( is_array( $ip_fonts['family'] ) ) ? join( '|', $ip_fonts['family'] ) : $ip_fonts['family']
			];

			// Construct font: subset - 'latin,latin-ext'
			if ( isset( $ip_fonts['subset'] ) && ! empty( $ip_fonts['subset'] ) ) { 
				$query_args['subset'] = urlencode( $ip_fonts['subset'] );
			}

			// Set fonts url
			$ip_fonts_url = add_query_arg( $query_args, $ip_fonts_url );

			// Set media type
			$media = ( isset( $ip_fonts['media'] ) && in_array( $ip_fonts['media'], $this->media ) ) ? $ip_fonts['media'] : 'all';

			// Register & enqueue css style file for later use 
			wp_register_style( 'ipress-fonts', esc_url( $ip_fonts_url ), [], null, $media ); 
			wp_enqueue_style( 'ipress-fonts' ); 
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
			if ( empty( $ip_header_styles ) ) { return; }

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
			if ( empty( $ip_header_admin_styles ) ) { return; }

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

			// Initial validation
			if ( empty( $this->login ) ) { return; }

			// Register & enqueue admin styles
			foreach ( $this->login as $k => $v ) { 
				
				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_style( $k );

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline style
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}				
			}
		}
		
		//----------------------------------------------
		//	Block Editor Styles
		//----------------------------------------------

		/**
		 * Load block editor styles
		 */
		public function block_editor_assets() {

			// Initial validation
			if ( empty( $this->block ) ) { return; }

			// Register & enqueue admin styles
			foreach ( $this->block as $k => $v ) { 
				
				// Set media type, default 'all'
				$media = ( isset( $v[3] ) && in_array( $v[3], $this->media ) ) ? $v[3] : 'all';

				// Register and enqueue style
				wp_register_style( $k, $v[0], $v[1], $v[2], $media ); 
				wp_enqueue_style( $k );

				// Set optional style attribute
				$this->set_style_attr( $k );

				// Inject associated inline style
				if ( array_key_exists( $k, $this->inline ) ) {
					$this->set_inline_style( $k );
				}				

				// Add style data
				$ip_style_data = (bool) apply_filters( "ipress_{$k}_style_data", false );
				if ( true === $ip_style_data ) {
					wp_style_add_data( $k, 'rtl', 'replace' );
				}
			}
		}

		//----------------------------------------------
		//	Add Styles Attributes
		//----------------------------------------------

		/**
		 * Tag on script attributes to matching handles
		 *
		 * @param	string	$tag
		 * @param	string	$handle
		 * @param	string	$src
		 */
		public function add_styles_attr( $tag, $handle, $src ) {

			// Add async or defer
			foreach ( [ 'async', 'defer' ] as $attr ) {

				// Test if attribute set for handle 
				if ( ! wp_styles()->get_data( $handle, $attr ) ) {	continue; }

				// Prevent adding attribute when already added in trac #12009.
				if ( ! preg_match( ":\s$attr(=|/>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=/>):', "$attr ", $tag, 1 );
				}

				// Only allow async or defer, not both.
				break;
			}

			// OK, check integrity
			if ( $integrity = wp_styles()->get_data( $handle, 'integrity' ) ) {

				// Add integrity SHA string.
				$tag = preg_replace( ':(?=/>):', 'integrity="' . $integrity . '" ', $tag, 1 );

				// Add anonymous crossorigin for integrity				
				if ( $crossorigin = wp_styles()->get_data( $handle, 'crossorigin' ) ) {
					$tag = preg_replace( ':(?=/>):', 'crossorigin="' . $crossorigin . '" ', $tag, 1 );
				}
			}			

			return $tag;
		}

	}

endif;

// Instantiate Styles Loader class
return IPR_Load_Styles::getInstance();

//end
