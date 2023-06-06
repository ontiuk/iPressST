<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Main template displaying generic blog posts archive.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<main id="main" class="site-main home-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'ipress_before_archive' ); ?>

		<?php get_template_part( 'templates/home' ); ?>

		<?php do_action( 'ipress_after_archive' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

	</main><!-- #main / .site-main -->

	<?php do_action( 'ipress_sidebar' ); ?>

	<?php do_action( 'ipress_after_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
