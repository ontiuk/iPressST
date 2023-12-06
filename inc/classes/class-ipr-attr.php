<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme HTML attributes functionality.
 *
 * - Optional: Not implemented in template files
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Attr' ) ) :

	/**
	 * Set up HTML attributes & classes functionality
	 */
	final class IPR_Attr extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {
		
			// Parse Attributes
			add_filter( 'ipress_parse_attr', [ $this, 'parse_attributes' ], 10, 3 );

			// Set context classes by element
			//add_filter( 'ipress_element-xxx_class', [ $this, 'element_xxx_classes' ] );
		}

		//----------------------------------------------
		//	Attributes Functions
		//----------------------------------------------

		/**
		 * Parse attributes
		 *
		 * @param array  $attributes Attribute list
		 * @param string $context Context element
		 * @param array  $settings Custom settings
		 */
		public function parse_attributes( $attributes, $context, $settings ) {

			// Set attributes by context element
			switch ( $context ) {
				case 'element_xxx':
					return $this->element_xxx( $attributes );
				default: //NOWORK
			}

			return $attributes;
		}

		//----------------------------------------------
		//	Element Attributes Functions
		//----------------------------------------------

		/**
		 * Generate custom attributes for element context
		 *
		 * @param array $attributes Current attributes
		 * @return array $attributes
		 */
		public function element_xxx( $attributes ) {
			return $attributes;
		}

		//----------------------------------------------
		//	Context Classes Functions
		//----------------------------------------------

		/**
		 * Generate custom classes for element context
		 *
		 * @param array $classes Current element classes
		 * @return array $classes
		 */
		public function element_xxx_classes( $classes ) {
			return $classes;
		}
	}

endif;

// Instantiate Attr Class, if required
// return IPR_Attr::Init();
