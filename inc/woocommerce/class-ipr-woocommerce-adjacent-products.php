<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * WooCommerce Adjacent Products Class
 *
 * @see     Adapted from WooCommerce Storefront theme
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_WooCommerce_Adjacent_Products' ) ) :

	/**
	 * The WooCommerce Adjacent Products Class
	 */
	class IPR_WooCommerce_Adjacent_Products {

		/**
		 * The current product ID.
		 *
		 * @var int|null
		 */
		private $current_product = null;

		/**
		 * Whether post should be in a same taxonomy term.
		 *
		 * @var boolean
		 */
		private $in_same_term = false;

		/**
		 * List of excluded term IDs.
		 *
		 * @var string
		 */
		private $excluded_terms = '';

		/**
		 * Taxonomy slug.
		 *
		 * @var string
		 */
		private $taxonomy = 'product_cat';

		/**
		 * Whether to retrieve previous product.
		 *
		 * @var boolean
		 */
		private $previous = false;

		/**
		 * Constructor.
		 *
		 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
		 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
		 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
		 */
		public function __construct( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
			$this->in_same_term   = $in_same_term;
			$this->excluded_terms = $excluded_terms;
			$this->taxonomy       = $taxonomy;
		}

		/**
		 * Get adjacent product or circle back to the first/last valid product.
		 *
		 * @param bool $previous Optional. Whether to retrieve previous product. Default false.
		 * @return WC_Product|false Product object if successful. False if no valid product is found.
		 */
		public function get_product( $previous = false ) {

			global $post;

			// Set variables used throughout class methods
			$product               = false;
			$this->current_product = $post->ID;
			$this->previous        = $previous;

			// Try to get a valid product via `get_adjacent_post()`.
			// phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition.FoundInWhileCondition
			while ( $adjacent = $this->get_adjacent() ) {

				// Retrieve product by ID & check visibility
				$product = wc_get_product( $adjacent->ID );
				if ( $product && $product->is_visible() ) {
					break;
				}

				// Set current paramaters
				$product               = false;
				$this->current_product = $adjacent->ID;
			}

			// Ok, have product
			if ( $product ) {
				return $product;
			}

			// No valid product found; Query WC for first/last product.
			$product = $this->query_wc();
			return ( $product ) ? $product : false;
		}

		/**
		 * Get adjacent post.
		 *
		 * @return WP_POST|false Post object if successful. False if no valid post is found.
		 */
		private function get_adjacent() {

			global $post;

			// Needs a direction for the filters
			$direction = ( true === $this->previous ) ? 'previous' : 'next';

			// Set up dynamic filters and process
			add_filter( 'get_' . $direction . '_post_where', [ $this, 'filter_post_where' ] );
			$adjacent = get_adjacent_post( $this->in_same_term, $this->excluded_terms, $this->previous, $this->taxonomy );
			remove_filter( 'get_' . $direction . '_post_where', [ $this, 'filter_post_where' ] );

			return $adjacent;
		}

		/**
		 * Filters the WHERE clause in the SQL for an adjacent post query, replacing the
		 * date with date of the next post to consider.
		 *
		 * @param string $where The `WHERE` clause in the SQL.
		 * @return WP_POST|false Post object if successful. False if no valid post is found.
		 */
		public function filter_post_where( $where ) {

			global $post;

			$new = get_post( $this->current_product );

			return str_replace( $post->post_date, $new->post_date, $where );
		}

		/**
		 * Query WooCommerce for either the first or last products.
		 *
		 * @global $post Post object
		 * @return WC_Product|false Post object if successful. False if no valid post is found.
		 */
		private function query_wc() {

			global $post;

			// Set product args
			$args = [
				'limit'      => 2,
				'visibility' => 'catalog',
				'exclude'    => [ $post->ID ],
				'orderby'    => 'date',
				'status'     => 'publish',
			];

			if ( ! $this->previous ) {
				$args['order'] = 'ASC';
			}

			// Set the taxonomy term
			if ( $this->in_same_term ) {
				$terms = get_the_terms( $post->ID, $this->taxonomy );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					$args['category'] = wp_list_pluck( $terms, 'slug' );
				}
			}

			// Retrieve products from args
			$products = wc_get_products( apply_filters( 'ipress_woocommerce_adjacent_query_args', $args ) );

			// At least 2 results are required, otherwise previous/next will be the same.
			if ( ! empty( $products ) && count( $products ) >= 2 ) {
				return $products[0];
			}

			return false;
		}
	}
endif;
