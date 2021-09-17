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

if ( ! class_exists( 'IPR_Widgets' ) ) :

	/**
	 * Initialise and set up widgets
	 */
	final class IPR_Widgets {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Core widget initialisation
			add_action( 'widgets_init', [ $this, 'widgets_init' ] );
		}

		//------------------------------------------
		//	Widget Loading
		//------------------------------------------

		/**
		 * Widget Autoload
		 *
		 * @param string $widget
		 * @return boolean
		 */
		private function widget_autoload( $widget ) {

			// Syntax for widget classname to file
			$ip_classname = 'class-' . trim( str_replace( '_', '-', strtolower( $widget ) ) );

			// Create the actual filepath
			$ip_file_path = ( is_child_theme() ) ? trailingslashit( IPRESS_CHILD_WIDGETS_DIR ) . $ip_classname . '.php' : trailingslashit( IPRESS_WIDGETS_DIR ) . $ip_classname . '.php';

			// Check if the file exists in parent theme
			if ( file_exists( $ip_file_path ) && is_file( $ip_file_path ) ) {
				include_once $ip_file_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound 
				return true;
			}

			// Bad file or path?
			return false;
		}

		/**
		 * Load & Initialise default widgets
		 */
		public function widgets_init() {

			// Contruct widgets list
			$ip_widgets = (array) apply_filters( 'ipress_widgets', [] );

			// Register widgets
			foreach ( $ip_widgets as $widget ) {

				// Load widget file... spl_autoload might be better
				if ( ! $this->widget_autoload( $widget ) ) {
					continue;
				}

				// Register widget
				register_widget( $widget );
			}
		}
	}

endif;

// Instantiate Widgets Class
return new IPR_Widgets;
