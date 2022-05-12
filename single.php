<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Display single post content.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="main-content single-page">

	<?php do_action( 'ipress_single_before' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php the_post(); ?>

		<?php get_template_part( 'templates/content', 'single' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_single_after' ); ?>

	</main><!-- #main / .main-content -->

	<?php do_action( 'ipress_sidebar' ); ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
