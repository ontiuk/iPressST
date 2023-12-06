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

if ( ! class_exists( 'IPR_Post_Type' ) ) :

	/**
	 * Set up custom post-types
	 */
	final class IPR_Post_Type extends IPR_Custom {

		/**
		 * Reserved post-type names
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
			'wp_block',
			'wp_global_styles',
			'wp_navigation',
			'wp_template',
			'wp_template_part',
			'action',
			'author',
			'order',
			'theme',
		];

		/**
		 * Valid optional arguments for post-type registration
		 *
		 * @var array $post_type_valid
		 */
		private $post_type_valid = [
			'label',
			'labels',
			'description',
			'public',
			'hierarchical',
			'exclude_from_search',
			'publicly_queryable',
			'show_ui',
			'show_in_menu',
			'show_in_nav_menus',
			'show_in_admin_bar',
			'show_in_rest',
			'rest_base',
			'rest_namespace',
			'rest_controller_class',
			'autosave_rest_controller_class',
			'revisions_rest_controller_class',
			'late_route_registration',
			'menu_position',
			'menu_icon',
			'capability_type',
			'capabilities',
			'map_meta_cap',
			'supports',
			'register_meta_box_cb',
			'taxonomies',
			'has_archive',
			'rewrite',
			'query_var',
			'can_export',
			'delete_with_user',
			'template',
			'template_lock',
		];

		/**
		 * Built-in post-type names, do not use here
		 *
		 * @var array $post_type_invalid
		 */
		private $post_type_invalid = [
			'_builtin',
			'_edit_link',
		];

		/**
		 * List of post-types to be processed
		 *
		 * @var array $post_types
		 */
		protected $post_types = [];

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Register parent hooks
			parent::__construct();

			// Generate & register custom post-types
			add_action( 'init', [ $this, 'register' ], 0 );

			// Generate & register custom post-types
			add_action( 'init', [ $this, 'register_post_types' ], 3 );

			// Callback for post update
			add_filter( 'post_updated_messages', [ $this, 'messages' ] );

			// Contextual screen help tab content
			add_action( 'load-edit.php', [ $this, 'contextual_help_tabs' ] );
			add_action( 'load-post.php', [ $this, 'contextual_help_tabs' ] );
			
			// Flush rewrite rules after theme activation
			add_action( 'after_switch_theme', [ $this, 'flush_rewrite_rules' ] );
		}

		//----------------------------------------------
		//	Initialise Post-Types
		//----------------------------------------------

		/**
		 * Initialize post-types & post-type restrictions
		 */
		public function register() {

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
		 * Register custom post-types and assign taxonmomies
		 * 
		 * @see https://codex.wordpress.org/Function_Reference/register_post_type
		 *
		 * $post_types = [
		 *   'cpt' => [
		 *     'singular' => __( 'CPT', 'ipress-standalone' ),
		 *     'plural' => __( 'CPTs', 'ipress-standalone' ),
		 *     'args' => [
		 *       'public => false,
		 *       'description' => __( 'This is the CPT post-type', 'ipress ),
		 *       'supports'    => [ 'title', 'editor', 'thumbnail' ],
		 *       'taxonomies   => [ 'cpt_tax' ],
		 *       'has_archive' => true,
		 *       'show_in_rest' => true
		 *     ],
		 *   ],
		 * ];
		 */
		public function register_post_types() {

			// Iterate stored custom post-types...
			foreach ( $this->post_types as $key => $args ) {

				// Basic key overrides: no spaces, translate to underscores
				$post_type = $this->sanitize_key_with_dashes( $key );

				// Generate post-type prefix if required
				$ip_post_type_prefix = (string) apply_filters( "ipress_{$post_type}_prefix", '' );

				// Sanitize post-type... [a-z_-] only, with or without prefix
				if ( $ip_post_type_prefix !== '' ) {
					$post_type = sanitize_key( $ip_post_type_prefix . $post_type );
				}

				// Validate the post-type, or set error
				if ( false === $this->validate_post_type( $post_type ) ) {
					$this->post_type_errors[] = $post_type;
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
		 * - Checks for reserved words and max post-type length (20 chars max)
		 *
		 * @param string $post_type Post-type name
		 * @return boolean
		 */
		private function validate_post_type( $post_type ) {
			return ( in_array( $post_type, $this->post_type_reserved, true ) || strlen( $post_type ) > 20 ) ? false : true;
		}

		/**
		 * Sanitize post-type args
		 *
		 * @param array $args Arguments list for post-type processing
		 * @return array
		 */
		protected function sanitize_args ( $args ) {

			// Set up post-type args - common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
			if ( isset( $args['args'] ) && is_array( $args['args'] ) ) {
				$args = $args['args'];
			} else {
				return [];
			}

			// Validate args: no built-in args
			$args = array_filter( $args, function( $key ) {
				return ! in_array( $key, $this->post_type_invalid, true );
			}, ARRAY_FILTER_USE_KEY );

			// Validate args: available options
			$args = array_filter( $args, function( $key ) {
				return in_array( $key, $this->post_type_valid, true );
			}, ARRAY_FILTER_USE_KEY );

			return $args;
		}

		/**
		 * Validate post_type args
		 *
		 * @param array $args The pre-processed list of args for post-type registration
		 * @param string $key The current post-type key
		 * @param string $singular Singular post-type name
		 * @param string $plural Plural post-type name
		 * @return array $args
		 */
		protected function validate_args( $args, $key, $singular, $plural ) {

			// Set post-type
			$post_type = $key;

			// Set up description : string
			$post_type_description = $this->post_type_description( $args, $singular );

			// Set up post-type labels : array
			$post_type_labels = $this->post_type_labels( $args, $post_type, $singular, $plural );

			// Set up post-type support : array
			$post_type_support = $this->post_type_support( $args, $post_type );

			// Set up taxonomies : array of sanitized taxonomy names
			$post_type_taxonomies = $this->post_type_taxonomies( $args );

			// Set up public availability : boolean
			$post_type_availability = $this->post_type_availability( $args );

			// Validate: hierarchical : boolean, default: false
			if ( isset( $args['hierarchical'] ) ) {
				$args['hierarchical'] = $this->sanitize_bool( $args['hierarchical'] );
			}

			// Validate: exclude_from_search : boolean, default: opposite of public argument
			if ( isset( $args['exclude_from_search'] ) ) {
				$args['exclude_from_search'] = $this->sanitize_bool( $args['exclude_from_search'] );
			}

			// Validate: publicly_queryable : boolean, default: value of public argument
			if ( isset( $args['publicly_queryable'] ) ) {
				$args['publicly_queryable'] = $this->sanitize_bool( $args['publicly_queryable'] );
			}

			// Validate: show_ui : boolean, default: value of public argument
			if ( isset( $args['show_ui'] ) ) {
				$args['show_ui'] = $this->sanitize_bool( $args['show_ui'] );
			}

			// Validate: show_in_menu : boolean | string, default: value of show_ui argument
			if ( isset( $args['show_in_menu'] ) ) {
				$args['show_in_menu'] = $this->sanitize_string_or_bool( $args['show_in_menu'] );
			}

			// Validate: show_in_nav_menus : boolean, default: value of public argument
			if ( isset( $args['show_in_nav_menus'] ) ) {
				$args['show_in_nav_menus'] = $this->sanitize_bool( $args['show_in_nav_menus'] );
			}

			// Validate: show_in_admin_bar : boolean, default: value of show_in_menu argument
			if ( isset( $args['show_in_admin_bar'] ) ) {
				$args['show_in_admin_bar'] = $this->sanitize_bool( $args['show_in_admin_bar'] );
			}

			// Validate: show_in_rest : boolean, default: false
			if ( isset( $args['show_in_rest'] ) ) {
				$args['show_in_rest'] = $this->sanitize_bool( $args['show_in_rest'] );
			}

			// Validate: rest_base : string, default: post-type name
			if ( isset( $args['rest_base'] ) ) {
				$args['rest_base'] = sanitize_text_field( $args['rest_base'] );
			}

			// Validate: rest_namespace : string, default: post-type name
			if ( isset( $args['rest_namespace'] ) ) {
				$args['rest_namespace'] = sanitize_text_field( $args['rest_namespace'] );
			}

			// Validate: rest_controller_class : string, default: WP_REST_Posts_Controller class
			if ( isset( $args['rest_controller_class'] ) ) {
				$args['rest_controller_class'] = sanitize_text_field( $args['rest_controller_class'] );
			}

			// Validate: menu_position : integer, default: below comments (25)
			if ( isset( $args['menu_position'] ) ) {
				$args['menu_position'] = $this->sanitize_integer( $args['menu_position'] );
			}

			// Validate: menu_icon : string, default: posts icon
			if ( isset( $args['menu_icon'] ) ) {
				$args['menu_icon'] = $this->sanitize_string_or_svg( $args['menu_icon'] );
			}

			// Validate: capability_type : string | array, default: "post"
			if ( isset( $args['capability_type'] ) ) {
				$args['capability_type'] = $this->sanitize_string_or_array( $args['capability_type'], 'post' );
			}

			// Validate: capabilities : array, default: uses capability_type value
			if ( isset( $args['capabilities'] ) ) {
				if ( is_array( $args['capabilities'] ) ) {
					$meta_cap = ( isset( $args['map_meta_cap'] ) ) ? $args['map_meta_cap'] : false;
					$this->sanitize_capabilities( $args['capabilities'], $meta_cap );
				} else {
					unset( $args['capabilities'] );
				}
			}
			
			// Validate: map_meta_cap : boolean, default: null
			if ( isset( $args['map_meta_cap'] ) ) {
				$args['map_meta_cap'] = $this->sanitize_bool( $args['map_meta_cap'] );
			}

			// Validate: register_meta_box_cb : boolean, default: none
			if ( isset( $args['register_meta_box_cb'] ) ) {
				if ( ! is_callable( $args['register_meta_box_cb'] ) ) {
					unset( $args['register_meta_box_cb'] );
				}
			}

			// Validate: archives : string or boolean, default: false
			if ( isset( $args['has_archive'] ) ) {
				$args['has_archive'] = $this->sanitize_string_or_bool( $args['has_archive'] );
			}

			// Validate: rewrite : boolean or array, default: true & uses post-type name
			if ( isset( $args['rewrite'] ) ) {
				$args['rewrite'] = $this->sanitize_bool_or_array_keys( $args['rewrite'], [ 'slug', 'with_front', 'feeds', 'pages', 'ep_mask' ] );
			}

			// Validate: query var : string or boolean, default: true & uses post-type name
			if ( isset( $args['query_var'] ) ) {
				$args['query_var'] = $this->sanitize_string_or_bool( $args['query_var'] );
			}

			// Validate: can_export : boolean, default: true
			if ( isset( $args['can_export'] ) ) {
				$args['can_export'] = $this->sanitize_bool( $args['can_export'], true );
			}

			// Validate: delete_with_user : boolean, default: null
			if ( isset( $args['delete_with_user'] ) ) {
				$args['delete_with_user'] = $this->sanitize_bool( $args['delete_with_user'] );
			}

			// Validate: template : array. default: []
			if ( isset( $args['template'] ) ) {
				$args['template'] = $this->sanitize_array( $args['template'] );
			}

			// Validate: archives : string or boolean, default: false
			if ( isset( $args['template_lock'] ) ) {
				$args['template_lock'] = $this->sanitize_string_or_bool_keys( $args['query_var'], [ 'all', 'insert' ] );
			}

			// Return validated args, replace with sanitized options
			return array_replace( $args, [
				'labels' 		=> $post_type_labels,
				'supports'		=> $post_type_support,
				'description' 	=> $post_type_description,
				'public'      	=> $post_type_availability,
				'taxonomies'	=> $post_type_taxonomies
			] );
		}

		//----------------------------------------------
		//	Post-Type Processing
		//----------------------------------------------

		/**
		 * Set post-type description
		 *
		 * @param array $args List of arguments for register_post_type() function
		 * @param string $singular Singular post-type name
		 * @return string
		 */
		private function post_type_description( $args, $singular ) {
			return ( isset( $args['description'] ) && ! empty( $args['description'] ) ) ? sanitize_text_field( $args['description'] ) : sprintf( __( 'This is the %s post-type', 'ipress-standalone' ), $singular );
		}

		/**
		 * Process post-type labels
		 *
		 * - If set up in the args then use these, and fill with generic defaults, assume non-empty
		 * - Otherwise set up post-type labels - Rename to suit
		 *
		 * @see https://codex.wordpress.org/Function_Reference/register_post_type
		 *
		 * @param array $args List of arguments for register_post_type() function
		 * @param string $post_type Post-type key
		 * @param string $singular Singular post-type name
		 * @param string $plural Plural post-type name
		 * @return array $labels
		 */
		private function post_type_labels( $args, $post_type, $singular, $plural ) {
			return ( isset( $args['labels'] ) && is_array( $args['labels'] ) ) ? $args['labels'] : (array) apply_filters(
				"ipress_{$post_type}_labels",
				[
					'name'                     => $plural,
					'singular_name'            => $singular,
					'menu_name'                => $plural,
					'add_new'                  => sprintf( __( 'Add %s', 'ipress-standalone' ), $singular ),
					'add_new_item'             => sprintf( __( 'Add New %s', 'ipress-standalone' ), $singular ),
					'edit_item'                => sprintf( __( 'Edit %s', 'ipress-standalone' ), $singular ),
					'new_item'                 => sprintf( __( 'New %s', 'ipress-standalone' ), $singular ),
					'view_item'                => sprintf( __( 'View %s', 'ipress-standalone' ), $singular ),
					'view_items'               => sprintf( __( 'View %s', 'ipress-standalone' ), $plural ),
					'search_items'             => sprintf( __( 'Search %s', 'ipress-standalone' ), $plural ),
					'not_found'                => sprintf( __( 'No %s found', 'ipress-standalone' ), $plural ),
					'not_found_in_trash'       => sprintf( __( 'No %s found in Trash', 'ipress-standalone' ), $plural ),
					'parent_item_colon'        => sprintf( __( 'Parent %s:', 'ipress-standalone' ), $singular ),
					'all_items'                => sprintf( __( 'All %s', 'ipress-standalone' ), $plural ),
					'archives'                 => sprintf( __( '%s Archives', 'ipress-standalone' ), $singular ),
					'attributes'               => sprintf( __( '%s Attributes', 'ipress-standalone' ), $singular ),
					'insert_into_item'         => sprintf( __( 'Insert into %s', 'ipress-standalone' ), $singular ),
					'uploaded_to_this_item'    => sprintf( __( 'Uploaded to this %s', 'ipress-standalone' ), $singular ),
					'featured_image'           => sprintf( __( '%s Featured Image', 'ipress-standalone' ), $singular ),
					'set_featured_image'       => sprintf( __( 'Set %s Featured Image', 'ipress-standalone' ), $singular ),
					'remove_featured_image'    => sprintf( __( 'Remove %s Featured Image', 'ipress-standalone' ), $singular ),
					'use_featured_image'       => sprintf( __( 'Use %s Featured Image', 'ipress-standalone' ), $singular ),
					'filter_items_list'        => sprintf( __( 'Filter %s list', 'ipress-standalone' ), $plural ),
					'filter_by_date'           => sprintf( __( 'Filter %s by date', 'ipress-standalone' ), $plural ),
					'items_list_navigation'    => sprintf( __( '%s list navigation', 'ipress-standalone' ), $plural ),
					'items_list'               => sprintf( __( '%s list', 'ipress-standalone' ), $plural ),
					'item_published'           => sprintf( __( '%s published', 'ipress-standalone' ), $singular ),
					'item_published_privately' => sprintf( __( '%s published privately', 'ipress-standalone' ), $singular ),
					'item_reverted_to_draft'   => sprintf( __( '%s reverted to draft', 'ipress-standalone' ), $singular ),
					'item_trashed'			   => sprintf( __( '%s trashed', 'ipress-standalone' ), $singular ),
					'item_scheduled'           => sprintf( __( '%s scheduled', 'ipress-standalone' ), $singular ),
					'item_updated'             => sprintf( __( '%s updated', 'ipress-standalone' ), $singular ),
					'item_link'                => sprintf( _x( '%s Link', 'navigation link block title', 'ipress-standalone' ), $singular ),
					'item_link_description'    => sprintf( _x( 'A link to a %s.', 'navigation link block description', 'ipress-standalone' ), $singular )
				] 
			);
		}

		/**
		 * Register post-type support
		 *
		 * - Default: 'title', 'editor', 'thumbnail'
		 *
		 * @param array $args List of arguments for register_post_type() function
		 * @param string $post_type Post-type key
		 * @return array
		 */
		private function post_type_support( $args, $post_type ) {
			return ( isset( $args['supports'] ) && is_array( $args['supports'] ) ) ? $this->sanitize_support( $args['supports'] ) : (array) apply_filters(
				"ipress_{$post_type}_supports",
				[
					'title',
					'editor',
					'thumbnail',
				]
			);
		}

		/**
		 * Process taxonomies associated with post-type
		 *
		 * - Still need to explicitly register with 'register_taxonomy'
		 * 
		 * @param array $args List of arguments for register_post_type() function
		 * @return array
		 */
		private function post_type_taxonomies( $args ) {
			return ( isset( $args['taxonomies'] ) && is_array( $args['taxonomies'] ) ) ? array_map( [ $this, 'sanitize_key_with_dashes' ], $args['taxonomies'] ) : [];
		}

		/**
		 * Set post-type availability, public, default false
		 *
		 * @param array $args List of arguments for register_post_type() function
		 * @return boolean
		 */
		private function post_type_availability( $args ) {
			return ( isset( $args['public'] ) ) ? (bool) $args['public'] : false;
		}

		//----------------------------------------------
		//	Messages
		//----------------------------------------------

		/**
		 * Messages Callback
		 *
		 * @param array $messages Messages callback list
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
		 *   ],
		 *   [
		 *     'id'      => 'sp_settings',
		 *     'title'   => 'Settings',
		 *     'content' => '<p>Theme settings help here</p>'
		 *   ],
		 * ];
		 */
		public function contextual_help_tabs() {

			// Get current screen
			$screen = get_current_screen();

			// Test valid post-types
			if ( in_array( $screen->id, $this->post_types, true ) ) {

				// Get help types
				$ip_help = (array) apply_filters( "ipress_{$screen->id}_help", [] );
				if ( $ip_help ) {
	
					// Construct tabs from array
					array_walk( $help_tabs, function( $help_tab, $key ) use ( $screen ) {
						$screen->add_help_tab( $help_tab );
					} );
				}
			}
		}

		//----------------------------------------------
		//	Rewrite Rules
		//----------------------------------------------

		/**
		 * Flush rewrite rules for custom post-types & taxonomies after switching theme
		 */
		public function flush_rewrite_rules() {
			$this->register_post_types();
			flush_rewrite_rules(); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_flush_rewrite_rules
		}
	}

endif;

// Instantiate Post-Type Class
return IPR_Post_Type::Init();
