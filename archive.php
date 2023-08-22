<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying generic post archives when a category, taxonomy, tag, post-type, author, or date is queried.
 * - Will be overridden by specific archive type pages and respective query types if available.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<main id="main" class="site-main archive-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'ipress_before_archive' ); ?>

		<header class="page-header">
			<?php do_action( 'ipress_before_archive_title' ); ?>

			<?php the_archive_title( '<h1 class="page-title archive-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

			<?php do_action( 'ipress_after_archive_title' ); ?>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/archive' ); ?>

		<?php do_action( 'ipress_after_archive' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

	</main><!-- #main / .site-main -->

	<?php do_action( 'ipress_sidebar' ); ?>

	<?php do_action( 'ipress_after_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
