<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress login features.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Login' ) ) :

	/**
	 * Set up login redirect features
	 */ 
	final class IPR_Login {

		/**
		 * Class constructor
		 */
		public function __construct() {
		
			// Login page overrides
			add_action( 'init',					[ $this, 'redirect_login_page' ] );
			add_action( 'wp_login_failed',		[ $this, 'custom_login_failed' ] );
			add_filter( 'authenticate',			[ $this, 'verify_user_pass' ], 1, 3 );
			add_action( 'wp_logout',			[ $this, 'logout_redirect'] );	
		}

		//----------------------------------------------
		//	Custom Login Page
		//----------------------------------------------

		/** 
		 * Main redirection of the default login page 
		 */
		public function redirect_login_page() {
			
			$ip_login_page = (string) apply_filters( 'ipress_login_page', '' );
			if ( empty( $ip_login_page ) ) { return; }

			$ip_login_url  		= trailingslashit( esc_url( home_url( '/' ) . trim( $ip_login_page ) ) );
			$ip_request_uri 	= ( isset( $_SERVER['REQUEST_URI'] ) ) ? basename( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '';
			$ip_request_method 	= ( isset( $_SERVER['REQUEST_METHOD'] ) ) ? strtoupper( sanitize_key( $_SERVER['REQUEST_METHOD'] ) ) : '';

			if ( $ip_request_uri === 'wp-login.php' && $ip_request_method === 'GET' ) {
				wp_redirect( $ip_login_url );
				exit;
			}
		}

		/**
		 * Where to go if a login failed 
		 */
		public function custom_login_failed() {

			$ip_login_failed_page = (string) apply_filters( 'ipress_login_failed_page', '' );
			if ( empty( $ip_login_failed_page ) ) { return; }

			$ip_login_url = trailingslashit( esc_url( home_url( '/' ) . trim( $ip_login_failed_page ) ) );
			wp_redirect( $ip_login_url . '?login=failed' );
			exit;
		}

		/**
		 * Where to go if any of the fields were empty 
		 */
		public function verify_user_pass( $user, $username, $password ) {

			$ip_login_verify_page = (string) apply_filters( 'ipress_login_verify_page', '' );
			if ( empty( $ip_login_verify_page ) ) { return; }

			$ip_login_url = trailingslashit( esc_url( home_url( '/' ) . trim( $ip_login_verify_page ) ) );
			if ( $username == '' || $password == '' ) {
				wp_redirect( $ip_login_url . '?login=empty' );
				exit;
			}
		}

		/**
		 * What to do on logout 
		 */
		public function logout_redirect() {

			$ip_login_logout_page = (string) apply_filters( 'ipress_login_logout_page', '' );
			if ( empty( $ip_login_logout_page ) ) { return; }

			$ip_login_logout_url = trailingslashit( esc_url( home_url( '/' ) . trim( $ip_login_logout_page ) ) );
			wp_redirect( $ip_login_logout_url . '?login=false');
			exit;
		}
	}

endif;

// Instantiate Login Redirect Class
return new IPR_Login;

//end
