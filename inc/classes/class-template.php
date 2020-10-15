<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress template features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Template' ) ) :

	/**
	 * Set up template & template heirarchy features
	 * - hook: template_include
	 * - hook: template_redirect
	 */ 
	final class IPR_Template {

		/**
		 * Class constructor
		 */
		public function __construct() {}

		//---------------------------------------------
		// Theme Template Functionality  
		//---------------------------------------------
	}

endif;

// Instantiate Template Class
return new IPR_Template;

//end
