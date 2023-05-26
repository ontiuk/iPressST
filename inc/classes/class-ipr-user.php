<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress user features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_User' ) ) :

	/**
	 * Set up user features
	 */
	final class IPR_User extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {}

		//----------------------------------------------
		//	User Functionality
		//----------------------------------------------
	}

endif;

// Instantiate User Class
return IPR_User::Init();
