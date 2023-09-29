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

// Get Woocomerce details if available
$cart_url = wc_get_cart_url();
$cart_count = WC()->cart->get_cart_contents_count();

// Display link
echo sprintf(
	'<a href="%s" id="getHeaderCart" class="header-cart-link" title="%s">
		<svg xmlns="http://www.w3.org/2000/svg" width="36" height="20" class="bi bi-cart-fill" viewBox="0 0 16 16">
		  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
		</svg>
		<span class="cart-items-number">%d</span>
	</a>',
	esc_url( $cart_url ),
	esc_attr__( 'View your basket', 'ipress-standalone' ),
	wp_kses_data( $cart_count )
);
