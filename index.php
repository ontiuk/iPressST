<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Main fallback template displaying generic posts list.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<main id="main" class="site-main index-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>
   
		<?php do_action( 'ipress_before_archive' ); ?>

		<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
			<header class="page-header">
				<h1 class="page-title index-title"><?php single_post_title(); ?></h1>
			</header><!-- .page-header -->
		<?php endif; ?>

		<?php get_template_part( 'templates/index' ); ?>

		<?php do_action( 'ipress_after_archive' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

	</main><!-- #main / .site-main -->

	<?php do_action( 'ipress_sidebar' ); ?>

	<?php do_action( 'ipress_after_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
