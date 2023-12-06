<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Init' ) ) :

	/**
	 * Set up core WordPress features
	 */
	final class IPR_Init extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Core WordPress functionality
			add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

			// Clean up the messy WordPress header
			add_action( 'init', [ $this, 'clean_header' ] );

			// Remove comments functionality as best as possible
			add_action( 'init', [ $this, 'clean_comments' ] );

			// Remove the bloody awful emojicons! Worse than Pokemon!
			add_action( 'init', [ $this, 'disable_emojicons' ] );

			// Add a pingback url for articles if pings active
			add_action( 'wp_head', [ $this, 'pingback_header' ] );

			// Add slug to body class
			add_filter( 'body_class', [ $this, 'body_class' ] );

			// Wrapper for video embedding - generic & jetpack
			add_filter( 'embed_oembed_html', [ $this, 'embed_video_html' ], 10, 4 );
			add_filter( 'video_embed_html', [ $this, 'embed_video_html' ], 10, 4 );
		}

		//----------------------------------------------
		//	Theme SetUp
		//----------------------------------------------

		/**
		 * Set up core theme settings & functionality
		 */
		public function setup_theme() {

			// Enable customisable editor styles? Default, true
			$ip_editor_styles = (bool) apply_filters( 'ipress_editor_styles', false );
			if ( true === $ip_editor_styles ) {

				// Add support for editor styles.
				add_theme_support( 'editor-styles' );

				// Add support for editor font sizes.
				add_theme_support(
					'editor-font-sizes',
					(array) apply_filters(
						'ipress_editor_font_sizes',
						[
							[
								'name' => __( 'Small', 'ipress-standalone' ),
								'size' => 14,
								'slug' => 'small',
							],
							[
								'name' => __( 'Normal', 'ipress-standalone' ),
								'size' => 16,
								'slug' => 'normal',
							],
							[
								'name' => __( 'Medium', 'ipress-standalone' ),
								'size' => 22,
								'slug' => 'medium',
							],
							[
								'name' => __( 'Large', 'ipress-standalone' ),
								'size' => 28,
								'slug' => 'large',
							],
							[
								'name' => __( 'Big', 'ipress-standalone' ),
								'size' => 36,
								'slug' => 'big',
							],
						]
					)
				);

				// Set editor styles path
				$ip_editor_styles_url = apply_filters(
					'ipress_editor_styles_url',
					[
						IPRESS_ASSETS_URL . '/css/editor.css'
					]
				);

				// Add editor styles
				add_editor_style( $ip_editor_styles_url );
			}

			// Theme initialization
			do_action( 'ipress_startup' );
		}

		//----------------------------------------------
		//	Header Tidy Up
		//----------------------------------------------

		/**
		 * Clean the WordPress Header
		 * - The WordPress head contains multiple meta & link records,
		 * - many of which are not required, are detrimental, and slow loading
		 * - Activate and filterable options to selectively remove features
		 */
		public function clean_header() {

			// Due process, activate by choice
			$ip_header_clean = (bool) apply_filters( 'ipress_header_clean', false );
			if ( true === $ip_header_clean ) {

				// Remove feed & rsd links
				$this->header_links();
				
				// Remove index & rel links
				$this->rel_links();

				// Remove WordPress XHTML generator
				$this->xhtml_generator();

				// Remove versioning from scripts
				$this->header_version();
				
				// Clean CSS tags from enqueued stylesheets & gallery
				$this->header_css();
					
				// Remove inline recent comment styles from wp_head()
				$this->header_comments();

				// Canonical refereneces
				$this->header_canonical();
			}
		}

		/**
		 *  Remove feed & rsd links
		 */
		private function header_links() {
			$ip_header_links = (bool) apply_filters( 'ipress_header_links', false );
			if ( true === $ip_header_links ) {

				// Post & comment feeds
				remove_action( 'wp_head', 'feed_links', 2 );

				// Category feeds
				remove_action( 'wp_head', 'feed_links_extra', 3 );

				// EditURI link
				remove_action( 'wp_head', 'rsd_link' );

				// Windows live writer
				remove_action( 'wp_head', 'wlwmanifest_link' );

				// Shortlink for the page
				remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
			}
		}

		/**
		 * Remove index & rel links	
		 */
		private function rel_links() {
			$ip_header_index = (bool) apply_filters( 'ipress_header_index', false );
			if ( true === $ip_header_index ) {

				// Remove meta robots tag from wp_head
				remove_action( 'wp_head', 'noindex', 1 );

				// Index link
				remove_action( 'wp_head', 'index_rel_link' );

				// Previous link
				remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

				// Start link
				remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

				// Links for adjacent posts
				remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
			}
		}

		/**
		 * Remove WordPress XHTML generator
		 */
		private function xhtml_generator() {
			$ip_header_generator = (bool) apply_filters( 'ipress_header_generator', false );
			if ( true === $ip_header_generator ) {
				add_filter( 'the_generator', [ $this, 'disable_version' ] );
				remove_action( 'wp_head', 'wp_generator' );
			}
		}

		/**
		 * Remove versioning from scripts
		 */
		private function header_version() {
			$ip_header_version = (bool) apply_filters( 'ipress_header_version', false );
			if ( true === $ip_header_version ) {
				add_filter( 'style_loader_src', [ $this, 'loader_src' ], 9999, 10, 2 );
				add_filter( 'script_loader_src', [ $this, 'loader_src' ], 9999, 10, 2 );
			}
		}

		/**
		 * Clean CSS tags from enqueued stylesheets & gallery
		 */
		private function header_css() {
			$ip_header_css = (bool) apply_filters( 'ipress_header_css', false );
			if ( true === $ip_header_css ) {
				add_filter( 'style_loader_tag', [ $this, 'style_remove' ] );
				add_filter( 'gallery_style', [ $this, 'style_remove' ] );
			}
		}

		/**
		 *  Remove inline recent comment styles from wp_head()
		 */
		private function header_comments() {
			$ip_header_comments = (bool) apply_filters( 'ipress_header_comments', false );
			if ( true === $ip_header_comments ) {
				add_action( 'widgets_init', [ $this, 'head_comments' ] );
			}
		}

		/**
		 * Canonical refereneces
		 */
		private function header_canonical() {
			$ip_header_canonical = (bool) apply_filters( 'ipress_header_canonical', false );
			if ( true === $ip_header_canonical ) {
				remove_action( 'wp_head', 'rel_canonical' );
			}
		}

		/**
		 * Disable Version Reference
		 *
		 * @return string
		 */
		public function disable_version() {
			return '';
		}

		/**
		 * remove WP version from scripts
		 *
		 * @param string $src Script src url
		 * @param string $handle Script handle
		 * @return string
		 */
		public function loader_src( $src, $handle ) {
			return ( strpos( $src, 'ver=' ) ) ? remove_query_arg( 'ver', $src ) : $src;
		}

		/**
		 * Remove 'text/css' from our enqueued stylesheet
		 *
		 * @param string Style text to process
		 * @return string
		 */
		public function style_remove( $tag ) {
			return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
		}

		/**
		 * Remove wp_head() injected Recent Comment styles
		 *
		 * @global $wp_widget_factory
		 */
		public function head_comments() {

			global $wp_widget_factory;

			// Remove head comments
			remove_action(
				'wp_head',
				[
					$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
					'recent_comments_style',
				]
			);

			// Check and remove
			if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
				remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
			}
		}

		//----------------------------------------------
		//	Comments functionality
		//----------------------------------------------

		/**
		 * Remove Comments funtionality from the admin UI & frontend
		 * - Admin UI comments links
		 * - Post-type support
		 * - Frontend display
		 */
		public function clean_comments() {

			// Due process, activate by choice
			$ip_comments_clean = (bool) apply_filters( 'ipress_comments_clean', false );
			if ( true === $ip_comments_clean ) {

				// Removes comments link from admin menu
				add_action( 'admin_menu', [ $this, 'comments_admin_links' ] );
				
				// Remove index & rel links
				add_action( 'admin_init', [ $this, 'comments_post_type_support' ] );

				// Close comments on the front-end
				add_filter( 'comments_open', '__return_false', 20, 2 );
				add_filter( 'pings_open', '__return_false', 20, 2 );
				 
				// Hide existing comments
				add_filter( 'comments_array', '__return_empty_array', 10, 2 );

				// Remove comments link from admin bar
				add_action( 'wp_before_admin_bar_render', [ $this, 'comments_admin_bar' ] );
			}
		}

		/**
		 * Disable admin UI menu comments link
		 */
		public function comments_admin_links() {
			remove_menu_page( 'edit-comments.php' );
		}

		/**
		 * Remove comment support from post-types
		 */
		public function comments_post_type_support() {

			// Redirect any user trying to access comments page
			global $pagenow;

			// We shouldn't get here	
			if ( $pagenow === 'edit-comments.php' ) {
				wp_safe_redirect(admin_url());
				exit;
			}
		 
			// Remove comments metabox from dashboard
			remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		 
			// Disable support for comments and trackbacks in post types
			foreach ( get_post_types() as $post_type ) {
				if ( post_type_supports( $post_type, 'comments' ) ) {
					remove_post_type_support( $post_type, 'comments' );
					remove_post_type_support( $post_type, 'trackbacks' );
				}
			}
		}

		/**
		 * Remove admin bar comments link 
		 */
		public function comments_admin_bar() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
		}

		//----------------------------------------------
		//	Features
		//----------------------------------------------

		/**
		 * Remove emojicons support - hurrah!
		 */
		public function disable_emojicons() {

			// Ok, we know you really want to do this!
			$ip_disable_emojicons = (bool) apply_filters( 'ipress_disable_emojicons', false );
			if ( true === $ip_disable_emojicons ) {

				// Remove head/foot styles & script
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );
				remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
				remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
				remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

				// Editor functionality
				add_filter( 'tiny_mce_plugins', [ $this, 'disable_emojis_tinymce' ] );
			}
		}

		/**
		 * Remove tinymce emoji support
		 *
		 * @param array $plugins Active plugins list
		 * @return array
		 */
		public function disable_emojis_tinymce( $plugins ) {
			return ( is_array( $plugins ) ) ? array_diff( $plugins, [ 'wpemoji' ] ) : [];
		}

		/**
		 * Add a pingback url for articles if pings active
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				echo sprintf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}

		//---------------------------------------------
		//	Layout Actions & Filters
		//---------------------------------------------

		/**
		 * Add page slug to body class - Credit: Starkers WordPress Theme
		 *
		 * @global $post
		 * @param array $classes Active body classes
		 * @return array $classes
		 */
		public function body_class( $classes ) {

			global $post;

			// Add featured image classes to singular pages
			if ( is_singular() && has_post_thumbnail() ) { 
				$classes[] = 'has-image';
			}

			// Add class if we're viewing the Customizer
			if ( is_customize_preview() ) {
				$classes[] = 'is-customizer customizer-preview';
			}

			return (array) apply_filters( 'ipress_body_class', $classes );
		}

		/**
		 * Video embedding wrapper
		 *
		 * @param string $html Video HTML
		 * @param string $url Video url to embed
		 * @param array $attr Attributes list
		 * @param integer $post_id Post ID
		 * @return string
		 */
		public function embed_video_html( $html, $url, $attr, $post_id ) {
			return (string) apply_filters( 'ipress_embed_video', sprintf( '<div class="video-container">%s</div>', $html ), $html );
		}
	}

endif;

// Instantiate Initialiser Class
return IPR_Init::Init();
