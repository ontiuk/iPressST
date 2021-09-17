<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme specific WP-REST API functionality in-absentia of plugin.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_API' ) ) :

	/**
	 * Set up WP-REST API functionality
	 */
	final class IPR_API {

		/**
		 * Class constructor
		 */
		public function __construct() {

			//	REST API Endpoints
			add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
		}

		//----------------------------------------------
		//	REST API Endpoints
		//----------------------------------------------

		/**
		 * Register rest routes
		 */
		public function register_rest_route() {}

		//----------------------------------------------
		//	REST API Functionality
		//----------------------------------------------
	}

endif;

// Instantiate REST API Class
return new IPR_API;
