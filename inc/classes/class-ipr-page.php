<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress page support features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Page' ) ) :

	/**
	 * Set up page support features
	 */
	final class IPR_Page extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Page excerpt & tag support
			add_action( 'init', [ $this, 'page_support' ] );

			// Tags query support
			add_action( 'pre_get_posts', [ $this, 'page_tags_query' ] );

			// Add post types to generic search
			add_action( 'pre_get_posts', [ $this, 'add_cpt_to_search' ] );
		}

		//----------------------------------------------
		// Page Excerpt & Tag Support
		//----------------------------------------------

		/**
		 * Set up page excerpt & tag support
		 */
		public function page_support() {

			// Page excerpt support
			$ip_page_excerpt = (bool) apply_filters( 'ipress_page_excerpt', false );
			if ( true === $ip_page_excerpt ) {
				add_post_type_support( 'page', 'excerpt' );
			}

			// Page tag support
			$ip_page_tags = (bool) apply_filters( 'ipress_page_tags', false );
			if ( true === $ip_page_tags ) {
				register_taxonomy_for_object_type( 'post_tag', 'page' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_register_taxonomy_for_object_type
			}
		}

		/**
		 * Ensure all tags are included in queries
		 *
		 * @param object $query WP_Query
		 */
		public function page_tags_query( WP_Query $wp_query ) {

			// Include tags in query?
			$ip_page_tags_query = (bool) apply_filters( 'ipress_page_tags_query', false );
			if ( true === $ip_page_tags_query && $wp_query->get( 'tag' ) ) {
				$wp_query->set( 'post_type', 'any' );
			}
		}

		/**
		 * Add custom post types to search
		 *
		 * @param object $wp_query WP_Query
		 * @return object $wp_query 
		 */
		public function add_cpt_to_search( WP_Query $wp_query ) {

			// Generate search post types - e.g names from get_post_types( [ 'public' => true, 'exclude_from_search' => false ], 'objects' );
			$ip_search_post_types = (array) apply_filters( 'ipress_search_post_types', [] );
			if ( $ip_search_post_types ) {

				// Check to verify it's search page & add post types to search
				if ( ! is_admin() && $query->is_main_query() && $wp_query->is_search() ) {
					$wp_query->set( 'post_type', array_merge( $ip_search_post_types, [ 'post', 'page' ] ) );
				}
			}

			return $wp_query;
		}
	}

endif;

// Instantiate Page Class
return IPR_Page::Init();
