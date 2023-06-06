<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the page content.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

/** @hooked ipress_page_image - 10 */
do_action( 'ipress_before_page_content' );
?>
<section class="page-content">
	<?php the_content(); ?>

	<?php do_action( 'ipress_page_content' ); ?>

	<?php
	wp_link_pages(
		[
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
			'after'  => '</div>',
		]
	);
	?>
</section><!-- .page-content -->

<?php do_action( 'ipress_after_page_content' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
