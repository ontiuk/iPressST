<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * WooCommerce Template Hooks
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//  Header Hooks
//----------------------------------------------

/**
 * @see ipress_product_search
 */
add_action( 'ipress_header', 'ipress_product_search', 40 );

//----------------------------------------------
//	Product Archive Page Hooks
//----------------------------------------------

//----------------------------------------------
//	Single Product Page Hooks
//----------------------------------------------

//----------------------------------------------
//	HomePage Hooks
//----------------------------------------------

/**
 * Homepage
 *
 * @see ipress_product_categories()
 * @see ipress_recent_products()
 * @see ipress_featured_products()
 * @see ipress_popular_products()
 * @see ipress_on_sale_products()
 * @see ipress_best_selling_products()
 */
add_action( 'ipress_homepage_after', 'ipress_product_categories', 10 );
add_action( 'ipress_homepage_after', 'ipress_recent_products', 20 );
add_action( 'ipress_homepage_after', 'ipress_featured_products', 30 );
add_action( 'ipress_homepage_after', 'ipress_popular_products', 40 );
add_action( 'ipress_homepage_after', 'ipress_on_sale_products', 50 );
add_action( 'ipress_homepage_after', 'ipress_best_selling_products', 60 );

//----------------------------------------------
//	Custom Hooks
//----------------------------------------------

// We only really need to bother with the rest if we're using the cart, so check first, default to on / true
$ip_wc_active = (bool) apply_filters( 'ipress_wc_active', true );
if ( true !== $ip_wc_active ) {
	return;
}

//----------------------------------------------
//	Cart Page Hooks
//----------------------------------------------

//----------------------------------------------
//	Checkout Page Hooks
//----------------------------------------------

//----------------------------------------------
//	Account Page Hooks
//----------------------------------------------

//----------------------------------------------
//	Order Page Hooks
//----------------------------------------------

//----------------------------------------------
//	Form Markup Hooks
//----------------------------------------------
