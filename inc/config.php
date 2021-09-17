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

//----------------------------------------------------------------------
//	Theme Scripts, Styles & Fonts
//
// $ip_scripts = [
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
//     'theme' => [ IPRESS_JS_URL . '/theme.js', [ 'jquery' ], NULL ]
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
//
//	// Set up styless - filterable array. See definitions for structure
// $ip_styles = [
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
//     'theme' => [ IPRESS_URL . '/style.css', [], NULL ]
//   ],
//
//   // Inline style: [ 'label' => [ [ 'handle', key ], ...] ]
//   'inline' => []
//
//   // Style attributes ( defer, async, integrity ): [ 'label' => [ [ 'handle', key ], ...] ]
//   'attr' 	=> []
// ];
//
// // Set up custom fonts
// $ip_fonts = [
//
//   // Font families to merge
//   $font_families = [
//     'OpenSans:300,300i,400,400i,600,600i,800,800i',
//     'Roboto:500,700'
//   ];
// ];
//----------------------------------------------------------------------

// Register Scripts, Styles & Fonts: Scripts
add_filter( 'ipress_scripts', function( $scripts ) {

	global $ipress_version;

	// Set up simple debugging via core define
	$ip_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Set up child theme scripts
	$ip_scripts = [

		// Add core scripts, front-end
		'core' => [ 'jquery' ],

		// Theme scripts
		'custom' => [
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

	return ( empty( $scripts ) ) ? $ip_scripts : array_merge( $scripts, $ip_scripts );
} );

// Register Scripts, Styles & Fonts: Styles
add_filter( 'ipress_styles', function( $styles ) {

	global $ipress_version;

	// Set up simple debugging via core define
	$ip_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Set up child theme styles
	$ip_styles = [
		'theme' => [
			'reboot' => [ IPRESS_CSS_URL . '/reboot' . $ip_suffix . '.css', [], '5.0.2' ],
			'theme'  => [ IPRESS_URL . '/style.css', [ 'reboot' ], $ipress_version ]
		]
	];

	return ( empty ( $styles ) ) ? $ip_styles : array_merge( $styles, $ip_styles );
} );

// Register Scripts, Styles & Fonts: Fonts
add_filter( 'ipress_fonts', function( $fonts ) {

	// Font families to merge if more tham one
	$ip_fonts = [];

	return ( empty ( $fonts ) ) ? $ip_fonts : array_merge( $fonts, $ip_fonts );
} );

//--------------------------------------------------------------
//	Theme Custom Post Types & Taxonomies
//
// @see https://codex.wordpress.org/Function_Reference/register_post_type
// @see https://codex.wordpress.org/Function_Reference/register_taxonomy
//
// $post_types = [
//   'cpt' => [
//     'name'        => _x( 'CPT', 'Post Type Singular Name', 'ipress' ),
//     'plural'      => _x( 'CPTs', 'Post Type General Name', 'ipress' ),
//     'public'      => false,
//     'description' => __( 'This is the CPT post type', 'ipress' ),
//     'supports'    => [ 'title', 'editor', 'thumbnail' ],
//     'taxonomies'  => [ 'post_tag', 'category' ],
//     'args'        => [
//       'has_archive'  => true,
//       'show_in_rest' => true
//     ],
//   ]
// ];
//
// $taxonomies = [
//   'cpt_tax' => [
//     'name'        => _x( 'Taxonomy Name', 'Taxonomy Singular Name', 'ipress' ),
//     'plural'      => _x( 'Taxonomies Name', 'Taxonomy General Name', 'ipress' ),
//     'public'      => false,
//     'description' => __( 'This is the Taxonomy name', 'ipress' ),
//     'post_types'  => [ 'cpt' ],
//     'args'        => [],
//     'column'      => true, //optional
//     'sortable'    => true, //optional
//     'filter'      => true  //optional
//    ]
//  ];
// ----------------------------------------------------------

// Register Custom Post Types
add_filter( 'ipress_custom_post_types', function( $post_types ) {

	// Set up custom post types & taxonomies
	$ip_post_types = [];

	return ( empty( $post_types ) ) ? $ip_post_types : array_merge( $post_types, $ip_post_types );
} );

// Register taxonomies
add_filter( 'ipress_taxonomies', function( $taxonomies ) {

	// Set up custom taxonomies
	$ip_taxonomies = [];

	return ( empty( $taxonomies ) ) ? $ip_taxonomies : array_merge( $taxonomies, $ip_taxonomies );
} );

//----------------------------------------------
//	Menus Configuration
//----------------------------------------------

// Add custom menu
add_filter( 'ipress_nav_menus', function( $menus ) {
	return array_merge( $menus, [] );
} );

//----------------------------------------------
//	Images Configuration
//----------------------------------------------

// Add custom image size
add_filter( 'ipress_add_image_size', function( $images ) {
	return array_merge( $images, [] );
} );

//----------------------------------------------
//	Shortcode Configuration
//	- Terms & conditions
//	- Privacy
//	- Cookies
//----------------------------------------------

//----------------------------------------------
//	Sidebars Configuration
//----------------------------------------------

// Update default sidebars list
add_filter( 'ipress_default_sidebars', function( $sidebars ) {
	return $sidebars;
} );

// Add Woocommerce sidebars, if active
if ( ipress_wc_active() ) {

	// Custom Shop Sidebar Areas
	add_filter( 'ipress_custom_sidebars', function() {

		$sidebars = [
			'shop' => [
				'name'        => __( 'Shop Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop page sidebar for all layouts.', 'ipress' )
			],
			'product' => [
				'name'        => __( 'Shop Product Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop product page sidebar for all layouts.', 'ipress' )
			],
			'product-category' => [
				'name'        => __( 'Shop Category Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop category page sidebar for all layouts.', 'ipress' )
			],
			'cart' => [
				'name'        => __( 'Shop Cart & Checkout Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop cart & checkout page sidebar for all layouts.', 'ipress' )
			],
			'account' => [
				'name'        => __( 'Shop Account Page Sidebar', 'ipress' ),
				'description' => __( 'This is the shop account page sidebar for all layouts.', 'ipress' )
			]
		];

		return $sidebars;
	} );
}

//----------------------------------------------
//	Widgets Configuration
//----------------------------------------------

// Add custom widget areas
add_filter ( 'ipress_widgets', function() {
	return [];
} );

//----------------------------------------------
//	Custom Hooks & Filters
//----------------------------------------------

//------------------------------
// Plugins
// - Woocommerce
// - ACF
//------------------------------

// Advanced Custom Fields Admin UI
if ( is_admin() ) {
	require_once IPRESS_LIB_DIR . '/acf-config.php';
}

//--------------------------------------
// Google
// - Analytics
// - Adwords Tracking
//--------------------------------------
