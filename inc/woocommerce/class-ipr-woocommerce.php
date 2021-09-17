<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core Woocommerce features.
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Woocommerce' ) ) :

	/**
	 * iPress Woocommerce Support
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
	 */
	final class IPR_Woocommerce {

		/**
		 * Class constructor
		 */
		public function __construct() {

			//----------------------------------------------
			//  Core Woocommerce Settings
			//----------------------------------------------

			// Include Woocommerce support
			add_action( 'after_setup_theme', [ $this, 'woocommerce_setup' ] );

			// Disable default Woocommerce styles @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'wp_enqueue_scripts', [ $this, 'add_core_fonts' ], 130 );

			// Woocommerce body class
			add_filter( 'body_class', [ $this, 'woocommerce_body_class' ] );

			// Turn off products pagination
			add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );

			// Add custom theme Woocommerce styles & scripts
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_scripts' ], 20 );

			// Only display core Woocommerce CSS on WC pages?
			add_filter( 'woocommerce_enqueue_styles', [ $this, 'woocommerce_disable_core_css' ] );

			// Only display plugin Woocommerce CSS on WC pages?
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_css' ], 999 );

			// Only display core & plugin Woocommerce JS on WC pages?
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_js' ], 999 );

			// Disable Woocommerce select2?
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_disable_select2' ], 100 );

			// Change add to cart text on archives depending on product type, translatable
			add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'add_to_cart_text' ], 10, 2 );

			// Woocommeerce breadcrumb default args
			add_filter( 'woocommerce_breadcrumb_defaults', [ $this, 'breadcrumb_default_args' ], 10 );

			//----------------------------------------------
			//  Header Hooks
			//----------------------------------------------

			// Header cart ajax fragments
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_link_fragment' ], 10, 1 );
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_content_fragment' ], 10, 1 );

			//----------------------------------------------
			//	Product Archive Page Hooks
			//----------------------------------------------

			add_filter( 'woocommerce_product_thumbnails_columns', [ $this, 'product_thumbnail_columns' ] );

			//----------------------------------------------
			//	Single Product Page Hooks
			//----------------------------------------------

			// Add gallery images class
			add_filter( 'woocommerce_single_product_image_gallery_classes', [ $this, 'image_gallery_classes' ], 10, 1 );

			// Related product settings
			add_filter( 'woocommerce_output_related_products_args', [ $this, 'related_products_args' ], 10, 1 );

			//----------------------------------------------
			//	Admin Page Hooks
			//----------------------------------------------

			// Set up custom reports
			add_filter( 'woocommerce_admin_reports', [ $this, 'admin_reports' ], 10, 1 );

			//----------------------------------------------
			// Plugin Integration Hooks
			//
			// - WC_Brands
			// - WC_Subscriptions
			//----------------------------------------------
		}

		//----------------------------------------------
		//	Core support
		//----------------------------------------------

		/**
		 * Woocommerce theme support
		 */
		public function woocommerce_setup() {

			// Construct Woocommerce defaults
			$ip_wc_args = (array) apply_filters(
				'ipress_wc_args',
				[
					'single_image_width'    => 480,
					'thumbnail_image_width' => 320,
					'product_grid'          => [
						'default_columns' => 3,
						'default_rows'    => 4,
						'min_columns'     => 1,
						'max_columns'     => 6,
						'min_rows'        => 1,
					],
				]
			);

			// Add Woocommerce support, inc 3.x features, with default args if available
			if ( empty( $ip_wc_args ) ) {
				add_theme_support( 'woocommerce' );
			} else {
				add_theme_support( 'woocommerce', $ip_wc_args );
			}

			// Add Woocommerce gallery support: zoom, lightbox, slider
			$ip_wc_product_gallery = (bool) apply_filters( 'ipress_wc_product_gallery', true );
			if ( true === $ip_wc_product_gallery ) {
				add_theme_support( 'wc-product-gallery-zoom' );
				add_theme_support( 'wc-product-gallery-lightbox' );
				add_theme_support( 'wc-product-gallery-slider' );
			}

			// Additional Woocommerce setup features
			do_action( 'ipress_wc_setup' );
		}

		/**
		 * Add CSS in <head> to register WooCommerce Core fonts.
		 */
		public function add_core_fonts() {

			// Include core Woocommerce fonts, default false
			$ip_wc_core_fonts = (bool) apply_filters( 'ipress_wc_core_fonts', false );
			if ( true !== $ip_wc_core_fonts ) {
				return;
			}

			// Set up core Woocommerce fonts
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

		/**
		 * Add 'woocommerce-active' class to the body tag
		 *
		 * @param array $classes
		 * @return array $classes
		 */
		public function woocommerce_body_class( $classes ) {

			// Load additional body classes when WooCommerce is active
			$ip_wc_body_classes = (array) apply_filters( 'ipress_wc_body_classes', [ 'woocommerce-active' ] );
			if ( empty( $ip_wc_body_classes ) ) {
				return $classes;
			}

			// Include custom class list
			$classes[] = join( ' ', $ip_wc_body_classes );
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
			if ( true !== $ip_product_loop ) {
				return $query;
			}

			// De-restrict posts, show all in loop if we're a WooCommerce prodict
			if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'product' ) ) {
				$query->set( 'posts_per_page', -1 );
			}

			return $query;
		}

		/**
		 * WooCommerce specific scripts & stylesheets
		 */
		public function woocommerce_scripts() {

			global $ipress_version;

			// Debugging support
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// Add Wcoocommerce style
			wp_enqueue_style( 'ipress-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce/woocommerce' . $suffix . '.css', [ 'ipress-style' ], $ipress_version );
			wp_style_add_data( 'ipress-woocommerce-style', 'rtl', 'replace' );

			// Additional Woocommerce scripts
			do_action( 'ipress_wc_scripts' );
		}

		/**
		 * Disable core woocommerce css in non-woocommerce front-end pages
		 *
		 * @param array $enqueue_styles Enqueued Woocommerce styles
		 * @return array $enqueue_styles Enqueued Woocommerce styles
		 */
		public function woocommerce_disable_core_css( $enqueue_styles ) {

			// Front-end only
			if ( is_admin() ) {
				return;
			}

			// Disable loading core Woocommerce css if enabled
			$ip_wc_disable_core_css = (bool) apply_filters( 'ipress_wc_disable_core_css', false );
			if ( true !== $ip_wc_disable_core_css ) {
				return $enqueue_styles;
			}

			// Check if it's any of WooCommerce pages, ignore if it is
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

				// Dequeue WooCommerce stylesto lighten the load, GTMetrix will thank you
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
			}

			return $enqueue_styles;
		}

		/**
		 * Disable plugin woocommerce css in non-woocommerce pages
		 * - plugins
		 * - default blocks library
		 * - custom options
		 */
		public function woocommerce_disable_css() {

			// Front-end only
			if ( is_admin() ) {
				return;
			}

			// Disable Woocommerce loading css if woocommerce enabled
			$ip_wc_disable_css = (bool) apply_filters( 'ipress_wc_disable_css', false );
			if ( true !== $ip_wc_disable_css ) {
				return;
			}

			// Check if it's any of WooCommerce page, ignore if it is
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

				// Dequeue Woocommerce plugin styles: [ name, [...] ]
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
		 * Disable core & plugin woocommerce js in non-woocommerce pages
		 */
		public function woocommerce_disable_js() {

			// Front-end only
			if ( is_admin() ) {
				return;
			}

			// Disable Woocommerce loading js & css if woocommerce enabled
			$ip_wc_disable_js = (bool) apply_filters( 'ipress_wc_disable_js', false );
			if ( true !== $ip_wc_disable_js ) {
				return;
			}

			// Check if it's any of WooCommerce page, ignore if it is
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

				// Dequeue WooCommerce scripts
				$ip_wc_disable_cart = (bool) apply_filters( 'ipress_wc_disable_cart', true );
				if ( true === $ip_wc_disable_cart ) {

					// Dequeue WooCommerce cart scripts: cart js
					wp_dequeue_script( 'wc-cart-fragments' );
					wp_dequeue_script( 'woocommerce' );
					wp_dequeue_script( 'wc-add-to-cart' );

					// Dequeue WooCommerce cart scripts: cookie js
					wp_dequeue_script( 'js-cookie' );
				}

				// Dequeue Woocommerce plugin scripts: [ 'name', [...] ]
				$ip_wc_disable_js = (array) apply_filters( 'ipress_wc_plugin_scripts', [] );
				foreach ( $ip_wc_disable_js as $k => $v ) {
					wp_dequeue_script( $v );
				}
			}
		}

		/**
		 * Remove Woocommerce Select2 from front-end WooCommerce pages
		 */
		public function woocommerce_disable_select2() {

			// Front-end only
			if ( is_admin() ) {
				return;
			}

			// Disable Woocommerce loading js & css if woocommerce enabled
			$ip_wc_disable_select2 = (bool) apply_filters( 'ip_wc_disable_select2', false );
			if ( true !== $ip_wc_disable_select2 ) {
				return;
			}

			// Disable display
			wp_dequeue_style( 'select2' );
			wp_dequeue_script( 'selectWoo' );
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

			// Load the woocommerce translation
			$locale = get_locale() . '.mo';
			load_textdomain( 'ipress', get_stylesheet_directory() . '/languages/' . $locale );

			// Get the product type
			$product_type = $product->get_type();

			// Set translations by product type
			switch ( $product_type ) {
				case 'simple':
				case 'bundle':
				case 'subscription':
					return ( $product->is_purchasable() && $product->is_in_stock() ) ? __( 'Add to basket', 'ipress' ) : __( 'Read more', 'ipress' );
				case 'variable':
				case 'variable-subscription':
					return ( $product->is_purchasable() ) ? __( 'Select options', 'ipress' ) : __( 'Read more', 'ipress' );
				case 'grouped':
					return  __( 'View products', 'ipress' );
				case 'external':
					return ( $product->get_button_text() ) ? $product->get_button_text() : _x( 'Buy product', 'placeholder', 'ipress' );
				default:
					return __( 'Read more', 'ipress' );
			}

			// Shouldn't get here
			return $text;
		}

		/**
		 * Modify woocommerce breadcrumb args
		 * - [delimiter]
		 * - [wrap_before]
		 * - [wrap_after]
		 *
		 * @param array $args default breadcrumb structure
		 * @return array $args default breadcrumb structure
		 */
		public function breadcrumb_default_args( $args ) {
			return (array) apply_filters( 'ipress_wc_breadcrumb_default_args', $args );
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

			// Set fragment
			if ( true === $ip_wc_header_cart ) {
				ob_start();
				wc_get_template_part( 'header-cart-content' );
				$fragments['div.header-cart-content'] = ob_get_clean();
			}

			return $fragments;
		}

		//----------------------------------------------
		//	Product Archive Markup Functions
		//----------------------------------------------

		/**
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns, default 4
		 */
		public function product_thumbnail_columns() {
			return (int) apply_filters( 'ipress_product_thumbnail_columns', 4 );
		}

		//----------------------------------------------
		//	Single Product Markup Functions
		//----------------------------------------------

		/**
		 * Add gallery classes
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
					'columns'        => 1,
				]
			);

			return wp_parse_args( $ip_related_products_args, $args );
		}

		//----------------------------------------------
		//	Admin Hook Functions
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
	}
endif;

// Initialize WC class
return new IPR_Woocommerce();
