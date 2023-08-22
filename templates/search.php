<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying the_loop in search mode.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_loop', 'search' ); ?>

<?php while ( have_posts() ) : ?>

	<?php the_post(); ?>

	<?php get_template_part( 'templates/content', 'search' ); ?>

<?php endwhile; ?>

<?php do_action( 'ipress_after_loop', 'search' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
