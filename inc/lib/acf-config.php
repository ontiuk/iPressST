<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Advanced Custom Fields plugin config file: actions, filters, data etc
 * - Potentially move to ACF config plugin
 *
 * @package iPress\Config
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// phpcs:disable

//----------------------------------------------
//	Plugin SetUp & Configuration
//----------------------------------------------

// Set ACF options page title
add_filter( 'ipress_acf_title', function( $title ) {
	return IPRESS_THEME_NAME;	
} );

// Set ACF options page subpages
add_filter( 'ipress_acf_pages', function( $pages, $parent ) {
	return [];
}, 10, 2 );

//--------------------------------------------------
//	Plugin - Woocommerce, add main WC page options
//--------------------------------------------------

if ( ipress_wc_active() ) {

	add_filter( 'acf/location/rule_values/page_type', function ( $choices ) {
		$choices['woo_shop_page']     = __( 'WooCommerce Shop Page', 'ipress' );
		$choices['woo_cart_page']     = __( 'WooCommerce Cart Page', 'ipress' );
		$choices['woo_checkout_page'] = __( 'WooCommerce Checkout Page', 'ipress' );
		$choices['woo_account_page']  = __( 'WooCommerce Account Page', 'ipress' );
		return $choices;
	});

	add_filter( 'acf/location/rule_match/page_type', function ( $match, $rule, $options ) {

		// Shop page?
		if ( 'woo_shop_page' === $rule['value'] ) {
			if ( '==' === $rule['operator'] || '===' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) === absint( wc_get_page_id( 'shop' ) ) );
			}
			if ( '!=' === $rule['operator'] || '!==' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) !== absint( wc_get_page_id( 'shop' ) ) );
			}
		}

		// Cart page
		if ( 'woo_cart_page' === $rule['value'] ) {
			if ( '==' === $rule['operator'] || '===' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) === absint( wc_get_page_id( 'cart' ) ) );
			}
			if ( '!=' === $rule['operator'] || '!==' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) !== absint( wc_get_page_id( 'cart' ) ) );
			}
		}

		// Checkout page
		if ( 'woo_checkout_page' === $rule['value'] ) {
			if ( '==' === $rule['operator'] || '===' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) === absint( wc_get_page_id( 'checkout' ) ) );
			}
			if ( '!=' === $rule['operator'] || '!==' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) !== absint( wc_get_page_id( 'checkout' ) ) );
			}
		}

		// Account page
		if ( 'woo_account_page' === $rule['value'] ) {
			if ( '==' === $rule['operator'] || '===' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) === absint( wc_get_page_id( 'myaccount' ) ) );
			}
			if ( '!=' === $rule['operator'] || '!==' === $rule['operator'] ) {
				$match = ( absint( $options['post_id'] ) !== absint( wc_get_page_id( 'myaccount' ) ) );
			}
		}
		return $match;
	}, 10, 3 );
}

//----------------------------------------------------------------------------------------
//	Plugin CPTX Configuration
//	@see https://www.advancedcustomfields.com/resources/post-types-and-taxonomies/
//	@see https://www.advancedcustomfields.com/resources/registering-a-custom-post-type/
//	@see https://www.advancedcustomfields.com/resources/registering-a-custom-taxonomy/
//----------------------------------------------------------------------------------------

// Disable custom post types and taxonomies generation
//add_filter( 'acf/settings/enable_post_types', '__return_false' );

//----------------------------------------------------------------------------------------
//	Plugin REST Configuration
//	@see https://www.advancedcustomfields.com/resources/wp-rest-api-integration/
//----------------------------------------------------------------------------------------

// Disable REST API ACF endpoints
//add_filter( 'acf/settings/rest_api_enabled', '__return_false' );

//----------------------------------------------
//	Plugin i18n - Translation Configuration
//----------------------------------------------

// Set ACF Localization & Translations
add_filter('acf/settings/l10n', function( $localization ) {
	return true;
} );

// Set up translation text domain
add_filter('acf/settings/l10n_textdomain', function( $domain ) {
	return IPRESS_TEXT_DOMAIN;
} );

//----------------------------------------------
//	Plugin i18n - Translation Configuration
//----------------------------------------------

// Add translatable meta data: CTA Section
if ( ! function_exists( 'acf_add_local_field_group' ) ) { return; }

// Include all available meta data files
//include_once IPRESS_INCLUDES_DIR . '/lib/acf/sample.php';
