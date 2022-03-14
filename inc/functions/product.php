<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality for WooCommerce
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	WooCommerce Functions
//
// ipress_wc_active
// ipress_wc_version_check
// ipress_wc_version
// ipress_wc_version_notice
// ipress_wc_archive
// ipress_wc_page
// ipress_wc_pages
// ipress_is_wc_endpoint
// ipress_wc_cart_available
// ipress_wc_subscriptions_active
//----------------------------------------------

if ( ! function_exists( 'ipress_wc_active' ) ) :

	/**
	 * Query WooCommerce activation
	 *
	 * @return boolean true if WooCommerce plugin active
	 */
	function ipress_wc_active() {
		return class_exists( 'WooCommerce', false );
	}
endif;

if ( ! function_exists( 'ipress_wc_version_check' ) ) :

	/**
	 * Compare WooCommerce version
	 *
	 * @param string $version WooCommerce version, default 4.0
	 * @param string $compare default '>=' greater or equal than
	 * @return boolean WooCommerce version comparison, or false if not active
	 */
	function ipress_wc_version_check( $version = '4.0', $compare = '>=' ) {
		global $woocommerce;
		return ( ipress_wc_active() ) ? version_compare( $woocommerce->version, $version, $compare ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_version' ) ) :

	/**
	 * Retrieve current WooCommerce version
	 *
	 * @return string|boolean WooCommerce version if active, false if not
	 */
	function ipress_wc_version() {
		global $woocommerce;
		return ( ipress_wc_active() ) ? $woocommerce->version : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_version_notice' ) ) :

	/**
	 * Display WooCommerce version notice
	 *
	 * @return string WooCommerce version warning notice
	 */
	function ipress_wc_version_notice() {
		$message = sprintf(
			/* translators: 1: WooCommerce version, 2: WooCommerce version */
			__( 'Theme Requires WooCommerce %1$s. Version %2$s installed', 'ipress' ),
			IPRESS_THEME_WC,
			ipress_wc_version()
		);
		echo sprintf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
	}
endif;

if ( ! function_exists( 'ipress_wc_archive' ) ) :

	/**
	 * Checks if the current page is a WooCommerce archive page
	 *
	 * @return boolean True if a WooCommerce archive page, false if not
	 */
	function ipress_wc_archive() {
		return ( ipress_wc_active() ) ? ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_page' ) ) :

	/**
	 * Checks if the current page is a WooCommerce standard page with shortcode
	 *
	 * @return boolean True if a standard WooCommerce page, false if not
	 */
	function ipress_is_wc_page() {
		return ( ipress_wc_active() ) ? ( is_cart() || is_checkout() || is_account_page() ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_pages' ) ) :

	/**
	 * Checks if the current page is a WooCommerce page of any description.
	 *
	 * @return boolean True if a standard WooCommerce page, false if not
	 */
	function ipress_wc_pages() {

		// Initial test
		if ( ipress_wc_active() && is_woocommerce() ) {
	        return true;
    	}

		// Set up filterable WooCommerce virtual page list
		$woocommerce_keys = apply_filters(
			'ipress_wc_pages_list',
			[ 
				'woocommerce_shop_page_id' ,
				'woocommerce_terms_page_id' ,
				'woocommerce_cart_page_id',
				'woocommerce_checkout_page_id',
				'woocommerce_pay_page_id',
				'woocommerce_thanks_page_id',
				'woocommerce_myaccount_page_id',
				'woocommerce_edit_address_page_id',
				'woocommerce_view_order_page_id',
				'woocommerce_change_password_page_id',
				'woocommerce_logout_page_id',
				'woocommerce_lost_password_page_id' 
			]
		);

		foreach ( $woocommerce_keys as $wc_page_id ) {
			if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
				return true ;
			}
		}
		return false;
	}
endif;

if ( ! function_exists( 'ipress_wc_page_id' ) ) :

	/**
	 * Get the page if is a WooCommerce page
	 *
	 * @param string $page page type, default empty
	 * @return boolean WooCommerce page ID if found, false if not
	 */
	function ipress_wc_page_id( $page = '' ) {

		// Valid WooCommerce page types
		$wc_pages = [
			'myaccount',
			'shop',
			'cart',
			'checkout',
			'terms',
		];

		// No WooCommerce?
		if ( ! ipress_wc_active() ) {
			return false;
		}

		// Page?
		if ( $page && in_array( $page, $wc_pages, true ) ) {
			return wc_get_page_id( $page );
		}

		// Correct type of WooCommerce page
		if ( is_shop() ) {
			return wc_get_page_id( 'shop' );
		} elseif ( is_cart() ) {
			return wc_get_page_id( 'cart' );
		} elseif ( is_checkout() ) {
			return wc_get_page_id( 'checkout' );
		} elseif ( is_account_page() ) {
			return wc_get_page_id( 'myaccount' );
		}

		// None found
		return false;
	}
endif;

if ( ! function_exists( 'ipress_is_wc_endpoint' ) ) :

	/**
	 * Check if is a WooCommerce endpoint
	 *
	 * @param string $endpoint endpoint type, default url
	 * @return boolean true / false
	 */
	function ipress_is_wc_endpoint( $endpoint = 'url' ) {

		// Valid WooCommerce page types
		$wc_endpoints = [
			'url',
			'order-pay',
			'order-received',
			'view-order',
			'edit-account',
			'edit-address',
			'lost-password',
			'customer-logout',
			'add-payment-method',
		];

		// No WooCommerce?
		if ( ! ipress_wc_active() ) {
			return false;
		}

		// Check endpoint validity
		if ( ! in_array( $endpoint, $wc_endpoints ) ) {
			return false;
		}

		// Check by endpoint
		switch( $endpoint ) {
			case 'order-pay':
				return is_wc_endpoint_url( 'order-pay' );
			case 'order-received':
				return is_wc_endpoint_url( 'order-received' );
			case 'view-order':
				return is_wc_endpoint_url( 'view-order' );
			case 'edit-account':
				return is_wc_endpoint_url( 'edit-account' );
			case 'edit-address':
				return is_wc_endpoint_url( 'edit-address' );
			case 'lost-password':
				return is_wc_endpoint_url( 'lost-password' );
			case 'customer-logout':
				return is_wc_endpoint_url( 'customer-logout' );
			case 'add-payment-method':
				return is_wc_endpoint_url( 'add-payment-method' );
			case 'url':
				return is_wc_endpoint_url();
			default:
				break;
		}

		return false;
	}
endif;

if ( ! function_exists( 'ipress_wc_cart_available' ) ) :

	/**
	 * Checks whether the Woo Cart instance is available in the request
	 *
	 * @return boolean
	 */
	function ipress_wc_cart_available() {
		$woo = WC();
		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
endif;

if ( ! function_exists( 'ipress_wc_subscriptions_active' ) ) :

	/**
	 * Query WooCommerce subscriptions activation
	 *
	 * @return boolean true if WooCommerce Subscriptions plugin active
	 */
	function ipress_wc_subscriptions_active() {
		return( ipress_wc_active() ) ? class_exists( 'WC_Subscriptions', false ) : false;
	}
endif;

//end
