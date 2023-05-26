<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for Kirki customizer functionality.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Kirki' ) ) :

	/**
	 * Set up Kirki functionality
	 */
	final class IPR_Kirki extends IPR_Registry {

		/**
		 * Kirki config id, for Kirki pre v4
		 *
		 * @access private
		 * @var string $ip_kirki_config_id default ''
		 */
		private $ip_kirki_config_id = '';

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Set up Kirki telemetry
			add_filter( 'kirki_telemetry', '__return_false' );

			// Initialise Kirki config
			add_action( 'init', [ $this, 'set_config' ] );

			// In initialise
		}

		//---------------------------------------------
		// Kirki Core Functionality
		//---------------------------------------------

		/**
		 * Initialise configuration
		 *
		 * @return void
		 */
		public function set_config() {

			// Check version, if v4 then we don't need this
			$ip_kirki_version = (int) apply_filters( 'ipress_kirki_version', 4 );
			if ( $ip_kirki_version >= 4 ) { return; }

			// Filterable config ID
			$this->ip_kirki_config_id = apply_filters( 'ipress_kirki_config_id', 'ipress_kirki_ID' );
	
			// General configuration for Kirki
			Kirki::add_config( $this->ip_kirki_config_id, [
				'capability'  => 'edit_theme_options',
				'option_type' => 'theme_mod',
			] );
		}
		
		//---------------------------------------------
		// Kirki Customizer Functionality
		//---------------------------------------------
	}

endif;

// Instantiate Kirki Class
return IPR_Kirki::Init();
