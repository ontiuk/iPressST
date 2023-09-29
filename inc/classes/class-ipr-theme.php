<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress theme features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Theme' ) ) :

	/**
	 * Set up core theme features
	 */
	final class IPR_Theme extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Default content width for image manipulation
			add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );

			// Core WordPress functionality
			add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );
		}

		//----------------------------------------------
		//	Theme SetUp
		//----------------------------------------------

		/**
		 * Required default content width for image manipulation
		 *
		 * - Priority 0 to make it available to lower priority callbacks
		 *
		 * @global int $content_width
		 */
		public function content_width() {

			global $content_width;

			if ( ! isset( $content_width ) ) {
				$content_width = (int) apply_filters( 'ipress_content_width', 1200 ); /* pixels */
			}
		}

		/**
		 * Set up core theme settings & functionality
		 * 
		 * - Some such as logo, header and background moved to customizer setup
		 * 
		 * @global integer $wp_version
		 */
		public function setup_theme() {

			global $wp_version;

			// Load the iPress Parent Theme text domain. Checks in order, if e.g. it_IT lang:
			// 1. wp-content/languages/themes/ipress-it_IT.mo via WP_LANG_DIR
			// 2. wp-content/themes/ipress/languages/it_IT.mo via get_template_directory()
			load_theme_textdomain( 'ipress-standalone', trailingslashit( WP_LANG_DIR ) . 'themes' );
			load_theme_textdomain( 'ipress-standalone', IPRESS_LANG_DIR );

			// Add thumbnail theme support & post type support
			// @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			// - add_theme_support( 'post-thumbnails' );
			// - add_theme_support( 'post-thumbnails', $post_types );

			// Set post types, default post
			$ip_post_thumbnails_post_types = (array) apply_filters( 'ipress_post_thumbnails_post_types', [ 'post' ] );

			// Set post-thumbnail support
			add_theme_support( 'post-thumbnails', $ip_post_thumbnails_post_types );
				
			// Set thumbnail default size: width, height, crop
			// - set_post_thumbnail_size( 50, 50 ); 						// 50px x 50px, prop resize
			// - set_post_thumbnail_size( 50, 50, true ); 					// 50px x 50px, hard crop
			// - set_post_thumbnail_size( 50, 50, [ 'left', 'top' ] ); 		// 50px x 50px, hard crop from top left
			// - set_post_thumbnail_size( 50, 50, [ 'center', 'center' ] ); // 50 px x 50px, crop from center
			$ip_post_thumbnail_size = (array) apply_filters( 'ipress_post_thumbnail_size', [] );
			if ( $ip_post_thumbnail_size ) {
				$this->set_post_thumbnail_size( $ip_post_thumbnail_size );
			}

			// Core image sizes overrides
			// - add_image_size( 'large', 1024, '', true ); 		// Large Image
			// - add_image_size( 'medium', 768, '', true ); 		// Medium Image
			// - add_image_size( 'medium_large', 768, '', true ); 	// Medium Large Image
			// - add_image_size( 'thumbnail', 320, '', true);			// Small Image
			$ip_image_size_default = (array) apply_filters( 'ipress_image_size_default', [] );
				
			// Filter array for legitimate values only, check it's a built-in image size...
			$ip_image_size_default = array_filter( $ip_image_size_default, function( $key ) {
				return in_array( $key, [ 'large', 'medium', 'medium_large', 'thumbnail' ], true );
			}, ARRAY_FILTER_USE_KEY );

			// Ok, Reset image size defaults with hopefully valid replacements
			if ( $ip_image_size_default ) {
				$this->set_add_image_size( $ip_image_size_default );
			}

			// Custom image sizes
			// - add_image_size( 'custom-size', 220 );					// 220px wide, relative height, soft proportional crop mode
			// - add_image_size( 'custom-size', '', 480 );				// relative width, 480px height, soft proportional crop mode
			// - add_image_size( 'custom-size-prop', 220, 180 );		// 220px x 180px, soft proportional crop
			// - add_image_size( 'custom-size-prop-height', 9999, 180); // 180px height: proportion resize
			// - add_image_size( 'custom-size-crop', 220, 180, true );	// 220 pixels wide by 180 pixels tall, hard positional crop mode
			$ip_add_image_size = (array) apply_filters( 'ipress_add_image_size', [] );
			if ( $ip_add_image_size ) {
				$this->set_add_image_size( $ip_add_image_size );
			}

			// Turn off big image support, from WP 5.3
			$ip_big_image_size = (bool) apply_filters( 'ipress_big_image_size', true );
			if ( false === $ip_big_image_size ) {
				add_filter( 'big_image_size_threshold', '__return_false' );
			}

			// Register default navigation menu locations
			// register_nav_menus( [
			//	 'primary' 	 => __( 'Primary Menu', 'ipress-standalone' ),
			//   'secondary' => __( 'Secondary Menu', 'ipress-standalone' ),
			//   'social'    => __( 'Social Menu', 'ipress-standalone' ),
			//   'header'    => __( 'Header Menu', 'ipress-standalone' ),
			// ] );
			$ip_nav_menus = (array) apply_filters( 'ipress_nav_menus', [] );
			if ( $ip_nav_menus ) {
				register_nav_menus( $ip_nav_menus );
			}

			// Enable support for HTML5 markup: 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets',	'script', 'style', 'editor-styles', 'align-wide'
			// add_theme_support( 'html5', [ 'search-form', 'gallery' ] );
			$ip_html5 = (array) apply_filters(
				'ipress_html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'widgets'
				]
			);

			// Filter array for legitimate values only...
			$ip_html5 = array_filter( $ip_html5, function( $key, $item ) {
				return in_array( $item, [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets', 'script', 'style', 'editor-styles', 'align-wide' ], true );
			}, ARRAY_FILTER_USE_BOTH );

			// Add support for HTML5 values
			if ( $ip_html5 ) {
				add_theme_support( 'html5', $ip_html5 );
			}

			// Add post-format support: 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
			// add_theme_support( 'post-formats', [ 'image', 'link' ] );
			$ip_post_formats = (array) apply_filters( 'ipress_post_formats', [] );

			// Filter array for legitimate values only, check it's a built-in image size...
			$ip_post_formats = array_filter( $ip_post_formats, function( $key, $item ) {
				return in_array( $item, [ 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat' ], true );
			}, ARRAY_FILTER_USE_BOTH );

			// Add support for p[ost-formats
			if ( $ip_post_formats ) {
				add_theme_shupport( 'post-formats', $ip_post_formats );
			}

			// Add feed link support
			add_theme_support( 'automatic-feed-links' );

			// Custom plugin & feature support, e.g. Guttenberg wide image alignment, embeds & block styles
			$ip_theme_support = (array) apply_filters(
				'ipress_theme_support',
				[
					'align-wide',
					'responsive-embeds',
					'wp-block-styles',
				]
			);
			// Set theme support if required...
			array_walk( $ip_theme_support, function( $feature, $key ) {
				if ( ! current_theme_supports( $feature ) ) {
					add_theme_support( $feature );
				}
			} );

			// Custom plugin & feature support removal
			$ip_remove_theme_support = (array) apply_filters( 'ipress_remove_theme_support', [] );
			array_walk( $ip_remove_theme_support, function( $feature , $key ) {
				if ( current_theme_supports( $feature ) ) {
					remove_theme_support( $feature );
				}
			} );

			// Make WordPress manage the document title & <title> tag
			add_theme_support( 'title-tag' );

			// Custom title tag? Or, let WP handle it and plugins override
			$ip_custom_title_tag = (bool) apply_filters( 'ipress_custom_title_tag', false );
			if ( true === $ip_custom_title_tag ) {
				add_filter( 'pre_get_document_title', [ $this, 'pre_get_document_title' ] );
				add_filter( 'document_title_separator', [ $this, 'document_title_separator' ], 10, 1 );
				add_filter( 'document_title_parts', [ $this, 'document_title_parts' ], 10, 1 );
			}

			// Theme initialization
			do_action( 'ipress_setup' );
		}

		//----------------------------------------------
		//	Thumbnail & Image Support
		//----------------------------------------------

		/**
		 * Set up thumbnail image size
		 *
		 * [ width:int, height:int, crop:bool ]
		 *
		 * @param array $size Thumbnail size & crop data
		 */
		private function set_post_thumbnail_size( $size ) {
			[ $width, $height, $crop ] = array_pad( $size, 3, 0 );
			if ( $width || $height ) {
				set_post_thumbnail_size( $width, $height, ( 0 === $crop ) ? false : (bool) $crop );
			}
		}

		/**
		 * Set up thumbnail image size
		 *
		 * [ name => [ width:int, height:int, crop:bool ] ]
		 *
		 * @param array $sizes Image size data to add
		 */
		private function set_add_image_size( $sizes ) {
			array_walk( $sizes, function( $item, $key ) {
				[ $width, $height, $crop ] = array_pad( $item, 3, 0 );
				if ( $width || $height ) {
					add_image_size( $key, $width, $height, (bool) $crop );
				}
			} );
		}

		//----------------------------------------------
		//	Title Tag Support
		//
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

				// Get blog title
				$title = get_bloginfo( 'name' );

				// Get title separator
				$ip_document_title_separator = (string) apply_filters( 'ipress_document_title_separator', '-' );

				// Append or prepend?
				$ip_home_doctitle_append = (bool) apply_filters( 'ipress_home_doctitle_append', true );

				// Sanitize title
				$title = $this->pre_sanitize_title( $title );

				// Return title
				return ( $ip_home_doctitle_append ) ? sprintf( '%s %s %s', $title, esc_attr( $ip_document_title_separator ), get_bloginfo( 'description' ) ) : $title;
			}

			return '';
		}

		/**
		 * Define the document_title_separator callback
		 *
		 * @param string $sep Title separator
		 * @return string
		 */
		public function document_title_separator( $sep ) {

			// Get the theme setting and set if needed...
			$ip_doctitle_separator = (string) apply_filters( 'ipress_doctitle_separator', '' );

			return ( empty( $ip_doctitle_separator ) ) ? $sep : esc_attr( $ip_doctitle_separator );
		}

		/**
		 * Define the document_title_parts callback
		 *
		 * @param array $title Document title
		 * @return array $title
		 */
		public function document_title_parts( $title ) {

			// Home page or not amending inner pages
			if ( is_front_page() ) {
				return $title;
			}

			// Append site name?
			$ip_append_site_name = (bool) apply_filters( 'ipress_append_site_name', true );
			$title['site'] = ( true === $ip_append_site_name ) ? get_bloginfo( 'name' ) : '';

			return $title;
		}

		/**
		 * Pre sanitize the title string
		 *
		 * @param string $title Document title
		 * @return string $title
		 */
		public function pre_sanitize_title( $title ) {

			// Process sanitization
			$title = wptexturize( $title );
			$title = convert_chars( $title );
			$title = esc_html( $title );
			$title = capital_P_dangit( $title );

			return $title;
		}
	}

endif;

// Instantiate Theme Class
return IPR_Theme::Init();
