<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying page content in page.php.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Are we using this? Move to theme mod?
$ip_page_header_image = (bool) apply_filters( 'ipress_page_header_image', false );
if ( ! $ip_page_header_image ) {
	return;
}

// No featured image?
if ( ! has_post_thumbnail() ) {
	return;
}

// Get current page
$the_page = get_post();
if ( ! $the_page ) {
	return;
}

// Get image details
$image_id = get_post_thumbnail_id( $the_page );
if ( ! $image_id ) {
	return;
}

// Get image
$image_size = (string) apply_filters( 'ipress_page_header_image_size', 'full', $the_page->ID );
$image = wp_get_attachment_image_src( $image_id, $image_size );

// Display if OK,include image template
if ( $image ) :

	// Get image meta data
	$meta = ipress_get_attachment_meta( $image_id, $image );

	// Add image size
	$meta['size'] = $image_size;

	// Display image with data
	get_template_part( 'templates/global/page-header-image', null, [ 'meta' => $meta ] );
endif;
