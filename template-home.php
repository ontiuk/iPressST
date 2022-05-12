<?php /* Template Name: Home Page */

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Home / front-page page when set as template.
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

	<main id="main" class="main-content front-page front-template">

	<?php do_action( 'ipress_homepage_before' ); ?>

	<?php if ( have_posts() ) : ?> 

		<?php the_post(); ?>

		<?php get_template_part( 'templates/content', 'home' ); ?>

	<?php endif; ?>

	<?php
	/**
	 * Functions hooked in to homepage_after action
	 * - Requires WoCommerce to be active
	 *
	 * @hooked ipress_product_categories    - 10
	 * @hooked ipress_recent_products       - 20
	 * @hooked ipress_featured_products     - 30
	 * @hooked ipress_popular_products      - 40
	 * @hooked ipress_on_sale_products      - 50
	 * @hooked ipress_best_selling_products - 60
	 */
	do_action( 'ipress_homepage' );
	?>

	</main><!-- #main / .main-content -->

	<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
