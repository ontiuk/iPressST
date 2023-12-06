<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme core & admin hooks - actions and filters
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Hooks' ) ) :

	/**
	 * Set up theme template hooks
	 */
	final class IPR_Hooks extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			//----------------------------------------------
			//	Core Hooks: Actions & Filters
			//----------------------------------------------

			// Template: Filter the archive title by content type
			add_filter( 'get_the_archive_title', [ $this, 'the_archive_title' ] );

			// Template: Filter the excerpt more dialog
			add_filter( 'excerpt_more', [ $this, 'excerpt_more' ] );

			// Template: Filter the content more dialog
			add_filter( 'content_more', [ $this, 'content_more' ] );

			// Navigation archives template markup
			add_filter( 'navigation_markup_template', [ $this, 'navigation_markup_template'], 10, 2 );

			//----------------------------------------------
			//	Admin UI Hooks: Actions & Filters
			//----------------------------------------------

	        // Admin: Add phone number to general settings
    	    add_action( 'admin_init', [ $this, 'register_setting' ], 10 );
		}

		//----------------------------------------------
		//  Core Hook Functions
		//----------------------------------------------

		/**
		 * Filter the archive title by content type
		 *
		 * @param array $title default post or page title
		 * @return string
		 */
		public function the_archive_title( $title ) {

			global $wp_query;

			// Category
			if ( is_category() ) {
				return sprintf( __( 'Category: %s', 'ipress-standalone' ), single_cat_title( '', false ) );
			}

			// Author
			if ( is_author() ) {
				return sprintf(	__( 'Author: <span class="post-author">%s</span>', 'ipress-standalone' ), get_the_author() );
			}

			// Tag
			if ( is_tag() ) {
				return sprintf(	__( 'Tag: %s', 'ipress-standalone' ), single_tag_title( '', false ) );
			}

			// Taxonomy
			if ( is_tax() ) {
				$the_tax = get_taxonomy( get_queried_object()->taxonomy );
				return sprintf(	__( 'Taxonomy: %1$s: %2$s', 'ipress-standalone' ), esc_attr( $the_tax->labels->singular_name ), esc_html( single_term_title( '', false ) ) );
			}

			// Search
			if ( is_search() ) {
				return ( 0 === $wp_query->found_posts )
					? sprintf( _x( 'Search: No Results for <span class="search-query">%1$s</span>', 'Search results count', 'ipress-standalone' ), esc_html( get_search_query() ) )
					: sprintf(_nx( 'Search: %1$s Result for <span class="search-query">%2$s</span>', 'Search: %1$s Results for <span class="search-query">%2$s</span>', $wp_query->found_posts, 'Search results count', 'ipress-standalone' ),	esc_attr( $wp_query->found_posts ),	esc_html( get_search_query() ) );
			}

			return $title;
		}

		/**
		 * Filter the excerpt more dialog
		 *
		 * @param string $more default more display string
		 * @return string more link text
		 */
		public function excerpt_more( $more ) {

			// Aria label
			$more_label = sprintf(
				/* translators: Aria-label describing the read more button */
				_x( 'More on %s', 'more on post title', 'ipress-standalone' ),
				the_title_attribute( 'echo=0' )
			);

			return apply_filters(
				'ipress_excerpt_more_html',
				sprintf(
					' ... <a title="%1$s" class="read-more" href="%2$s" aria-label="%4$s">%3$s</a>',
					the_title_attribute( 'echo=0' ),
					esc_url( get_permalink( get_the_ID() ) ),
					__( 'Read more', 'ipress-standalone' ),
					$more_label
				)
			);
		}


		/**
		 * Filter the content more dialog
		 *
		 * @param string $more default more display string
		 * @return string more link text
		 */
		public function content_more( $more ) {

			// Aria label
			$more_label = sprintf(
				/* translators: Aria-label describing the read more button */
				_x( 'More on %s', 'more on post title', 'ipress-standalone' ),
				the_title_attribute( 'echo=0' )
			);

			return apply_filters(
				'ipress_content_more_html',
				sprintf(
					'<p class="read-more-container"><a title="%1$s" class="read-more content-read-more" href="%2$s" aria-label="%4$s">%3$s</a></p>',
					the_title_attribute( 'echo=0' ),
					esc_url( get_permalink( get_the_ID() ) . apply_filters( 'ipress_more_jump', '#more-' . get_the_ID() ) ),
					__( 'Read more', 'ipress-standalone' ),
					$more_label
				)
			);
		}

		/**
		 * Markup template for archive pagination 'nav' tags
		 *
		 * @param string $template
		 * @param string $css_class
		 * @return string
		 */
		public function navigation_markup_template( $template, $css_class ) {
			return apply_filters(
				'ipress_navigation_markup_html',
				'<nav class="%1$s" aria-label="%4$s">
					<h2 class="screen-reader-text">%2$s</h2>
					<div class="nav-links">%3$s</div>
				</nav>'
			);
		}

		//----------------------------------------------
		//  Admin UI Functions
		//----------------------------------------------

		/**
		 * Registers a custom field setting
		 */
		public function register_setting() {

			// Filterable option, default false
			$ip_admin_phone_number = apply_filters( 'ipress_admin_phone_number', false );
			if ( true === $ip_admin_phone_number ) {

				// Admin phone text field
				$args = [
					'type'              => 'string', 
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null
				];

				// Register Admin phone field
				register_setting( 'general', 'admin_phone_number', $args ); 

				// Add Admin phone field
				add_settings_field (
					'admin_phone_number',
					'<label for="admin_phone_number">' . __( 'Admin Phone No.' , 'ipress-standalone' ) . '</label>',
					[ $this, 'admin_phone_number' ],
					'general'
				);
			}
		}

		/**
		 * Output custom admin phone field
		 */
		public function admin_phone_number() {
			$admin_phone = get_option( 'admin_phone_number' );
			echo sprintf( '<input type="text" id="admin_phone_number" name="admin_phone_number" class="regular-text ltr" value="%s" />', esc_attr( $admin_phone ) );
		}
	}

endif;

// Instantiate Hooks Class
return IPR_Hooks::Init();
