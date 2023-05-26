<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme ajax functionality.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Ajax' ) ) :

	/**
	 * Set up ajax features
	 */
	final class IPR_Ajax extends IPR_Registry {

		/**
		 * Class constructor, protected, initialise Ajax hooks
		 * 
		 * - wp_ajax_xxx
		 * - wp_ajax_nopriv_xxx
		 */
		protected function __construct() {}

		//----------------------------------------------
		//	Ajax Functionality
		//----------------------------------------------
	}

endif;

// Instantiate Ajax Class
return IPR_Ajax::Init();
