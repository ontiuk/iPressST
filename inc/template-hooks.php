<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme template hooks - actions and filters.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	Core Actions & Filters
//----------------------------------------------

/**
 * @see ipress_header_pingback
 */
add_action( 'wp_head', 'ipress_header_pingback' );

//------------------------------------------
//  General
//------------------------------------------

/**
 * @see ipress_loader()
 */
add_action( 'wp_body_open', 'ipress_loader', 10 );

/**
 * @see ipress_skip_links()
 * @see ipress_top_bar()
 */
add_action( 'ipress_before_header', 'ipress_skip_links', 2 );
add_action( 'ipress_before_header', 'ipress_top_bar', 5 );

/**
 * @see ipress_back_to_top()
 */
add_action( 'ipress_before_footer', 'ipress_back_to_top', 10 );

/**
 * @see ipress_breadcrumbs()
 */
add_action( 'ipress_before_content', 'ipress_breadcrumbs', 5 );

/**
 * @see ipress_hero()
 */
add_action( 'ipress_before_content', 'ipress_hero', 10 );

/**
 * @see ipress_display_comments()
 */
add_action( 'ipress_after_article', 'ipress_display_comments', 10 );

/**
 * @see ipress_sidebar()
 */
add_action( 'ipress_sidebar', 'ipress_sidebar', 10 );

//------------------------------------------
//  Header
//------------------------------------------

/**
 * @see ipress_header_container()
 * @see ipress_header_container_close()
 */
add_action( 'ipress_before_header_content', 'ipress_header_container', 10 );
add_action( 'ipress_after_header_content', 'ipress_header_container_close', 10 );

/**
 * @see ipress_site_branding_container()
 * @see ipress_site_branding_container_close()
 * @see ipress_site_logo()
 * @see ipress_site_branding()
 * @see ipress_site_navigation()
 */
//add_action( 'ipress_header', 'ipress_site_branding_container', 5 );
//add_action( 'ipress_header', 'ipress_site_branding_container_close', 25 );
add_action( 'ipress_header', 'ipress_site_logo', 10 );
add_action( 'ipress_header', 'ipress_site_branding', 20 );
add_action( 'ipress_header', 'ipress_site_navigation', 30 );

//------------------------------------------
//  Footer
//------------------------------------------

/**
 * @see ipress_footer_container()
 * @see ipress_footer_container_close()
 */
add_action( 'ipress_before_footer_content', 'ipress_footer_container', 5 );
add_action( 'ipress_after_footer_content', 'ipress_footer_container_close', 15 );

/**
 * @see ipress_footer_widgets()
 * @see ipress_credit()
 */
add_action( 'ipress_footer', 'ipress_footer_widgets', 10 );
add_action( 'ipress_after_footer_content', 'ipress_credit_info', 10 );

//------------------------------------------
//  Posts
//------------------------------------------

/**
 * @see ipress_loop_header()
 * @see ipress_loop_meta()
 * @see ipress_loop_content()
 * @see ipress_loop_footer()
 */
add_action( 'ipress_loop', 'ipress_loop_header', 10 );
add_action( 'ipress_loop', 'ipress_loop_meta', 20 );
add_action( 'ipress_loop', 'ipress_loop_content', 30 );
add_action( 'ipress_loop', 'ipress_loop_footer', 40 );

/**
 * @see ipress_loop_sticky()
 */
add_action( 'ipress_loop_header', 'ipress_loop_sticky', 10 );

/**
 * @see ipress_loop_thumbnail()
 */
add_action( 'ipress_before_loop_content', 'ipress_loop_thumbnail', 10 );

/**
 * @see ipress_loop_header()
 * @see ipress_loop_meta()
 * @see ipress_loop_excerpt()
 * @see ipress_loop_footer()
 */
add_action( 'ipress_loop_excerpt', 'ipress_loop_header', 10 );
add_action( 'ipress_loop_excerpt', 'ipress_loop_meta', 20 );
add_action( 'ipress_loop_excerpt', 'ipress_loop_excerpt', 23 );
add_action( 'ipress_loop_excerpt', 'ipress_loop_footer', 40 );

/**
 * @see ipress_loop_nav()
 */
add_action( 'ipress_after_archive', 'ipress_loop_nav', 10 );

//------------------------------------------
//  Single
//------------------------------------------

/**
 * @see ipress_single_header()
 * @see ipress_single_meta()
 * @see ipress_single_content()
 * @see ipress_single_footer()
 * @see ipress_single_image
 * @see ipress_single_edit_link()
 * @see ipress_single_nav()
 */
add_action( 'ipress_single', 'ipress_single_header', 10 );
add_action( 'ipress_single', 'ipress_single_meta', 20 );
add_action( 'ipress_single', 'ipress_single_content', 30 );
add_action( 'ipress_single', 'ipress_single_footer', 40 );

add_action( 'ipress_before_post_content', 'ipress_single_image', 10 );

add_action( 'ipress_post_footer', 'ipress_single_taxonomy', 10 );
add_action( 'ipress_post_footer', 'ipress_single_edit_link', 20 );

add_action( 'ipress_after_article', 'ipress_single_nav', 20 );

//------------------------------------------
//  Page
//------------------------------------------

/**
 * @see ipress_page_header_image()
 * @see ipress_page_header()
 * @see ipress_page_content()
 * @see ipress_page_footer()
 * @see ipress_page_image
 * @see ipress_page_edit_page_link()
 * @see ipress_page_nav()
 */
add_action( 'ipress_before_content', 'ipress_page_header_image', 10 );
add_action( 'ipress_page', 'ipress_page_header', 10 );
add_action( 'ipress_page', 'ipress_page_content', 20 );
add_action( 'ipress_page', 'ipress_page_footer', 30 );

add_action( 'ipress_before_page_content', 'ipress_page_image', 10 );
add_action( 'ipress_page_footer', 'ipress_edit_page_link', 10 );

add_action( 'ipress_after_article', 'ipress_page_nav', 20 );

//------------------------------------------
//  Attachment
//------------------------------------------

/**
 * @see ipress_attachment_header()
 * @see ipress_attachment_content()
 */
add_action( 'ipress_attachment', 'ipress_attachment_header', 10 );
add_action( 'ipress_attachment', 'ipress_attachment_content', 20 );

//------------------------------------------
//  Privacy Policy
//------------------------------------------

/**
 * @see ipress_page_header()
 * @see ipress_privacy()
 * @see ipress_edit_page_link()
 */
add_action( 'ipress_privacy', 'ipress_page_header', 10 );
add_action( 'ipress_privacy', 'ipress_privacy_content', 20 );
add_action( 'ipress_privacy', 'ipress_edit_page_link', 30 );

//------------------------------------------
//  Search
//------------------------------------------

/**
 * @see ipress_loop_header()
 * @see ipress_loop_meta()
 * @see ipress_loop_excerpt()
 * @see ipress_loop_footer()
 */
add_action( 'ipress_search', 'ipress_loop_header', 10 );
add_action( 'ipress_search', 'ipress_loop_meta', 20 );
add_action( 'ipress_search', 'ipress_loop_excerpt', 30 );
add_action( 'ipress_search', 'ipress_loop_footer', 40 );

//------------------------------------------
//  Homepage
//------------------------------------------

/**
 *  ipress_homepage_image
 */
add_action( 'ipress_before_homepage_content', 'ipress_homepage_image', 10 );
