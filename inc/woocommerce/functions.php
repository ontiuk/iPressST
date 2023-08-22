<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality for WooCommerce.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	WooCommerce Functions
//
// ipress_wc_active
// ipress_wc_version_check
// ipress_wc_version
// ipress_wc_version_notice
// ipress_wc_archive
// ipress_wc_page
// ipress_wc_pages
// ipress_is_wc_endpoint
// ipress_wc_cart_available
// ipress_wc_subscriptions_active
//----------------------------------------------

if ( ! function_exists( 'ipress_wc_active' ) ) :

	/**
	 * Query WooCommerce activation
	 *
	 * @return boolean true if WooCommerce plugin active
	 */
	function ipress_wc_active() {
		return class_exists( 'WooCommerce', false );
	}
endif;

if ( ! function_exists( 'ipress_wc_version_check' ) ) :

	/**
	 * Compare WooCommerce version
	 *
	 * @global woocommerce
	 * @param string $version WooCommerce version, default 4.0
	 * @param string $compare Default '>=' greater or equal than
	 */
	function ipress_wc_version_check( $version = '4.0', $compare = '>=' ) : bool {
		global $woocommerce;
		return ( ipress_wc_active() ) ? version_compare( $woocommerce->version, $version, $compare ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_version' ) ) :

	/**
	 * Retrieve current WooCommerce version
	 *
	 * - WooCommerce version if active, false if not
	 *
	 * @global woocommerce
	 * @return string|boolean
	 */
	function ipress_wc_version() {
		global $woocommerce;
		return ( ipress_wc_active() ) ? $woocommerce->version : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_version_notice' ) ) :

	/**
	 * Display WooCommerce version notice
	 *
	 * @return string
	 */
	function ipress_wc_version_notice() {
		$message = sprintf(
			/* translators: 1: WooCommerce version, 2: WooCommerce version */
			__( 'Theme Requires WooCommerce %1$s. Version %2$s installed', 'ipress' ),
			IPRESS_THEME_WC,
			ipress_wc_version()
		);
		echo sprintf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
	}
endif;

if ( ! function_exists( 'ipress_wc_archive' ) ) :

	/**
	 * Checks if the current page is a WooCommerce archive page
	 */
	function ipress_wc_archive() : bool {
		return ( ipress_wc_active() ) ? ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_page' ) ) :

	/**
	 * Checks if the current page is a WooCommerce standard page with shortcode
	 */
	function ipress_is_wc_page() : bool {
		return ( ipress_wc_active() ) ? ( is_cart() || is_checkout() || is_account_page() ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_pages' ) ) :

	/**
	 * Checks if the current page is a WooCommerce page of any description.
	 */
	function ipress_wc_pages() : bool {

		// Initial test
		if ( ipress_wc_active() && is_woocommerce() ) {
	        return true;
    	}

		// Set up filterable WooCommerce virtual page list
		$woocommerce_keys = apply_filters(
			'ipress_wc_pages_list',
			[ 
				'woocommerce_shop_page_id' ,
				'woocommerce_terms_page_id' ,
				'woocommerce_cart_page_id',
				'woocommerce_checkout_page_id',
				'woocommerce_pay_page_id',
				'woocommerce_thanks_page_id',
				'woocommerce_myaccount_page_id',
				'woocommerce_edit_address_page_id',
				'woocommerce_view_order_page_id',
				'woocommerce_change_password_page_id',
				'woocommerce_logout_page_id',
				'woocommerce_lost_password_page_id' 
			]
		);

		// Cross check for key vs page_id
		foreach ( $woocommerce_keys as $wc_page_id ) {
			if ( get_the_ID () === (int) get_option ( $wc_page_id , 0 ) ) {
				return true ;
			}
		}
		return false;
	}
endif;

if ( ! function_exists( 'ipress_wc_page_id' ) ) :

	/**
	 * Get the page if is a WooCommerce page
	 *
	 * @param string $page Page type, default empty
	 * @return boolean|integer
	 */
	function ipress_wc_page_id( $page = '' ) {

		// Valid WooCommerce page types
		$wc_pages = [
			'myaccount',
			'shop',
			'cart',
			'checkout',
			'terms',
		];

		// No WooCommerce?
		if ( ! ipress_wc_active() ) {
			return false;
		}

		// Page?
		if ( $page && in_array( $page, $wc_pages, true ) ) {
			return wc_get_page_id( $page );
		}

		// Correct type of WooCommerce page
		if ( is_shop() ) {
			return wc_get_page_id( 'shop' );
		} elseif ( is_cart() ) {
			return wc_get_page_id( 'cart' );
		} elseif ( is_checkout() ) {
			return wc_get_page_id( 'checkout' );
		} elseif ( is_account_page() ) {
			return wc_get_page_id( 'myaccount' );
		}
		return false;
	}
endif;

if ( ! function_exists( 'ipress_is_wc_endpoint' ) ) :

	/**
	 * Check if is a WooCommerce endpoint
	 *
	 * @param string $endpoint Endpoint type, default url
	 */
	function ipress_is_wc_endpoint( $endpoint = 'url' ) : bool {

		// Valid WooCommerce page types
		$wc_endpoints = [
			'url',
			'order-pay',
			'order-received',
			'view-order',
			'edit-account',
			'edit-address',
			'lost-password',
			'customer-logout',
			'add-payment-method',
		];

		// No WooCommerce?
		if ( ! ipress_wc_active() ) {
			return false;
		}

		// Check endpoint validity
		if ( ! in_array( $endpoint, $wc_endpoints ) ) {
			return false;
		}

		// Check by endpoint
		switch( $endpoint ) {
			case 'order-pay':
				return is_wc_endpoint_url( 'order-pay' );
			case 'order-received':
				return is_wc_endpoint_url( 'order-received' );
			case 'view-order':
				return is_wc_endpoint_url( 'view-order' );
			case 'edit-account':
				return is_wc_endpoint_url( 'edit-account' );
			case 'edit-address':
				return is_wc_endpoint_url( 'edit-address' );
			case 'lost-password':
				return is_wc_endpoint_url( 'lost-password' );
			case 'customer-logout':
				return is_wc_endpoint_url( 'customer-logout' );
			case 'add-payment-method':
				return is_wc_endpoint_url( 'add-payment-method' );
			case 'url':
				return is_wc_endpoint_url();
			default:
				break;
		}
		return false;
	}
endif;

if ( ! function_exists( 'ipress_wc_cart_available' ) ) :

	/**
	 * Checks whether the Woo Cart instance is available in the request
	 */
	function ipress_wc_cart_available() : bool {
		$woo = WC();
		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
endif;

if ( ! function_exists( 'ipress_wc_subscriptions_active' ) ) :

	/**
	 * Query WooCommerce subscriptions activation
	 */
	function ipress_wc_subscriptions_active() : bool {
		return( ipress_wc_active() ) ? class_exists( 'WC_Subscriptions', false ) : false;
	}
endif;

if ( ! function_exists( 'ipress_wc_get_archive' ) ) :

	/**
	 * Retrieve a list of products by parameters
	 *
	 * @param array|null $args Query args
	 * @return array
	 */
	function ipress_wc_get_archive( $args = null ) {

		// Set post-type settings
		$post_type 	    = 'product';
		$post_status    = 'publish';
		$orderby        = 'date';
		$excerpt_length = 12;
		$excerpt_more 	= '...';

		// Extract any arguments provided
        if ( is_array( $args ) ) {
            extract( $args, EXTR_OVERWRITE );
		}

        // Start setting up WP Query for case studies
        $query_args = [
            'post_type' 	=> $post_type,
            'post_status' 	=> $post_status,
            'orderby'       => $orderby
		];

		// Posts per page: int, default -1, all courses
		$query_args['posts_per_page'] = ( isset( $posts_per_page ) ) ? absint( $posts_per_page ) : -1;

		// Pagination: int
        if ( isset( $paged ) ) {
			$query_args['paged'] = $paged;
		}

		// Pages ID list: array
        if ( isset( $post__in ) ) {
			$query_args['post__in'] = $post__in;
		}

		// Category: int
		if ( isset( $cat ) ) {
			$query_args['cat'] = $cat;
		}

		// Pages ID list: array
        if ( isset( $post__not_in ) ) {
			$query_args['post__not_in'] = $post__not_in;
		}

        // Default taxonomy ('category') query

        // Get the queried object if we're on an archive page - just in case we also have custom taxonomy
        $queried_object = ( is_archive() ) ? get_queried_object() : false;

		// Are we on the default category or a related taxonomy
		if ( $queried_object && $queried_object->taxonomy !== 'category' ) {

			// Set taxonomy query
			$query_args['tax_query'] = [
				[
	                'taxonomy'	=> $queried_object->taxonomy,
    	            'field'		=> 'term_id',
					'terms'		=> $queried_object->term_id
				]
			];

			// Taxonomy slug
            $custom_taxonomy = $queried_object->slug;
        }

		// Date: month : int
        if ( isset( $monthnum ) ) {
			$query_args['monthnum'] = intval( $monthnum );
		}

		// Date: year : int
        if ( isset( $year ) ) {
			$query_args['year'] = intval( $year );
		}

		// Tax query override: array
        if ( isset( $tax_query ) ) {
            $query_args['tax_query'] = $tax_query;
		}

		// Ordering: string
        if ( $orderby ) {
			$query_args['orderby'] = $orderby;
		}

        // Run the WP Query
        $posts_query = new WP_Query( $query_args );

		// Products list
		$products = [];

		// Iterate returned posts
		while( $posts_query->have_posts() ) {

			// Set the current post
			$posts_query->the_post();

            // Get the course categories, nyi
            $category_data = get_the_category();

			// Initiate category list
			$categories = [];

			// Construct categories list if available
			if ( is_array( $category_data ) ) {

				foreach( $category_data as $category ) {

                    $categories[] = [
                        'id'	=> $category->term_id,
                        'name'	=> $category->name,
                        'link'	=> get_term_link( $category )
					];
                }
            }

			// Filterable posts list
			$products[] = apply_filters( 
				'ipress_product_archive',
				[
					'date'		=> new DateTime( get_the_date() ),
					'id'		=> get_the_id(),
					'title'		=> get_the_title(),
					'excerpt'  	=> ( has_excerpt() ) ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ), $excerpt_length, $excerpt_more ),
					'link' 	   	=> get_the_permalink(),
					'image'    	=> get_the_post_thumbnail(),
					'category'	=> $categories,
					'product'	=> wc_get_product( get_the_id() )
				]
			);
        }

		// Process results
        $result = [
            'total_pages'		=> $posts_query->max_num_pages,
            'posts_returned'	=> $posts_query->post_count,
            'total_posts'		=> $posts_query->found_posts,
            'current_page'		=> $posts_query->query_vars['paged'],
            'products' 			=> $products
        ];

        wp_reset_postdata();
        return $result;
	}
endif;

// ------------------------------------
// Product Pagination Functions
//
// ipress_get_previous_product
// ipress_get_next_product
// ------------------------------------

if ( ! function_exists( 'ipress_get_previous_product' ) ) :

	/**
	 * Retrieves the previous product
	 *
	 * - Product object if successful. False if no valid product is found
	 *
	 * @see Adapted from WooCommerce Storefront Theme
	 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term, default false
	 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs, default empty
	 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true, default 'product_cat'
	 * @return WC_Product|false
	 */
	function ipress_get_previous_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new IPR_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
		return $product->get_product( true );
	}
endif;

if ( ! function_exists( 'ipress_get_next_product' ) ) :

	/**
	 * Retrieves the next product
	 *
	 * - Product object if successful, false if no valid product is found
	 * 
	 * @see Adapted from WooCommerce Storefront Theme
	 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term, default false
	 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs, default empty
	 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true, default 'product_cat'
	 * @return WC_Product|false
	 */
	function ipress_get_next_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new IPR_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
		return $product->get_product();
	}
endif;

// ------------------------------------
// Product and Shop Functions
//
// ipress_shop_results
// ------------------------------------

if ( ! function_exists( 'ipress_shop_results' ) ) :

	/**
	 * Remove shop results from archives listing
	 */
	function ipress_shop_results(){

		// Must be active and shop page
		if ( ! ipress_wc_active() || ! is_shop() ) { return; }

		// Remove the sorting dropdown from WooCommerce archives header
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );

		// Remove the result count from WooCommerce archives header
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
	}
endif;

// ------------------------------------
// Custom Theme Functions
// ------------------------------------
