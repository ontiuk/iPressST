<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress sidebar areas features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Sidebars' ) ) :

	/**
	 * Set up sidebar areas
	 */
	final class IPR_Sidebars extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Core sidebar initialisation
			add_action( 'widgets_init', [ $this, 'sidebars_init' ] );
		}

		//----------------------------------------------
		// Sidebar Functionality
		//----------------------------------------------

		/**
		 * Set sidebar defaults
		 *
		 * @param array $sidebar Sidebar data
		 * @return array $sidebar
		 */
		private function sidebar_defaults( $sidebar ) {

			// Set default wrappers
			$ip_sidebar_defaults = (array) apply_filters(
				'ipress_sidebar_defaults',
				[
					'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
					'after_widget'  => '</div></section>' . PHP_EOL,
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>' . PHP_EOL,
					'class'         => ( isset( $sidebar['class'] ) ) ? $sidebar['class'] : 'sidebar-' . $sidebar['id'],
				]
			);

			// Filterable sidebar defaults
			$ip_sidebar_defaults = (array) apply_filters( "ipress_sidebar_{$sidebar['id']}_defaults", $ip_sidebar_defaults );

			// Construct sidebar params
			$sidebar = wp_parse_args( $sidebar, $ip_sidebar_defaults );

			return $sidebar;
		}

		/**
		 * Register theme sidebars
		 *
		 * @return array
		 */
		private function register_sidebars() {

			// Default sidebars, default - array of sidebars
			$ip_default_sidebars = (array) apply_filters( 'ipress_default_sidebars', [] );

			// Footer sidebars, default - array of sidebars, or false for numerical
			$ip_footer_sidebars = apply_filters( 'ipress_footer_sidebars', [] );
			if ( false === $ip_footer_sidebars ) {
				$ip_footer_sidebars = $this->footer_sidebars();
			}
			
			// Custom sidebars, hook into externally
			$ip_custom_sidebars = (array) apply_filters( 'ipress_custom_sidebars', [] );

			return array_merge( $ip_default_sidebars, $ip_footer_sidebars, $ip_custom_sidebars );
		}

		/**
		 * Process footer sidebars by row & areas
		 *
		 * @return array $ip_footer_sidebars
		 */
		private function footer_sidebars() {

			// Get footer sidebar settings, default to standard 3 footer sidebar areas
			$ip_footer_sidebar_rows  = (int) apply_filters( 'ipress_footer_sidebar_rows', 1 );
			$ip_footer_sidebar_areas = (int) apply_filters( 'ipress_footer_sidebar_areas', 3 );

			// Default footer sidebars
			$ip_footer_sidebars = [];

			// Process footer sidebars
			for ( $r = 1; $r <= $ip_footer_sidebar_rows; $r++ ) {
				for ( $i = 1; $i <= $ip_footer_sidebar_areas; $i++ ) {

					// Give each footer an ID
					$footer = sprintf( 'footer-%d', $i + ( $ip_footer_sidebar_areas * ( $r - 1 ) ) );

					// Set footer sidebar
					$ip_footer_sidebars[ $footer ] = [
						/* translators: %s: footer ID */
						'name'        => sprintf( __( 'Footer %d', 'ipress' ), $i ),
						/* translators: %s: footer description */
						'description' => sprintf( __( 'Footer sidebar area %d.', 'ipress' ), $i ),
						'class'       => 'sidebar-' . $footer,
					];
				}
			}

			return $ip_footer_sidebars;
		}

		//----------------------------------------------
		// Sidebars Action & Filter Functions
		//----------------------------------------------

		/**
		 * Bootstrap sidebar areas
		 *
		 * @uses register_sidebar()
		 */
		public function sidebars_init() {

			// Get sidebars
			$ip_sidebars = $this->register_sidebars();

			// Register sidebar areas
			array_walk( $ip_sidebars, function( $sidebar, $id ) {

				// Reasign sidebar ID
				$sidebar['id'] = $id;

				// Need name...
				if ( isset( $sidebar['name'] ) && ! empty( $sidebar['name'] ) ) {

					// ...and description
					if ( ! isset( $sidebar['description'] ) || empty( $sidebar['description'] ) ) {
						/* translators: %s: sidebar description */
						$sidebar['description'] = sprintf( __( 'This is the %s sidebar description', 'ipress' ), $sidebar['name'] );
					}

					// Set up defaults for each sidebar
					$sidebar = $this->sidebar_defaults( $sidebar );
	
					// Register sidebar
					register_sidebar( $sidebar );
				}
			} );
		}
	}

endif;

// Instantiate Sidebars Class
return IPR_Sidebars::Init();
