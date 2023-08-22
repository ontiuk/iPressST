<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme blocks functionality.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Blocks' ) ) :

	/**
	 * Set up blocks functionality
	 */
	final class IPR_Blocks extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Enqueue block editor assets
			add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_assets' ] );

			// Add inline styles to the block editor content
			add_filter( 'block_editor_settings_all', [ $this, 'block_editor_settings' ] );
		
		}


		//----------------------------------------------
		//	Blocks Functions
		//----------------------------------------------

		/**
		 * Enqueue block editor assets
		 */
		public function enqueue_block_assets() {}

		/**
		 * Add inline settings & styles to the block editor content
		 *
		 * @param array $editor_settings Current editor settings
		 * @return array $editor_settings 
		 */
		public function block_editor_settings( $editor_settings ) {
			return $editor_settings;
		}
	}

endif;

// Instantiate Blocks class
return IPR_Blocks::Init();
