<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress user features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_User' ) ) :

	/**
	 * Set up user features
	 */ 
	final class IPR_User {

		/**
		 * Class constructor
		 */
		public function __construct() {}

		//----------------------------------------------
		//	User Functionality 
		//----------------------------------------------
	}

endif;

// Instantiate User Class
return new IPR_User;

//end
