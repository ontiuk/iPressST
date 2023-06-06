<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying generic category archives.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<main id="main" class="site-main category-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'ipress_before_archive' ); ?>

		<header class="page-header">
			<?php
			$category_title = sprintf(
				/* translators: %s: category title */
				__( 'Category: %s', 'ipress' ),
				single_cat_title( '', false )
			);
			?>
			<h1 class="page-title category-title"><?php echo wp_kses_post( $category_title ); ?></h1>
			<?php the_archive_description( '<div class="archive-description category-archive">', '</div>' ); ?>
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
