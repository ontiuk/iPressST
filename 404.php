<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the 404 page.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<main id="main" class="site-main error-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php if ( ipress_wc_active() ) : ?>

		<?php get_template_part( 'templates/global/404', 'product' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/404' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

	</main><!-- #main / .site-main -->

	<?php do_action( 'ipress_after_content' ); ?>

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
