<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop thumbnail image.
 * 
 * @package     iPress\Templates
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
$thumb_id   = get_post_thumbnail_id( $the_post );
if ( ! $thumb_id ) { return; }

// Update post thumbnail cache
if ( in_the_loop() ) { update_post_thumbnail_cache(); }

// Get image 
$thumb_size = (string) apply_filters( 'post_thumbnail_size', 'post-thumbnail', $the_post->ID );
$image 		= wp_get_attachment_image_src( $thumb_id, $thumb_size ); 

// Display if ok via template, todo: WP 5.5 get_template_part()
if ( $image ) :
    $meta = ipress_get_attachment_meta( $thumb_id, $image );
	include locate_template( 'templates/global/post-thumbnail.php', false, false ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
endif;
