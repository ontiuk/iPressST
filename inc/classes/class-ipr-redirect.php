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
	final class IPR_Redirect {

		/**
		 * Class constructor
		 */
		public function __construct() {}

		//----------------------------------------------
		//	Redirect Functionality
		//----------------------------------------------
	}

endif;

// Instantiate Redirect Class
return new IPR_Redirect;
