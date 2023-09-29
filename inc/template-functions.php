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

if ( ! function_exists( 'ipress_header_pingback' ) ) :

	/**
	 * Add pingback url to singular pages when allowed.
	 */
	function ipress_header_pingback() {
		if ( is_singular() && pings_open() ) {
			echo sprintf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
endif;

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

if ( ! function_exists( 'ipress_top_bar' ) ) :

	/**
	 * Top bar
	 */
	function ipress_top_bar() {
		get_template_part( 'templates/layout/top-bar' );
	}
endif;

if ( ! function_exists( 'ipress_back_to_top' ) ) :

	/**
	 * Scroll back to top link
	 */
	function ipress_back_to_top() {
		get_template_part( 'templates/global/back-to-top' );
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

if ( ! function_exists( 'ipress_display_comments' ) ) :

	/**
	 * Display the comments form in single post & page if appropriate
	 */
	function ipress_display_comments() {

		// Single type && comments are open or we have at least one comment, load up the comment template.
		if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
			comments_template();
		}
	}
endif;

if ( ! function_exists( 'ipress_sidebar' ) ) :

	/**
	 * Display sidebar - default primary sidebar
	 *
	 * @uses get_sidebar()
	 * @param string $sidebar Sidebar name, default ''
	 */
	function ipress_sidebar( $sidebar = '' ) {
		if ( empty( $sidebar ) ) {
			get_sidebar();
		} else {
			get_sidebar( $sidebar );
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

if ( ! function_exists( 'ipress_site_branding_container' ) ) :

	/**
	 * Load site branding container wrapper
	 */
	function ipress_site_branding_container() {
		get_template_part( 'templates/global/header/site-branding-container' );
	}
endif;

if ( ! function_exists( 'ipress_site_branding_container_close' ) ) :

	/**
	 * Load site branding container wrapper closure
	 */
	function ipress_site_branding_container_close() {
		get_template_part( 'templates/global/header/site-branding-container-close' );
	}
endif;

if ( ! function_exists( 'ipress_site_logo' ) ) :

	/**
	 * Site logo display
	 */
	function ipress_site_logo() {
		get_template_part( 'templates/global/header/site-logo' );
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

if ( ! function_exists( 'ipress_site_navigation' ) ) :

	/**
	 * Site navigation, defaults to primary menu location
	 */
	function ipress_site_navigation() {
		get_template_part( 'templates/global/header/site-navigation' );
	}
endif;

//----------------------------------------------
//	Footer Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_footer_container' ) ) :

	/**
	 * Load footer container wrapper
	 */
	function ipress_footer_container() {
		get_template_part( 'templates/global/footer/container' );
	}
endif;

if ( ! function_exists( 'ipress_footer_container_close' ) ) :

	/**
	 * Load footer container wrapper closure
	 */
	function ipress_footer_container_close() {
		get_template_part( 'templates/global/footer/container-close' );
	}
endif;

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

		// Archive pages only
		if ( is_singular() ) {
			return;
		}
		
		// Set post pagination links
		ipress_loop_navigation();
	}
endif;

if ( ! function_exists( 'ipress_loop_nav_list' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function ipress_loop_nav_list() {

		$args = [
			'type'      => 'list',
			'next_text' => _x( 'Next', 'Next post', 'ipress-standalone' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'ipress-standalone' ),
			'mid_size'  => apply_filters( 'ipress_nav_list_mid_size', 1 ),
			'before_page_number' => sprintf( '<span class="screen-reader-text">%s</span>', _x( 'Page', 'Pagination page number for screen readers', 'ipress-standalone' ) )
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

if ( ! function_exists( 'ipress_single_taxonomy' ) ) :

	/**
	 * Display the post taxonomy: categories & tags
	 */
	function ipress_single_taxonomy() {
		get_template_part( 'templates/single/taxonomy' );
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

if ( ! function_exists( 'ipress_single_nav' ) ) :

	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function ipress_single_nav() {

		// Single post only
		if ( is_single() ) {

			// Set previous and next post pagination links
			ipress_post_navigation();
		}
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

if ( ! function_exists( 'ipress_page_footer' ) ) :

	/**
	 * Display the page footer
	 */
	function ipress_page_footer() {
		get_template_part( 'templates/page/footer' );
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

if ( ! function_exists( 'ipress_page_header_image' ) ) :

	/**
	 * Display the page header image if set
	 */
	function ipress_page_header_image() {
		get_template_part( 'templates/page/header-image' );
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

if ( ! function_exists( 'ipress_page_nav' ) ) :

	/**
	 * Display navigation to next/previous set of pages when applicable.
	 */
	function ipress_page_nav() {

		// Check page
		if ( is_page() ) {
	
			// Set previous and next post pagination links
			ipress_prev_next_post_nav();
		}
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

if ( ! function_exists( 'ipress_homepage_image' ) ) :

	/**
	 * Display the homepage page image
	 */
	function ipress_homepage_image() {

		// Inline image
		$ip_homepage_image_inline = (bool) apply_filters( 'ipress_homepage_image_inline', false );
		if ( true === $ip_homepage_image_inline ) {
			get_template_part( 'templates/page/image' );
		}
	}
endif;
