<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying post & page image.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Get meta data
$meta = $args['meta'];
?>
<div class="post-image image-<?php echo esc_attr( $meta['size'] ); ?>">
	<img src="<?php echo esc_url( $meta['src'] ); ?>" width="<?php echo esc_attr( $meta['width'] ); ?>" height="<?php echo esc_attr( $meta['height'] ); ?>" alt="<?php echo esc_attr( $meta['alt'] ); ?>" srcset="<?php echo esc_attr( $meta['srcset'] ); ?>" sizes="<?php echo esc_attr( $meta['sizes'] ); ?>"/>
</div> <!-- .post-image -->
