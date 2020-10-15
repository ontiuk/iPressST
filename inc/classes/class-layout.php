<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress Layout features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
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

			// Set the current theme direction
			add_action( 'init', 					[ $this, 'theme_direction' ] ); 

			// Add slug to body class
			add_filter( 'body_class', 				[ $this, 'body_class' ] ); 

			// Remove hentry in lieu of using schema format
			add_filter ( 'post_class',				[ $this, 'post_class' ], 		10, 1 );

			// Remove or amend the 'read more' link
			add_filter( 'the_content_more_link', 	[ $this, 'read_more_link' ] ); 

			// Add 'Read More' button instead of [...] for Excerpts
			add_filter( 'excerpt_more', 			[ $this, 'excerpt_more' ] ); 

			// Wrapper for video embedding - generic & jetpack
			add_filter( 'embed_oembed_html', 		[ $this, 'embed_video_html' ], 10, 4 );
			add_filter( 'video_embed_html', 		[ $this, 'embed_video_html' ], 10, 4 ); 
		}

		//---------------------------------------------
		//	Layout Actions & Filters
		//---------------------------------------------

		/**
		 * Control rtl - ltr theme layout at user level 
		 *
		 * @global $wp_locale
		 * @global $wp_styles
		 */
		public function theme_direction() {

			global $wp_locale, $wp_styles;

			// Filterable direction: ltr, rtl, none
			$ip_theme_direction = (string) apply_filters( 'ipress_theme_direction', '' );		
			if ( empty( $ip_theme_direction ) ) { return; }

			// Get current user
			$ip_uid = get_current_user_id();
		
			// Set direction data
			if ( $ip_theme_direction ) {
				update_user_meta( $ip_uid, 'rtladminbar', trim( $ip_theme_direction ) );
			} else {
				$ip_theme_direction = get_user_meta( $ip_uid, 'rtladminbar', true );
				if ( false === $ip_theme_direction ) {
					$ip_theme_direction = ( isset( $wp_locale->text_direction ) ) ? $wp_locale->text_direction : 'ltr' ;
				}
			}	

			// Set styles setting
			$wp_locale->text_direction = $ip_theme_direction;
			$wp_styles->text_direction = $ip_theme_direction;
		}

		/**
		 * Add page slug to body class - Credit: Starkers WordPress Theme
		 *
		 * @param	array
		 * @return	array
		 */
		public function body_class( $classes ) {

			global $post;

			// Add classes to singular pages
			if ( is_singular() ) {
				
				// Base singular
				$classes[] = 'singular';

				// Add class for featured image 
				$classes[] = ( has_post_thumbnail() ) ? 'ipress-singular-image' : 'ipress-singular-image-hidden';

				// Check if posts have single pagination
				$classes[] = ( get_next_post() || get_previous_post() ) ? 'ipress-single-pagination' : 'ipress-single-pagination-hidden';
			}

			// Add class for breadcrumbs
			if ( is_singular() || is_archive() || is_post_type_archive() ) {
				$ip_breadcrumbs = (bool) apply_filters( 'ipress_breadcrumbs', false );
				$classes[] = ( true === $ip_breadcrumbs ) ? 'ipress-breadcrumbs' : 'ipress-breadcrumbs-hidden';
			}

			// Slim page template class names (class = name - file suffix)
			if ( is_page_template() ) {
				$classes[] = basename( get_page_template_slug(), '.php' );
			}

			// Add class if we're viewing the Customizer
			if ( is_customize_preview() ) {
				$classes[] = 'is-customizer customizer-preview';
			}

			// Widgetless main sidebar? clunky adjust to full-width layout
			if ( is_singular() && ! is_active_sidebar( 'primary' ) ) {
				$classes[] = 'full-width-content';
			}

			// Add class on static front page
			if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
				$classes[] = 'is-front-page';
			}

			// Add a class if there is a custom header
			if ( has_header_image() ) {
				$classes[] = 'ipress-header-image';
			}
			
			// Check if we're showing comments 
			if ( is_singular() ) {
				if ( $post && ( ( 'post' === get_post_type() || comments_open() || get_comments_number() ) && ! post_password_required() ) ) {
					$classes[] = 'with-comments';
				} else {
					$classes[] = 'no-comments';
				}
			}

			// Return attributes
			return (array) apply_filters( 'ipress_body_class', $classes );
		}

		/**
		 * Modify post classes
		 *
		 * @param	array	$class
		 * @return 	array	$class
		 */
		public function post_class( $class ) {
			$class = array_diff( $class, [ 'hentry' ] );	
			return $class;
		}

		/**
		 * Remove or amend the 'read more' link - defaults to remove
		 *
		 * @return string
		 */
		public function read_more_link( $link ) { 
			$ip_read_more_link = (bool) apply_filters( 'ipress_read_more_link', false ); 
			return ( ! $ip_read_more_link || empty( $ip_read_more_link ) ) ? $link : $ip_read_more_link;
		}

		/**
		 * Custom view article link to post
		 *
		 * @param string
		 * @return $string
		 */
		public function excerpt_more( $more ) {

			// Frontend only
			if ( is_admin() ) { return $more; }

			// Get fiterable link & set markup
			$ip_view_more = (bool) apply_filters( 'ipress_view_more', false );
			if ( true !== $ip_view_more ) { return $more; }

			// Set link
			$view_article = sprintf( '... <a class="view-article" href="%s">%s</a>', 
				esc_url( get_permalink( get_the_ID() ) ), 
				__( '[Read more...]', 'ipress' ) );

			// Return filterable markup
			return (string) apply_filters( 'ipress_view_more_link', $view_article );
		}

		/**
		 * Video embedding wrapper
		 *
		 * @param	string 	$html
		 * @param	string	$url
		 * @param	array	$attr
		 * @param	integer	$post_id
		 * @return	string
		 */
		public function embed_video_html( $html, $url, $attr, $post_id  ) {
			return (string) apply_filters( 'ipress_embed_video', sprintf( '<div class="video-container">%s</div>', $html ), $html );
		}
	}

endif;

// Instantiate Layout class
return new IPR_Layout;

//end
