<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress Layout features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Layout' ) ) :

	/**
	 * Initialise and set up Layout features
	 */
	final class IPR_Layout {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Add slug to body class
			add_filter( 'body_class', [ $this, 'body_class' ] );

			// Remove hentry in lieu of using schema format
			add_filter( 'post_class', [ $this, 'post_class' ], 10, 1 );

			// Remove or amend the 'read more' link
			add_filter( 'the_content_more_link', [ $this, 'read_more_link' ] );

			// Wrapper for video embedding - generic & jetpack
			add_filter( 'embed_oembed_html', [ $this, 'embed_video_html' ], 10, 4 );
			add_filter( 'video_embed_html', [ $this, 'embed_video_html' ], 10, 4 );
		}

		//---------------------------------------------
		//	Layout Actions & Filters
		//---------------------------------------------

		/**
		 * Add page slug to body class - Credit: Starkers WordPress Theme
		 *
		 * @param array $classes
		 * @return array $classes
		 */
		public function body_class( $classes ) {

			global $post;

			// Add classes to singular pages
			if ( is_singular() ) {

				// Base singular
				$classes[] = 'ipress-singular';

				// Add class for featured image
				$classes[] = ( has_post_thumbnail() ) ? 'ipress-singular-image' : 'ipress-singular-image-hidden';

				// Check if posts have single pagination
				$classes[] = ( get_next_post() || get_previous_post() ) ? 'ipress-single-pagination' : 'ipress-single-pagination-hidden';

				// Check if we're showing comments
				if ( $post && ( ( 'post' === get_post_type() || comments_open() || get_comments_number() ) && ! post_password_required() ) ) {
					$classes[] = 'ipress-with-comments';
				} else {
					$classes[] = 'ipress-no-comments';
				}
			}

			// Add class for breadcrumbs
			if ( is_singular() || is_archive() || is_post_type_archive() ) {

				// Using breadcrumbs
				$ip_breadcrumbs = (bool) apply_filters( 'ipress_breadcrumbs', false );

				// Add class based on usage
				$classes[] = ( true === $ip_breadcrumbs ) ? 'ipress-breadcrumbs' : 'ipress-no-breadcrumbs';
			}

			// Slim page template class names (class = name - file suffix)
			if ( is_page_template() ) {
				$classes[] = basename( get_page_template_slug(), '.php' );
			}

			// Add class if we're viewing the Customizer
			if ( is_customize_preview() ) {
				$classes[] = 'is-customizer customizer-preview ipress-customizer';
			}

			// Widgetless main sidebar? clunky adjust to full-width layout
			if ( is_singular() && ! is_active_sidebar( 'primary' ) ) {
				$classes[] = 'ipress-full-width-content';
			}

			// Add class on static front page
			if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
				$classes[] = 'is-front-page';
			}

			// Add a class if there is a custom header
			if ( has_header_image() ) {
				$classes[] = 'ipress-header-image';
			}

			// Check if more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'ipress-multi-blog';
			}

			// Add class if align-wide is supported.
			if ( current_theme_supports( 'align-wide' ) ) {
				$classes[] = 'ipress-align-wide';
			}

			// Return attributes
			return (array) apply_filters( 'ipress_body_class', $classes );
		}

		/**
		 * Modify post classes
		 *
		 * @param array $class
		 * @return array $class
		 */
		public function post_class( $class ) {
			$class = array_diff( $class, [ 'hentry' ] );
			return $class;
		}

		/**
		 * Remove or amend the 'read more' link
		 *
		 * @return string
		 */
		public function read_more_link( $link ) {
			$ip_read_more_link = apply_filters( 'ipress_read_more_link', false );
			return ( ! $ip_read_more_link ) ? $link : sanitize_text_field( $ip_read_more_link );
		}

		/**
		 * Video embedding wrapper
		 *
		 * @param string $html
		 * @param string $url
		 * @param array $attr
		 * @param integer $post_id
		 * @return string
		 */
		public function embed_video_html( $html, $url, $attr, $post_id ) {
			return (string) apply_filters( 'ipress_embed_video', sprintf( '<div class="video-container">%s</div>', $html ), $html );
		}
	}

endif;

// Instantiate Layout class
return new IPR_Layout;
