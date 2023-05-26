<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme specific WooCommerce WP-REST API functionality in-absentia of plugin.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_WooCommerce_API' ) ) :

	/**
	 * Set up WooCommerce specific WP-REST API functionality
	 */
	final class IPR_WooCommerce_API extends IPR_REST {

		/**
		 * Class constructor
		 */
		public function __construct() {
			
			// Initiate REST actions
			parent::__construct();
			
			//	Custom REST API hooks
		}

		//----------------------------------------------
		//	REST API Endpoints
		//----------------------------------------------

		/**
		 * Register rest routes
		 *
		 * register_rest_route(
		 *   $namespace,
		 *   '/endpoint/',
		 *   [
		 *     'methods' => WP_REST_Server::EDITABLE,
		 *     'callback' => [ $this, 'endpoint' ],
		 *     'permission_callback' => [ $this, 'update_settings_permission' ],
		 *   ]
		 * );
		 */
		public function register_rest_route() {

			// Initialise namespace
			$namespace = IPRESS_THEME_NAMESPACE . '/' . $this->version;

			// Register REST Routes
		}

		//----------------------------------------------
		//	REST API Endpoint Functionality
		//----------------------------------------------
	}

endif;

// Instantiate REST API Class
return IPR_WooCommerce_API::Init();
