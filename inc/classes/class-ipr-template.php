<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress template features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Template' ) ) :

	/**
	 * Set up template & template heirarchy features
	 * - hook: template_include
	 * - hook: template_redirect
	 */
	final class IPR_Template extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Custom template attributes
			add_filter( 'ipress_parse_attr', [ $this, 'parse_attr' ], 10, 3 );
		}

		//---------------------------------------------
		// Theme Template Functionality
		//---------------------------------------------
		
		/**
		 * Parse the custom attributes
		 *
		 * @param array $attr Context attributes
		 * @param string $context Attribute context
		 * @param array $settings Custom context settings
		 */
		public function parse_attr( $attr, $context, $settings ) {}
	}

endif;

// Instantiate Template Class, if required
// return IPR_Template::Init();
