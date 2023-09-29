<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post single post taxonomy data.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Get relevent post types
$ip_footer_taxonomy_types = apply_filters( 'ipress_post_taxonomy_types', [ 'post' ] );

// Hide category and tag text for pages
if ( in_array( get_post_type(), $ip_footer_taxonomy_types, true ) ) {

	// Get category list
	$category_list = ( has_category() ) ? sprintf( '<span class="post-categories">%1$s %2$s</span>', esc_html__( 'Posted in', 'ipress-standalone' ), get_the_category_list( ', ' ) ) : '';

	// Get the tag list
	$tag_list = ( has_tag() ) ? sprintf( '<span class="post-tags">%1$s %2$s</span>', esc_html__( 'Tagged in', 'ipress-standalone' ), get_the_tag_list( '', ', ' ) ) : '';

	// Output the category & tag lists
	if ( $category_list || $tag_list ) {
		echo sprintf( '<aside class="post-taxonomy">%1$s %2$s</aside>', $category_list, $tag_list );
	}
}
