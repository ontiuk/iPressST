<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * WooCommerce Template Functions.
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//  Header Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_product_search' ) ) :

	/**
	 * Display Product Search
	 *
	 * @uses ipress_wc_active check if WooCommerce is activated
	 */
	function ipress_product_search() {

		// Check if WooCommerce product search is active
		if ( ! ipress_wc_active() || is_shop() || true !== get_theme_mod( 'ipress_product_search', true ) ) {
			return;
		}

		// Load the WooCommerce search template
		wc_get_template_part( 'product-search' );
	}
endif;

//----------------------------------------------
//	Product Archive Page Hook Functions
//----------------------------------------------

//----------------------------------------------
//	Single Product Page Hook Functions
//----------------------------------------------

//----------------------------------------------
//	HomePage Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_product_categories' ) ) :

	/**
	 * Display Product Categories
	 * 
	 * @see Woocommerce Storefront Theme
	 *
	 * @param array $args the product section args.
	 */
	function ipress_product_categories( $args ) {

		// Set product category args
		$args = apply_filters(
			'ipress_product_categories_args',
			[
				'limit'            => 3,
				'columns'          => 3,
				'child_categories' => 0,
				'orderby'          => 'menu_order',
				'title'            => __( 'Shop by Category', 'ipress' ),
			]
		);

		// Process Product Categories shortcode
		$shortcode_content = ipress_do_shortcode(
			'product_categories',
			apply_filters(
				'ipress_product_categories_shortcode_args',
				[
					'number'  => intval( $args['limit'] ),
					'columns' => intval( $args['columns'] ),
					'orderby' => esc_attr( $args['orderby'] ),
					'parent'  => esc_attr( $args['child_categories'] ),
				]
			)
		);

		// Only display the section if the shortcode returns product categories
		if ( false !== strpos( $shortcode_content, 'product-category' ) ) {

			echo sprintf( '<section class="ipress-product-section ipress-product-categories" aria-label="%s">', esc_attr__( 'Product Categories', 'ipress' ) );

			do_action( 'ipress_before_product_categories' );

			echo sprintf( '<h2 class="section-title product-categories-title">%s</h2>', wp_kses_post( $args['title'] ) );

			do_action( 'ipress_after_product_categories_title' );

			echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			do_action( 'ipress_after_product_categories' );

			echo '</section>';
		}
	}
endif;

if ( ! function_exists( 'ipress_recent_products' ) ) :

	/**
	 * Display Recent Products
	 *
	 * @see Woocommerce Storefront Theme
	 * 
	 * @param array $args the product section args.
	 */
	function ipress_recent_products( $args ) {

		// Set related product args
		$args = apply_filters(
			'ipress_recent_products_args',
			[
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'New Products', 'ipress' ),
			]
		);

		// Process recent products shortcode
		$shortcode_content = ipress_do_shortcode(
			'products',
			apply_filters(
				'ipress_recent_products_shortcode_args',
				[
					'orderby'  => esc_attr( $args['orderby'] ),
					'order'    => esc_attr( $args['order'] ),
					'per_page' => intval( $args['limit'] ),
					'columns'  => intval( $args['columns'] ),
				]
			)
		);

		// Only display the section if the shortcode returns products
		if ( false !== strpos( $shortcode_content, 'product' ) ) {

			echo sprintf( '<section class="ipress-product-section ipress-recent-products" aria-label="%s">', esc_attr__( 'Recent Products', 'ipress' ) );

			do_action( 'ipress_before_recent_products' );

			echo sprintf( '<h2 class="section-title recent-products-title">%s</h2>', wp_kses_post( $args['title'] ) );

			do_action( 'ipress_after_recent_products_title' );

			echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			do_action( 'ipress_after_recent_products' );

			echo '</section>';
		}
	}
endif;

if ( ! function_exists( 'ipress_featured_products' ) ) :

	/**
	 * Display Featured Products
	 *
	 * @see Woocommerce Storefront Theme
	 * 
	 * @param array $args the product section args.
	 */
	function ipress_featured_products( $args ) {

		// Set featured product args
		$args = apply_filters(
			'ipress_featured_products_args',
			[
				'limit'      => 4,
				'columns'    => 4,
				'orderby'    => 'date',
				'order'      => 'desc',
				'visibility' => 'featured',
				'title'      => __( 'We Recommend', 'ipress' ),
			]
		);

		// Process featured product shortcode
		$shortcode_content = ipress_do_shortcode(
			'products',
			apply_filters(
				'ipress_featured_products_shortcode_args',
				[
					'per_page'   => intval( $args['limit'] ),
					'columns'    => intval( $args['columns'] ),
					'orderby'    => esc_attr( $args['orderby'] ),
					'order'      => esc_attr( $args['order'] ),
					'visibility' => esc_attr( $args['visibility'] ),
				]
			)
		);

		// Only display the section if the shortcode returns products
		if ( false !== strpos( $shortcode_content, 'product' ) ) {

			echo sprintf( '<section class="ipress-product-section ipress-featured-products" aria-label="%s">', esc_attr__( 'Featured Products', 'ipress' ) );

			do_action( 'ipress_before_featured_products' );

			echo sprintf( '<h2 class="section-title featured-products-title">%s</h2>', wp_kses_post( $args['title'] ) );

			do_action( 'ipress_after_featured_products_title' );

			echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			do_action( 'ipress_after_featured_products' );

			echo '</section>';
		}
	}
endif;

if ( ! function_exists( 'ipress_popular_products' ) ) :

	/**
	 * Display Popular Products
	 *
	 * @see Woocommerce Storefront Theme
	 * 
	 * @param array $args the product section args.
	 */
	function ipress_popular_products( $args ) {

		// Set popular product args
		$args = apply_filters(
			'ipress_popular_products_args',
			[
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'rating',
				'order'   => 'desc',
				'title'   => __( 'Popular Products', 'ipress' ),
			]
		);

		// Process popular product shortcode
		$shortcode_content = ipress_do_shortcode(
			'products',
			apply_filters(
				'ipress_popular_products_shortcode_args',
				[
					'per_page' => intval( $args['limit'] ),
					'columns'  => intval( $args['columns'] ),
					'orderby'  => esc_attr( $args['orderby'] ),
					'order'    => esc_attr( $args['order'] ),
				]
			)
		);

		// Only display the section if the shortcode returns products
		if ( false !== strpos( $shortcode_content, 'product' ) ) {

			echo sprintf( '<section class="ipress-product-section ipress-popular-products" aria-label="%s">', esc_attr__( 'Popular Products', 'ipress' ) );

			do_action( 'ipress_before_popular_products' );

			echo sprintf( '<h2 class="section-title popular-products-title">%s</h2>', wp_kses_post( $args['title'] ) );

			do_action( 'ipress_after_popular_products_title' );

			echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			do_action( 'ipress_after_popular_products' );

			echo '</section>';
		}
	}
endif;

if ( ! function_exists( 'ipress_on_sale_products' ) ) :

	/**
	 * Display On Sale Products
	 *
	 * @see Woocommerce Storefront Theme
	 * 
	 * @param array $args the product section args.
	 */
	function ipress_on_sale_products( $args ) {

		// Set on sale product args
		$args = apply_filters(
			'ipress_on_sale_products_args',
			[
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'on_sale' => 'true',
				'title'   => __( 'On Sale', 'ipress' ),
			]
		);

		// Process on sale product shortcode
		$shortcode_content = ipress_do_shortcode(
			'products',
			apply_filters(
				'ipress_on_sale_products_shortcode_args',
				[
					'per_page' => intval( $args['limit'] ),
					'columns'  => intval( $args['columns'] ),
					'orderby'  => esc_attr( $args['orderby'] ),
					'order'    => esc_attr( $args['order'] ),
					'on_sale'  => esc_attr( $args['on_sale'] ),
				]
			)
		);

		// Only display the section if the shortcode returns products
		if ( false !== strpos( $shortcode_content, 'product' ) ) {

			echo sprintf( '<section class="ipress-product-section ipress-on-sale-products" aria-label="%s">', esc_attr__( 'On Sale Products', 'ipress' ) );

			do_action( 'ipress_before_on_sale_products' );

			echo sprintf( '<h2 class="section-title on-sale-products-title">%s</h2>', wp_kses_post( $args['title'] ) );

			do_action( 'ipress_after_on_sale_products_title' );

			echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			do_action( 'ipress_after_on_sale_products' );

			echo '</section>';
		}
	}
endif;

if ( ! function_exists( 'ipress_best_selling_products' ) ) :

	/**
	 * Display Best Selling Products
	 *
	 * @see Woocommerce Storefront Theme
	 * 
	 * @param array $args the product section args.
	 */
	function ipress_best_selling_products( $args ) {

		// Set best selling product args
		$args = apply_filters(
			'ipress_best_selling_products_args',
			[
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'popularity',
				'order'   => 'desc',
				'title'   => esc_attr__( 'Best Sellers', 'ipress' ),
			]
		);

		// Process best selling products shortcode
		$shortcode_content = ipress_do_shortcode(
			'products',
			apply_filters(
				'ipress_best_selling_products_shortcode_args',
				[
					'per_page' => intval( $args['limit'] ),
					'columns'  => intval( $args['columns'] ),
					'orderby'  => esc_attr( $args['orderby'] ),
					'order'    => esc_attr( $args['order'] ),
				]
			)
		);

		// Only display the section if the shortcode returns products
		if ( false !== strpos( $shortcode_content, 'product' ) ) {

			echo sprintf( '<section class="ipress-product-section ipress-best-selling-products" aria-label="%s">', esc_attr__( 'Best Selling Products', 'ipress' ) );

			do_action( 'ipress_before_best_selling_products' );

			echo sprintf( '<h2 class="section-title best-selling-products-title">%s</h2>', wp_kses_post( $args['title'] ) );

			do_action( 'ipress_after_best_selling_products_title' );

			echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			do_action( 'ipress_after_best_selling_products' );

			echo '</section>';
		}
	}
endif;

if ( ! function_exists( 'ipress_single_product_pagination' ) ) :

	/**
	 * Single Product Pagination
	 *
	 * @see WooCommerce Storefront Theme
	 */
	function ipress_single_product_pagination() {

		// Check if this is activated
		$product_pagination = (bool) get_theme_mod( 'ipress_product_pagination', 'false' );
		if ( true !== $product_pagination ) {
			return;
		}

		// Load the Woocommerce product pagination template
		wc_get_template_part( 'single-product/pagination' );
	}
endif;

//----------------------------------------------
//	Custom Hook Functions
//----------------------------------------------

//----------------------------------------------
//	Cart Page Hook Functions
//----------------------------------------------

//----------------------------------------------
//	Checkout Page Hook Functions
//----------------------------------------------

//----------------------------------------------
//	Account Page Hook Functions
//----------------------------------------------

//----------------------------------------------
//	Order Page Hook Functions
//----------------------------------------------

//----------------------------------------------
//	Form Markup Hook Functions
//----------------------------------------------
