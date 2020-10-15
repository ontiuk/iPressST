<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress theme features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Theme' ) ) :

	/**
	 * Set up core theme features
	 */ 
	final class IPR_Theme {

		/**
		 * Class constructor. Set up hooks
		 */
		public function __construct() {

			// Default content width for image manipulation
			add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );

			// Core WordPress functionality
			add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

			// Preload fonts & resources
			add_filter( 'wp_resource_hints', [ $this, 'resource_hints' ], 10, 2 );
		}

		//----------------------------------------------
		//	Theme SetUp
		//----------------------------------------------

		/**
		 * Required default content width for image manipulation
		 * - Priority 0 to make it available to lower priority callbacks
		 *
		 * @global int $content_width
		 */
		public function content_width() {
			
			global $content_width;

			if ( ! isset( $content_width ) ) {
				$content_width = (int) apply_filters( 'ipress_content_width', 840 );
			}
		}

		/**
		 * Set up core theme settings & functionality
		 * - Some such as logo, header and background moved to customizer setup
		 */
		public function setup_theme() {

			global $wp_version;

			// Load the iPress Parent Theme text domain. Checks in order, if e.g. it_IT lang:
			// 1. wp-content/languages/themes/ipress-it_IT.mo via WP_LANG_DIR
			// 2. wp-content/themes/ipress/languages/it_IT.mo via get_template_directory()
			load_theme_textdomain( 'ipress', IPRESS_LANG_DIR );

			// Enables post and comment RSS feed links to head 
			$ip_feed_links_support = (bool) apply_filters( 'ipress_feed_links_support', true );
			if ( true === $ip_feed_links_support ) {
				add_theme_support( 'automatic-feed-links' ); 
			}

			// Add thumbnail theme support & post type support
			// @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			// - add_theme_support( 'post-thumbnails' ); 
			// - add_theme_support( 'post-thumbnails', $post_types );
			$ip_post_thumbnails_support 	= (bool) apply_filters( 'ipress_post_thumbnails_support', true );
			$ip_post_thumbnails_post_types 	= (array) apply_filters( 'ipress_post_thumbnails_post_types', [] );
			if ( true === $ip_post_thumbnails_support ) {
				if ( empty( $ip_post_thumbnails_post_types ) ) {
					add_theme_support( 'post-thumbnails' ); 
				} else {
					add_theme_support( 'post-thumbnails', $ip_post_thumbnails_post_types ); 
				}
			}

			// Set thumbnail default size: width, height, crop
			// - set_post_thumbnail_size( 50, 50 ); 						// 50px x 50px, prop resize
			// - set_post_thumbnail_size( 50, 50, true ); 					// 50px x 50px, hard crop
			// - set_post_thumbnail_size( 50, 50, [ 'left', 'top' ] ); 		// 50px x 50px, hard crop from top left
			// - set_post_thumbnail_size( 50, 50, [ 'center', 'center' ] ); // 50 px x 50px, crop from center
			$ip_post_thumbnail_size = (array) apply_filters( 'ipress_post_thumbnail_size', [] );
			if ( true === $ip_post_thumbnails_support && true === $ip_post_thumbnail_size ) {
				$this->set_post_thumbnail_size( $ip_post_thumbnail_size );
			}

			// Core image sizes overrides
			// - add_image_size( 'large', 1024, '', true ); 			// Large Image 
			// - add_image_size( 'medium', 768, '', true ); 			// Medium Image 
			// - add_image_size( 'medium_large', 768, '', true ); 		// Medium Large Image 
			// - add_image_size( 'small', 320, '', true);				// Small Image 
			$ip_image_size_default = (array) apply_filters( 'ipress_image_size_default', [] );
			if ( true === $ip_post_thumbnails_support && ! empty( $ip_image_size_default ) ) {
				array_walk( $ip_image_size_default, function ( $v, $k ) use( &$ip_image_size_default ) { 
					if ( ! in_array( $k, [ 'large', 'medium', 'medium_large', 'small' ] ) ) { unset( $ip_image_size_default[$k] ); };
				} );	
				$this->set_add_image_size( $ip_image_size_default );
			}
	 
			// Custom image sizes
			// - add_image_size( 'custom-size', 220 );					// 220px wide, relative height, soft proportional crop mode
			// - add_image_size( 'custom-size', '', 480 );				// relative width, 480px height, soft proportional crop mode
			// - add_image_size( 'custom-size-prop', 220, 180 );		// 220px x 180px, soft proportional crop
			// - add_image_size( 'custom-size-prop-height', 9999, 180); // 180px height: proportion resize 
			// - add_image_size( 'custom-size-crop', 220, 180, true );	// 220 pixels wide by 180 pixels tall, hard positional crop mode
			$ip_add_image_size = (array) apply_filters( 'ipress_add_image_size', [] );
			if ( true === $ip_post_thumbnails_support && ! empty( $ip_add_image_size ) ) {
				$this->set_add_image_size( $ip_add_image_size );
			}

			// Turn off big image support, from WP 5.3
			$ip_big_image_size = (bool) apply_filters( 'ipress_big_image_size', true );
			if ( true === $ip_post_thumbnails_support && false === $ip_big_image_size && version_compare( $wp_version, '5.3.0', '>=' ) ) {
				add_filter( 'big_image_size_threshold', '__return_false' );
			}

			// Add menu support
			$ip_menus_support = (bool) apply_filters( 'ipress_menus_support', true );

			// Set default navigation menu locations
			$ip_nav_menus_default = (array) apply_filters( 'ipress_nav_menus_default', [ 
				'primary'   => __( 'Primary Menu', 'ipress' )
			] );

			// Register additional navigation menu locations
			// register_nav_menus( [ 
			//   'secondary' => __( 'Secondary Menu', 'ipress' ),
			//   'social'    => __( 'Social Menu', 'ipress' ),
			//   'header'    => __( 'Header Menu', 'ipress' ) 
			// ] );
			$ip_nav_menus = (array) apply_filters( 'ipress_nav_menus', [] );

			// Set up and register menus
			$ip_nav_menus = array_merge( $ip_nav_menus_default, $ip_nav_menus );
			if ( true === $ip_menus_support && ! empty( $ip_nav_menus ) ) { 
				register_nav_menus( $ip_nav_menus ); 
			}

			// Enable support for HTML5 markup: 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets',	'script', 'style', 'editor-styles', 'align-wide' 
			$ip_html5 = (array) apply_filters( 'ipress_html5', [
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'widgets'
			] );
			if ( ! empty( $ip_html5 ) ) {
				add_theme_support( 'html5', $ip_html5 );
			}

			// Add post-format support: 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
			// add_theme_support( 'post-formats', [ 'image', 'link' ] ); 
			$ip_post_formats = (array) apply_filters( 'ipress_post_formats', [] );
			if ( ! empty( $ip_post_formats ) ) {
				add_theme_support( 'post-formats', $ip_post_formats ); 
			}

			// Custom plugin & feature support, e.g. Guttenberg wide image alignment & embeds
			$ip_theme_support = (array) apply_filters( 'ipress_theme_support', [ 'align-wide', 'responsive-embeds' ] );
			if ( ! empty( $ip_theme_support ) ) {
				foreach ( $ip_theme_support as $feature ) {
					if ( current_theme_supports( $feature ) ) { continue; }
					add_theme_support ( $feature );
				}
			}

			// Custom plugin & feature support removal
			$ip_remove_theme_support = (array) apply_filters( 'ipress_remove_theme_support', [] );
			if ( ! empty( $ip_remove_theme_support ) ) {
				foreach ( $ip_remove_theme_support as $feature ) {
					if ( current_theme_supports( $feature ) ) {
						remove_theme_support ( $feature );
					}
				}
			}

			// Make WordPress manage the document title & <title> tag
			$ip_title_tag = (bool) apply_filters( 'ipress_title_tag', true );
			if ( true === $ip_title_tag ) {

				// Make WordPress manage the document title & <title> tag
				add_theme_support( 'title-tag' );

				// Newer title tag hooks - requires title-tag support above
				add_filter( 'pre_get_document_title',	[ $this, 'pre_get_document_title' ] ); 
				add_filter( 'document_title_separator', [ $this, 'document_title_separator' ], 	10, 1 ); 
				add_filter( 'document_title_parts',		[ $this, 'document_title_parts' ], 		10, 1 ); 
			}
			
			// Theme initialization
			do_action( 'ipress_setup' );
		}

		//----------------------------------------------
		//	Thumbnail & Image Support
		//----------------------------------------------

		/**
		 * Set up thumbnail image size
		 * [ width:int, height:int, crop:bool ]
		 *
		 * @param array $size
		 */
		private function set_post_thumbnail_size( $size ) {
			list( $width, $height, $crop ) = array_pad( $size, 3, '' );
			set_post_thumbnail_size( $width, $height, ( empty( $crop ) ) ? false : $crop );
		}

		/**
		 * Set up thumbnail image size
		 * [ name => [ width:int, height:int, crop:bool ] ]
		 *
		 * @param array $sizes
		 */
		private function set_add_image_size( $sizes ) {
			foreach ( $sizes as $k => $v ) {
				list( $width, $height, $crop ) = array_pad( $v, 3, '' );
				add_image_size( $k, $width, $height, (bool)$crop );
			}
		}

		//----------------------------------------------
		//	Title Tag Support
		//	- Make WordPress manage the document title
		//----------------------------------------------

		/**
		 * Define the pre_get_document_title callback 
		 *	
		 * @return string
		 */
		public function pre_get_document_title() { 
		
			// Home page?
			if ( is_front_page() ) {

				// Get details
				$title = get_bloginfo( 'name' );		
				$ip_document_title_separator = (string) apply_filters( 'ipress_document_title_separator', '-' );
				$ip_home_doctitle_append 	 = (bool) apply_filters( 'ipress_home_doctitle_append', true );

				// Sanitize title
				$title = $this->pre_sanitize_title( $title );
	
				// Return title		   
				return ( $ip_home_doctitle_append ) ? sprintf( '%s %s %s', $title, esc_attr( $ip_document_title_separator ), get_bloginfo( 'description' ) ) : $title;
			}

			// Default
			return ''; 
		} 

		/**
		 * Define the document_title_separator callback 
		 *
		 * @param	string $sep
		 * @return	string
		 */
		public function document_title_separator( $sep ) { 

			// Get the theme setting and set if needed...
			$ip_doctitle_separator = (string) apply_filters( 'ipress_doctitle_separator', '' );

			// Return title separator
			return ( empty( $ip_doctitle_separator ) ) ? $sep : esc_attr( $ip_doctitle_separator ); 
		} 

		/**
		 * Define the document_title_parts callback 
		 *
		 * @param	array $title
		 * @return	array $title
		 */ 
		public function document_title_parts( $title ) { 

			// Home page or not amending inner pages
			if ( is_front_page() ) { return $title; }
		
			// Append site name?
			$ip_append_site_name 	= (bool) apply_filters( 'ipress_append_site_name', true );
			$title['site'] 			= ( true === $ip_append_site_name ) ? get_bloginfo( 'name' ) : '';

			// Return
			return $title; 
		}
		
		/**
		 * Pre sanitize the title string
		 *
		 * @param	string	$title
		 * @return	string	$title
		 */
		public function pre_sanitize_title( $title ) {

			// Process sanitization
			$title = wptexturize( $title );
			$title = convert_chars( $title );
			$title = esc_html( $title );
			$title = capital_P_dangit( $title );
			
			return $title;
		}

		/**
		 * Add preconnect for Google Fonts
		 *
		 * @param	array	$urls	URLs to print for resource hints
		 * @param	string	$relation_type	The relation type the URLs are printed
		 * @return	array	$urls	URLs to print for resource hints
		 */
		public function resource_hints( $urls, $relation_type ) {
	  
			if ( wp_style_is( 'ipress-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
				$urls[] = [
					'href' => 'https://fonts.gstatic.com',
					'crossorigin',
				];
			}

			// Modify & add custom resource hints
			$urls = (array) apply_filters( 'ipress_resource_hints', $urls ); 

			return $urls;
		}
	}

endif;

// Instantiate Theme Class
return new IPR_Theme;

//end
