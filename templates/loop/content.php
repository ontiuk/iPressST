<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop content and thumbnail.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_loop_content' ); ?>

<section class="post-summary post-content">
	<?php do_action( 'ipress_loop_content' ); ?>

	<?php
	the_content(
		sprintf(
			/* translators: %s: name of current post. only visible to screen readers */
			__( 'Continue reading %s', 'ipress' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
		)
	);
	?>

	<?php do_action( 'ipress_after_loop_content' ); ?>

	<?php
	wp_link_pages(
		[
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress' ),
			'after'  => '</div>',
		]
	);
	?>
</section><!-- .post-summary / .post-content -->
