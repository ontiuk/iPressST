<?php
/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Advanced Custom Fields (ACF) Plugin functionality.
 * - Pro v5+ only.
 * 
 * @package     iPress\Includes
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

if ( ! class_exists( 'IPR_ACF' ) ) :

	/**
	 * Advanced Custom Fields Plugin Functionality
	 */
	final class IPR_ACF {
		
		/**
		 * Class constructor
		 */
		public function __construct() {

			// Add the theme options page
			add_action( 'init', [ $this, 'acf_options_page' ] ); 
		}

		//----------------------------------------------
		//  ACF Functionality
		//----------------------------------------------

		/**
		 * Add ACF Options Page if allowed: 
		 *
		 *  e.g ipr_acf_pages[]
		 *	
		 *	'terms' => [ 
		 *		'page_title'    => __( 'Terms and Conditions', 'ipress' ),
		 *		'menu_title'    => __( 'Terms', 'ipress' ),
		 *		'menu_slug'     => 'ipress-terms',
		 *		'parent_slug' 	=> $parent['menu_slug']
		 *	],
		 *	'privacy' => [ 
		 *		'page_title'    => __( 'Privacy Policy', 'ipress' ),
		 *		'menu_title'    => __( 'Privacy', 'ipress' ),
		 *		'menu_slug'     => 'ipress-privacy',
		 *		'parent_slug' 	=> $parent['menu_slug']
		 *	],
		 *	'Shipping' => [ 
		 *		'page_title'    => __( 'Shipping Policy', 'ipress' ),
		 *		'menu_title'    => __( 'Shipping', 'ipress' ),
		 *		'menu_slug'     => 'ipress-shipping',
		 *		'parent_slug' 	=> $parent['menu_slug']
		 *	]
		 */
		public function acf_options_page() { 

			// Check ACF Admin OK
			if ( ! $this->admin_acf_active() ) { return; }

			// Check Options Page OK        
			if ( ! function_exists( 'acf_add_options_page' ) ) { return; }

			// Set theme options page title, or turn off
			$ip_acf_title 		= (string) apply_filters( 'ipress_acf_title', 'iPress Child' ); 
			$ip_acf_capability	= (string) apply_filters( 'ipress_acf_capability', 'manage_options' );
			if ( empty( $ip_acf_title ) || empty( $ip_acf_capability ) ) { return; }

			// Add Options Page
			$parent = acf_add_options_page( [  
				'title'      => sanitize_text_field( $ip_acf_title ),
				'capability' => sanitize_key( $ip_acf_capability )
			] ); 

			// Set Options Page Subpages
			$ip_subpages = (array) apply_filters( 'ipress_acf_pages', [], $parent );
	   
			// Add Subpages? 
			foreach ( $ip_subpages as $k => $v ) {
				acf_add_options_sub_page( $v );
			}
		}

		//----------------------------------------------
		//  Other
		//----------------------------------------------    

		/**
		 * Check at admin level if ACF is active
		 *
		 * @return boolean
		 */
		private function admin_acf_active() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			}
			return is_plugin_active( 'advanced-custom-fields-pro/acf.php' ); 
		}

		/**
		 * Front-end check if ACF is active
		 * 
		 * @return boolean
		 */
		private function front_acf_active() {
			return class_exists( 'acf' );
		}
	}

endif;

// Initialise ACF class
return new IPR_ACF();

// End
