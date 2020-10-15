<?php
/**
 * The Template for displaying all single products
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<?php defined( 'ABSPATH' ) || exit; ?>

<?php

get_header( 'shop' ); ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

	<main id="main" class="site-main single-product">

	<?php do_action( 'ipress_single_product_before' ); ?>	

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; // end of the loop. ?>

	<?php do_action( 'ipress_single_product_after' ); ?>

	</main><!-- #main / .site-main-->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' );
