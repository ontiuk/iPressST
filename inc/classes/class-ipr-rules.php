<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress rewrite rules features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Rules' ) ) :

	/**
	 * Set up custom rewrite rules
	 */
	final class IPR_Rules extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {}

		//----------------------------------------------
		//	Rewrite Rules
		//----------------------------------------------
	}

endif;

// Instantiate Rewrites Rules Class, if required
// return IPR_Rules::Init();
