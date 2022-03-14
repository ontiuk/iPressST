<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress query features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Query' ) ) :

	/**
	 * Set up query manipulation functionality
	 */
	final class IPR_Query {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Eliminate duplicates in query results
			//add_filter( 'posts_distinct', [ $this, 'posts_distinct' ] );

			// Set the GROUP BY clause for the SQL query
			//add_filter( 'posts_groupby', [ $this, 'posts_groupby' ] );

			// Set the table JOIN clause for the SQL query
			//add_filter( 'posts_join', [ $this, 'posts_join' ] );

			// Set the LIMIT clause for the SQL query
			//add_filter( 'post_limits', [ $this, 'posts_limit' ], 10, 2 );

			// Set the ORDER BY clause for the SQL query
			//add_filter( 'posts_orderby', [ $this, 'posts_orderby' ] );

			// Set the POSTS JOIN PAGED clause for the SQL query
			//add_filter( 'posts_join_paged', [ $this, 'posts_join_paged' ] );

			// Set the POSTS WHERE clause for the SQL query
			//add_filter( 'posts_where' , [ $this, 'posts_where' ] );

			// Query post clauses
			//add_filter( 'posts_clauses', [ $this, 'posts_clauses' ] );

			// Term query clauses
			//add_filter( 'terms_clauses', [ $this, 'terms_clauses' ] );

			// Customise the Post Type query if a taxonomy term is used
			add_action( 'pre_get_posts', [ $this, 'post_type_archives' ] );

			// Exclude category posts from home page - defaults to unclassified
			add_action( 'pre_get_posts', [ $this, 'exclude_categories' ] );

			// Add custom post types to Search
			add_action( 'pre_get_posts', [ $this, 'search_include' ] );
		}

		//----------------------------------------------
		//	Main Query Filters
		//----------------------------------------------

		/**
		 * Set the query duplicate restrictions
		 *
		 * @return string
		 */
		public function posts_distinct() {
			return 'DISTINCT';
		}

		/**
		 * Set the Group By clause
		 *
		 * @param string $groupby
		 * @return string $groupby
		 */
		public function posts_groupby( $groupby ) {
			return $groupby;
		}

		/**
		 * Set the table join parameters
		 *
		 * @param string $join
		 * @return string $join
		 */
		public function posts_join( $join ) {
			return $join;
		}

		/**
		 * Set the return limiter
		 *
		 * @param integer $limit
		 * @param string $query
		 * @return integer $limit
		 */
		public function posts_limit( $limit, $query ) {
			return $limit;
		}

		/**
		 * Set the orderby clause
		 *
		 * @param string $orderby
		 * @return string $orderby
		 */
		public function posts_orderby( $orderby ) {
			return $orderby;
		}

		/**
		 * Set the paged join clause
		 *
		 * @param string $join_paged
		 * @return string $join_paged
		 */
		public function posts_join_paged( $join_paged ) {
			return $join_paged;
		}

		/**
		 * Set the where clause
		 *
		 * @param string $where
		 * @return string $where
		 */
		public function posts_where( $where ) {
			return $where;
		}

		/**
		 * Posts Clauses
		 *
		 * @param array $pieces
		 * @return array $pieces
		 */
		public function posts_clauses( $pieces ) {
			return $pieces;
		}

		//----------------------------------------------
		// Terms Query Filters
		//----------------------------------------------

		/**
		 * Terms Clauses
		 *
		 * @param array $pieces
		 * @return array $pieces
		 */
		public function terms_clauses( $pieces ) {
			return $pieces;
		}

		//----------------------------------------------
		// Main Query Manipulation
		//----------------------------------------------

		/**
		 * Customise the Post Type query if a taxonomy term is used
		 *
		 * @param object $query WP_Query
		 */
		public function post_type_archives( $query ) {

			// Set up filterable post-types
			$ip_query_post_type_archives = (array) apply_filters( 'ipress_query_post_type_archives', [] );
			if ( empty( $ip_query_post_type_archives ) ) {
				return;
			}

			// Main query & post-types
			if ( $query->is_main_query() && ! is_admin() && $query->is_post_type_archive( $ip_query_post_type_archives ) ) {

				// Only if taxonomy set modify query
				if ( is_tax() ) {

					$tax_obj = $query->get_queried_object();

					$tax_query = [
						'taxonomy'         => $tax_obj->taxonomy,
						'field'            => 'slug',
						'terms'            => $tax_obj->slug,
						'include_children' => false,
					];

					$query->tax_query->queries[]    = $tax_query;
					$query->query_vars['tax_query'] = $query->tax_query->queries;
				}
			}
		}

		/**
		 * Exclude uncategorised posts from home/posts page
		 *
		 * @param object $query WP_Query
		 */
		public function exclude_categories( $query ) {

			// Select categories to exclude: default 'uncategorised'
			$ip_query_exclude_category = (array) apply_filters( 'ipress_query_exclude_category', [ '-1' ] );

			// Main query & home page
			if ( $ip_query_exclude_category && $query->is_home() && $query->is_main_query() ) {
				$cats = array_map( [ $this, 'exclude_category_map' ], $ip_query_exclude_category );
				$cats = join( ',', $cats );
				$query->set( 'cat', $cats );
			}
		}

		/**
		 * Map excluded categories to negatives
		 *
		 * @param string $cat
		 * @return integer
		 */
		private function exclude_category_map( $cat ) {
			$cat = (int) $cat;
			return ( $cat <= 0 ) ? $cat : ( -1 * $cat );
		}

		/**
		 * Customize search post-types
		 *
		 * @param object $query WP_Query
		 */
		public function search_include( $query ) {

			// Set search post types
			$ip_query_search_include = (array) apply_filters( 'ipress_query_search_include', [] );

			// Main query search
			if ( $ip_query_search_include && ! is_admin() && $query->is_main_query() && $query->is_search ) {
				$query->set( 'post_type', [ $ip_query_search_include ] );
			}
		}
	}

endif;

// Instantiate Query Class
return new IPR_Query;
