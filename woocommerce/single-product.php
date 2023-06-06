<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * The Template for displaying all single products
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */
?>

<?php get_header( 'shop' ); ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'ipress_before_single_product' ); ?>	
	
		<?php the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php do_action( 'ipress_after_single_product' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
