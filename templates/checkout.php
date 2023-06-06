<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying Woocommerce checkout page content
 * - Displays the rendered [woocommerce_chackout] shortcode via the_content()
 * - Template overrides in /woocommerce/checkout
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_checkout' ); ?>

<!-- Checkout -->
<section id="checkout" class="checkout-content">
	<?php do_action( 'ipress_before_checkout_content' ); ?>
	<?php the_content(); ?>
	<?php do_action( 'ipress_checkout' ); ?>
</section><!-- #checkout / .checkout-content -->

<?php do_action( 'ipress_after_checkout' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
