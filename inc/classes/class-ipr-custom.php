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
	abstract class IPR_Custom {

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
		 * Class constructor
		 */
		public function __construct() {

			// Display post-type & taxonomy error messages
			add_action( 'admin_notices', [ $this, 'admin_notices' ] );
		}

		//----------------------------------------------
		//	Admin Error Notices
		//----------------------------------------------

		/**
		 * Post-Type and Taxonomy Error Notices
		 */
		public function admin_notices() {

			// Post-Type Errors
			if ( ! empty( $this->post_type_errors ) ) {

				$message = sprintf(
					/* translators: %s: Post type errors */
					__( 'Error: Bad Post Types [%s].', 'ipress' ),
					join( ', ', $this->post_type_errors )
				);

				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
			}

			// Taxonomy Errors
			if ( ! empty( $this->taxonomy_errors ) ) {

				$message = sprintf(
					/* translators: %s: Taxonomy errors */
					__( 'Error: Bad Taxonomies [%s].', 'ipress' ),
					join( ', ', $this->taxonomy_errors )
				);

				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
			}
		}

		//----------------------------------------------
		//	Sanitization functions
		//----------------------------------------------

		/**
		 * Sanitize post_types & taxonomy keys
		 *
		 * @param string $key
		 * @return string
		 */
		protected function sanitize_key_with_dashes( $key ) {
			return sanitize_key( str_replace( ' ', '_', $key ) );
		}

		/**
		 * Sanitize support
		 *
		 * @param array $support
		 * @return array $support
		 */
		protected function sanitize_support( &$support ) {

			// Valid suppport
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

			// Sanitize
			foreach ( $support as $k => $v ) {
				if ( ! in_array( $v, $supports, true ) ) {
					unset( $support[ $k ] );
				}
			}

			// Return sanitized values
			return $support;
		}

		/**
		 * Sanitize capabilities
		 *
		 * @param mixed $caps
		 * @param boolean $meta
		 * @param boolean $term
		 */
		protected function sanitize_capabilities( &$caps, $meta = false, $term = false ) {

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

			// terms capabilities
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

			// Sanitize
			foreach ( $caps as $k => $v ) {
				if ( ! in_array( $k, $capabilities, true ) ) {
					unset( $caps[ $k ] );
				}
			}
		}

		/**
		 * Sanitize argument as bool
		 *
		 * @param mixed $arg
		 * @return bool$ arg
		 */
		protected function sanitize_bool( $arg ) {
			return (bool) $arg;
		}

		/**
		 * Sanitize argument as bool or string
		 *
		 * @param mixed $arg
		 * @return bool|string
		 */
		protected function sanitize_string_or_bool( $arg ) {
			return ( is_bool( $arg ) ) ? $arg : sanitize_text_field( $arg );
		}

		/**
		 * Sanitize argument as bool or array
		 *
		 * @param mixed $arg
		 * @return bool|string
		 */
		protected function sanitize_bool_or_array( $arg ) {
			return ( is_bool( $arg ) ) ? $arg : (array) $arg;
		}

		/**
		 * Sanitize argument as integer
		 *
		 * @param mixed $arg
		 * @param bool $null
		 * @param integer $integer
		 * @return integer|null
		 */
		protected function sanitize_integer( $arg, $null = true, $integer = 0 ) {
			return ( is_integer( $arg ) ) ? absint( $arg ) : ( ( $null ) ? null : absint( $integer ) );
		}

		/**
		 * Sanitize argument as string or array
		 *
		 * @param mixed $arg
		 * @return string|array
		 */
		protected function sanitize_string_or_array( $arg, $str = '' ) {
			return ( is_string( $arg ) || is_array( $arg ) ) ? $arg : $str;
		}

		/**
		 * Sanitize argument as array
		 *
		 * @param mixed $arg
		 * @return string|array
		 */
		protected function sanitize_array( $arg ) {
			return ( is_array( $arg ) && ! empty( $arg ) ) ? $arg : null;
		}
	}

endif;
