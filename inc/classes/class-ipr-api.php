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

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_API' ) ) :

	/**
	 * Set up WP-REST API functionality
	 */
	final class IPR_API extends IPR_REST {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// REST Actions
			parent::__construct();

			//	Custom API Hooks
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

// Instantiate REST API Class, if required
// return IPR_API::Init();
