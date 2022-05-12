<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WooCommerce features.
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_WooCommerce' ) ) :

	/**
	 * iPress WooCommerce Support
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
	 */
	final class IPR_WooCommerce {

		/**
		 * Class constructor
		 */
		public function __construct() {

			//----------------------------------------------
			//  Core WooCommerce Support
			//----------------------------------------------

			// Include WooCommerce support
			add_action( 'after_setup_theme', [ $this, 'woocommerce_setup' ] );

			// Disable thumbnail generation if not required
			add_filter( 'woocommerce_background_image_regeneration', [ $this, 'woocommerce_regenerate_thumbnails' ] );

			// WooCommerce body class
			add_filter( 'body_class', [ $this, 'woocommerce_body_class' ], 10, 1 );

			// Turn off products pagination
			add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );

			// Change add to cart text on archives depending on product type, translatable
			add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'add_to_cart_text' ], 10, 2 );

			// WooCommerce breadcrumb default args
			add_filter( 'woocommerce_breadcrumb_defaults', [ $this, 'breadcrumb_default_args' ], 10 );

			// Add product attribute taxonomies to the menus API
			add_action( 'after_setup_theme', [ $this, 'register_taxonomy_menus' ] );

			//----------------------------------------------
			//	Styles & Fonts Support
			//----------------------------------------------

			// Disable default WooCommerce styles @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
			add_filter( 'woocommerce_enqueue_styles', [ $this, 'woocommerce_disable_css' ] );

			// Only display plugin WooCommerce CSS on WC pages
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_plugin_css' ], 99 );

			// Add core fonts. Dependent on WooCommerce css being active
			add_filter( 'wp_enqueue_scripts', [ $this, 'woocommerce_add_core_fonts' ], 130 );

			// Add custom theme WooCommerce styles & scripts
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_scripts' ], 20 );

			//----------------------------------------------
			//	Scripts Support
			//----------------------------------------------

			// Only display core WooCommerce JS on WC pages
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_js' ], 99 );

			// Disable WooCommerce cart fragments JS
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_cart_js' ], 99 );

			// Disable WooCommerce select2
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_select2' ], 100 );

			// Disable WooCommerce head CSS
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_generator' ], 99 );

			//----------------------------------------------
			//  Header Hooks
			//----------------------------------------------

			// Header cart ajax fragments
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_link_fragment' ], 10, 1 );
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_content_fragment' ], 10, 1 );

			// ----------------------------------------------
			//	HomePage Hooks
			// ----------------------------------------------

			//----------------------------------------------
			//	Product Archive / Shop Page Hooks
			//----------------------------------------------

			// Reset WooCommerce wrappers to enable Flex layout
			add_action( 'woocommerce_before_main_content', [ $this, 'woocommerce_output_container' ], 5 );
			add_action( 'woocommerce_sidebar', [ $this, 'woocommerce_output_container_end' ], 25 );

			// Set the thumbnail column count
			add_filter( 'woocommerce_product_thumbnails_columns', [ $this, 'product_thumbnail_columns' ] );

			// Add container for results & ordering, enable Flex layout and formatting
			add_action( 'woocommerce_before_shop_loop', [ $this, 'woocommerce_output_result_container' ], 15 );
			add_action( 'woocommerce_before_shop_loop', [ $this, 'woocommerce_output_result_container_end' ], 35 );
 
			// Add custom random ordering as an option for product archives
			add_filter( 'woocommerce_get_catalog_ordering_args', [ $this, 'woocommerce_catalog_random_ordering' ] );
			add_filter( 'woocommerce_default_catalog_orderby_options', [ $this, 'woocommerce_catalog_random_orderby' ] );
			add_filter( 'woocommerce_catalog_orderby', [ $this, 'woocommerce_catalog_random_orderby' ] );

			// Product loop: Wrap image & style
			add_filter( 'woocommerce_product_get_image', [ $this, 'product_get_image' ], 10, 1 );

			// Product loop: Modify product title class: h2
			add_filter( 'woocommerce_product_loop_title_classes', [ $this, 'loop_title_classes' ], 10, 1 );

			//----------------------------------------------
			//	Single Product Page Hooks
			//----------------------------------------------

			// Add container for images and summary, enable Flex layout and formatting
			add_action( 'woocommerce_before_single_product_summary', [ $this, 'woocommerce_output_product_container' ], 5 );
			add_action( 'woocommerce_after_single_product_summary', [ $this, 'woocommerce_output_product_container_end' ], 5 );

			// Add gallery images class
			add_filter( 'woocommerce_single_product_image_gallery_classes', [ $this, 'image_gallery_classes' ], 10, 1 );

			// Use the 'Woocommerce Thumbnail' (480px x 480px) in the single product image
			add_filter( 'woocommerce_gallery_image_size', [ $this, 'gallery_image_size' ], 10, 1 );

			// Product tabs: Remove unwanted, modify rest & add extra
			add_filter( 'woocommerce_product_tabs', [ $this, 'product_tabs' ],10, 1 );

			// Related product settings
			add_filter( 'woocommerce_output_related_products_args', [ $this, 'related_products_args' ], 10, 1 );

			// Change number of upsells output
			add_filter( 'woocommerce_upsell_display_args', [ $this, 'upsell_products_args' ] , 20, 1 );

			// ----------------------------------------------
			//	Widget Hooks
			// ----------------------------------------------

			//----------------------------------------------
			//	Blocks Hooks
			//----------------------------------------------

			// Disable WooCommerce blocks CSS
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_blocks_css' ], 100 );
			add_action( 'enqueue_block_assets', [ $this, 'woocommerce_disable_block_editor_styles' ], 1, 1 );

			// ----------------------------------------------
			//	Admin & User Page Hooks
			// ----------------------------------------------

			// Set up custom reports
			add_filter( 'woocommerce_admin_reports', [ $this, 'admin_reports' ], 10, 1 );

			// Add user data: Order Count & Total Spent
			add_action( 'admin_init', [ $this, 'add_order_details_to_user_list' ], 10 );
			add_filter( 'manage_users_sortable_columns', [ $this, 'order_details_sortable_columns' ], 10, 1 );
			add_action( 'pre_user_query', [ $this, 'order_details_column_orderby' ], 10 );

			// ----------------------------------------------
			//	Email Hooks
			// ----------------------------------------------

			//----------------------------------------------
			// Plugin Integration Hooks
			//
			// - WC_Brands
			// - WC_Subscriptions
			//----------------------------------------------

			// Additional WooCommerce integrations
			do_action( 'ipress_wc_init' );

			// We only really need to bother with the rest if we're using the cart, so check first, default to on/true
			$ip_wc_active = (bool) apply_filters( 'ipress_wc_active', true );
			if ( false === $ip_wc_active ) { 

				// Add functionality to redirect cart, checkout & account pages	
				add_action( 'woocommerce_before_cart', [ $this, 'woocommerce_active_redirect' ], 1, 1 );
				add_action( 'woocommerce_before_checkout_form', [ $this, 'woocommerce_active_redirect' ], 1, 1 );
				add_action( 'woocommerce_account_navigation', [ $this, 'woocommerce_active_redirect' ], 1, 1 );

				// We're done with the hooks now
				return; 			
			}

			// ----------------------------------------------
			//	Cart Page Hooks
			// ----------------------------------------------
			
			// Add the cart page header
			add_action( 'woocommerce_before_cart', [ $this, 'woocommerce_cart_page_header' ], 20 );	

			// Add the cart page container
			add_action( 'woocommerce_before_cart', [ $this, 'woocommerce_cart_container' ], 30 );	
			add_action( 'woocommerce_after_cart', [ $this, 'woocommerce_cart_container_end' ], 10 );	

			// ----------------------------------------------
			//	Checkout Page Hooks
			// ----------------------------------------------

			// Add the cart page header
			add_action( 'woocommerce_before_checkout_form', [ $this, 'woocommerce_checkout_page_header' ], 8 );

			// Add the checkout page container
			add_action( 'woocommerce_checkout_before_order_review_heading', [ $this, 'woocommerce_checkout_container' ], 45 );	
			add_action( 'woocommerce_checkout_after_order_review', [ $this, 'woocommerce_checkout_container_end' ], 5 );	

			// Sets the default checkout country to 2 letter code
			add_filter( 'default_checkout_billing_country',	[ $this, 'default_checkout_country' ], 10, 1 );
			add_filter( 'default_checkout_shipping_country', [ $this, 'default_checkout_country' ], 10, 1 );

			// Set the default checkout state
			add_filter( 'default_checkout_billing_state', [ $this, 'default_checkout_state' ], 10, 1 );
			add_filter( 'default_checkout_shipping_state', [ $this, 'default_checkout_state' ], 10, 1 );

			// ----------------------------------------------
			//	Account Page Hooks
			// ----------------------------------------------
			
			// Add the account page header
			add_action( 'ipress_before_account_content', [ $this, 'woocommerce_account_page_header' ], 8 );

			// Add customer profile to navigation header
			add_action( 'woocommerce_before_account_navigation', [ $this, 'woocommerce_account_navigation_profile' ], 20 );

			// Add the account navigation container
			add_action( 'woocommerce_before_account_navigation', [ $this, 'woocommerce_account_navigation_container' ], 10 );	
			add_action( 'woocommerce_after_account_navigation', [ $this, 'woocommerce_account_navigation_container_end' ], 10 );

			// Add the login form container
//			add_action( 'woocommerce_before_customer_login_form', [ $this, 'woocommerce_account_container' ], 10 );	
//			add_action( 'woocommerce_after_customer_login_form', [ $this, 'woocommerce_account_container_end' ], 10 );

			// ----------------------------------------------
			//	Order Page Hooks
			// ----------------------------------------------

			// ----------------------------------------------
			//	Form Markup Hooks
			// ----------------------------------------------
		}

		//----------------------------------------------
		//	Core support
		//----------------------------------------------

		/**
		 * WooCommerce theme support
		 */
		public function woocommerce_setup() {

			// Construct WooCommerce defaults
			$ip_wc_args = (array) apply_filters(
				'ipress_wc_args',
				[
					'single_image_width'    => 480,
					'thumbnail_image_width' => 320,
					'gallery_thumbnail_image_width' => 125,
					'product_grid'          => [
						'default_rows'    => 4,
						'min_rows'        => 2,
						'max_rows'		  => 6,
						'default_columns' => 3,
						'min_columns'     => 2,
						'max_columns'     => 5,
					],
				]
			);

			// Add WooCommerce support, inc 3.x features, with default args if available
			if ( empty( $ip_wc_args ) ) {
				add_theme_support( 'woocommerce' );
			} else {
				add_theme_support( 'woocommerce', $ip_wc_args );
			}

			// Add WooCommerce gallery support: zoom, lightbox, slider
			$ip_wc_product_gallery = (bool) apply_filters( 'ipress_wc_product_gallery', true );
			if ( true === $ip_wc_product_gallery ) {
				add_theme_support( 'wc-product-gallery-zoom' );
				add_theme_support( 'wc-product-gallery-lightbox' );
				add_theme_support( 'wc-product-gallery-slider' );
			}

			// Additional WooCommerce setup features
			do_action( 'ipress_wc_setup' );
		}

		/**
		 * Disable automatic background thumbnail regeneration if not needed
		 *
		 * @return boolean default true, false to disable
		 */
		public function woocommerce_regenerate_thumbnails() {
			return (bool) apply_filters( 'ipress_wc_background_image_regeneration', true );
		}

		/**
		 * Add 'woocommerce-active' class to the body tag
		 *
		 * @param array $classes
		 * @return array $classes
		 */
		public function woocommerce_body_class( $classes ) {

			// Load additional body classes when WooCommerce is active
			$ip_wc_body_classes = (array) apply_filters( 'ipress_wc_body_classes', [ 'woocommerce-active' ] );
			foreach ( $ip_wc_body_classes as $class ) {
				$classes[] = sanitize_html_class( $class );
			}

			return $classes;
		}

		/**
		 * Display all products on archive page, disables pagination
		 *
		 * @param object $query WP_Query instance
		 * @return object $query WP_Query instance
		 */
		public function pre_get_posts( $query ) {

			// Turn on, off by default
			$ip_product_loop = (bool) apply_filters( 'ipress_wc_product_loop', false );
			if ( true === $ip_product_loop ) {

				// De-restrict posts, show all in loop if we're a WooCommerce product
				if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'product' ) ) {
					$query->set( 'posts_per_page', -1 );
				}
			}

			return $query;
		}

		/**
		 * Update add to cart text based on context and location
		 * - load locale textdomain & translations
		 *
		 * @param string $text
		 * @param object $product
		 * @return string $text
		 */
		public function add_to_cart_text( $text, $product ) {

			// Load the WooCommerce translation
			$locale = get_locale() . '.mo';
			load_textdomain( 'ipress', get_stylesheet_directory() . '/languages/' . $locale );

			// Get the product type
			$product_type = $product->get_type();

			// Set translations by product type
			switch ( $product_type ) {
				case 'simple':
				case 'bundle':
				case 'subscription':
					$text = ( $product->is_purchasable() && $product->is_in_stock() ) ? __( 'Add to basket', 'ipress' ) : __( 'Read more', 'ipress' );
					break;
				case 'variable':
				case 'variable-subscription':
					$text = ( $product->is_purchasable() ) ? __( 'Select options', 'ipress' ) : __( 'Read more', 'ipress' );
					break;
				case 'grouped':
					$text = __( 'View products', 'ipress' );
					break;
				case 'external':
					$text = ( $product->get_button_text() ) ? $product->get_button_text() : _x( 'Buy product', 'placeholder', 'ipress' );
					break;
				default:
					$text = __( 'Read more', 'ipress' );
					break;
			}

			// Filterable output
			return apply_filters( 'ipress_wc_add_to_cart_text', $text );
		}

		/**
		 * Modify WooCommerce breadcrumb args
		 * - [delimiter]
		 * - [wrap_before]
		 * - [wrap_after]
		 * - [before]
		 * - [after]
		 * - [home]
		 * 
		 * @param array $args default breadcrumb structure
		 * @return array $args default breadcrumb structure
		 */
		public function breadcrumb_default_args( $args ) {
			return (array) apply_filters( 'ipress_wc_breadcrumb_default_args', $args );
		}

		/**
		 * Register product attribute taxonomies in the menu API
		 */
		public function register_taxonomy_menus() {

			// Register product pa_* taxonomies, don't attach pa_ frefix
			$ip_wp_register_taxonomy_menus = (array) apply_filters( 'ipress_wp_register_taxonomy_menus', [] );
			if ( empty( $ip_wp_register_taxonomy_menus ) ) { return; }

			// Iterate attributes and set menus
			foreach ( $ip_wp_register_taxonomy_menus as $taxonomy ) {

				// Set taxonomy name
				$tax_name = 'pa_' . $taxonomy;

				// Add filter for taxonomy
				add_filter( 'woocommerce_attribute_show_in_nav_menus', function( $register, $name = '' ) use ( $tax_name ) {
					return ( $name === $tax_name ) ? true : $register;
				}, 1, 2 );
			}
		}

		//----------------------------------------------
		//	Styles & Font support
		//----------------------------------------------

		/**
		 * Dequeue all WooCommerce styles, if not required, to lighten the load
		 *
		 * @param array $enqueue_styles Enqueued WooCommerce styles
		 * @return array $enqueue_styles Enqueued WooCommerce styles
		 */
		public function woocommerce_disable_css( $enqueue_styles ) {

			// Disable all WooCommerce styles?
			$ip_wc_disable_css = (bool) apply_filters( 'ipress_wc_disable_css', false );
			if ( true === $ip_wc_disable_css ) {
				return [];
			}
			
			// Check if it's any of WooCommerce pages, ignore if it is...
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

				// Remove core WooCommerce styles, unless required as above
				// [ 
				// 	 'woocommerce-general',
				// 	 'woocommerce-layout',
				// 	 'woocommerce-smallscreen',
				// 	 'woocommerce_frontend_styles',
				// 	 'woocommerce_fancybox_styles',
				// 	 'woocommerce_chosen_styles',
				// 	 'woocommerce_prettyPhoto_css',
				// ]
				$ip_wc_disable_core_css = (array) apply_filters( 'ipress_wc_disable_core_css', [] );

				// Unqueue WooCommerce styles
				foreach ( $ip_wc_disable_core_css as $style ) {
					unset( $enqueue_styles[$style] );
				}
			}

			// Return what's left
			return $enqueue_styles;
		}

		/**
		 * Disable WooCommerce plugin styles on non-WC pages
		 * - plugins, [ 'wc-bundle-style', 'wc-composite-css', ... ] 
		 * - custom options
		 */
		public function woocommerce_disable_plugin_css() {

			// Check if it's any of WooCommerce pages, ignore if it is
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

				// Dequeue WooCommerce plugin styles: [ name, [...] ]
				$ip_wc_plugin_styles = (array) apply_filters(
					'ipress_wc_plugin_styles', 
					[
						'wc-block-vendors-style',
					   	'wc-block-style',
						'wp-block-library',
						'wc-bundle-style',
						'wc-composite-css',
					]
				);

				foreach ( $ip_wc_plugin_styles as $style ) {
					wp_dequeue_style( $style );
				}
			}
		}

		/**
		 * Add CSS in <head> to register WooCommerce Core fonts.
		 */
		public function woocommerce_add_core_fonts() {

			// Include core WooCommerce fonts, default false
			$ip_wc_core_fonts = (bool) apply_filters( 'ipress_wc_core_fonts', false );
			if ( true === $ip_wc_core_fonts ) {

				// Set up core WooCommerce fonts
				$fonts_url = plugins_url( '/woocommerce/assets/fonts/' );
				wp_add_inline_style(
					'ipress-woocommerce-style',
					'@font-face {
					font-family: star;
					src: url(' . $fonts_url . '/star.eot);
					src:
						url(' . $fonts_url . '/star.eot?#iefix) format("embedded-opentype"),
						url(' . $fonts_url . '/star.woff) format("woff"),
						url(' . $fonts_url . '/star.ttf) format("truetype"),
						url(' . $fonts_url . '/star.svg#star) format("svg");
					font-weight: 400;
					font-style: normal;
				}
				@font-face {
					font-family: WooCommerce;
					src: url(' . $fonts_url . '/WooCommerce.eot);
					src:
						url(' . $fonts_url . '/WooCommerce.eot?#iefix) format("embedded-opentype"),
						url(' . $fonts_url . '/WooCommerce.woff) format("woff"),
						url(' . $fonts_url . '/WooCommerce.ttf) format("truetype"),
						url(' . $fonts_url . '/WooCommerce.svg#WooCommerce) format("svg");
					font-weight: 400;
					font-style: normal;
				}'
				);
			}
		}

		/**
		 * WooCommerce specific scripts & stylesheets
		 */
		public function woocommerce_scripts() {

			global $ipress_version;

			// Debugging support
			$ip_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// Check we've defined where custom styles to be loaded, default WooCommerce pages 
			$ip_wc_custom_styles = (bool) apply_filters( 'ipress_wc_custom_styles', true );

			// Load in WooCommerce pages only, or globally
			if ( true === $ip_wc_custom_styles ) {
				
				// Add custom WooCommerce style: load after general WooCommerce style if there
				wp_register_style( 'ipress-woocommerce', IPRESS_CSS_URL . '/woocommerce/woocommerce' . $ip_suffix . '.css', [ 'woocommerce-general' ], $ipress_version );
				wp_enqueue_style( 'ipress-woocommerce' );
				wp_style_add_data( 'ipress-woocommerce', 'rtl', 'replace' );

			} else {

				// Check if it's any of WooCommerce pages, load if it is
				if ( is_woocommerce() || is_cart() || is_checkout() ) {
					
					// Add custom WooCommerce style: load after general WooCommerce style if there
					wp_register_style( 'ipress-woocommerce', IPRESS_CSS_URL . '/woocommerce/woocommerce' . $suffix . '.css', [ 'woocommerce-general' ], $ipress_version );
					wp_enqueue_style( 'ipress-woocommerce' );
					wp_style_add_data( 'ipress-woocommerce', 'rtl', 'replace' );

				}
			}

			// Additional WooCommerce scripts & styles
			do_action( 'ipress_wc_scripts' );
		}

		//----------------------------------------------
		//	Scripts Support
		//----------------------------------------------

		/**
		 * Disable core WooCommerce JS in non-WooCommerce pages
		 * 
		 * @todo Look at dependencies for better granular removal
		 */
		public function woocommerce_disable_js() {

			// Disable WooCommerce loading js & css if woocommerce enabled
			$ip_wc_disable_js = (bool) apply_filters( 'ipress_wc_disable_js', false );
			if ( true === $ip_wc_disable_js ) {

				// Check if it's any of WooCommerce page, ignore if it is
				if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

					// Dequeue main WooCommerce scripts
					wp_dequeue_script( 'woocommerce' );

					// Dequeue product pages scripts
					wp_dequeue_script( 'wc_price_slider' );
					wp_dequeue_script( 'wc-single-product' );
					wp_dequeue_script( 'prettyPhoto' );
					wp_dequeue_script( 'prettyPhoto-init' );
					wp_dequeue_script( 'jquery-placeholder' );
					wp_dequeue_script( 'fancybox' );

					// Dequeue WooCommerce cart scripts
					wp_dequeue_script( 'wc-cart' );

					// Dequeue WooCommerce checkout scripts
					wp_dequeue_script( 'wc-checkout' );
					wp_dequeue_script( 'wc-credit-card-form' );
					wp_dequeue_script( 'wc-add-payment-method' );

					// Dequeue WooCommerce process scripts
					wp_dequeue_script( 'wc-chosen' );
					wp_dequeue_script( 'wc-lost-password' );

					// Dequeue jQuery scripts
					wp_dequeue_script( 'jquery-blockui' );
					wp_dequeue_script( 'jquery-placeholder' );
					wp_dequeue_script( 'jquery-payment' );
					wp_dequeue_script( 'jqueryui' );

					// Dequeue cookie scripts - required or dependencies?
					wp_deregister_script( 'js-cookie' );
					wp_dequeue_script( 'js-cookie' );

					// Dequeue Woocommerce blocks scripts
					wp_dequeue_script( 'jquery-blockui' );
				}

				// Dequeue WooCommerce plugin scripts: [ 'name', [...] ]
				$ip_wc_disable_plugin_js = (array) apply_filters( 'ipress_wc_plugin_scripts', [] );
				foreach ( $ip_wc_disable_plugin_js as $script ) {
					wp_dequeue_script( $script );
				}
			}
		}
		
		/**
		 * Disable WooCommerce cart fragmentation & dynamic add-to-cart JS on non-WooCommerce pages
		 */
		public function woocommerce_disable_cart_js() {
			
			// Disable the cart fragments and dynamic add-to-cart functionality, default false 
			$ip_wc_disable_cart_js = (bool) apply_filters( 'ipress_wc_disable_cart_js', false );
			if ( true === $ip_wc_disable_cart_js ) {

				// Check if it's any of WooCommerce page, ignore if it is
				if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
					wp_dequeue_script( 'wc-cart-fragments' );
					wp_dequeue_script( 'wc-add-to-cart' );
					wp_dequeue_script( 'wc-add-to-cart-variation' );			
				}
			}
		}
		
		/**
		 * Remove WooCommerce Select2 from front-end WooCommerce pages
		 */
		public function woocommerce_disable_select2() {

			// Disable WooCommerce loading js & css if WooCommerce enabled
			$ip_wc_disable_select2 = (bool) apply_filters( 'ipress_wc_disable_select2', false );
			if ( true === $ip_wc_disable_select2 ) {

				// Disable & dequeue
				wp_dequeue_style( 'select2' );
				wp_deregister_script( 'select2' );

				wp_dequeue_script( 'selectWoo' );
				wp_deregister_script( 'selectWoo' );
			}
		}

		/**
		 * Disable WooCommerce head tags & styles 
		 */
		public function woocommerce_disable_generator() {

			// Dequeue WooCommerce head styles, default false
			$ip_wc_generator = (bool) apply_filters( 'ipress_wc_generator', false );
			if ( true === $ip_wc_generator ) {

				// Remove the generated by WooCommerce tag
				remove_action( 'wp_head', [ $GLOBALS['woocommerce'], 'generator' ] );
			}
		}

		//----------------------------------------------
		//	Header Markup Functions
		//----------------------------------------------

		/**
		 * Keep cart contents update when products are added to the cart via AJAX
		 *
		 * @param array $fragments Fragments to refresh via AJAX
		 * @return array $fragments Fragments to refresh via AJAX
		 * @uses /woocommerce theme overwrite directory header_cart_link template
		 */
		public function header_cart_link_fragment( $fragments ) {

			// Filterable header cart, default on
			$ip_wc_header_cart = (bool) apply_filters( 'ipress_wc_header_cart', true );

			// Set fragment?
			if ( true === $ip_wc_header_cart ) {
				ob_start();
				wc_get_template_part( 'header-cart-link' );
				$fragments['a.header-cart-link'] = ob_get_clean();
			}

			return $fragments;
		}

		/**
		 * Keep cart contents update when products are added to the cart via AJAX
		 *
		 * @param array $fragments Fragments to refresh via AJAX
		 * @return array $fragments Fragments to refresh via AJAX
		 * @uses /woocommerce theme overwrite directory header_cart_content template
		 */
		public function header_cart_content_fragment( $fragments ) {

			// Filterable header cart, default on
			$ip_wc_header_cart = (bool) apply_filters( 'ipress_wc_header_cart', true );

			// Set fragment?
			if ( true === $ip_wc_header_cart ) {
				ob_start();
				wc_get_template_part( 'header-cart-content' );
				$fragments['div.header-cart-content'] = ob_get_clean();
			}

			return $fragments;
		}

		// ------------------------------------------------
		//	HomePage Markup Functions
		// ------------------------------------------------

		//----------------------------------------------
		//	Product Archive Markup Functions
		//----------------------------------------------

		/** 
		 * Before main content WooCommerce container
		 */ 
		public function woocommerce_output_container() {
			if ( is_shop() ) {
				wc_get_template_part( 'global/container-start');
			} 
		}
		
		/** 
		 * After main content WooCommerce wrapper
		 */ 
		public function woocommerce_output_container_end() {
			if ( is_shop() ) {
				wc_get_template_part( 'global/container-end');
			}
		}
		
		/** 
		 * Before product content WooCommerce container
		 */ 
		public function woocommerce_output_product_container() {
			if ( is_product() ) {
				wc_get_template_part( 'global/product-container-start');
			}
		}	
		
		/** 
		 * After product content WooCommerce wrapper
		 */ 
		public function woocommerce_output_product_container_end() { 
			if ( is_product() ) {
				wc_get_template_part( 'global/product-container-end');
			}
		}
		
		/** 
		 * Before Results & Ordering Content
		 */ 
		public function woocommerce_output_result_container() {
			wc_get_template_part( 'global/result-container-start');
		}

		/** 
		 * After Results & Ordering Content
		 */ 
		public function woocommerce_output_result_container_end() { 
			wc_get_template_part( 'global/result-container-end');
		} 


		/**
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns, default 4
		 */
		public function product_thumbnail_columns() {
			return (int) apply_filters( 'ipress_product_thumbnail_columns', 4 );
		}

		/**
		 * Add custom random ordering for product archives
		 *
		 * @param array $args current sorting settings
		 * @return array $args
		 */
		public function woocommerce_catalog_random_ordering( $args ) {

			// Filterable setting, default false
			$ip_wc_catalog_random_ordering = apply_filters( 'ipress_wc_catalog_random_ordering', false );
			if ( true !== $ip_wc_catalog_random_ordering ) { return $args; }

			// Set ordering, random if there
			$orderby_value = ( isset( $_GET['orderby'] ) ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			if ( 'random' === $orderby_value ) {
				$args['orderby'] = 'rand';
				$args['order'] = '';
				$args['meta_key'] = '';
			}
			return $args;
		}

		/**
		 * Add custom random ordering for product archives
		 *
		 * @param array $sortby current sorting settings
		 * @param array $sortby
		 */
		public function woocommerce_catalog_random_orderby( $sortby ) {
			
			// Filterable setting, default false
			$ip_wc_catalog_random_ordering = apply_filters( 'ipress_wc_catalog_random_ordering', false );
			if ( true !== $ip_wc_catalog_random_ordering ) { return $sortby; }

			// Add random ordering option
			$sortby['random'] = __( 'Random', 'ipress' );
			return $sortby;
		}

		/**
		 * Product image style
		 *
		 * @param string $image
		 * @return string
		 */
		public function product_get_image( $image ) {		
			return sprintf( '<span class="product-img">%s</span>', $image );
		}

		/**
		 * Loop title classes
		 *
		 * @param array $classes
		 * @return string
		 */
		public function loop_title_classes( $classes ) {
			return $classes . ' product-title'; 
		}

		//----------------------------------------------
		//	Single Product Markup Functions
		//----------------------------------------------

		/**
		 * Add gallery classes to aid in styling gallery thumbnail containers
		 *
		 * @param array $classes
		 * @return array $classes
		 */
		public function image_gallery_classes( $classes ) {

			global $product;

			// Adds a -with-gallery or -without-gallery class to enable styling of gallery wrapper
			$classes[] = 'woocommerce-product-gallery--' . ( $product->get_gallery_image_ids() ? 'with-gallery' : 'without-gallery' );
			return $classes;
		}

		/**
		 * Set the gallery image to use the woocommerce_thumbnail (480px x 480px) image
		 *
		 * @param string $size
		 * @return string
		 */
		public function gallery_image_size( $size ) {
			return 'woocommerce_thumbnail';
		}		

		/**
		 * Product tabs: Remove, modify & add tabs & content
		 *
		 * @param array $tabs
		 * @return array $tabs
		 */
		public function product_tabs( $tabs ) {
			return $tabs;
		}

		/**
		 * Related Products Args
		 *
		 * @param array $args related product args
		 * @return array $args related product args
		 */
		public function related_products_args( $args ) {

			// Filterable related products, default to 3 products & columns
			$ip_related_products_args = (array) apply_filters(
				'ipress_related_products_args',
				[
					'posts_per_page' => 3,
					'columns'        => 3,
				]
			);

			return wp_parse_args( $ip_related_products_args, $args );
		}

		/**
		 * Upsell Products Args
		 *
		 * @param array $args related product args
		 * @return array $args related product args
		 */
		public function upsell_products_args( $args ) {

			// Filterable upsell products, default to 2 products & columns
			$ip_upsell_products_args = (array) apply_filters(
				'ipress_upsell_products_args',
				[
					'posts_per_page' => 2,
					'columns'        => 2,
				]
			);

			return wp_parse_args( $ip_upsell_products_args, $args );
		}
		
		//----------------------------------------------
		//	Widget Hook Functions
		//----------------------------------------------

		//----------------------------------------------
		//	Blocks Hook Functions
		//----------------------------------------------

		/**
		 * Disable WooCommerce block styles
		 *
		 * @todo Look at dependencies for better granular removal
		 */
		public function woocommerce_disable_blocks_css() {

			// Dequeue WooCommerce blocks styles, default false
			$ip_wc_disable_blocks_css = (bool) apply_filters( 'ipress_wc_disable_blocks_css', false );
			if ( true === $ip_wc_disable_blocks_css ) {

				// Set up block styles
				$ip_wc_block_styles = apply_filters(
					'ipress_wc_block_styles',
					[
						'wc-blocks-vendors-style',
						'wc-blocks-style',
						'wp-block-library',
						'wp-block-library-theme',						
					]
				);

				// Iterate and dequeue styles
				foreach ( $ip_wc_block_styles as $style ) {
					wp_dequeue_style( $style );
				}
			}
		}

		/**
		 * Disable WooCommerce block editor styles
		 *
		 * @todo Look at dependencies for better granular removal
		 */
		public function woocommerce_disable_block_editor_styles() {

			// Dequeue WooCommerce blocks styles, default false
			$ip_wc_disable_block_editor_css = (bool) apply_filters( 'ipress_wc_disable_block_editor_css', false );
			if ( true === $ip_wc_disable_block_editor_css ) {

				// Set up block editor styles
				$ip_wc_block_editor_styles = apply_filters(
					'ipress_wc_block_editor_styles',
					[
						'wc-block-editor',
						'wc-blocks-style',
					]
				);

				// Iterate and dequeue styles
				foreach ( $ip_wc_block_editor_styles as $style ) {
					wp_deregister_style( $style );
				}
			}
		}

		//----------------------------------------------
		//	Admin & User Hook Functions
		//----------------------------------------------

		/**
		 * Add custom reports
		 *
		 * @param array $reports
		 * @return array $reports
		 */
		public function admin_reports( $reports ) {
			return $reports;
		}

		/**
		 * Add Order Count and Total Spent columns to customer list
		 */
		public function add_order_details_to_user_list() {
			add_filter( 'manage_users_columns', [ $this, 'add_user_details_columns' ], 10, 1 );
			add_action( 'manage_users_custom_column', [ $this, 'show_user_details_column_content' ], 10, 3 );
		}

		/**
		 * Add Total Spent & Order Count to the users column
		 *
		 * @param array $columns
		 * @return array $columns
		 */
		public function add_user_details_columns( $columns ) {
			$columns['user_orders'] = __( 'Orders', 'ipress' );
	    	$columns['user_total_spent'] = __( 'Total Spent', 'ipress' );
	    	return $columns;
		}

		/**
		 * Set the data value for custom columns
		 *
		 * @param mixed $value
		 * @param string $column_name
		 * @param integer $user_id
		 * @return string $value
		 */
		public function show_user_details_column_content( $value, $column_name, $user_id ) {

			// Set value by type
			switch ( $column_name ) {
				case 'user_orders':
					return wc_get_customer_order_count( $user_id );
				case 'user_total_spent':
					return wc_price( wc_get_customer_total_spent( $user_id ) );
				default: // No column found
					return $value;
			}
		}

		/**
		 * Set sortable columns for custom user data
		 *
		 * @param array $columns
		 * @return array $columns
		 */
		public function order_details_sortable_columns( $columns ) {
			$columns['user_orders'] 		= '_order_count';
	    	$columns['user_total_spent'] 	= '_total_spent';
	    	return $columns;
		}

		/**
		 * Modify query for user data
		 *
		 * @param object $query User Query
		 */
		public function order_details_column_orderby( $query ) {

			global $wpdb;

			// Set orderby status, if there
			$order_by = $query->query_vars['orderby'];
			if ( ! $order_by ) { return; }

			// Modify query by type
			switch ( $order_by ) {
				case '_order_count':
					$query->query_from 		.= " LEFT OUTER JOIN $wpdb->usermeta AS alias ON ($wpdb->users.ID = alias.user_id) ";
					$query->query_where 	.= " AND alias.meta_key = '_order_count' "; 
					$query->query_orderby 	 = " ORDER BY alias.meta_value + 0 " . ( $query->query_vars['order'] == "ASC" ? "asc " : "desc " );
					break;
				case '_total_spent':
					$query->query_from 		.= " LEFT OUTER JOIN $wpdb->usermeta AS alias ON ($wpdb->users.ID = alias.user_id) ";
					$query->query_where 	.= " AND alias.meta_key = '_total_spent' ";
					$query->query_orderby 	 = " ORDER BY alias.meta_value + 0 " . ( $query->query_vars['order'] == "ASC" ? "asc " : "desc " );
			}
		}

		//-------------------------------------------------
		//	Plugin Hook Functions
		//-------------------------------------------------

		// ------------------------------------------------
		//	Email Hooks Functions
		// ------------------------------------------------

		//-------------------------------------------------
		//	Cart, Checkout, Account Support
		//-------------------------------------------------

		/**
		 * Redirect for Cart, Checkout & Account pages when cart functionality inactivated
		 *
		 * @param object $data cart or checkout data, default null
		 */
		public function woocommerce_active_redirect( $data = null ) {

			// Set redirect for inactive cart
			$ip_wc_active_redirect = apply_filters( 'ipress_wc_active_redirect', home_url( '/' ) );
			if ( empty( $ip_wc_active_redirect ) ) { return; }

			// Process redirect with validation
			wp_safe_redirect( $ip_wc_active_redirect );
			exit;
		}

		//----------------------------------------------
		//	Cart Page Functions
		//----------------------------------------------

		/**
		 * Display Cart Page Header
		 */
		public function woocommerce_cart_page_header() {
			wc_get_template_part( 'cart/header' );
		}

		/**
		 * Display Cart Page Container, enable Flex container
		 */
		public function woocommerce_cart_container() {
			wc_get_template_part( 'cart/container-start' );
		}

		/**
		 * Display Cart Page Container, close Flex container
		 */
		public function woocommerce_cart_container_end() {
			wc_get_template_part( 'cart/container-end' );
		}

		//----------------------------------------------
		//	Checkout Page Functions
		//----------------------------------------------

		/**
		 * Display Checkout Page Header
		 */
		public function woocommerce_checkout_page_header() {
			wc_get_template_part( 'checkout/header' );
		}

		/**
		 * Display Checkout Page Container, enable Flex container
		 */
		public function woocommerce_checkout_container() {
			wc_get_template_part( 'checkout/container-start' );
		}

		/**
		 * Display Checkout Page Container, close Flex container
		 */
		public function woocommerce_checkout_container_end() {
			wc_get_template_part( 'checkout/container-end' );
		}

		/**
		 * Fix the checkout country to GB, filterable
		 * - If the user already exists, don't override country
		 *
		 * @param string $country default country
		 * @return string
		 */
		public function default_checkout_country( $country ) {
			return ( WC()->customer->get_is_paying_customer() ) ? $country : apply_filters( 'ipress_default_checkout_country', 'GB' );
		}

		/**
		 * Fix the checkout state, filterable
		 * - If the user already exists, don't override state
		 *
		 * @param string $state default state
		 * @return string
		 */
		public function default_checkout_state( $state ) {
			return ( WC()->customer->get_is_paying_customer() ) ? $state : apply_filters( 'ipress_default_checkout_state', '' );
		}

		//----------------------------------------------
		//	Account Page Functions
		//----------------------------------------------

		/**
		 * Display Account Page Header
		 */
		public function woocommerce_account_page_header() {
			wc_get_template_part( 'myaccount/header' );
		}

		/**
		 * Display Account profile details in navigation
		 */
		public function woocommerce_account_navigation_profile() {
			wc_get_template_part( 'myaccount/profile' );
		}

		/**
		 * Display Account Navigation Container, enable Flex container
		 */
		public function woocommerce_account_navigation_container() {
			wc_get_template_part( 'myaccount/navigation-container-start' );
		}

		/**
		 * Display Account Navigation Container, close Flex container
		 */
		public function woocommerce_account_navigation_container_end() {
			wc_get_template_part( 'myaccount/navigation-container-end' );
		}

		/**
		 * Display Account Login Container, enable Flex container
		 */
		public function woocommerce_account_container() {
			wc_get_template_part( 'myaccount/container-start' );
		}

		/**
		 * Display Account Login Container, close Flex container
		 */
		public function woocommerce_account_container_end() {
			wc_get_template_part( 'myaccount/container-end' );
		}
	}
endif;

// Initialize WC class
return new IPR_WooCommerce();
