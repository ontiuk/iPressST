<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress url rewrite features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Rewrites' ) ) :

	/**
	 * Set up query rewrite features
	 */
	final class IPR_Rewrites {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Add new query vars
			add_filter( 'query_vars', [ $this, 'query_vars' ], 10, 1 );
		}

		//----------------------------------------------
		//	Query Vars Rules
		//----------------------------------------------

		/**
		 * Add a new query var
		 *
		 * @param array $qvars
		 * @return array
		 */
		public function query_vars( $qvars ) {

			// Filterable query vars
			$ip_query_vars = (array) apply_filters( 'ipress_query_vars', [] );

			// Return modified query vars
			return ( empty( $ip_query_vars ) ) ? $qvars : array_merge( $qvars, array_map( sanitize_title_with_dashes, $ip_query_vars ) );
		}
	}

endif;

// Instantiate Rewrites Class
return new IPR_Rewrites;
