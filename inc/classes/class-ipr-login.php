<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress login features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

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
			add_action( 'init', [ $this, 'redirect_login_page' ] );
			add_action( 'wp_login_failed', [ $this, 'custom_login_failed' ] );
			add_filter( 'authenticate', [ $this, 'verify_user_pass' ], 1, 3 );
			add_action( 'wp_logout', [ $this, 'logout_redirect' ] );
		}

		//----------------------------------------------
		//	Custom Login Page
		//----------------------------------------------

		/**
		 * Main redirection of the default login page
		 */
		public function redirect_login_page() {

			// Is the login redirect active?
			$ip_login_page = apply_filters( 'ipress_login_page', false );
			if ( ! $ip_login_page ) {
				return;
			}

			// Construct login URL
			$login_url = esc_url( home_url( '/' ) ) . sanitize_text_field( $ip_login_page );

			// Validate Request parameters
			$ip_request_uri    = ( isset( $_SERVER['REQUEST_URI'] ) ) ? basename( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '';
			$ip_request_method = ( isset( $_SERVER['REQUEST_METHOD'] ) ) ? strtoupper( sanitize_key( $_SERVER['REQUEST_METHOD'] ) ) : '';

			// Perform redirect
			if ( 'wp-login.php' === $ip_request_uri && 'GET' === $ip_request_method ) {
				wp_safe_redirect( $ip_login_url );
				exit;
			}
		}

		/**
		 * Where to go if a login failed
		 */
		public function custom_login_failed() {

			// Is the login redirect active?
			$ip_login_failed_page = apply_filters( 'ipress_login_failed_page', false );
			if ( ! $ip_login_failed_page ) {
				return;
			}

			// Construct login URL & redirect
			$ip_login_url = esc_url( home_url( '/' ) ) . sanitize_text_field( $ip_login_failed_page );

			// Perform safe redirect
			wp_safe_redirect( add_query_arg( [ 'login' => 'failed' ], $ip_login_url ) );
			exit;
		}

		/**
		 * Where to go if any of the fields were empty
		 */
		public function verify_user_pass( $user, $username, $password ) {

			// Is the login redirect active?
			$ip_login_verify_page = apply_filters( 'ipress_login_verify_page', false );
			if ( ! $ip_login_verify_page ) {
				return;
			}

			// Construct login URL & redirect
			$ip_login_url = esc_url( home_url( '/' ) ) . sanitize_text_field( $ip_login_verify_page );

			// Perform safe redirect, if required
			if ( '' === $username || '' === $password ) {
				wp_safe_redirect( add_query_arg( [ 'login' => 'empty' ], $ip_login_url ) );
				exit;
			}
		}

		/**
		 * What to do on logout
		 */
		public function logout_redirect() {

			// Is the login redirect active?
			$ip_login_logout_page = apply_filters( 'ipress_login_logout_page', false );
			if ( ! $ip_login_logout_page ) {
				return;
			}

			// Construct logout URL & redirect
			$ip_login_logout_url = esc_url( home_url( '/' ) ) . sanitize_text_field( $ip_login_logout_page );

			// Perform safe redirect
			wp_safe_redirect( add_query_arg( [ 'login' => 'false' ], $ip_login_logout_url ) );
			exit;
		}
	}

endif;

// Instantiate Login Redirect Class
return new IPR_Login;
