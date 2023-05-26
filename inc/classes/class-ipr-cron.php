<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress cron features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Cron' ) ) :

	/**
	 * Set up cron functionality
	 */
	final class IPR_Cron extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {}

		//----------------------------------------------
		//	Cron Functionality
		//----------------------------------------------
	}

endif;

// Instantiate Cron Class
return IPR_Cron::Init();
