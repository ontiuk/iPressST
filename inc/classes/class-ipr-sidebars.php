<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress sidebar widget areas features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Sidebars' ) ) :

	/**
	 * Set up sidebar / widget areas
	 */
	final class IPR_Sidebars {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Core sidebar initialisation
			add_action( 'widgets_init', [ $this, 'sidebars_init' ] );
		}

		//----------------------------------------------
		// Sidebar Functionality
		//----------------------------------------------

		/**
		 * Set sidebar defaults
		 *
		 * @param array $sidebar
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

			// Return sidebar params
			return $sidebar;
		}

		/**
		 * Register theme sidebars
		 *
		 * @return array
		 */
		private function register_sidebars() {

			// Default sidebars
			$ip_default_sidebars = (array) apply_filters(
				'ipress_default_sidebars',
				[
					'primary' => [
						'name'        => __( 'Primary Sidebar', 'ipress' ),
						'description' => __( 'This is the primary sidebar.', 'ipress' ),
						'class'       => 'sidebar-primary',
					],
					'header'  => [
						'name'        => __( 'Header Sidebar', 'ipress' ),
						'description' => __( 'This is the header sidebar.', 'ipress' ),
						'class'       => 'sidebar-header',
					],
				]
			);

			// Footer widgets - default 3, false or 0 for none
			$ip_footer_widget_rows  = (int) apply_filters( 'ipress_footer_widget_rows', 1 );
			$ip_footer_widget_areas = (int) apply_filters( 'ipress_footer_widget_areas', 3 );
			if ( $ip_footer_widget_areas > 0 ) {

				$ip_footer_sidebars = [];

				for ( $r = 1; $r <= $ip_footer_widget_rows; $r++ ) {
					for ( $i = 1; $i <= $ip_footer_widget_areas; $i++ ) {

						$footer = sprintf( 'footer-%d', $i + ( $ip_footer_widget_areas * ( $r - 1 ) ) );

						$ip_footer_sidebars[ $footer ] = [
							/* translators: %s: footer ID */
							'name'        => sprintf( __( 'Footer %d', 'ipress' ), $i ),
							/* translators: %s: footer description */
							'description' => sprintf( __( 'Footer sidebar area %d.', 'ipress' ), $i ),
							'class'       => 'sidebar-' . $footer,
						];
					}
				}
			} else {
				$ip_footer_sidebars = [];
			}

			// Custom widgets
			$ip_custom_sidebars = (array) apply_filters( 'ipress_custom_sidebars', [] );

			// Set default sidebars
			return array_merge( $ip_default_sidebars, $ip_footer_sidebars, $ip_custom_sidebars );
		}

		//----------------------------------------------
		// Sidebars Action & Filter Functions
		//----------------------------------------------

		/**
		 * Kickstart sidebar widget areas
		 *
		 * @global $ipress_sidebars
		 * @uses register_sidebar()
		 */
		public function sidebars_init() {

			// Get sidebars
			$ip_sidebars = $this->register_sidebars();

			// Register widget areas
			foreach ( $ip_sidebars as $id => $sidebar ) {

				// Reasign sidebar ID
				$sidebar['id'] = $id;

				// Need name...
				if ( ! isset( $sidebar['name'] ) || empty( $sidebar['name'] ) ) {
					continue;
				}

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
		}
	}

endif;

// Instantiate Sidebars Class
return new IPR_Sidebars;
