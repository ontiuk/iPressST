<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme core & admin hooks - actions and filters
 * 
 * @package     iPress\Includes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

if ( ! class_exists( 'IPR_Hooks' ) ) :

	/**
	 * Set up theme template hooks
	 */ 
	final class IPR_Hooks {

		/**
		 * Class constructor
		 */
		public function __construct() {

			//----------------------------------------------
			//	Core Hooks: Actions & Filters
			//----------------------------------------------

			//----------------------------------------------
			//	Admin UI Hooks: Actions & Filters
			//----------------------------------------------
		}

	    //----------------------------------------------
	    //  Core Hook Functions
    	//----------------------------------------------

		//----------------------------------------------
		//  Admin UI Functions
		//----------------------------------------------
	}

endif;

// Instantiate Hooks Class
return new IPR_Hooks;

//end
