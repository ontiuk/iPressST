<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme compatibility functionality.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Compat' ) ) :

	/**
	 * Initialise and set up theme compatibility functionality.
	 *
	 * - WP version check
	 * - PHP version check
	 * - Child theme check
	 */
	final class IPR_Compat extends IPR_Registry {

		/**
		 * Versioning error
		 *
		 * @var boolean $version_error default false
		 */
		private $version_error = false;

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			global $wp_version;

			// Set up versioning
			$ip_theme_php = (string) apply_filters( 'ipress_theme_php', IPRESS_THEME_PHP );
			$ip_theme_wp  = (string) apply_filters( 'ipress_theme_wp', IPRESS_THEME_WP );

			// PHP versioning check, using operator, bool return
			if ( version_compare( phpversion(), $ip_theme_php, '<' ) ) {

				// Prevent switching & activation
				add_action( 'after_switch_theme', [ $this, 'switch_theme_php' ] );

				// Set the version error
				$this->version_error = true;
			}

			// WP versioning check, using operator, bool return
			if ( version_compare( $wp_version, $ip_theme_wp, '<' ) ) {

				// Prevent switching & activation
				add_action( 'after_switch_theme', [ $this, 'switch_theme_wp' ] );

				// Prevent the customizer from being loaded
				add_action( 'load-customize.php', [ $this, 'theme_customizer' ] );

				// Prevent the theme preview from being loaded
				add_action( 'template_redirect', [ $this, 'theme_preview' ] );

				// Set the version error
				$this->version_error = true;
			}

			// Check to make sure a child theme is not used
			if ( is_child_theme() ) {

				// Set admin notice for invalid Child Theme
				add_action( 'admin_notices', [ $this, 'child_theme_notice' ] );

				// Set the version error
				$this->version_error = true;
			}
		}

		//----------------------------------------------
		//	PHP Version Control
		//----------------------------------------------

		/**
		 * Process theme switching version control
		 */
		public function switch_theme_php() {

			// Action switch & admin notice
			switch_theme( WP_DEFAULT_THEME );
			unset( $_GET['activated'] );
			add_action( 'admin_notices', [ $this, 'version_notice_php' ] );
		}

		/**
		 * Adds a message for unsuccessful theme switch if version prior to theme required
		 */
		public function version_notice_php() {

			// Set version notice message
			$message = sprintf(
				/* translators: 1. Required PHP version, 2. Current PHP version. */
				__( 'PHP version <strong>%1$s</strong> is required You are using <strong>%2$s</strong>. Please update or contact your hosting company.', 'ipress' ),
				phpversion(),
				IPRESS_THEME_PHP
			);

			echo sprintf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
		}

		//----------------------------------------------
		//	WordPress Version Control
		//----------------------------------------------

		/**
		 * Process theme switching version control
		 */
		public function switch_theme_wp() {

			// Action switch & admin notice
			switch_theme( WP_DEFAULT_THEME );
			unset( $_GET['activated'] );
			add_action( 'admin_notices', [ $this, 'version_notice_wp' ] );
		}

		/**
		 * Adds a message for unsuccessful theme switch if version prior to theme required
		 *
		 * @global string $wp_version WordPress version
		 */
		public function version_notice_wp() {

			global $wp_version;

			// Set version notice message
			$message = sprintf(
				/* translators: 1. Required WordPress version, 2. Current WordPress version. */
				__( 'iPress requires at least WordPress version %1$s. You are running version %2$s.', 'ipress' ),
				IPRESS_THEME_WP,
				$wp_version
			);

			echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
		}

		/**
		 * Prevents the Customizer from being loaded on WordPress versions prior to theme required
		 *
		 * @global string $wp_version WordPress version
		 */
		public function theme_customizer() {

			global $wp_version;

			// Set version notice message
			$message = sprintf(
				/* translators: 1. Required WordPress version, 2. Current WordPress version. */
				__( 'iPress requires at least WordPress version %1$s. You are running version %2$s.', 'ipress' ),
				IPRESS_THEME_WP,
				$wp_version
			);

			wp_die( esc_html( $message ), '', [ 'back_link' => true ] );
		}

		/**
		 * Prevents the Theme Preview from being loaded on WordPress versions prior to theme required
		 *
		 * @global string $wp_version WordPress version
		 */
		public function theme_preview() {

			global $wp_version;

			// Only apply if in preview mode
			if ( isset( $_GET['preview'] ) ) {

				// Set version notice message
				$message = sprintf(
					/* translators: 1. Required WordPress version, 2. Current WordPress version. */
					__( 'iPress requires at least WordPress version %1$s. You are running version %2$s.', 'ipress' ),
					IPRESS_THEME_WP,
					$wp_version
				);

				wp_die( esc_html( $message ) );
			}
		}

		//----------------------------------------------
		//	WordPress Theme Control
		//----------------------------------------------

		/**
		 * Adds a message if a child theme is not being used. i.e. Parent theme is active
		 */
		public function child_theme_notice() {
			$message = __( 'iPress Child Theme is active. This theme is intended for standalone use.', 'ipress' );
			echo sprintf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
		}

		//----------------------------------------------
		//	Version Error
		//----------------------------------------------

		/**
		 * Get the version error
		 */
		public function get_error() : bool {
			return $this->version_error;
		}
	}

endif;

// Instantiate Compatibility Class
return IPR_Compat::Init();
