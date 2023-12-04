<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Set up and load theme requirements and bootstrap initialization.
 *
 * @package iPress\Bootstrap
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// phpcs:disable

// Initialise hooks
do_action( 'ipress_bootstrap' );

//----------------------------------------------
//	Theme Defines
//----------------------------------------------

// Theme Name
define( 'IPRESS_THEME_NAME', 'iPress Standalone' );
define( 'IPRESS_TEXT_DOMAIN', 'ipress-standalone' );
define( 'IPRESS_THEME_NAMESPACE', 'ipress-standalone' );

// Theme Versioning
define( 'IPRESS_THEME_WP', 6.3 ); // WordPress minimum version required
define( 'IPRESS_THEME_PHP', 8.1 ); // PHP minimum version required
define( 'IPRESS_THEME_WC', 8.1 ); // WooCommerce minimum version required

// Directory Structure
define( 'IPRESS_DIR', get_theme_file_path() );
define( 'IPRESS_ASSETS_DIR', IPRESS_DIR . '/assets' );
define( 'IPRESS_INCLUDES_DIR', IPRESS_DIR . '/inc' );
define( 'IPRESS_TEMPLATES_DIR', IPRESS_DIR . '/templates' );
define( 'IPRESS_LANG_DIR', IPRESS_DIR . '/languages' );
define( 'IPRESS_STORE_DIR', IPRESS_DIR . '/woocommerce' );

// Directory Paths
define( 'IPRESS_URL', get_theme_file_uri() );
define( 'IPRESS_ASSETS_URL', IPRESS_URL . '/assets' );
define( 'IPRESS_INCLUDES_URL', IPRESS_URL . '/inc' );
define( 'IPRESS_LANG_URL', IPRESS_URL . '/languages' );
define( 'IPRESS_STORE_URL', IPRESS_URL . '/woocommerce' );

//----------------------------------------------
//	Theme Compatibility & Versioning
//----------------------------------------------

// Registry helper
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-registry.php';

// Load compatability check
$ipress_compat = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-compat.php';
if ( true === $ipress_compat->get_error() ) { return; }

//------------------------------------------------------
//	Includes - Functions, Blocks, Customizer, Template
//------------------------------------------------------

// Functions
require_once IPRESS_INCLUDES_DIR . '/functions.php';

// Settings and Customizer
require_once IPRESS_INCLUDES_DIR . '/customizer.php';

// Blocks: custom guttenberg blocks
require_once IPRESS_INCLUDES_DIR . '/blocks.php';

// Functions: theme template hooks & functions
require_once IPRESS_INCLUDES_DIR . '/template-hooks.php';
require_once IPRESS_INCLUDES_DIR . '/template-functions.php';

//----------------------------------------------
//	Includes - Classes
//----------------------------------------------

// Load scripts, styles & fonts
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-load-scripts.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-load-styles.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-load-fonts.php';

// Core functionality
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-init.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-navigation.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-images.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-login.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-rewrites.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-sidebars.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-widgets.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-page.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-ajax.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-rest.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-api.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-cron.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-query.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-redirect.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-rules.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-template.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-user.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-attr.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-blocks.php';

// Theme hooks
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-hooks.php';

// Additional functionality
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-css.php';

// Optional functionality : Hero
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-hero.php';

//----------------------------------------------
//	Init
//----------------------------------------------

// Initialization
do_action( 'ipress_init' );

// Initiate Main Registry, Scripts & Styles
$ipress = (object)[];

// Set theme & version
$ipress->theme = wp_get_theme( IPRESS_THEME_NAME );
$ipress->version = $ipress->theme['Version'];

// Theme setup & customizer functionality
$ipress->main = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-theme.php';
$ipress->customizer = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-customizer.php';

// Multisite?
if ( is_multisite() ) {
	$ipress->multisite = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-multisite.php';
}

// Admin UI functionality
if ( is_admin() ) {
	require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-admin.php';
}

//----------------------------------------------------------
//	Initialize Custom Post Types & Taxonomies
//----------------------------------------------------------

require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-custom.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-post-type.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-taxonomy.php';

//----------------------------------------------
//	Libraries & Plugins
//----------------------------------------------

// Advanced Custom Fields active?
if ( ipress_acf_plugin_active() ) {
	require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-acf.php';
}

// Kirki active?
if ( ipress_kirki_active() ) {
	require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-kirki.php';
}

// Load Woocommerce functionality
require_once IPRESS_INCLUDES_DIR . '/woocommerce/functions.php';

// WooCommerce active?
if ( ipress_wc_active() ) {

	// Do versioning check
	if ( ipress_wc_version_check( IPRESS_THEME_WC ) ) {

		// Main WooCommerce class
		$ipress->woocommerce = require_once IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce.php';

		// WooCommerce customizer functionality
		$ipress->woocommerce_customizer = require IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce-customizer.php';

		// Include WooCommerce REST API functionality
		require_once IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce-api.php';

		// WooCommerce product pagination functionality
		require_once IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce-adjacent-products.php';

		// WooCommerce template hooks & functions
		require_once IPRESS_INCLUDES_DIR . '/woocommerce/template-hooks.php';
		require_once IPRESS_INCLUDES_DIR . '/woocommerce/template-functions.php';
	} else {
		add_action( 'admin_notices', ipress_wc_version_notice() );
	}
}

//----------------------------------------------
//	Theme Settings & Configuration
//----------------------------------------------

// Configuration
do_action( 'ipress_config' );

// Theme Setup Configuration: actions, filters etc
include_once IPRESS_INCLUDES_DIR . '/config.php';
