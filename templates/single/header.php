<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop header.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_post_header' ); ?>

<header class="post-header">

	<?php do_action( 'ipress_post_header' ); ?>
	<?php
	if ( is_singular() ) {
		the_title( '<h1 class="post-title single-title">', '</h1>' );
	} else {
		the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
	}
	?>

	<?php do_action( 'ipress_after_post_header_title' ); ?>

</header><!-- .post-header -->

<?php do_action( 'ipress_after_post_header' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
