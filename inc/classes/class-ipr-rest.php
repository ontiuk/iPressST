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

if ( ! class_exists( 'IPR_REST' ) ) :

	/**
	 * Set up WP-REST API functionality
	 */
	abstract class IPR_REST extends IPR_Registry {

		/**
		 * REST API Version
		 *
		 * @access protected
		 * @var string
		 */
		protected $version = 'v1';

		/**
		 * Class constructor, protected, set hooks
		 * 
		 * @access protected
		 */
		protected function __construct() {

			//	REST API Endpoints
			add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
		}

		//----------------------------------------------
		//	REST API Endpoints
		//----------------------------------------------

		/**
		 * Register rest routes
		 */
		abstract public function register_rest_route();

		//----------------------------------------------
		//	REST API Functionality
		//----------------------------------------------
			
		/**
		 * Get administrative edit options permissions
		 */
		public function update_settings_permission() : bool {
			return current_user_can( 'manage_options' );
		}

		/**
		 * Wrapper for successful REST API call
		 *
		 * @param mixed $response REST response data
		 * @return object
		 */
		public function success( $response ) {
			return new WP_REST_Response(
				[
					'success'  => true,
					'response' => $response,
				],
				200
			);
		}

		/**
		 * Wrapper for failed REST API call
		 *
		 * @param mixed $response REST response data
		 * @return object
		 */
		public function failure( $response ) {
			return new WP_REST_Response(
				[
					'success'  => false,
					'response' => $response,
				],
				200
			);
		}

		/**
		 * Wrapper for errored REST API call
		 *
		 * @param mixed $code error code
		 * @param mixed $response response data
		 * @return object
		 */
		public function error( $code, $response ) {
			return new WP_REST_Response(
				[
					'error'      => true,
					'success'    => false,
					'error_code' => $code,
					'response'   => $response,
				],
				401
			);
		}
	}

endif;
