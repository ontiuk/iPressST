<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying generic date archives.
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

	<main id="main" class="site-content date-page">

	<?php do_action( 'ipress_archive_before' ); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php the_archive_title( '<h1 class="page-title date-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="archive-description date-archive">', '</div>' ); ?>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/archive' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

	</main><!-- #main / .site-content -->

	<?php do_action( 'ipress_sidebar' ); ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
