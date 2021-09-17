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

if ( ! class_exists( 'IPR_Init' ) ) :

	/**
	 * Set up core WordPress theme features
	 */
	final class IPR_Init {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Core WordPress functionality
			add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

			// Clean up the messy WordPress header
			add_action( 'init', [ $this, 'clean_header' ] );

			// Remove the bloody awful emojicons! Worse than Pokemon!
			add_action( 'init', [ $this, 'disable_emojicons' ] );

			// Add a pingback url for articles if pings active
			add_action( 'wp_head', [ $this, 'pingback_header' ] );
		}

		//----------------------------------------------
		//	Theme SetUp
		//----------------------------------------------

		/**
		 * Add editor styles if required
		 */
		public function setup_theme() {

			// Enable customisable editor styles? Default, true
			$ip_editor_styles = (bool) apply_filters( 'ipress_editor_styles', true );
			if ( true !== $ip_editor_styles ) {
				return;
			}

			// Add support for editor styles.
			add_theme_support( 'editor-styles' );

			// Add support for editor font sizes.
			add_theme_support(
				'editor-font-sizes',
				(array) apply_filters(
					'ipress_editor_font_sizes',
					[
						[
							'name' => __( 'Small', 'ipress' ),
							'size' => 14,
							'slug' => 'small',
						],
						[
							'name' => __( 'Normal', 'ipress' ),
							'size' => 16,
							'slug' => 'normal',
						],
						[
							'name' => __( 'Medium', 'ipress' ),
							'size' => 22,
							'slug' => 'medium',
						],
						[
							'name' => __( 'Large', 'ipress' ),
							'size' => 28,
							'slug' => 'large',
						],
						[
							'name' => __( 'Big', 'ipress' ),
							'size' => 36,
							'slug' => 'big',
						],
					]
				)
			);

			// External fonts
			$ip_fonts = $this->load_fonts();

			// Add editor styles
			if ( empty( $ip_fonts ) ) {
				add_editor_style( IPRESS_CSS_URL . '/editor.css' );
			} else {
				add_editor_style( [ IPRESS_CSS_URL . '/editor.css', $ip_fonts ] );
			}

			// Theme initialization
			do_action( 'ipress_startup' );
		}

		/**
		 * Load custom font families, default google fonts.
		 *
		 * @return string $ip_fonts_url
		 */
		public function load_fonts() {

			// Retrieve theme fonts, if used
			$ip_fonts = (array) apply_filters( 'ipress_fonts', [] );
			if ( empty( $ip_fonts ) ) {
				return;
			}

			// Filterable fonts url, required
			$ip_fonts_url = (string) apply_filters( 'ipress_fonts_url', 'https://fonts.googleapis.com/css' );
			if ( empty( $ip_fonts_url ) ) {
				return;
			}

			// Construct font: family & subset
			$query_args = [
				'family' => join( '|', $ip_fonts ),
				'subset' => rawurlencode( apply_filters( 'ipress_fonts_subset', 'latin,latin-ext' ) ),
			];

			// Set fonts url
			$ip_fonts_url = add_query_arg( $query_args, $ip_fonts_url );

			return $ip_fonts_url;
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

			// Due process
			$ip_header_clean = (bool) apply_filters( 'ipress_header_clean', false );
			if ( true !== $ip_header_clean ) {
				return;
			}

			// Remove feed & rsd links
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

			// Remove index & rel links
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

			// Remove WordPress XHTML generator
			$ip_header_generator = (bool) apply_filters( 'ipress_header_generator', false );
			if ( true === $ip_header_generator ) {
				add_filter( 'the_generator', [ $this, 'disable_version' ] );
				remove_action( 'wp_head', 'wp_generator' );
			}

			// Remove versioning from scripts
			$ip_header_version = (bool) apply_filters( 'ipress_header_version', false );
			if ( true === $ip_header_version ) {
				add_filter( 'style_loader_src', [ $this, 'loader_src' ], 9999, 10, 2 );
				add_filter( 'script_loader_src', [ $this, 'loader_src' ], 9999, 10, 2 );
			}

			// Clean CSS tags from enqueued stylesheet
			$ip_header_css = (bool) apply_filters( 'ipress_header_css', false );
			if ( true === $ip_header_css ) {
				add_filter( 'style_loader_tag', [ $this, 'style_remove' ] );
			}

			// Remove inline recent comment styles from wp_head()
			$ip_header_comments = (bool) apply_filters( 'ipress_header_comments', false );
			if ( true === $ip_header_comments ) {
				add_action( 'widgets_init', [ $this, 'head_comments' ] );
			}

			// Canonical refereneces
			$ip_header_canonical = (bool) apply_filters( 'ipress_header_canonical', false );
			if ( true === $ip_header_canonical ) {
				remove_action( 'wp_head', 'rel_canonical' );
			}

			// Show less info to users on failed login for security.
			$ip_header_login = (bool) apply_filters( 'ipress_header_login', false );
			if ( true === $ip_header_login ) {
				$ip_login_info = (string) apply_filters( 'ipress_login_info', __( '<strong>ERROR</strong>: Stop guessing!', 'ipress' ) );
				if ( ! empty( $ip_login_info ) ) {
					add_filter( 'login_errors', esc_html( $ip_login_info ) );
				}
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
		 * @param string $src
		 * @param string $handle
		 * @return string
		 */
		public function loader_src( $src, $handle ) {
			return ( strpos( $src, 'ver=' ) ) ? remove_query_arg( 'ver', $src ) : $src;
		}

		/**
		 * Remove 'text/css' from our enqueued stylesheet
		 *
		 * @param string
		 * @return string
		 */
		public function style_remove( $tag ) {
			return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
		}

		/**
		 * Remove wp_head() injected Recent Comment styles
		 *
		 * global $wp_widget_factory
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
		//	Features
		//----------------------------------------------

		/**
		 * Remove emojicons support - hurrah!
		 */
		public function disable_emojicons() {

			// Ok, we know you really want to do this!
			$ip_disable_emojicons = (bool) apply_filters( 'ipress_disable_emojicons', true );
			if ( true !== $ip_disable_emojicons ) {
				return;
			}

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

		/**
		 * Remove tinymce emoji support
		 *
		 * @param array $plugins
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
	}

endif;

// Instantiate Initialiser Class
return new IPR_Init;
