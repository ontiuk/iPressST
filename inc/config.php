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
//   // Admin scripts: [ 'handle' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'admin' => [],
//
//   // External scripts: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'locale' ] ... ]
//   'external' => [],
//
//   // Scripts: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'locale' ] ... ]
//   'scripts' => [],
//
//   // Page scripts: [ 'handle' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'page' => [],
//
//   // Post-Type scripts: [ 'handle' => [ 'post_type', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'post_type' => [],
//
//   // Taxonomy & Term scripts: [ 'handle' => [ 'taxonomy' | [ 'taxonomy', 'term' ], 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'taxonomy' => [],
//
//   // Conditional scripts: [ 'handle' => [ (array|string)callback_fn, 'path_url', (array)dependencies, 'version' ] ... ];
//   'conditional' => [],
//
//   // Front page scripts: [ 'handle' => [ 'template', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'front' => [],
//
//   // Custom scripts: [ 'handle' => [ 'path_url', (array)dependencies, 'version' ] ... ];
//   'custom' => [
//     'app' => [ IPRESS_ASSETS_URL . '/js/app.js', [ 'jquery' ], NULL ]
//   ],
//
//   // Login scripts: [ 'handle' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'login' => [],
//
//   // Inline scripts: [ 'handle' => [ 'src' => text/function, 'position' => 'before|after' ] ]
//   'inline' => [],
//
//   // Localize scripts: [ 'handle' => [ 'name' => name, trans => function/path_url ] ]
//   'local' => [
//     'app' => [
//       'name'	=> 'app',
//       'trans' => [
//         'home_url' => home_url(),
//         'ajax_url' => admin_url( 'admin-ajax.php' ),
//         'rest_url' => rest_url( '/' )
//       ]
//     ]
//   ],
//
//   // Script attributes ( defer, async, integrity ) : [ 'route' => [ [ 'handle', key ], ...] ]
//   'attr' => [
//	   'integrity' => []
//   ]
// ];
//----------------------------------------------------------------------

// Register Scripts, Styles & Fonts: Scripts, override at lower priority
add_filter( 'ipress_scripts', function() use( $ip_suffix ) {

	global $ipress_version;

	// Set up scripts
	return [

		// Add core scripts, front-end
		'core' => [ 'jquery' ],

//		'external' => [
//			'jquery' => [ 'https://code.jquery.com/jquery-3.6.0' . $ip_suffix . '.js', [], '3.6.0', true ],
//		],

		// Theme scripts
		'custom' => [
			'navigation' => [ IPRESS_ASSETS_URL . '/js/navigation' . $ip_suffix . '.js', [ 'app' ], $ipress_version, true ],
			'app' => [ IPRESS_ASSETS_URL . '/js/app' . $ip_suffix . '.js', [ 'jquery' ], $ipress_version, true ],
		],

		// Localize scripts: [ 'handle' => [ 'name' => name, trans => function/path_url ] ]
		'local' => [
			'app' => [
				'name'  => 'app',
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
//   // Admin styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'admin' => [],
//
//   // External styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'external' => [],
//
//   // Styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'styles' => [],
//   
//   // Page styles: [ 'handle' => [ 'template', 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'page' => [],
//
//   // Post-Type scripts: [ 'handle' => [ 'post_type', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'post_type' => [],
//
//   // Taxonomy & Term scripts: [ 'handle' => [ 'taxonomy' | [ 'taxonomy', 'term' ], 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
//   'taxonomy' => [],
//   
//   // Front page styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'front' => [],
//
//   // Login page styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'login' => [],
//
//   // Print only styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version' ] ... ]
//   'print' => [],
//
//   // Theme styles: [ 'handle' => [ 'path_url', (array)dependencies, 'version', 'media' ] ... ]
//   'custom' => [
//     'ipress' => [ IPRESS_URL . '/style.css', [], NULL ]
//   ],
//
//   // Inline style: [ 'handle' => [ [ 'handle', key ], ...] ]
//   'inline' => []
//
//   // Style attributes ( defer, async, integrity ): [ 'route' => [ [ 'handle', key ], ...] ]
//   'attr' => [
//	   'integrity' => []
//   ]
// ];
//----------------------------------------------------------------------

// Register Scripts, Styles & Fonts: Styles, override at lower priority
add_filter( 'ipress_styles', function() use( $ip_suffix ) {

	global $ipress_version;

	// Set up styles
	return [
		'custom' => [
			'ipress' => [ IPRESS_URL . '/style' . $ip_suffix . '.css', [], $ipress_version ]
		]
	];
} );

//----------------------------------------------------------------------
// Theme Scripts, Styles & Fonts
// ================================
//
// Set up custom fonts, via Google Fonts API v2
//
// $ip_fonts = [
//   return [
//   	[
//   		'family' => 'Montserrat',
//   		'weight' => [
//   			'normal' => [ 300, 500, '600:900' ],
//   			'italic' => [ 400, 600 ]
//			],
//			'display' => 'swap',
//			'media' => 'all'
//		],
//		[
//			'family' => 'Roboto',
//			'weight' => [
//				'normal' => [ 300, 500 ]
//			]
//		],
//		[
//			'family' => 'Crimson Pro',
//			'weight' => [
//				'italic' => [ 300, '500:700' ]
//			]
//		],
//		[
//			'family' => 'Poppins',
//			'weight' => [ 300, '500:700' ]
//		],
//		[
//			'family' => 'Open Sans'
//		],
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
// ----------------------------------------------------------

// Register Custom Post Types, override at lower priority
add_filter( 'ipress_post_types', function() {
	return [];
} );

//--------------------------------------------------------------
//	Theme Custom Post Types & Taxonomies
//	====================================
//
// @see https://codex.wordpress.org/Function_Reference/register_taxonomy
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

// Set post-thumbnail support for cpt, override at lower priority
add_filter( 'ipress_post_thumbnails_post_types', function() {
	return [ 'post' ];
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

// Set sidebar defaults, for wrapping widgets, override at lower priority
add_filter( 'ipress_sidebar_defaults', function( $defaults ) {
	return $defaults; // [ 'before_widget', 'after_widget', 'before_title', 'after_title', 'class' ]
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

// Enable or disable front page hero section, use '__return_false'to disable
add_filter( 'ipress_custom_hero', '__return_true' );

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
	require_once IPRESS_INCLUDES_DIR . '/lib/acf-config.php';
}

//----------------------------------------------
//	WooCommerce Configuration
//----------------------------------------------

//add_filter( 'ipress_wc_header_cart_dropdown', '__return_true' );

// Woocommerce functionality, if active
if ( ipress_wc_active() ) {

	// Is the WooCommerce Cart Active, turn on by default
	add_filter( 'ipress_wc_active', '__return_true' );

	// WooCommerce scripts: [ 'label' => [ 'path', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
	add_filter( 'ipress_scripts', function( $scripts ) use( $ip_suffix ) {
		$scripts['store'] = [];
		return $scripts;
	}, 12 );

	// WooCommerce styles: [ 'label' => [ 'path', 'path_url', (array)dependencies, 'version', 'locale' ] ... ];
	add_filter( 'ipress_styles', function( $styles ) use( $ip_suffix ) {
		$styles['store'] = [
			'ipress-woocommerce' => [ 'all', IPRESS_ASSETS_URL . '/css/woocommerce/woocommerce' . $ip_suffix . '.css', [ 'ipress' ], null ],
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

	// Login - redirect login page to my account, for non-admins
	add_filter( 'ipress_login_page', function() {
		return ( current_user_can( 'manage_options' ) ) ? '' : __( 'my-account', 'ipress' );
	} );

	// Logout - redirect logout to my account page, for non-admins
	add_filter( 'ipress_login_logout_page', function() {
		return ( current_user_can( 'manage_options' ) ) ? '' : __( 'my-account', 'ipress' );
	} );
}

//--------------------------------------
// Google
// - Analytics
// - Adwords Tracking
//--------------------------------------

// Post configuration
do_action( 'ipress_after_config' );
