<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme core & admin hooks - actions and filters
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Hooks' ) ) :

	/**
	 * Set up theme template hooks
	 */
	final class IPR_Hooks extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			//----------------------------------------------
			//	Core Hooks: Actions & Filters
			//----------------------------------------------

			//----------------------------------------------
			//	Admin UI Hooks: Actions & Filters
			//----------------------------------------------
			
	        // Admin: Add phone number to general settings
    	    add_action( 'admin_init', [ $this, 'register_setting' ], 10 );
		}

		//----------------------------------------------
		//  Core Hook Functions
		//----------------------------------------------

		//----------------------------------------------
		//  Admin UI Functions
		//----------------------------------------------

		/**
		 * Registers a custom field setting
		 */
		public function register_setting() {

			// Filterable option, default false
			$ip_admin_phone_number = apply_filters( 'ipress_admin_phone_number', false );
			if ( true === $ip_admin_phone_number ) {

				// Admin phone text field
				$args = [
					'type'              => 'string', 
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null
				];

				// Register Admin phone field
				register_setting( 'general', 'admin_phone_number', $args ); 

				// Add Admin phone field
				add_settings_field (
					'admin_phone_number',
					'<label for="admin_phone_number">' . __( 'Admin Phone No.' , 'ipress' ) . '</label>',
					[ $this, 'admin_phone_number' ],
					'general'
				);
			}
		}

		/**
		 * Output custom admin phone field
		 */
		public function admin_phone_number() {
			$admin_phone = get_option( 'admin_phone_number' );
			echo sprintf( '<input type="text" id="admin_phone_number" name="admin_phone_number" class="regular-text ltr" value="%s" />', esc_attr( $admin_phone ) );
		}
	}

endif;

// Instantiate Hooks Class
return IPR_Hooks::Init();
