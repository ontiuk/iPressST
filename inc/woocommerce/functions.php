<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * WooCommerce functions.
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// ------------------------------------
// Product Pagination Functions
//
// ipress_get_previous_product
// ipress_get_next_product
// ------------------------------------

if ( ! function_exists( 'ipress_get_previous_product' ) ) :

	/**
	 * Retrieves the previous product.
	 *
	 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
	 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
	 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
	 * @see Adapted from WooCommerce Storefront Theme
	 * @return WC_Product|falseProduct object if successful. False if no valid product is found.
	 */
	function ipress_get_previous_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new IPR_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
		return $product->get_product( true );
	}
endif;

if ( ! function_exists( 'ipress_get_next_product' ) ) :

	/**
	 * Retrieves the next product.
	 *
	 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
	 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
	 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
	 * @see Adapted from WooCommerce Storefront Theme
	 * @return WC_Product|false Product object if successful. False if no valid product is found.
	 */
	function ipress_get_next_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new IPR_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
		return $product->get_product();
	}
endif;

// ------------------------------------
// Product and Shop Functions
//
// ipress_shop_results
// ------------------------------------

if ( ! function_exists( 'ipress_shop_results' ) ) :

	/**
	 * Remove shop results from archives listing
	 */
	function ipress_shop_results(){

		// Must be active and shop page
		if ( ! ipress_wc_active() || ! is_shop() ) { return; }

		// Remove the sorting dropdown from WooCommerce archives header
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );

		// Remove the result count from WooCommerce archives header
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
	}
endif;

// ------------------------------------
// Custom Theme Functions
// ------------------------------------
