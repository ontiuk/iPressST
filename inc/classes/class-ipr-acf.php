<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Advanced Custom Fields (ACF) Plugin functionality.
 * - Pro v5+ only.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_ACF' ) ) :

	/**
	 * Advanced Custom Fields Plugin Functionality
	 */
	final class IPR_ACF extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Add the theme options page
			add_action( 'init', [ $this, 'acf_options_page' ] );

			// Disable front end functionality if not needed
			add_filter( 'option_active_plugins', [ $this, 'acf_disable_frontend' ] );
		}

		//----------------------------------------------
		//  ACF Functionality
		//----------------------------------------------

		/**
		 * Add ACF Options Page if allowed:
		 *
		 * e.g ipr_acf_pages[]
		 *
		 * 'terms' => [
		 *   'page_title'  => __( 'Terms and Conditions', 'ipress-standalone' ),
		 *   'menu_title'  => __( 'Terms', 'ipress-standalone' ),
		 *   'menu_slug'   => 'ipress-terms',
		 *   'parent_slug' => $parent['menu_slug'],
		 * ],
		 * 'privacy' => [
		 *   'page_title'  => __( 'Privacy Policy', 'ipress-standalone' ),
		 *   'menu_title'  => __( 'Privacy', 'ipress-standalone' ),
		 *   'menu_slug'   => 'ipress-privacy',
		 *   'parent_slug' => $parent['menu_slug'],
		 * ],
		 * 'Shipping' => [
		 *   'page_title'  => __( 'Shipping Policy', 'ipress-standalone' ),
		 *   'menu_title'  => __( 'Shipping', 'ipress-standalone' ),
		 *   'menu_slug'   => 'ipress-shipping',
		 *   'parent_slug' => $parent['menu_slug'],
		 * ],
		 */
		public function acf_options_page() {

			// Check Options Page OK
			if ( ! function_exists( 'acf_add_options_page' ) ) {
				return;
			}

			// Set theme options page title, or turn off
			$ip_acf_title = (string) apply_filters( 'ipress_acf_title', IPRESS_THEME_NAME );
			$ip_acf_capability = (string) apply_filters( 'ipress_acf_capability', 'manage_options' );
			if ( $ip_acf_title && $ip_acf_capability ) {

				// Add Options Page
				$parent = acf_add_options_page(
					[
						'title' => sanitize_text_field( $ip_acf_title ),
						'capability' => sanitize_key( $ip_acf_capability ),
					]
				);

				// Set Options Page Subpages
				$ip_subpages = (array) apply_filters( 'ipress_acf_pages', [], $parent );

				// Add Subpages?
				foreach ( $ip_subpages as $k => $v ) {
					acf_add_options_sub_page( $v );
				}
			}
		}

		/**
		 * Disable ACF on Frontend
		 *
		 * @param array $plugins List of active plugins
		 * @return array $plugins
		 */
		public function acf_disable_frontend( $plugins ) {

			// Frontend only
			if ( is_admin() ) {
				return $plugins;
			}

			// Filterable check
			$ip_acf_disable_frontend = (bool) apply_filters( 'ipress_acf_disable_frontend', false );
			if ( true === $ip_acf_disable_frontend ) {

				// Iterate plugins and remove ACF
				foreach ( $plugins as $i => $plugin ) {
					if ( 'advanced-custom-fields-pro/acf.php' === $plugin ) {
						unset( $plugins[ $i ] );
					}
				}
			}

			return $plugins;
		}
	}

endif;

// Initialise ACF Class
return IPR_ACF::Init();
