<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress redirect features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Redirect' ) ) :

	/**
	 * Set up redirect features
	 */
	final class IPR_Redirect extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {}

		//----------------------------------------------
		//	Redirect Functionality
		//----------------------------------------------
	}

endif;

// Instantiate Redirect Class
return IPR_Redirect::Init();
