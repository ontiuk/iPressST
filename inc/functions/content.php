<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Content and URL functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//---------------------------------------------
//	Content & URL
//
// ipress_is_home_page
// ipress_is_index
// ipress_is_subpage
// ipress_is_tree
// ipress_canonical_url
// ipress_paged_post_url
// ipress_get_permalink_by_page
// ipress_excerpt
// ipress_content
// ipress_truncate
// ipress_ordinal_number
// ipress_do_shortcode
//---------------------------------------------

if ( ! function_exists( 'ipress_is_home_page' ) ) :

	/**
	 * Check if the root page of the site is being viewed
	 *
	 * is_front_page() returns false for the root page of a website when
	 * - the WordPress 'Front page displays' setting is set to 'Static page'
	 * - 'Front page' is left undefined
	 * - 'Posts page' is assigned to an existing page
	 */
	function ipress_is_home_page() : bool {
		return ( is_front_page() || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) );
	}
endif;

if ( ! function_exists( 'ipress_is_index' ) ) :

	/**
	 * Check if the page being viewed is the index page
	 *
	 * @param string $page Page name 
	 */
	function ipress_is_index( $page ) : bool {
		return ( basename( $page ) === 'index.php' );
	}
endif;

if ( ! function_exists( 'ipress_is_subpage' ) ) :

	/**
	 * Determine if the page is a subpage
	 * 
	 * - Returns parent post ID if true
	 *
	 * @global $post
	 * @return boolean|integer
	 */
	function ipress_is_subpage() {
		global $post;
		return ( is_page() && $post->post_parent ) ? $post->post_parent : false;
	}
endif;

if ( ! function_exists( 'ipress_is_tree' ) ) :

	/**
	 * Check if page is current of ancestor
	 *
	 * @global $post
	 * @param integer $pid Post ID
	 */
	function ipress_is_tree( $pid ) : bool {

		global $post;

		// Current page
		if ( is_page( $pid ) ) {
			return true;
		}

		// Post ancestor
		$anc = get_post_ancestors( $post->ID );
		foreach ( $anc as $ancestor ) {
			if ( is_page() && $ancestor === $pid ) {
				return true;
			}
		}

		return false;
	}
endif;

if ( ! function_exists( 'ipress_canonical_url' ) ) :

	/**
	 * Calculate and return the canonical URL
	 *
	 * @global $wp_query WP_Query
	 * @return string $canonical The canonical URL, if one exists
	 */
	function ipress_canonical_url() {

		global $wp_query;

		// Initialize output
		$canonical = '';

		// Pagination values
		$paged = absint( get_query_var( 'paged' ) );
		$page  = absint( get_query_var( 'page' ) );

		// Get the queried object id, returns int
		$id = $wp_query->get_queried_object_id();

		// Front page / home page
		if ( is_front_page() ) {
			$canonical = ( $paged > 0 ) ? get_pagenum_link( $paged ) : home_url( '/' );
		}

		// Single post
		if ( is_singular() && $id ) {
			$numpages  = substr_count( $wp_query->post->post_content, '<!--nextpage-->' ) + 1;
			$canonical = ( $numpages > 1 && $page > 1 ) ? ipress_paged_post_url( $page, $id ) : get_permalink( $id );
		}

		// Archive
		if ( ( is_category() || is_tag() || is_tax() ) && $id ) {
			$taxonomy  = $wp_query->queried_object->taxonomy;
			$canonical = ( $paged > 0 ) ? get_pagenum_link( $paged ) : get_term_link( $id, $taxonomy );
		}

		// Author
		if ( is_author() && $id ) {
			$canonical = ( $paged > 0 ) ? get_pagenum_link( $paged ) : get_author_posts_url( $id );
		}

		// Search
		if ( is_search() ) {
			$canonical = get_search_link();
		}

		return $canonical;
	}
endif;

if ( ! function_exists( 'ipress_paged_post_url' ) ) :

	/**
	 * Return the special URL of a paged post
	 * 
	 * - Adapted from _wp_link_page() in WP core
	 *
	 * @global $wp_rewrite
	 * @param int $page_id The page number to generate the URL from
	 * @param int $post_id The post ID
	 * @return string $url Unescaped URL
	 */
	function ipress_paged_post_url( $page_id, $post_id = 0 ) {

		global $wp_rewrite;

		// Get post by ID
		$post = get_post( $post_id );

		// Paged?
		if ( 1 === $page_id ) {
			$url = get_permalink( $post_id );
		} else {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ], true ) ) {
				$url = add_query_arg( 'page', $page_id, get_permalink( $post_id ) );
			} elseif ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $wp_rewrite->pagination_base . '/' . $page_id, 'single_paged' );
			} else {
				$url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $page_id, 'single_paged' );
			}
		}

		return $url;
	}
endif;

if ( ! function_exists( 'ipress_get_permalink_by_page' ) ) :

	/**
	 * Get url by page template
	 *
	 * @param string $template Page template name
	 * @return string
	 */
	function ipress_get_permalink_by_page( $template ) {

		// Get pages
		$page = get_pages(
			[
				'meta_key'   => '_wp_page_template',
				'meta_value' => $template . '.php',
			]
		);

		return ( empty( $page ) ) ? '' : get_permalink( $page[0]->ID );
	}
endif;

if ( ! function_exists( 'ipress_excerpt' ) ) :

	/**
	 * Create the Custom Excerpt
	 *
	 * @param string $length_callback Excerpt callback, default empty
	 * @param string $more_callback Callback function, default empty
	 * @param boolean $wrap Wrap excerpt, default true
	 */
	function ipress_excerpt( $length_callback = '', $more_callback = '', $wrap = true ) {

		// Excerpt length
		if ( ! empty( $length_callback ) && function_exists( $length_callback ) ) {
			add_filter( 'excerpt_length', $length_callback );
		}

		// Excerpt more
		if ( ! empty( $more_callback ) && function_exists( $more_callback ) ) {
			add_filter( 'excerpt_more', $more_callback );
		}

		// Get the excerpt
		$excerpt = get_the_excerpt();

		// No wrap, remove filter
		if ( ! $wrap ) {
			remove_filter( 'the_excerpt', 'wpautop' );
		}

		// Output the excerpt
		echo apply_filters( 'the_excerpt', $excerpt ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// No wrap, readd filter
		if ( ! $wrap ) {
			add_filter( 'the_excerpt', 'wpautop' );
		}
	}
endif;

if ( ! function_exists( 'ipress_content' ) ) :

	/**
	 * Trim the content by word count
	 *
	 * @param integer $length Content length, default 54
	 * @param string $before Before content text, default empty
	 * @param string $after After content text, default empty
	 */
	function ipress_content( $length = 54, $before = '', $after = '' ) {

		// Get the content
		$the_content = get_the_content();

		// Trim to word count and output, output as for the_content
		$the_content = $before . wp_trim_words( $content, $length, '...' ) . $after;
		$the_content = apply_filters( 'the_content', $the_content );
		echo str_replace( ']]>', ']]&gt;', $the_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_truncate' ) ) :

	/**
	 * Return a phrase shortened in length to a maximum number of characters
	 * 
	 * - Truncated at the last white space in the original string
	 *
	 * @param string $text Text top truncate
	 * @param integer $max_char Truncate length, default 54
	 * @return string $text
	 */
	function ipress_truncate( $text, $max_char = 54 ) {

		// Sanitize
		$text = trim( $text );

		// Test text length
		if ( strlen( $text ) > $max_char ) {

			// Truncate $text to $max_characters + 1
			$text = substr( $text, 0, $max_char + 1 );

			// Truncate to the last space in the truncated string
			$text = trim( substr( $text, 0, strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif;

if ( ! function_exists( 'ipress_ordinal_number' ) ) :

	/**
	 * Return a suffix for a number by type: st, rd, th
	 *
	 * @param integer|string $num Number to process
	 * @return string
	 */
	function ipress_ordinal_number( $num ) {

		// Typecast: string
		$num = trim( $num );

		// Test for outliers
		if ( in_array( ( $num % 100 ), [ 11, 12, 13 ], true ) ) {
			return 'th';
		}

		// Ok, general rules apply: handle 1st, 2nd, 3rd, nth
		switch ( $num % 10 ) {
			case 1:
				return 'st';
			case 2:
				return 'nd';
			case 3:
				return 'rd';
			default:
				return 'th';
		}
	}
endif;

//---------------------------------------------
//	Shortcode Functions
//---------------------------------------------

if ( ! function_exists( 'ipress_do_shortcode' ) ) :

	/**
	 * Call a shortcode function by tag name
	 *
	 * @param string $tag Shortcode whose function to call
	 * @param array $atts Shortcode attributes passed to shortcode
	 * @param array $content Shortcode content, default null
	 * @global $shortcode_tags
	 * @return string|bool
	 */
	function ipress_do_shortcode( $tag, $atts = [], $content = null ) {

		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) || ! is_array( $atts ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
endif;
