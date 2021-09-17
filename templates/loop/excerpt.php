<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop excerpt.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_loop_content_before' ); ?>

<section class="post-summary post-excerpt">
<?php
	do_action( 'ipress_loop_content' );
	the_excerpt();
	do_action( 'ipress_loop_content_after' );
?>
</section><!-- .post-summary / .post-excerpt -->
