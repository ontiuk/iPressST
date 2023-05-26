<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress widget features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Widgets' ) ) :

	/**
	 * Initialise and set up widgets
	 */
	final class IPR_Widgets extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Core widget initialisation
			add_action( 'widgets_init', [ $this, 'widgets_init' ] );
		}

		//------------------------------------------
		//	Widget Loading
		//------------------------------------------

		/**
		 * Widget Autoload
		 *
		 * @param string $widget Widget data
		 * @return boolean
		 */
		private function widget_autoload( $widget ) {

			// Syntax for widget classname to file
			$ip_classname = 'class-' . trim( str_replace( '_', '-', strtolower( $widget ) ) );

			// Create the actual filepath
			$ip_file_path = IPRESS_INCLUDES_DIR	. '/widgets/' . $ip_classname . '.php';

			// Check if the file exists in parent theme
			if ( file_exists( $ip_file_path ) && is_file( $ip_file_path ) ) {
				include_once $ip_file_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound 
				return true;
			}

			return false;
		}

		/**
		 * Load & Initialise default widgets
		 *
		 * @uses register_widget()
		 */
		public function widgets_init() {

			// Contruct widgets list
			$ip_widgets = (array) apply_filters( 'ipress_widgets', [] );

			// Register widgets if config ok
			foreach ( $ip_widgets as $widget ) {
				if ( $this->widget_autoload( $widget ) ) {
					register_widget( $widget );
				}
			}
		}
	}

endif;

// Instantiate Widgets Class
return IPR_Widgets::Init();
