<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme config file: set-up, actions, filters etc.
 *
 * @package iPress\Config
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// phpcs:disable

// Development - Set up simple debugging via core define
$ip_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

//----------------------------------------------------------------------
// Theme Scripts, Styles & Fonts
// ================================
//
// // Set up scripts
// return [
//
//   // Core scripts: [ 'script-name', 'script-name2' ... ]
//   'core' => [ 'jquery' ],
//
//   // Admin scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'admin' => [],
//
//   // External scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'locale' ] ... ]
//   'external' => [],
//
//   // Header scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'header' => [],
//
//   // Footer scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'footer' => [],
//
//   // Plugin scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'locale' ] ... ]
//   'plugins' => [],
//
//   // Page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'page' => [],
//
//   // Store page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'store' => [],
//
//   // Conditional scripts: [ 'label' => [ (array|string)callback_fn, 'path_url', (array)dependencies, 'version' ] ... ];
//   'conditional' => [],
//
//   // Front page scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'front' => [],
//
//   // Custom scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ];
//   'custom' => [
//     'theme' => [ IPRESS_CHILD_JS_URL . '/theme.js', [ 'jquery' ], NULL ]
//   ],
//
//   // Login scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'login' => [],
//
//   // Inline scripts: [ 'label' => [ 'src' => text/function, 'position' => 'before|after' ] ]
//   'inline'	=> [],
//
//   // Localize scripts: [ 'label' => [ 'name' => name, trans => function/path_url ] ]
//   'local' => [
//     'theme'		=> [
//       'name'	=> 'theme',
//       'trans' => [
//         'home_url' => home_url(),
//         'ajax_url' => admin_url( 'admin-ajax.php' ),
//         'rest_url' => rest_url( '/' )
//       ]
//     ]
//   ],
//
//   // Script attributes ( defer, async, integrity ) : [ 'label' => [ [ 'handle', key ], ...] ]
//   'attr' => []
// ];
//----------------------------------------------------------------------

// Register Scripts, Styles & Fonts: Scripts, override at lower priority
add_filter( 'ipress_scripts', function() use( $ip_suffix ) {

	global $ipress_version;

	// Set up theme scripts
	return [

		// Add core scripts, front-end
		'core' => [ 'jquery' ],

		// Theme scripts
		'custom' => [
			'navigation' => [ IPRESS_JS_URL . '/navigation' . $ip_suffix . '.js', [ 'theme' ], $ipress_version ],
			'theme' => [ IPRESS_JS_URL . '/theme' . $ip_suffix . '.js', [ 'jquery' ], $ipress_version ],
		],

		// Localize scripts: [ 'label' => [ 'name' => name, trans => function/path_url ] ]
		'local' => [
			'theme' => [
				'name'  => 'theme',
				'trans' => [
					'home_url' => esc_url( home_url() ),
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'rest_url' => esc_url( rest_url() ),
				]
			]
		]
	];
} );

//----------------------------------------------------------------------
// Theme Scripts, Styles & Fonts
// ================================
//
// // Set up styles
// return [
//
//   // Core styles: [ 'script-name', 'script-name2' ... ]
//   'core' => [],
//
//   // Admin styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'admin' => [],
//
//   // External styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'external' => [],
//
//   // Header styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'header' => [],
//
//   // Plugin styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'plugins' => [],
//
//   // Page styles: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'page' => [],
//
//   // Store page styles: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'store' => [],
//
//   // Front page styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'front' => [],
//
//   // Login page styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'login' => [],
//
//   // Print only styles: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'print' => [],
//
//   // Theme styles: [ 'label' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'theme'  => [
//     'theme' => [ IPRESS_CHILD_URL . '/style.css', [], NULL ]
//   ],
//
//   // Inline style: [ 'label' => [ [ 'handle', key ], ...] ]
//   'inline' => []
//
//   // Style attributes ( defer, async, integrity ): [ 'label' => [ [ 'handle', key ], ...] ]
//   'attr' 	=> []
// ];
//----------------------------------------------------------------------

// Register Scripts, Styles & Fonts: Styles, override at lower priority
add_filter( 'ipress_styles', function() use( $ip_suffix ) {

	global $ipress_version;

	// Set up theme styles
	return [
		'theme' => [
			'ipress' => [ IPRESS_URL . '/style' . $ip_suffix . '.css', [], $ipress_version ]
		]
	];
} );

//----------------------------------------------------------------------
// Theme Scripts, Styles & Fonts
// ================================
//
// // Set up custom fonts, via Google
// $ip_fonts = [
//   return [
//		'family' => [
//			[
//				'font-family' 	=> 'Montserrat',
//				'font-weight'	=> [ 600, 700 ]
//			],
//			[
//				'font-family' 	=> 'Roboto',
//				'font-weight'	=> [ 300, 400, 500, 700 ]
//			]
//		],
//		'media' => 'screen'
//   ];
// ];
//----------------------------------------------------------------------

// Register Scripts, Styles & Fonts: Fonts, override at lower priority
add_filter( 'ipress_fonts', function() {
	return [];
} );

//--------------------------------------------------------------
//	Theme Custom Post Types & Taxonomies
//
// @see https://codex.wordpress.org/Function_Reference/register_post_type
// @see https://codex.wordpress.org/Function_Reference/register_taxonomy
//
// $post_types = [
//   'cpt' => [
//     'singular' => _x( 'CPT', 'Post Type Singular Name', 'ipress' ),
//     'plural' => _x( 'CPTs', 'Post Type General Name', 'ipress' ),
//     'args' => [
//       'public'       => false,
//       'description'  => __( 'This is the CPT post type', 'ipress' ),
//       'supports'     => [ 'title', 'editor', 'thumbnail' ],
//       'taxonomies'   => [ 'post_tag', 'category' ],
//       'has_archive'  => true,
//       'show_in_rest' => true
//     ],
//   ]
// ];
//
// $taxonomies = [
//   'cpt_tax' => [
//     'singular' => _x( 'Taxonomy Name', 'Taxonomy Singular Name', 'ipress' ),
//     'plural' => _x( 'Taxonomies Name', 'Taxonomy General Name', 'ipress' ),
//     'post_types' => [ 'cpt' ],
//     'args' => [
//		 'public'      		 => false,
//       'description' 		 => __( 'This is the Taxonomy name', 'ipress' ),
//       'show_admin_column' => true
//     ],
//     'sortable' => true, //optional
//     'filter' => true  //optional
//    ]
//  ];
// ----------------------------------------------------------

// Register Custom Post Types, override at lower priority
add_filter( 'ipress_post_types', function() {
	return [];
} );

// Register taxonomies, override at lower priority
add_filter( 'ipress_taxonomies', function() {
	return [];
} );

//----------------------------------------------
//	Menus Configuration
//----------------------------------------------

// Register default menu locations, override at lower priority
add_filter( 'ipress_nav_menus', function() {
	return [
		'primary' => __( 'Primary Menu', 'ipress' ),
	];
} );

//----------------------------------------------
//	Images Configuration
//----------------------------------------------

// Add custom image size, override at lower priority
add_filter( 'ipress_add_image_size', function() {
	return [];
} );

// Add media image options, override at lower priority
add_filter( 'ipress_media_images', function () {
	return [
		'image-in-post' => __( 'Image in Post', 'ipress' ),
		'full' 			=> __( 'Original size', 'ipress' ),
	];
} );

//----------------------------------------------
//	Sidebars Configuration
//----------------------------------------------

// Generate initial default sidebars, override at lower priority
add_filter( 'ipress_default_sidebars', function() {
	return	[
		'primary' => [
			'name'        => __( 'Primary Sidebar', 'ipress' ),
			'description' => __( 'This is the primary sidebar.', 'ipress' ),
			'class'       => 'sidebar-primary',
		],
		'header'  => [
			'name'        => __( 'Header Sidebar', 'ipress' ),
			'description' => __( 'This is the header sidebar.', 'ipress' ),
			'class'       => 'sidebar-header',
		],
	];
} );

// Generate footer sidebars, override at lower priority
add_filter( 'ipress_footer_sidebars', function() {
	return []; // or, false for numerical sidebars
} );

//----------------------------------------------
//	Widgets Configuration
//----------------------------------------------

// Add custom widget areas, override at lower priority
add_filter ( 'ipress_widgets', function() {
	return [];
} );

//----------------------------------------------
//	Custom Hooks & Filters
//----------------------------------------------

//----------------------------------------------
//	Shortcode Configuration
//	- Terms & conditions
//	- Privacy
//	- Cookies
//----------------------------------------------

//------------------------------
// Plugins
// - ACF
//------------------------------

// Advanced Custom Fields Admin UI
if ( is_admin() ) {
	require_once IPRESS_LIB_DIR . '/acf-config.php';
}

//----------------------------------------------
//	WooCommerce Configuration
//----------------------------------------------

// Woocommerce functionality, if active
if ( ipress_wc_active() ) {

	// WooCommerce scripts: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
	add_filter( 'ipress_scripts', function( $scripts ) use( $ip_suffix ) {
		$scripts['store'] = [];
		return $scripts;
	}, 12 );

	// WooCommerce styles: [ 'label' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
	add_filter( 'ipress_styles', function( $styles ) use( $ip_suffix ) {
		$styles['store'] = [
			'ipress-woocommerce' => [ 'all', IPRESS_CSS_URL . '/woocommerce/woocommerce' . $ip_suffix . '.css', [ 'ipress' ], null ],
		];
		return $styles;
	}, 12 );

	// Custom Shop Sidebar Areas, override at lower priority
	add_filter( 'ipress_custom_sidebars', function() {
		return [
			'shop' => [
				'name'        => __( 'Shop Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop page sidebar for all layouts.', 'ipress' ),
				'class'		  => 'shop-sidebar',
			],
			'product' => [
				'name'        => __( 'Shop Product Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop product page sidebar for all layouts.', 'ipress' ),
				'class'		  => 'shop-product-sidebar',
			],
			'product-category' => [
				'name'        => __( 'Shop Category Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop category page sidebar for all layouts.', 'ipress' ),
				'class'		  => 'shop-category-sidebar'
			],
			'cart' => [
				'name'        => __( 'Shop Cart & Checkout Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop cart & checkout page sidebar for all layouts.', 'ipress' ),
				'class'		  => 'shop-cart-sidebar',
			],
			'account' => [
				'name'        => __( 'Shop Account Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop account page sidebar for all layouts.', 'ipress' ),
				'class'		  => 'shop-account-sidebar',				
			]
		];
	} );

	// Login - redirect login page to my account
	add_filter( 'ipress_login_page', function() {
		return __( 'my-account', 'ipress' );
	} );

	// Logout - redirect logout to my account page
	add_filter( 'ipress_login_logout_page', function() {
		return __( 'my-account', 'ipress' );
	} );
}

//--------------------------------------
// Google
// - Analytics
// - Adwords Tracking
//--------------------------------------
