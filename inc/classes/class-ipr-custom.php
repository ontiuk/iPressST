<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Initialize theme specific custom post-types and taxonomies.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Custom' ) ) :

	/**
	 * Set up custom post-types & taxonomies
	 */
	abstract class IPR_Custom extends IPR_Registry {

		/**
		 * Post Type Errors
		 *
		 * @var array $post_type_errors
		 */
		protected $post_type_errors = [];

		/**
		 * Taxonomy Errors
		 *
		 * @var array $taxonomy_errors
		 */
		protected $taxonomy_errors = [];

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Display post-type & taxonomy error messages
			add_action( 'admin_notices', [ $this, 'admin_notices' ] );
		}

		// Register post-types & taxonomies
		abstract public function register();

		//----------------------------------------------
		//	Admin Error Notices
		//----------------------------------------------

		/**
		 * Post-Type and Taxonomy Error Notices
		 */
		public function admin_notices() {

			// Post-Type Errors?
			if ( $this->post_type_errors ) {

				// Set error notice message
				$message = sprintf(
					/* translators: %s: Post type errors */
					__( 'Error: Bad Post Types [%s].', 'ipress-standalone' ),
					join( ', ', $this->post_type_errors )
				);

				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
			}

			// Taxonomy Errors?
			if ( $this->taxonomy_errors ) {

				// Set error notice message
				$message = sprintf(
					/* translators: %s: Taxonomy errors */
					__( 'Error: Bad Taxonomies [%s].', 'ipress-standalone' ),
					join( ', ', $this->taxonomy_errors )
				);

				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
			}
		}

		//----------------------------------------------
		//	Sanitization functions
		//----------------------------------------------

		/**
		 * Sanitize register arguments
		 *
		 * @param array $args Args passed via config settings
		 * @return array $args
		 */
		abstract protected function sanitize_args( $args );

		/**
		 * Validate register arguments
		 *
		 * @param array $args The pre-processed list of args for post-type or taxonomy registration
		 * @param string $key  The current post-type or taxonomy key
		 * @param string $singular The singular post-type or taxonomy name
		 * @param string $plural The plural post-type or taxonomy name
		 * @return array $args
		 */
		abstract protected function validate_args( $args, $key, $singular, $plural );

		/**
		 * Sanitize singular post-type or taxonomy
		 *
		 * @param string $key Post-type or taxonomy name
		 * @param array $args Args for post-type or taxonomy registration
		 * @return string
		 */
		protected function sanitize_singular( $key, $args ) : string {
			return ( isset( $args['singular'] ) && ! empty( $args['singular'] ) ) ? sanitize_text_field( $args['singular'] ) : ucwords( str_replace( [ '-', '_' ], ' ', $key ) );
		}

		/**
		 * Sanitize plural post-type or taxonomy
		 *
		 * @param string $singular post-type or taxonomy singular name
		 * @param array $args Args for post-type or taxonomy registration
		 * @return string
		 */
		protected function sanitize_plural( $singular, $args ) : string {
			return ( isset( $args['plural'] ) && ! empty( $args['plural'] ) ) ? $args['plural'] : $singular . 's';
		}

		/**
		 * Sanitize post_types & taxonomy keys
		 *
		 * @param string $key Post-type or taxonomy key
		 * @return string
		 */
		protected function sanitize_key_with_dashes( $key ) : string {
			return sanitize_key( str_replace( ' ', '_', $key ) );
		}

		/**
		 * Sanitize support
		 *
		 * @param array $support List of properties to support
		 * @return array $support
		 */
		protected function sanitize_support( $support ) : array {

			// Valid suppport options
			$supports = [
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'trackbacks',
				'custom-fields',
				'comments',
				'revisions',
				'page-attributes',
				'post-formats',
			];
			
			// Sanitize support
			$support = array_filter( $support, function( $item, $key ) use ( $supports ) {
				return in_array( $item, $supports, true );
			}, ARRAY_FILTER_USE_BOTH );

			// Return sanitized values
			return $support;
		}

		/**
		 * Sanitize capabilities
		 *
		 * @param mixed $caps List of capabilities
		 * @param boolean $meta Meta capabilities?
		 * @param boolean $term Term capabilities?
		 * @return array $caps
		 */
		protected function sanitize_capabilities( $caps, $meta = false, $term = false ) : array {

			// Valid capabilities
			$post_capabilities = [
				'edit_post',
				'read_post',
				'delete_post',
				'edit_posts',
				'edit_others_posts',
				'publish_posts',
				'read_private_posts',
			];

			// Terms capabilities
			$term_capabilities = [
				'manage_terms',
				'edit_terms',
				'delete_terms',
				'assign_terms',
			];

			// Valid meta capabilities
			$meta_caps = [
				'read',
				'delete_posts',
				'delete_private_posts',
				'delete_published_posts',
				'delete_others_posts',
				'edit_private_posts',
				'edit_published_posts',
				'create_posts',
			];

			// Set capabilities
			$capabilities = ( true === $term ) ? $term_capabilities : ( ( true === $meta ) ? array_merge( $meta_caps, $post_capabilities ) : $post_capabilities );

			// Sanitize capabilities
			return array_filter( $caps, function( $key ) use ( $capabilities ) {
				return in_array( $key, $capabilities );
			}, ARRAY_FILTER_USE_KEY );
		}

		/**
		 * Sanitize argument as boolean, default false
		 *
		 * @param mixed $arg Value to check
		 */
		protected function sanitize_bool( $arg ) : bool {
			return ( is_bool( $arg ) ) ? $arg : false;
		}

		/**
		 * Sanitize argument as bool or string
		 *
		 * @param mixed $arg Value to check
		 * @return bool|string
		 */
		protected function sanitize_string_or_bool( $arg ) : string|bool {
			return ( is_bool( $arg ) ) ? $arg : sanitize_text_field( $arg );
		}

		/**
		 * Sanitize argument as bool or string, with array key check
		 *
		 * @param mixed $arg Value to check
		 * @param array $keys Valid string options
		 * @return bool|string
		 */
		protected function sanitize_string_or_bool_keys( $arg, $keys ) : string|bool {
			return ( is_bool( $arg ) ) ? $arg : ( ( in_array( $arg, $keys ) ) ? $arg : false );
		}

		/**
		 * Sanitize argument as string or svg:base64
		 *
		 * @param mixed $arg Value to check
		 * @return string
		 */
		protected function sanitize_string_or_svg( $arg) : string {
			return ( preg_match( '/^data:image/', $arg ) ) ? esc_attr( $arg ) : sanitize_text_field( $arg );
		}

		/**
		 * Sanitize argument as bool or array
		 *
		 * @param mixed $arg Value to check
		 * @return bool|string
		 */
		protected function sanitize_bool_or_array( $arg ) : bool|array {
			return ( is_bool( $arg ) ) ? $arg : ( empty( $arg ) ? [] : (array) $arg );
		}

		/**
		 * Sanitize argument as bool or array
		 *
		 * @param mixed $arg Value to check
		 * @param array $keys Optional keys to check
		 * @return bool|string
		 */
		protected function sanitize_bool_or_array_keys( $arg, $keys = [] ) : bool|array {
			return ( is_bool( $arg ) ) ? $arg : ( is_array( $arg ) ? array_filter( $arg, function( $key ) use ( $keys ) {
				return array_key_exists( $key, $keys );
			}, ARRAY_FILTER_USE_KEY ) : [] );
		}

		/**
		 * Sanitize argument as integer
		 *
		 * @param mixed $arg Value to check
		 * @param bool $null Allow null
		 * @param integer $integer Integer default
		 * @return integer|null
		 */
		protected function sanitize_integer( $arg, $null = true, $integer = 0 ) : ?int {
			return ( is_integer( $arg ) ) ? $arg : ( ( $null ) ? null : intval( $integer ) );
		}

		/**
		 * Sanitize argument as integer, absint values
		 *
		 * @param mixed $arg Value to check
		 * @param bool $null Allow null
		 * @param integer $integer Integer default
		 * @return integer|null
		 */
		protected function sanitize_abs_integer( $arg, $null = true, $integer = 0 ) : ?int {
			return ( is_integer( $arg ) ) ? absint( $arg ) : ( ( $null ) ? null : absint( $integer ) );
		}

		/**
		 * Sanitize argument as string or array
		 *
		 * @param mixed $arg Value to check
		 * @param string $str default string
		 * @return string|array
		 */
		protected function sanitize_string_or_array( $arg, $str = '' ) : string|array {
			return ( is_string( $arg ) || is_array( $arg ) ) ? $arg : $str;
		}

		/**
		 * Sanitize argument as array
		 *
		 * @param mixed $arg Value to check
		 * @return string|array
		 */
		protected function sanitize_array( $arg ) : array {
			return ( is_array( $arg ) ) ? $arg : [];
		}
	}

endif;
