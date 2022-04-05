<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Initialize theme specific custom post-types.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

// Load parent class
require_once IPRESS_CLASSES_DIR . '/class-ipr-custom.php';

if ( ! class_exists( 'IPR_Post_Type' ) ) :

	/**
	 * Set up custom post-types
	 */
	final class IPR_Post_Type extends IPR_Custom {

		/**
		 * Reserved post_type names
		 *
		 * @var array $post_type_reserved
		 */
		private $post_type_reserved = [
			'post',
			'page',
			'attachment',
			'revision',
			'nav_menu_item',
			'custom_css',
			'customize_changeset',
			'oembed_cache',
			'user_request',
			'p_block',
			'action',
			'author',
			'order',
			'theme',
		];

		/**
		 * Valid optional args - description as unique arg
		 *
		 * @var array $post_type_valid
		 */
		private $post_type_valid = [
			'label',
			'labels',
			'public',
			'exclude_from_search',
			'publicly_queryable',
			'show_ui',
			'show_in_nav_menus',
			'show_in_menu',
			'show_in_admin_bar',
			'menu_position',
			'menu_icon',
			'capability_type',
			'capabilities',
			'map_meta_cap',
			'hierarchical',
			'supports',
			'register_meta_box_cb',
			'taxonomies',
			'has_archive',
			'rewrite',
			'query_var',
			'can_export',
			'delete_with_user',
			'show_in_rest',
			'rest_base',
			'rest_controller_class',
		];

		/**
		 * Built-in, do not use here
		 *
		 * @var array $post_type_invalid
		 */
		private $post_type_invalid = [
			'_builtin',
			'_edit_link',
		];

		/**
		 * Post-Types
		 *
		 * @var array $post_types
		 */
		protected $post_types = [];

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Register parent hooks
			parent::__construct();

			// Generate & register custom post-types
			add_action( 'init', [ $this, 'init' ], 0 );

			// Generate & register custom post-types
			add_action( 'init', [ $this, 'register_post_types' ], 3 );

			// Callback for post update
			add_filter( 'post_updated_messages', [ $this, 'messages' ] );

			// Contextual screen help tab content
			add_action( 'load-edit.php', [ $this, 'contextual_help_tabs' ] );
			add_action( 'load-post.php', [ $this, 'contextual_help_tabs' ] );
		}

		//----------------------------------------------
		//	Initialise Post-Types
		//----------------------------------------------

		/**
		 * Initialize post-types & post-type restrictions
		 */
		public function init() {

			// Register post-types
			$this->post_types = (array) apply_filters( 'ipress_post_types', [] );

			// Update reserved post-types with custom values e.g. from 3rd party products
			$this->post_type_reserved = (array) apply_filters( 'ipress_post_type_reserved', $this->post_type_reserved );

			// Update optional args list - e.g. remove args if needed
			$this->post_type_valid = (array) apply_filters( 'ipress_post_type_valid_args', $this->post_type_valid );
		}

		//----------------------------------------------
		//	Register Post-Types
		//----------------------------------------------

		/**
		 * Register Custom Post-Type
		 * 
		 * @see https://codex.wordpress.org/Function_Reference/register_post_type
		 *
		 * $post_types = [
		 *   'cpt' => [
		 *     'singular' => __( 'CPT', 'ipress' ),
		 *     'plural' => __( 'CPTs', 'ipress' ),
		 *     'args' => [
		 *     		'description' => __( 'This is the CPT post-type', 'ipress ),
		 *     		'supports'    => [ 'title', 'editor', 'thumbnail' ],
		 *     		'taxonomies   => [ 'cpt_tax' ],
		 *     ],
		 *   ],
		 * ];
		 */
		public function register_post_types() {

			// Iterate custom post-types...
			foreach ( $this->post_types as $k => $args ) {

				// Basic key overrides: no spaces, translate to underscores
				$post_type = sanitize_key( str_replace( ' ', '_', $k ) );

				// Generate post-type prefix if required
				$ip_post_type_prefix = (string) apply_filters( "ipress_{$post_type}_prefix", '' );

				// Sanitize post-type... [a-z_-] only, with or without prefix
				$post_type = ( empty( $ip_post_type_prefix ) ) ? $post_type : sanitize_key( $ip_post_type_prefix . $post_type );

				// Validate the post-type, or set error
				if ( false === $this->validate_post_type( $post_type ) ) {
					continue;
				}

				// Set up singluar & plural labels
				$singular = $this->sanitize_singular( $post_type, $args );
				$plural = $this->sanitize_plural( $singular, $args );
				
				// Set up post-type args
				$args = $this->sanitize_args( $args );	

				// Validate post-type args
				$args = $this->validate_args( $args, $post_type, $singular, $plural );

				// Register new post-type
				register_post_type( $post_type, $args ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_register_post_type
			}
		}

		//----------------------------------------------
		//	Validation & Sanitization Functions
		//----------------------------------------------

		/**
		 * Validate post_type against reserved or invalid post-type names
		 *
		 * @param string $post_type
		 * @return boolean true if valid false if invalid
		 */
		private function validate_post_type( $post_type ) {

			// Sanity checks - reserved words and max post-type length (20 chars max)
			if ( in_array( $post_type, $this->post_type_reserved, true ) || strlen( $post_type ) > 20 ) {
				$this->post_type_errors[] = $post_type;
				return false;
			}
			return true;
		}

		/**
		 * Validate post_type args
		 *
		 * @param array $args
		 * @param string $post_type
		 * @param string $singular
		 * @param string $plural
		 * @return array $args
		 */
		private function validate_args( $args, $post_type, $singular, $plural ) {

			// Set up post-type labels
			$post_type_labels = $this->post_type_labels( $args, $post_type, $singular, $plural );

			// Set up post-type support
			$post_type_support = $this->post_type_support( $args, $post_type );

			// Set up taxonomies
			$taxonomies = $this->post_type_taxonomies( $args );

			// Set up description
			$post_type_description = $this->post_type_description( $args, $singular );

			// Set up availability
			$public = $this->post_type_availability( $args );

			// Validate: hierarchical : boolean
			if ( isset( $args['hierarchical'] ) ) {
				$args['hierarchical'] = $this->sanitize_bool( $args['hierarchical'] );
			}

			// Validate: exclude_from_search : boolean
			if ( isset( $args['exclude_from_search'] ) ) {
				$args['exclude_from_search'] = $this->sanitize_bool( $args['exclude_from_search'] );
			}

			// Validate: publicly_queryable : boolean
			if ( isset( $args['publicly_queryable'] ) ) {
				$args['publicly_queryable'] = $this->sanitize_bool( $args['publicly_queryable'] );
			}

			// Validate: show_ui : boolean
			if ( isset( $args['show_ui'] ) ) {
				$args['show_ui'] = $this->sanitize_bool( $args['show_ui'] );
			}

			// Validate: show_in_menu : boolean | string
			if ( isset( $args['show_in_menu'] ) ) {
				$args['show_in_menu'] = $this->sanitize_string_or_bool( $args['show_in_menu'] );
			}

			// Validate: show_in_nav_menus : boolean
			if ( isset( $args['show_in_nav_menus'] ) ) {
				$args['show_in_nav_menus'] = $this->sanitize_bool( $args['show_in_nav_menus'] );
			}

			// Validate: show_in_admin_bar : boolean
			if ( isset( $args['show_in_admin_bar'] ) ) {
				$args['show_in_admin_bar'] = $this->sanitize_bool( $args['show_in_admin_bar'] );
			}

			// Validate: show_in_rest : boolean
			if ( isset( $args['show_in_rest'] ) ) {
				$args['show_in_rest'] = $this->sanitize_bool( $args['show_in_rest'] );
			}

			// Validate: rest_base : string
			if ( isset( $args['rest_base'] ) ) {
				$args['rest_base'] = sanitize_text_field( $args['rest_base'] );
			}

			// Validate: rest_namespace : string
			if ( isset( $args['rest_namespace'] ) ) {
				$args['rest_namespace'] = sanitize_text_field( $args['rest_namespace'] );
			}

			// Validate: rest_controller_class : string
			if ( isset( $args['rest_controller_class'] ) ) {
				$args['rest_controller_class'] = sanitize_text_field( $args['rest_controller_class'] );
			}

			// Validate: menu_position : integer
			if ( isset( $args['menu_position'] ) ) {
				$args['menu_position'] = $this->sanitize_integer( $args['menu_position'] );
			}

			// Validate: capability_type : string | array
			if ( isset( $args['capability_type'] ) ) {
				$args['capability_type'] = $this->sanitize_string_or_array( $args['capability_type'], 'post' );
			}

			// Validate: capabilities : array
			if ( isset( $args['capabilities'] ) ) {
				if ( is_array( $args['capabilities'] ) ) {
					$meta_cap = ( isset( $args['map_meta_cap'] ) ) ? $args['map_meta_cap'] : false;
					$this->sanitize_capabilities( $args['capabilities'], $meta_cap );
				} else {
					unset( $args['capabilities'] );
				}
			}
			
			// Validate: map_meta_cap : boolean
			if ( isset( $args['map_meta_cap'] ) ) {
				$args['map_meta_cap'] = $this->sanitize_bool( $args['map_meta_cap'] );
			}

			// Validate: archives : string or boolean
			if ( isset( $args['has_archive'] ) ) {
				$args['has_archive'] = $this->sanitize_string_or_bool( $args['has_archive'] );
			}

			// Validate: rewrite : boolean or array
			if ( isset( $args['rewrite'] ) ) {
				$args['rewrite'] = $this->sanitize_bool_or_array( $args['rewrite'] );
			}

			// Validate: archives : string or boolean
			if ( isset( $args['query_var'] ) ) {
				$args['query_var'] = $this->sanitize_string_or_bool( $args['query_var'] );
			}

			// Validate: can_export : boolean
			if ( isset( $args['can_export'] ) ) {
				$args['can_export'] = $this->sanitize_bool( $args['can_export'] );
			}

			// Validate: delete_with_user : boolean
			if ( isset( $args['delete_with_user'] ) ) {
				$args['delete_with_user'] = $this->sanitize_bool( $args['delete_with_user'] );
			}

			// return validated args, replace with sanitized options
			return array_replace( $args, [
				'labels' 		=> $post_type_labels,
				'supports'		=> $post_type_support,
				'description' 	=> $post_type_description,
				'public'      	=> $public,
				'taxonomies'	=> $taxonomies
			] );
		}

		/**
		 * Sanitize singular post-type name
		 *
		 * @param string $post_type
		 * @param array $args
		 * @return string
		 */
		private function sanitize_singular( $post_type, $args ) {
			return ( isset( $args['singular'] ) && ! empty( $args['singular'] ) ) ? sanitize_text_field( $args['singular'] ) : ucwords( str_replace( [ '-', '_' ], ' ', $post_type ) );
		}

		/**
		 * Sanitize plural post-type name
		 *
		 * @param string $singular name
		 * @param array $args
		 * @return string
		 */
		private function sanitize_plural( $singular, $args ) {
			return ( isset( $args['plural'] ) && ! empty( $args['plural'] ) ) ? $args['plural'] : $singular . 's';
		}

		/**
		 * Sanitize post-type args
		 *
		 * @param array $args
		 * @return bool|array
		 */
		private function sanitize_args ( $args ) {

			// Set up post-type args - common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
			$args = ( isset( $args['args'] ) && is_array( $args['args'] ) ) ? $args['args'] : [];

			// Validate args
			foreach ( $args as $k => $v ) {

				// No built in
				if ( in_array( $k, $this->post_type_invalid, true ) ) {
					unset( $args[ $k ] );
					continue;
				}

				// Available args
				if ( ! in_array( $k, $this->post_type_valid, true ) ) {
					unset( $args[ $k ] );
					continue;
				}
			}

			// Return sanitized args
			return $args;
		}

		//----------------------------------------------
		//	Post-Type Processing
		//----------------------------------------------

		/**
		 * Process post-type labels
		 *
		 * @param array $args
		 * @param string $post_type
		 * @param string $singular
		 * @param string $plural
		 * @return array $labels
		 */
		private function post_type_labels( $args, $post_type, $singular, $plural ) {

			// If set up in the args then use these, and fill with generic defaults, assume non-empty
			if ( isset( $args['labels'] ) ) {
				return $args['labels'];
			}

			// Otherwise set up post-type labels - Rename to suit, common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
			return (array) apply_filters(
				"ipress_{$post_type}_labels",
				[
					'name'                     => $plural,
					'singular_name'            => $singular,
					'menu_item'                => $plural,
					'add_new'                  => sprintf( _x( 'Add %s', $singular, 'ipress' ), $singular ),
					'add_new_item'             => sprintf( __( 'Add New %s', 'ipress' ), $singular ),
					'edit_item'                => sprintf( __( 'Edit %s', 'ipress' ), $singular ),
					'new_item'                 => sprintf( __( 'New %s', 'ipress' ), $singular ),
					'view_item'                => sprintf( __( 'View %s', 'ipress' ), $singular ),
					'view_items'               => sprintf( __( 'View %s', 'ipress' ), $plural ),
					'search_items'             => sprintf( __( 'Search %s', 'ipress' ), $plural ),
					'not_found'                => sprintf( __( 'No %s found', 'ipress' ), $plural ),
					'not_found_in_trash'       => sprintf( __( 'No %s found in Trash', 'ipress' ), $plural ),
					'parent_item_colon'        => sprintf( __( 'Parent %s:', 'ipress' ), $singular ),
					'all_items'                => sprintf( __( 'All %s', 'ipress' ), $plural ),
					'archives'                 => sprintf( __( '%s Archives', 'ipress' ), $singular ),
					'attributes'               => sprintf( __( '%s Attributes', 'ipress' ), $singular ),
					'insert_into_item'         => sprintf( __( 'Insert into %s', 'ipress' ), $singular ),
					'uploaded_to_this_item'    => sprintf( __( 'Uploaded to this %s', 'ipress' ), $singular ),
					'featured_image'           => sprintf( __( '%s Featured Image', 'ipress' ), $singular ),
					'set_featured_image'       => sprintf( __( 'Set %s Featured Image', 'ipress' ), $singular ),
					'remove_featured_image'    => sprintf( __( 'Remove %s Featured Image', 'ipress' ), $singular ),
					'use_featured_image'       => sprintf( __( 'Use %s Featured Image', 'ipress' ), $singular ),
					'filter_items_list'        => sprintf( __( 'Filter %s list', 'ipress' ), $plural ),
					'filter_by_date'           => sprintf( __( 'Filter %s by date', 'ipress' ), $plural ),
					'items_list_navigation'    => sprintf( __( '%s list navigation', 'ipress' ), $plural ),
					'items_list'               => sprintf( __( '%s list', 'ipress' ), $plural ),
					'item_published'           => sprintf( __( '%s published', 'ipress' ), $singular ),
					'item_published_privately' => sprintf( __( '%s published privately', 'ipress' ), $singular ),
					'item_reverted_to_draft'   => sprintf( __( '%s reverted to draft', 'ipress' ), $singular ),
					'item_scheduled'           => sprintf( __( '%s scheduled', 'ipress' ), $singular ),
					'item_updated'             => sprintf( __( '%s updated', 'ipress' ), $singular ),
					'item_link'                => sprintf( _x( '%s Link', 'navigation link block title' ), $singular ) ,
					'item_link_description'    => sprintf( _x( 'A link to a %s.', 'navigation link block description' ), $singular )
				] 
			);
		}

		/**
		 * Process post-type support
		 *
		 * @param array $args
		 * @param string $post_type
		 * @return array
		 */
		private function post_type_support( $args, $post_type ) {
			
			// Set up post-type support - default: 'title', 'editor', 'thumbnail'
			return ( isset( $v['supports'] ) && is_array( $v['supports'] ) ) ? $this->sanitize_support( $v['supports'] ) : (array) apply_filters(
				"ipress_{$post_type}_supports",
				[
					'title',
					'editor',
					'thumbnail',
				]
			);
		}

		/**
		 * Process taxonomies associated with post-type... still need to explicitly register with 'register_taxonomy'
		 * 
		 * @param array $args
		 * @return array
		 */
		private function post_type_taxonomies( $args ) {
			return ( isset( $args['taxonomies'] ) && is_array( $args['taxonomies'] ) ) ? array_map( [ $this, 'sanitize_key_with_dashes' ], $args['taxonomies'] ) : [];
		}

		/**
		 * Set post-type availability, public
		 *
		 * @param array $args
		 * @return boolean
		 */
		private function post_type_availability( $args ) {
			return ( isset( $v['public'] ) ) ? (bool) $v['public'] : true;
		}

		/**
		 * Set post-type description
		 *
		 * @param array $args
		 * @param string $singular
		 * @return boolean
		 */
		private function post_type_description( $args, $singular ) {
			return ( isset( $args['description'] ) && ! empty( $args['description'] ) ) ? sanitize_text_field( $args['description'] ) : sprintf( __( 'This is the %s post-type', 'ipress' ), $singular );
		}

		//----------------------------------------------
		//	Messages
		//----------------------------------------------

		/**
		 * Messages Callback
		 *
		 * @param array $messages
		 * @return array
		 */
		public function messages( $messages ) {
			return (array) apply_filters( 'ipress_post_type_messages', $messages );
		}

		//----------------------------------------------
		//	Contextual Help
		//----------------------------------------------

		/**
		 * Contextual Help Callback
		 * [
		 *   [
		 *     'id'      => 'sp_overview',
		 *     'title'   => 'Overview',
		 *     'content' => '<p>Overview of your plugin or theme here</p>'
		 *   ]
		 * ];
		 *
		 * @param string $contextual_help
		 * @param object $screen_id
		 * @param string $screen
		 * @return array
		 */
		public function contextual_help_tabs() {

			// Get current screen
			$screen = get_current_screen();

			// Test valid post-types
			if ( ! in_array( $screen->id, $this->post_types, true ) ) {
				return;
			}

			// Get help types
			$ip_help_types = (array) apply_filters( "ipress_{$screen->id}_help", [] );
			if ( empty( $ip_help_types ) ) {
				return;
			}

			// Get right help
			if ( ! array_key_exists( $screen->id, $ip_help_types[ $screen->id ] ) ) {
				return;
			}

			// Set help tabs
			$help_tabs = $ip_help_types[ $screen->id ];

			// Construct tabs from array
			foreach ( $help_tabs as $help_tab ) {
				$screen->add_help_tab( $help_tab );
			}
		}
	}

endif;

// Instantiate Post-Type Class
return new IPR_Post_Type;
