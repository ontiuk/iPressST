<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying archives post thumbnail.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>
<figure class="post-thumbnail figure-<?php echo esc_attr( $meta['size'] ); ?>">
	<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1" >
		<img src="<?php echo esc_url( $meta['src'] ); ?>" width="<?php echo esc_attr( $meta['width'] ); ?>" height="<?php echo esc_attr( $meta['height'] ); ?>" alt="<?php echo esc_attr( $meta['alt'] ); ?>" srcset="<?php echo esc_attr( $meta['srcset'] ); ?>" sizes="<?php echo esc_attr( $meta['sizes'] ); ?>" />
	</a>
	<?php if ( $meta['caption'] ) : ?>
	<figcaption><?php echo esc_html( $meta['caption'] ); ?></figcaption>
	<?php endif; ?>
</figure> <!-- .post-thumbnail -->
