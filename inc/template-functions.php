<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme template hooks functions.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	Core Hooks Functions
//----------------------------------------------

//----------------------------------------------
//	General Hooks Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_loader' ) ) :

	/**
	 * Load DOM page loader
	 */
	function ipress_loader() {
		get_template_part( 'templates/global/loader' );
	}
endif;

if ( ! function_exists( 'ipress_skip_links' ) ) :

	/**
	 * Add skip links html
	*/
	function ipress_skip_links() {
		get_template_part( 'templates/global/skip-links' );
	}
endif;

if ( ! function_exists( 'ipress_sidebar' ) ) :

	/**
	 * Display sidebar - default primary sidebar
	 *
	 * @uses get_sidebar()
	 * @param string $sidebar default empty
	 */
	function ipress_sidebar( $sidebar = '' ) {
		( empty( $sidebar ) ) ? get_sidebar() : get_sidebar( $sidebar );
	}
endif;

if ( ! function_exists( 'ipress_sidebar_header' ) ) :

	/**
	 * Display header sidebar
	 *
	 * @uses get_sidebar()
	 */
	function ipress_sidebar_header() {
		get_sidebar( 'header' );
	}
endif;

if ( ! function_exists( 'ipress_scroll_top' ) ) :

	/**
	 * Scroll to top link
	 */
	function ipress_scroll_top() {
		get_template_part( 'templates/global/scroll-top' );
	}
endif;

if ( ! function_exists( 'ipress_breadcrumbs' ) ) :

	/**
	 * Load header breadcrumbs
	 */
	function ipress_breadcrumbs() {

		// Not if error page
		if ( is_404() ) {
			return;
		}

		// Get theme mod, default false
		$ip_breadcrumbs = get_theme_mod( 'ipress_breadcrumbs', false );

		// Test if breadcumbs are turned on - default off
		$ip_breadcrumbs = (bool) apply_filters( 'ipress_breadcrumbs', $ip_breadcrumbs );
		if ( true !== $ip_breadcrumbs ) {
			return;
		}

		// Get custom template?
		$ip_breadcrumbs_custom_template = (string) apply_filters( 'ipress_breadcrumbs_custom_template', '' );
		if ( ! empty( $ip_breadcrumbs_custom_template ) ) {
			return get_template_part( 'templates/global/breadcrumbs/' . sanitize_text_field( $ip_breadcrumbs_custom_template ) );
		}

		// Load generic hierarchy crumbs
		if ( is_home() && ! is_front_page() ) {
			$template = 'home';
		} elseif ( is_single() ) {
			$template = 'single';
		} elseif ( is_author() ) {
			$template = 'author';
		} elseif ( is_page() ) {
			$template = 'page';
		} elseif ( is_author() ) {
			$template = 'author';
		} elseif ( is_category() ) {
			$template = 'category';
		} elseif ( is_tag() ) {
			$template = 'tag';
		} elseif ( is_date() ) {
			$template = 'date';
		} elseif ( is_search() ) {
			$template = 'search';
		} elseif ( is_tax() ) {
			$template = 'taxonomy';
		} elseif ( is_post_type_archive() ) {
			$template = 'archive-cpt';
		} elseif ( is_archive() ) {
			$template = 'archive';
		}

		// final template filter
		$template = (string) apply_filters( 'ipress_breadcrumbs_template', $template );

		// Load breadcrumbs template if set...
		if ( ! empty( $template ) ) {
			get_template_part( 'templates/global/breadcrumbs/' . sanitize_text_field( $template ) );
		}
	}
endif;

if ( ! function_exists( 'ipress_hero' ) ) :

	/**
	 * Load front page hero
	 */
	function ipress_hero() {

		// Front page only, duh!
		if ( is_front_page() ) {
			get_template_part( 'templates/front/hero' );
		}
	}
endif;

//----------------------------------------------
//	Header Hooks Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_header_container' ) ) :

	/**
	 * Load header container wrapper
	 */
	function ipress_header_container() {
		get_template_part( 'templates/global/header/container' );
	}
endif;

if ( ! function_exists( 'ipress_header_container_close' ) ) :

	/**
	 * Load header container wrapper closure
	 */
	function ipress_header_container_close() {
		get_template_part( 'templates/global/header/container-close' );
	}
endif;

if ( ! function_exists( 'ipress_site_branding' ) ) :

	/**
	 * Site branding wrapper and display
	 */
	function ipress_site_branding() {
		get_template_part( 'templates/global/header/site-branding' );
	}
endif;

if ( ! function_exists( 'ipress_primary_navigation' ) ) :

	/**
	 * Site navigation
	 */
	function ipress_primary_navigation() {
		get_template_part( 'templates/global/header/site-navigation' );
	}
endif;

//----------------------------------------------
//	Footer Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_footer_widgets' ) ) :

	/**
	 * Display the footer widget regions
	 */
	function ipress_footer_widgets() {
		get_template_part( 'templates/global/footer/footer-widgets' );
	}
endif;

if ( ! function_exists( 'ipress_credit_info' ) ) :

	/**
	 * Display the theme credit
	 */
	function ipress_credit_info() {
		get_template_part( 'templates/global/footer/site-credit' );
	}
endif;

//----------------------------------------------
//	Posts Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_loop_header' ) ) :

	/**
	 * Display the post header
	 */
	function ipress_loop_header() {
		get_template_part( 'templates/loop/header' );
	}
endif;

if ( ! function_exists( 'ipress_loop_meta' ) ) :

	/**
	 * Display the post meta data
	 */
	function ipress_loop_meta() {
		if ( 'post' === get_post_type() ) {
			get_template_part( 'templates/loop/meta' );
		}
	}
endif;

if ( ! function_exists( 'ipress_loop_content' ) ) :

	/**
	 * Display the post content
	 */
	function ipress_loop_content() {
		get_template_part( 'templates/loop/content' );
	}
endif;

if ( ! function_exists( 'ipress_loop_excerpt' ) ) :

	/**
	 * Display the post excerpt
	 */
	function ipress_loop_excerpt() {
		get_template_part( 'templates/loop/excerpt' );
	}
endif;

if ( ! function_exists( 'ipress_loop_footer' ) ) :

	/**
	 * Display the post footer
	 */
	function ipress_loop_footer() {
		get_template_part( 'templates/loop/footer' );
	}
endif;

if ( ! function_exists( 'ipress_loop_sticky' ) ) :

	/**
	 * Display the post sticky section
	 */
	function ipress_loop_sticky() {
		get_template_part( 'templates/loop/sticky' );
	}
endif;

if ( ! function_exists( 'ipress_loop_thumbnail' ) ) :

	/**
	 * Display the post thumbnail
	 */
	function ipress_loop_thumbnail() {
		get_template_part( 'templates/loop/thumbnail' );
	}
endif;

if ( ! function_exists( 'ipress_loop_nav' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function ipress_loop_nav() {

		$args = [
			'type'      => 'list',
			'next_text' => _x( 'Next', 'Next post', 'ipress' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'ipress' ),
		];

		the_posts_pagination( $args );
	}
endif;

//----------------------------------------------
//	Single Post Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_single_header' ) ) :

	/**
	 * Display the post header
	 */
	function ipress_single_header() {
		get_template_part( 'templates/single/header' );
	}
endif;

if ( ! function_exists( 'ipress_single_meta' ) ) :

	/**
	 * Display the post meta data
	 */
	function ipress_single_meta() {
		if ( 'post' === get_post_type() ) {
			get_template_part( 'templates/single/meta' );
		}
	}
endif;

if ( ! function_exists( 'ipress_single_content' ) ) :

	/**
	 * Display the post content
	 */
	function ipress_single_content() {
		get_template_part( 'templates/single/content' );
	}
endif;

if ( ! function_exists( 'ipress_single_footer' ) ) :

	/**
	 * Display the post footer
	 */
	function ipress_single_footer() {
		get_template_part( 'templates/single/footer' );
	}
endif;

if ( ! function_exists( 'ipress_single_image' ) ) :

	/**
	 * Display the post image
	 */
	function ipress_single_image() {
		get_template_part( 'templates/single/image' );
	}
endif;

if ( ! function_exists( 'ipress_single_edit_link' ) ) :

	/**
	 * Display the footer post edit link
	 */
	function ipress_single_edit_link() {
		get_template_part( 'templates/single/edit-link' );
	}
endif;

if ( ! function_exists( 'ipress_display_comments' ) ) :

	/**
	 * Display the comments form
	 */
	function ipress_display_comments() {

		// Single type && comments are open or we have at least one comment, load up the comment template.
		if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
			comments_template();
		}
	}
endif;

if ( ! function_exists( 'ipress_single_nav' ) ) :

	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function ipress_single_nav() {

		// Single post onle
		if ( ! is_single() ) {
			return;
		}

		$args = [
			'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'ipress' ) . ' </span>%title',
			'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'ipress' ) . ' </span>%title',
		];

		the_post_navigation( $args );
	}
endif;

//----------------------------------------------
//	Pages Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_page_header' ) ) :

	/**
	 * Display the page header
	 */
	function ipress_page_header() {
		get_template_part( 'templates/page/header' );
	}
endif;

if ( ! function_exists( 'ipress_page_content' ) ) :

	/**
	 * Display the page content
	 */
	function ipress_page_content() {
		get_template_part( 'templates/page/content' );
	}
endif;

if ( ! function_exists( 'ipress_edit_page_link' ) ) :

	/**
	 * Display the page footer
	 */
	function ipress_edit_page_link() {
		get_template_part( 'templates/page/edit-link' );
	}
endif;

if ( ! function_exists( 'ipress_page_image' ) ) :

	/**
	 * Display the page image
	 */
	function ipress_page_image() {
		get_template_part( 'templates/page/image' );
	}
endif;

//----------------------------------------------
//	Attachment Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_attachment_header' ) ) :

	/**
	 * Display the attachment page header
	 */
	function ipress_attachment_header() {
		get_template_part( 'templates/page/header' );
	}
endif;

if ( ! function_exists( 'ipress_attachment_content' ) ) :

	/**
	 * Display the attachment page content
	 */
	function ipress_attachment_content() {
		get_template_part( 'templates/page/attachment' );
	}
endif;

//----------------------------------------------
//	Privacy Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_privacy_content' ) ) :

	/**
	 * Display the privacy page content
	 * - uses the generic content block. Replace as appropriate.
	 */
	function ipress_privacy_content() {
		get_template_part( 'templates/global/content' );
	}
endif;

//----------------------------------------------
//	Homepage Hooks Functions
//----------------------------------------------
