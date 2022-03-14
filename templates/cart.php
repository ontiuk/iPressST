<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying Woocommerce cart page content
 * - Displays the rendered [woocommerce_cart] shortcode via the_content()
 * - Template overrides in /woocommerce/cart
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_cart_before' ); ?>

<!-- Cart -->
<section id="cart" class="cart-content">
	<?php do_action( 'ipress_before_cart_content' ); ?>
	<?php the_content(); ?>
	<?php do_action( 'ipress_cart' ); ?>
</section><!-- #cart / .cart-content -->

<?php do_action( 'ipress_cart_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
