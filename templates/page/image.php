<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying page content in page.php.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php
// No featured image?
if ( ! has_post_thumbnail() ) { return; }

// Get current post
$the_post = get_post();
if ( ! $the_post ) { return; }

// Get image details
$image_id = get_post_thumbnail_id( $the_post );
if ( ! $image_id ) { return; }

// Get image
$image_size = (string) apply_filters( 'ipress_page_image_size', 'large', $the_post->ID );
$image 		= wp_get_attachment_image_src( $image_id, $image_size ); 

// Display if OK,include image template
if ( $image ) :
    $meta = ipress_get_attachment_meta( $image_id, $image );
	include locate_template( 'templates/global/post-image.php', false, false ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
endif;
