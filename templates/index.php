<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying generic post list via the_loop.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_loop_before' ); ?>

<?php while ( have_posts() ) : ?>

	<?php the_post(); ?>

	<?php get_template_part( 'templates/content', get_post_format() ); ?>

<?php endwhile; ?>

<?php
/** @hooked ipress_loop_nav - 10 */
do_action( 'ipress_loop_after' );
