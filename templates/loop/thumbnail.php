<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop thumbnail image.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// No featured image?
if ( ! has_post_thumbnail() ) {
	return;
}

// Get current post
$the_post = get_post();
if ( ! $the_post ) {
	return;
}

// Get image details
$thumb_id = get_post_thumbnail_id( $the_post );
if ( ! $thumb_id ) {
	return;
}

// Update post thumbnail cache
if ( in_the_loop() ) {
	update_post_thumbnail_cache();
}

// Get image
$thumb_size = (string) apply_filters( 'post_thumbnail_size', 'thumbnail', $the_post->ID );
$image = wp_get_attachment_image_src( $thumb_id, $thumb_size );

// Display if ok via template
if ( $image ) :

	// Get image attachment meta
	$meta = ipress_get_attachment_meta( $thumb_id, $image );

	// Set the thumbnail size
	$meta['size'] = $thumb_size;

	// Display thumbnail with data
	get_template_part( 'templates/global/post-thumbnail', null, [ 'meta' => $meta ] );
endif;
