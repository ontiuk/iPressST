<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme admin UI functionality.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Admin' ) ) :

	/**
	 * Set up admin functionality
	 */
	final class IPR_Admin extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {}

		//----------------------------------------------
		//	Admin UI Functions
		//----------------------------------------------
	}

endif;

// Instantiate Admin Class, if required
// return IPR_Admin::Init();
