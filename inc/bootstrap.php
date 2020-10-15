<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Set up and load theme requirements and bootstrap initialization.
 * 
 * @package		iPress\Bootstrap
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Initialise hooks
do_action( 'ipress_bootstrap' );

//----------------------------------------------
//	Theme Defines
//----------------------------------------------

// Theme Name & Versioning
define( 'IPRESS_THEME_NAME', 		'iPress' );
define( 'IPRESS_THEME_WP', 			5.2 ); 	// WordPress minimum version required
define( 'IPRESS_THEME_PHP', 		7.2 ); 	// Server PHP minimum version required
define( 'IPRESS_THEME_WC', 			4.4 ); 	// Woocommerce minimum version required

// Development mode
define( 'IPRESS_DEV',				true ); // Dev mode, true/false. Sets minified status on theme css & js files.  

// Directory Structure
define( 'IPRESS_DIR', 				get_theme_file_path() );
define( 'IPRESS_ASSETS_DIR',		IPRESS_DIR . '/assets' );
define( 'IPRESS_INCLUDES_DIR',		IPRESS_DIR . '/inc' );
define( 'IPRESS_TEMPLATES_DIR',		IPRESS_DIR . '/templates' );
define( 'IPRESS_LANG_DIR',			IPRESS_DIR . '/languages' );

// Assets Directory Structure
define( 'IPRESS_CSS_DIR',			IPRESS_ASSETS_DIR . '/css' );
define( 'IPRESS_JS_DIR',			IPRESS_ASSETS_DIR . '/js' );
define( 'IPRESS_IMAGES_DIR',		IPRESS_ASSETS_DIR . '/images' );
define( 'IPRESS_FONTS_DIR',			IPRESS_ASSETS_DIR . '/fonts' );

// Includes Directory Structure
define( 'IPRESS_LIB_DIR',			IPRESS_INCLUDES_DIR . '/lib' );
define( 'IPRESS_ADMIN_DIR',			IPRESS_INCLUDES_DIR . '/admin' );
define( 'IPRESS_CLASSES_DIR',		IPRESS_INCLUDES_DIR . '/classes' );
define( 'IPRESS_BLOCKS_DIR',		IPRESS_INCLUDES_DIR . '/blocks' );
define( 'IPRESS_CONTROLS_DIR',		IPRESS_INCLUDES_DIR . '/controls' );
define( 'IPRESS_FUNCTIONS_DIR',		IPRESS_INCLUDES_DIR . '/functions' );
define( 'IPRESS_SHORTCODES_DIR',	IPRESS_INCLUDES_DIR . '/shortcodes' );
define( 'IPRESS_WIDGETS_DIR',		IPRESS_INCLUDES_DIR . '/widgets' );

// Directory Paths
define( 'IPRESS_URL',				get_theme_file_uri() );
define( 'IPRESS_ASSETS_URL',		IPRESS_URL . '/assets' );
define( 'IPRESS_INCLUDES_URL',		IPRESS_URL . '/inc' );
define( 'IPRESS_LANG_URL',			IPRESS_URL . '/languages' );

// Assets Directory Paths
define( 'IPRESS_CSS_URL',			IPRESS_ASSETS_URL . '/css' );
define( 'IPRESS_JS_URL',			IPRESS_ASSETS_URL . '/js' );
define( 'IPRESS_IMAGES_URL',		IPRESS_ASSETS_URL . '/images' );
define( 'IPRESS_FONTS_URL',			IPRESS_ASSETS_URL . '/fonts' );

// Includes Directory Paths
define( 'IPRESS_LIB_URL',			IPRESS_INCLUDES_URL . '/lib' );

//----------------------------------------------
//	Theme Compatibility & Versioning
//----------------------------------------------

// Load compatability check
$ipress_compat = require_once IPRESS_INCLUDES_DIR . '/classes/class-compat.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
if ( true === $ipress_compat->get_error() ) { return; }

//----------------------------------------------
//	Includes - Functions
//----------------------------------------------

// Functions
require_once IPRESS_INCLUDES_DIR . '/functions.php'; 	// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Shortcodes functionality
require_once IPRESS_INCLUDES_DIR . '/shortcodes.php'; 	// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Customizer: custom controls
require_once IPRESS_INCLUDES_DIR . '/customizer.php'; 	// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Blocks: custom guttenberg blocks
require_once IPRESS_INCLUDES_DIR . '/blocks.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Functions: theme template hooks & functions
require_once IPRESS_INCLUDES_DIR . '/template-hooks.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require_once IPRESS_INCLUDES_DIR . '/template-functions.php'; 	// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require_once IPRESS_INCLUDES_DIR . '/template-tags.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

//----------------------------------------------
//	Includes - Classes
//----------------------------------------------

// Initialization
do_action( 'ipress_init' );

// Set Up theme
$theme			= wp_get_theme( IPRESS_THEME_NAME );
$ipress_version = $theme['Version'];

// Initiate Main Registry, Scripts & Styles
$ipress = (object)[

	// Set theme
	'theme'			=> $theme,
	'version'		=> $ipress_version,

	// Load scripts & styles
	'scripts'		=> require_once IPRESS_CLASSES_DIR . '/class-load-scripts.php', // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	'styles'		=> require_once IPRESS_CLASSES_DIR . '/class-load-styles.php', 	// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	
	// Theme setup
	'main'			=> require_once IPRESS_CLASSES_DIR . '/class-theme.php' 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

	// Theme hooks
	'hooks'			=> require_once IPRESS_CLASSES_DIR . '/class-hooks.php' 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
];

// Multisite?
if ( is_multisite() ) {
	$ipress->multisite = require_once IPRESS_CLASSES_DIR . '/class-multisite.php'; 	// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
}

// Theme header setup
require_once IPRESS_CLASSES_DIR . '/class-init.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Layout template functions
require_once IPRESS_CLASSES_DIR . '/class-layout.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Mavigation functions
require_once IPRESS_CLASSES_DIR . '/class-navigation.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Images & Media template functions
require_once IPRESS_CLASSES_DIR . '/class-images.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Login Redirect template functions
require_once IPRESS_CLASSES_DIR . '/class-login.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Rewrites template functions
require_once IPRESS_CLASSES_DIR . '/class-rewrites.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Sidebars functionality
require_once IPRESS_CLASSES_DIR . '/class-sidebars.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Widgets functionality
require_once IPRESS_CLASSES_DIR . '/class-widgets.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Page Support: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-page.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Content Functionality: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-content.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Customizer Functionality: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-customizer.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound 

// Blocks & Guttenberg Functionality: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-blocks.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Admin UI functionality
require_once IPRESS_CLASSES_DIR . '/class-admin.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Ajax Functionality
require_once IPRESS_CLASSES_DIR . '/class-ajax.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// REST API functionality
require_once IPRESS_CLASSES_DIR . '/class-api.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Scheduled cron tasks
require_once IPRESS_CLASSES_DIR . '/class-cron.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Query modification
require_once IPRESS_CLASSES_DIR . '/class-query.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Redirect functionality
require_once IPRESS_CLASSES_DIR . '/class-redirect.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Rewrite rules & query vars
require_once IPRESS_CLASSES_DIR . '/class-rules.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Template includes & redirects
require_once IPRESS_CLASSES_DIR . '/class-template.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// User functionality
require_once IPRESS_CLASSES_DIR . '/class-user.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Schema.org Microdata
if ( ipress_has_schema() ) {
	require_once IPRESS_CLASSES_DIR . '/class-schema.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
}

// Admin UI functionality
if ( is_admin() ) {
	require_once IPRESS_CLASSES_DIR . '/class-admin.php'; 		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
}

//----------------------------------------------------------
//	Initialize Custom Post Types & Taxonomies
//----------------------------------------------------------

// Custom Post-Types & Taxonomies 
require_once IPRESS_CLASSES_DIR . '/class-custom.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

//----------------------------------------------
//	Libraries & Plugins
//----------------------------------------------

// Advanced Custom Fields
require_once IPRESS_CLASSES_DIR . '/class-acf.php'; 			// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Woocommerce
if ( ipress_woocommerce_active() ) {

	// Do versioning check
	if ( ipress_woocommerce_version_check( IPRESS_THEME_WC ) ) {
		require_once IPRESS_CLASSES_DIR . '/class-woocommerce.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	} else {
		add_action( 'admin_notices', ipress_woocommerce_version_notice() );
	}
}

//----------------------------------------------
//	Theme Settings & Configuration
//----------------------------------------------

// Configuration
do_action( 'ipress_config' );

// Theme Setup Configuration: actions, filters etc
include_once IPRESS_INCLUDES_DIR . '/config.php'; 				// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

//end
