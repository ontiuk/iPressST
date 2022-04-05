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

// Theme Name & Versioning
define( 'IPRESS_THEME_NAME', 	'iPress' );
define( 'IPRESS_TEXT_DOMAIN', 	'ipress' );
define( 'IPRESS_THEME_WP',   	5.6 ); // WordPress minimum version required
define( 'IPRESS_THEME_PHP',  	7.4 ); // Server PHP minimum version required
define( 'IPRESS_THEME_WC',   	6.0 ); // WooCommerce minimum version required

// Directory Structure
define( 'IPRESS_DIR',           get_theme_file_path() );
define( 'IPRESS_ASSETS_DIR',    IPRESS_DIR . '/assets' );
define( 'IPRESS_INCLUDES_DIR',  IPRESS_DIR . '/inc' );
define( 'IPRESS_TEMPLATES_DIR', IPRESS_DIR . '/templates' );
define( 'IPRESS_LANG_DIR',      IPRESS_DIR . '/languages' );

// Assets Directory Structure
define( 'IPRESS_CSS_DIR',       IPRESS_ASSETS_DIR . '/css' );
define( 'IPRESS_JS_DIR',        IPRESS_ASSETS_DIR . '/js' );
define( 'IPRESS_IMAGES_DIR',    IPRESS_ASSETS_DIR . '/images' );
define( 'IPRESS_FONTS_DIR',     IPRESS_ASSETS_DIR . '/fonts' );

// Includes Directory Structure
define( 'IPRESS_LIB_DIR',       IPRESS_INCLUDES_DIR . '/lib' );
define( 'IPRESS_ADMIN_DIR',	    IPRESS_INCLUDES_DIR . '/admin' );
define( 'IPRESS_CLASSES_DIR',   IPRESS_INCLUDES_DIR . '/classes' );
define( 'IPRESS_BLOCKS_DIR',    IPRESS_INCLUDES_DIR . '/blocks' );
define( 'IPRESS_CONTROLS_DIR',  IPRESS_INCLUDES_DIR . '/controls' );
define( 'IPRESS_FUNCTIONS_DIR', IPRESS_INCLUDES_DIR . '/functions' );
define( 'IPRESS_WIDGETS_DIR',   IPRESS_INCLUDES_DIR . '/widgets' );

// Directory Paths
define( 'IPRESS_URL',           get_theme_file_uri() );
define( 'IPRESS_ASSETS_URL',    IPRESS_URL . '/assets' );
define( 'IPRESS_INCLUDES_URL',  IPRESS_URL . '/inc' );
define( 'IPRESS_LANG_URL',      IPRESS_URL . '/languages' );

// Assets Directory Paths
define( 'IPRESS_CSS_URL',       IPRESS_ASSETS_URL . '/css' );
define( 'IPRESS_JS_URL',        IPRESS_ASSETS_URL . '/js' );
define( 'IPRESS_IMAGES_URL',    IPRESS_ASSETS_URL . '/images' );
define( 'IPRESS_FONTS_URL',     IPRESS_ASSETS_URL . '/fonts' );

// Includes Directory Paths
define( 'IPRESS_LIB_URL',       IPRESS_INCLUDES_URL . '/lib' );

//----------------------------------------------
//	Theme Compatibility & Versioning
//----------------------------------------------

// Load compatability check
$ipress_compat = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-compat.php';
if ( true === $ipress_compat->get_error() ) { return; }

//------------------------------------------------------
//	Includes - Functions, Blocks, Customizer, Template
//------------------------------------------------------

// Functions
require_once IPRESS_INCLUDES_DIR . '/functions.php';

// Customizer: custom controls
require_once IPRESS_INCLUDES_DIR . '/customizer.php';

// Blocks: custom guttenberg blocks
require_once IPRESS_INCLUDES_DIR . '/blocks.php';

// Functions: theme template hooks & functions
require_once IPRESS_INCLUDES_DIR . '/template-hooks.php';
require_once IPRESS_INCLUDES_DIR . '/template-functions.php';

//----------------------------------------------
//	Init
//----------------------------------------------

// Initialization
do_action( 'ipress_init' );

// Initiate Main Registry, Scripts & Styles
$ipress = (object)[];

// Set theme & version
$ipress->theme   = wp_get_theme( IPRESS_THEME_NAME );
$ipress->version = $ipress->theme['Version'];

// Theme setup & customizer functionality
$ipress->main       = require_once IPRESS_CLASSES_DIR . '/class-ipr-theme.php';
$ipress->customizer = require_once IPRESS_CLASSES_DIR . '/class-ipr-customizer.php';

// Multisite?
if ( is_multisite() ) {
	$ipress->multisite = require_once IPRESS_CLASSES_DIR . '/class-ipr-multisite.php';
}

//----------------------------------------------
//	Includes - Classes
//----------------------------------------------

// Theme hooks
require_once IPRESS_CLASSES_DIR . '/class-ipr-hooks.php';

// Load scripts & styles
require_once IPRESS_CLASSES_DIR . '/class-ipr-load-scripts.php';
require_once IPRESS_CLASSES_DIR . '/class-ipr-load-styles.php';

// Theme header setup
require_once IPRESS_CLASSES_DIR . '/class-ipr-init.php';

// Layout template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-layout.php';

// Mavigation functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-navigation.php';

// Images & Media template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-images.php';

// Login Redirect template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-login.php';

// Rewrites template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-rewrites.php';

// Sidebars functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-sidebars.php';

// Widgets functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-widgets.php';

// Page Support: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-ipr-page.php';

// Ajax Functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-ajax.php';

// REST API functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-api.php';

// Scheduled cron tasks
require_once IPRESS_CLASSES_DIR . '/class-ipr-cron.php';

// Query modification
require_once IPRESS_CLASSES_DIR . '/class-ipr-query.php';

// Redirect functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-redirect.php';

// Rewrite rules & query vars
require_once IPRESS_CLASSES_DIR . '/class-ipr-rules.php';

// Template includes & redirects
require_once IPRESS_CLASSES_DIR . '/class-ipr-template.php';

// User functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-user.php';

// Admin UI functionality
if ( is_admin() ) {
	require_once IPRESS_CLASSES_DIR . '/class-ipr-admin.php';
}

//----------------------------------------------------------
//	Initialize Custom Post Types & Taxonomies
//----------------------------------------------------------

// Custom Post-Types & Taxonomies
require_once IPRESS_CLASSES_DIR . '/class-ipr-post-type.php';
require_once IPRESS_CLASSES_DIR . '/class-ipr-taxonomy.php';

//----------------------------------------------
//	Libraries & Plugins
//----------------------------------------------

// Advanced Custom Fields active?
if ( ipress_acf_plugin_active() ) {
	require_once IPRESS_CLASSES_DIR . '/class-ipr-acf.php';
}

// WooCommerce active?
if ( ipress_wc_active() ) {

	// Do versioning check
	if ( ipress_wc_version_check( IPRESS_THEME_WC ) ) {

		// Main WooCommerce class
		$ipress->woocommerce = require_once IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce.php';

		// WooCommerce customizer functionality
		$ipress->woocommerce_customizer = require IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce-customizer.php';

		// Include WooCommerce REST API functionality
		require IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce-api.php';

		// WooCommerce product pagination functionality
		require IPRESS_INCLUDES_DIR . '/woocommerce/class-ipr-woocommerce-adjacent-products.php';
		require IPRESS_INCLUDES_DIR . '/woocommerce/functions.php';

		// WooCommerce template hooks & functions
		require IPRESS_INCLUDES_DIR . '/woocommerce/template-hooks.php';
		require IPRESS_INCLUDES_DIR . '/woocommerce/template-functions.php';
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
