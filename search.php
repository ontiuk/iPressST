<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying search results.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php global $wp_query; ?>

<?php get_header(); ?>

	<main id="main" class="site-main search-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'ipress_search_before' ); ?>

		<header class="page-header">
			<h1 class="page-title search-title">
			<?php
			if ( 0 === $wp_query->found_posts ) {
				$search_result = sprintf(
					/* translators: 1. search results count, 2. search query. */
					_x( 'Search: No Results for <span class="search-query">%1$s</span>', 'Search results count', 'ipress' ),
					esc_html( get_search_query() )
				);
			} else {
				$search_result = sprintf(
					/* translators: 1. search results count, 2. search query. */
					_nx( 'Search: %1$s Result for <span class="search-query">%2$s</span>', 'Search: %1$s Results for <span class="search-query">%2$s</span>', $wp_query->found_posts, 'Search results count', 'ipress' ),
					esc_attr( $wp_query->found_posts ),
					esc_html( get_search_query() )
				);
			}
			echo wp_kses_post( $search_result );
			?>
			</h1>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/search' ); ?>

		<?php do_action( 'ipress_search_after' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

	</main><!-- #main / .site-main -->

	<?php do_action( 'ipress_sidebar' ); ?>

	<?php do_action( 'ipress_after_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
