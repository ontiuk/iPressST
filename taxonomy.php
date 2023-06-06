<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying taxonomy archives.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php $the_tax = get_taxonomy( get_queried_object()->taxonomy ); ?>

<?php get_header(); ?>

	<main id="main" class="site-main taxonomy-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'ipress_before_archive' ); ?>

		<header class="page-header">
			<?php
			$the_tax_title = sprintf(
				/* translators: 1. taxonomy name, 2. taxonomy title. */
				__( 'Taxonomy: %1$s: %2$s', 'ipress' ),
				esc_attr( $the_tax->labels->singular_name ),
				esc_html( single_term_title( '', false ) )
			);
			?>
			<h1 class="page-title taxonomy-title"><?php echo esc_html( $the_tax_title ); ?></h1>
			<?php the_archive_description( '<div class="archive-description taxonomy-archive">', '</div>' ); ?>
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
