<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop content.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_post_content' ); ?>

<section class="post-content post-single">
	<?php
	the_content(
		sprintf(
			/* translators: %s: name of current post. only visible to screen readers */
			__( 'Continue reading %s', 'ipress-standalone' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
		)
	);
	?>

	<?php do_action( 'ipress_post_content' ); ?>
</section><!-- .post-content / .post-single -->

<?php do_action( 'ipress_after_post_content' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
