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

<?php do_action( 'ipress_before_loop_header' ); ?>

<header class="post-header">

	<?php do_action( 'ipress_loop_header' ); ?>
	<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

</header><!-- .post-header -->

<?php do_action( 'ipress_after_loop_header' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
