<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme ajax functionality.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Ajax' ) ) :

	/**
	 * Set up ajax features
	 */ 
	final class IPR_Ajax {

		/**
		 * Class constructor
		 */
		public function __construct() {

			/**
			 * Initialise Ajax hooks
			 * 
			 * - wp_ajax_xxx 
			 * - wp_ajax_nopriv_xxx
			 */
		}
			
		//----------------------------------------------
		//	Ajax Functionality
		//----------------------------------------------
	}

endif;

// Instantiate Ajax Class
return new IPR_Ajax;

//end
