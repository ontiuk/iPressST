<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core Woocommerce features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
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
			add_action( 'after_setup_theme', 					[ $this, 'woocommerce_setup' ] );

			// Disable default Woocommerce styles @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/ 
			add_filter( 'woocommerce_enqueue_styles', 			'__return_empty_array' ); 

			// Woocommerce body class
			add_filter( 'body_class', 							[ $this, 'body_class' ] ); 

			// Turn off products pagination
			add_action( 'pre_get_posts', 						[ $this, 'pre_get_posts' ] );

			// Only display Woocommerce assets on Woocommerce pages?
			add_action( 'wp_enqueue_scripts', 					[ $this, 'disable_woocommerce_loading_css_js' ], 999 );
			
			// Disable Woocommerce select2?
			add_action( 'wp_enqueue_scripts', 					[ $this, 'disable_woocommerce_select2' ], 100 );
			
			// Change add to cart text on archives depending on product type, translatable
			add_filter( 'woocommerce_product_add_to_cart_text',	[ $this, 'add_to_cart_text' ], 10, 2 );
			
		    //----------------------------------------------
			//  Header Hooks
			//----------------------------------------------

	        // Header cart ajax fragments
    	    add_filter( 'woocommerce_add_to_cart_fragments', 	[ $this, 'header_cart_link_fragment' ], 	10, 1 ); 
			add_filter( 'woocommerce_add_to_cart_fragments', 	[ $this, 'header_cart_content_fragment' ], 	10, 1 ); 

			//----------------------------------------------
			//	HomePage Hooks
			//----------------------------------------------

			//----------------------------------------------
			//	Product Archive Page Hooks
			//----------------------------------------------

			//----------------------------------------------
			//	Single Product Page Hooks
			//----------------------------------------------
		
			// Add gallery images class
			add_filter( 'woocommerce_single_product_image_gallery_classes', [ $this, 'image_gallery_classes' ], 	10, 1 );
	
	        // Related product settings
    	    add_filter( 'woocommerce_output_related_products_args', 		[ $this, 'related_products_args' ], 	10, 1 ); 

			//----------------------------------------------
			//	Widget Hooks
			//----------------------------------------------

			//----------------------------------------------
			//	Admin & User Page Hooks
			//----------------------------------------------

			// Set up custom reports
			add_filter( 'woocommerce_admin_reports', [ $this, 'admin_reports' ], 10, 1 );

			//----------------------------------------------
			//	Custom Hooks
			//----------------------------------------------

			// We only really need to bother with the rest if we're using the cart, so check first, default to on/true
			$ip_wc_active = (bool) apply_filters( 'ipress_wc_active', true );
			if ( true !== $ip_wc_active ) { return; }

			//----------------------------------------------
			//	Cart Page Hooks
			//----------------------------------------------
		
			//----------------------------------------------
			//	Checkout Page Hooks
			//----------------------------------------------
		
			//----------------------------------------------
			//	Account Page Hooks
			//----------------------------------------------

			//----------------------------------------------
			//	Order Page Hooks
			//----------------------------------------------

			//----------------------------------------------
			//	Form Markup Hooks
			//----------------------------------------------
		}

		//----------------------------------------------
		//	Core support
		//----------------------------------------------

		/**
		 * Woocommerce theme support
		 */
		public function woocommerce_setup() {
			
			// Add Woocommerce support, inc 3.x features
			add_theme_support( 'woocommerce' ); 

			// Add Woocommerce gallery support: zoom, lightbox, slider
			$ip_wc_product_gallery = (bool) apply_filters( 'ipress_wc_product_gallery', true );
			if ( true === $ip_wc_product_gallery ) {
				add_theme_support( 'wc-product-gallery-zoom' ); 
				add_theme_support( 'wc-product-gallery-lightbox' ); 
				add_theme_support( 'wc-product-gallery-slider' ); 
			}
		}

		/** 
		 * Add 'woocommerce-active' class to the body tag
		 * 
		 * @param  array	$classes
		 * @return array	$classes 
		 */ 
		public function body_class( $classes ) { 
			$classes[] = 'woocommerce-active'; 
			return $classes; 
		} 

		/**
		 * Display all products on archive page, disables pagination
		 *
		 * @param	object $query WP_Query
		 * @return	object $query
		 */
		public function pre_get_posts( $query ) {

			// Turn on, off by default
			$ip_product_loop = (bool) apply_filters( 'ipress_wc_product_loop', false );

			// De-restrict posts, show all in loop
			if ( true === $ip_product_loop && ! is_admin() && $query->is_main_query() && is_post_type_archive( 'product' ) ) {
				$query->set( 'posts_per_page', -1 );
    		}

		    return $query;
		}

		/**
		 * Disable woocommerce css & js in non-woocommerce pages
		 */
		public function disable_woocommerce_loading_css_js() {

			// Front-end only
			if ( is_admin() ) { return; }

			// Disable Woocommerce loading js & css if woocommerce enabled
			$ip_wc_disable_js_css = (bool) apply_filters( 'ipress_wc_disable_js_css', false );
			if ( true !== $ip_wc_disable_js_css ) { return; }

			// Check if it's any of WooCommerce page
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

				// Dequeue WooCommerce styles
				$ip_wc_disable_layout = (bool) apply_filters( 'ipress_wc_disable_layout', true );
				if ( true === $ip_wc_disable_layout ) {
					wp_dequeue_style( 'woocommerce-layout' ); 
					wp_dequeue_style( 'woocommerce-general' ); 
					wp_dequeue_style( 'woocommerce-smallscreen' );
				}

				// Dequeue Woocommerce plugin styles: [ name, name2, name3 ]
				$ip_wc_plugin_styles = (array) apply_filters( 'ipress_wc_disable_css', [ 'wc-block-style', 'wc-bundle-style', 'wc-composite-css' ] );
				foreach ( $ip_wc_plugin_styles as $style ) {
					wp_dequeue_style( $style );
				}

				// Dequeue WooCommerce scripts
				$ip_wc_disable_cart = (bool) apply_filters( 'ipress_wc_disable_cart', true );
				if ( true === $ip_wc_disable_cart ) {

					// Dequeue WooCommerce cart scripts: cart js
					wp_dequeue_script( 'wc-cart-fragments' );
					wp_dequeue_script( 'woocommerce' ); 
					wp_dequeue_script( 'wc-add-to-cart' ); 

					// Dequeue WooCommerce cart scripts: cookie js
					wp_deregister_script( 'js-cookie' );
					wp_dequeue_script( 'js-cookie' );
				}

				// Dequeue Woocommerce plugin scripts: [ [ 'name' => xxxx, 'register' = true ], [...] ]
				$ip_wc_disable_js = (array) apply_filters( 'ipress_wc_disable_js', [] );
				foreach ( $ip_wc_disable_js as $script ) {
					if ( isset( $script['register'] ) && $script['register'] ) {
						wp_deregister_script( $script['name'] );
					}
					wp_dequeue_script( $script['name'] );
				}
			}
		}
		
		/**
		 * Remove Woocommerce Select2
		 */
		public function disable_woocommerce_select2() {

			// Disable Woocommerce loading js & css if woocommerce enabled
			$ip_wc_disable_select2 = (bool) apply_filters( 'ip_wc_disable_select2', false );
			if ( true !== $ip_wc_disable_select2 ) { return; }

			wp_dequeue_style( 'select2' );
			wp_deregister_style( 'select2' );

			wp_dequeue_script( 'selectWoo');
			wp_deregister_script('selectWoo');
		}

		/**
		 * Update add to cart text based on context and location
		 * - load locale textdomain & translations
		 *
		 * @param	string	$text
		 * @param	objext	$product
		 * @return 	string	$text
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

		//----------------------------------------------
		//	Header Markup Functions
		//----------------------------------------------

		/** 
		 * Keep cart contents update when products are added to the cart via AJAX 
		 * 
		 * @param	array $fragments Fragments to refresh via AJAX
		 * @return	array
		 * @uses	/woocommerce theme overwrite directory
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
		 * @param	array $fragments Fragments to refresh via AJAX
		 * @return	array
		 * @uses	/woocommerce theme overwrite directory
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

		/** 
		 * Related Products Args
		 * 
		 * @param 	array $args
		 * @return 	array $args 
		 */ 
		public function related_products_args( $args ) {

			// Filterable related products, default to 3 products
			$ip_related_products_args = (array) apply_filters( 'ipress_related_products_args', [ 
				'posts_per_page' => 3, 
				'columns'		 => 3 
			] ); 

			$args = wp_parse_args( $ip_related_products_args, $args ); 
			return $args; 
		}

		//----------------------------------------------
		//	Product Archive Markup Functions
		//----------------------------------------------

		//----------------------------------------------
		//	Single Product Markup Functions
		//----------------------------------------------

		/**
		 * Add gallery classes
		 *
		 * @param	array	$classes
		 * @return	array	$classes
		 */
		public function image_gallery_classes( $classes ) {

			global $product;

			$classes[] = 'woocommerce-product-gallery--' . ( $product->get_gallery_image_ids() ? 'with-gallery' : 'without-gallery' );
			return $classes;
		}

		//----------------------------------------------
		//	Cart Page Markup Functions
		//----------------------------------------------

		//----------------------------------------------
		//	Checkout Page Markup Functions
		//----------------------------------------------

		//----------------------------------------------
		//	Account Page Markup Functions
		//----------------------------------------------

		//----------------------------------------------
		//	Admin Hook Functions
		//----------------------------------------------

		/**
		 * Add custom reports
		 *
		 * @param	array	$reports
		 * @return	array	$reports
		 */
		public function admin_reports( $reports ) {
			return $reports;
		}
	}

endif;

// Initialize WC class
return new IPR_Woocommerce();

// End
