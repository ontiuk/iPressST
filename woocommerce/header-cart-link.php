<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Woocommerce header cart link
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Check WC cart is available
if ( ! ipress_wc_cart_available() ) {
	return;
}

// Get Woocomerce details if available
$cart_url      = wc_get_cart_url();
$cart_count    = WC()->cart->get_cart_contents_count();
$cart_subtotal = WC()->cart->get_cart_subtotal();

// Display link
echo sprintf(
	'<a href="%s" id="getHeaderCart" class="header-cart-link" title="%s"><span class="cart-items-total">%s</span><span class="cart-items-number">%d</span></a>',
	esc_url( $cart_url ),
	esc_attr_e( 'View your basket', 'ipress' ),
	wp_kses_post( $cart_subtotal ),
	wp_kses_data( $cart_count )
);
