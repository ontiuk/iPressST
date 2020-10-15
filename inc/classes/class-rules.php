<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress rewrite rules features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Rules' ) ) :

	/**
	 * Set up custom rewrite rules 
	 */ 
	final class IPR_Rules {

		/**
		 * Class constructor
		 */
		public function __construct() {}

		//----------------------------------------------
		//	Rewrite Rules
		//----------------------------------------------
	}

endif;

// Instantiate Rewrites Rules Class
return new IPR_Rules;

//end
