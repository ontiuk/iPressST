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

// Load parent class
require_once IPRESS_CLASSES_DIR . '/class-ipr-custom.php';

if ( ! class_exists( 'IPR_Taxonomy' ) ) :

	/**
	 * Set up taxonomies
	 */
	final class IPR_Taxonomy extends IPR_Custom {

		/**
		 * Reserved taxonomy terms
		 *
		 * @var array $taxonomy_reserved
		 */
		private $taxonomy_reserved = [
			'attachment',
			'attachment_id',
			'author',
			'author_name',
			'calendar',
			'cat',
			'category',
			'category__and',
			'category__in',
			'category__not_in',
			'category_name',
			'comments_per_page',
			'comments_popup',
			'customize_messenger_channel',
			'customized',
			'cpage',
			'day',
			'debug',
			'error',
			'exact',
			'feed',
			'fields',
			'hour',
			'link_category',
			'm',
			'minute',
			'monthnum',
			'more',
			'name',
			'nav_menu',
			'nonce',
			'nopaging',
			'offset',
			'order',
			'orderby',
			'p',
			'page',
			'page_id',
			'paged',
			'pagename',
			'pb',
			'perm',
			'post',
			'post__in',
			'post__not_in',
			'post_format',
			'post_mime_type',
			'post_status',
			'post_tag',
			'post_type',
			'posts',
			'posts_per_archive_page',
			'posts_per_page',
			'preview',
			'robots',
			's',
			'search',
			'second',
			'sentence',
			'showposts',
			'static',
			'subpost',
			'subpost_id',
			'tag',
			'tag__and',
			'tag__in',
			'tag__not_in',
			'tag_id',
			'tag_slug__and',
			'tag_slug__in',
			'taxonomy',
			'tb',
			'term',
			'theme',
			'type',
			'w',
			'withcomments',
			'withoutcomments',
			'year',
		];

		/**
		 * Valid optional args - description as a unique arg
		 *
		 * @var array $taxonomy_valid
		 */
		private $taxonomy_valid = [
			'label',
			'labels',
			'public',
			'publicly_queryable',
			'show_ui',
			'show_in_menu',
			'show_in_nav_menus',
			'show_in_rest',
			'rest_base',
			'rest_controller_class',
			'show_tag_cloud',
			'show_in_quick_edit',
			'meta_box_cb',
			'show_admin_column',
			'hierarchical',
			'update_count_callback',
			'query_var',
			'rewrite',
			'capabilities',
			'sort',
		];

		/**
		 * Built-in, do not use here
		 *
		 * @var array $taxonomy_invalid
		 */
		private $taxonomy_invalid = [
			'_builtin' 
		];

		/**
		 * Taxonomies
		 *
		 * @var array $taxonomies
		 */
		protected $taxonomies = [];

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Register parent hooks
			parent::__construct();

			// Initialize post-types and taxonomies
			add_action( 'init', [ $this, 'init' ], 0 );

			// Generate & register taxonomies
			add_action( 'init', [ $this, 'register_taxonomies' ], 3 );
			
			// Flush rewrite rules after theme activation
			add_action( 'after_switch_theme', [ $this, 'flush_rewrite_rules' ] );
		}

		//----------------------------------------------
		//	Initialise Taxonomies
		//----------------------------------------------

		/**
		 * Initialise taxonomies & taxonomy restrictions 
		 */
		public function init() {

			// Register taxonomies
			$this->taxonomies = (array) apply_filters( 'ipress_taxonomies', [] );

			// Update reserved taxonomies with custom values e.g. from 3rd party products
			$this->taxonomy_reserved = (array) apply_filters( 'ipress_taxonomy_reserved', $this->taxonomy_reserved );

			// Update optional args list - e.g. remove args if needed
			$this->taxonomy_valid = (array) apply_filters( 'ipress_taxonomy_valid_args', $this->taxonomy_valid );

			// Post-type - taxonomy columns & filters
			$this->taxonomy_columns();
		}

		//----------------------------------------------
		//	Register Taxonomies
		//----------------------------------------------

		/**
		 * Register taxonomies & assign to post-types
		 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy
		 *
		 * $taxonomies = [
		 *   'cpt_tax' => [
		 *     'singular' => __( 'Tax Name', 'ipress' ),
		 *     'plural' => __( 'Taxes', 'ipress' ),
		 *     'args' => [
		 *     		'description' => __( 'This is the Taxonomy name', 'ipress' ),
		 *     		'post_types'  => [ 'cpt' ],
		 *     		'show_admin_column' => true
		 *     ],
		 *     'sortable'    => true, //optional
		 *     'filter'      => true, //optional
		 *   ],
		 * ];
		 */
		public function register_taxonomies() {

			// Iterate taxonomies...
			foreach ( $this->taxonomies as $k => $args ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Validate the taxonomy, or set error
				if ( false === $this->validate_taxonomy( $taxonomy ) ) {
					continue;
				}

				// Set up singluar & plural labels
				$singular = $this->sanitize_singular( $taxonomy, $args );
				$plural = $this->sanitize_plural( $singular, $args );

				// Assign to post-types?
				$post_types = $this->validate_post_types( $args );

				// Set up taxonomy args
				$args = $this->sanitize_args( $args );

				// Validate taxonomy args
				$args = $this->validate_args( $args, $taxonomy, $singular, $plural );

				// Register taxonomy
				register_taxonomy( $taxonomy, $post_types, $args ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_register_taxonomy
			}
		}

		//----------------------------------------------
		//	Validation & Sanitization Functions
		//----------------------------------------------
		
		/**
		 * Validate taxonomy against reserved or invalid taxonomy terms
		 *
		 * @param string $taxonomy
		 * @return boolean true if valid false if invalid
		 */
		private function validate_taxonomy( $taxonomy ) {

			// Sanity checks - reserved words and maximum taxonomy length
			if ( in_array( $taxonomy, $this->taxonomy_reserved, true ) || strlen( $taxonomy ) > 32 ) {
				$this->taxonomy_errors[] = $taxonomy;
				return false;
			}
			return true;
		}

		/**
		 * Validate taxonomy args
		 *
		 * @param array $args
		 * @param string $taxonomy
		 * @param string $singular
		 * @param string $plural
		 * @return array $args
		 */
		private function validate_args( $args, $taxonomy, $singular, $plural ) {

			// Set up taxonomy labels
			$taxonomy_labels = $this->taxonomy_labels( $args, $taxonomy, $singular, $plural );

			// Set up description
			$taxonomy_description = $this->taxonomy_description( $args, $singular );

			// Set up availability
			$public = $this->taxonomy_availability( $args );

			// Validate: publicly_queryable : boolean
			if ( isset( $args['publicly_queryable'] ) ) {
				$args['publicly_queryable'] = $this->sanitize_bool( $args['publicly_queryable'] );
			}

			// Validate: show_ui : boolean
			if ( isset( $args['show_ui'] ) ) {
				$args['show_ui'] = $this->sanitize_bool( $args['show_ui'] );
			}

			// Validate: show_in_menu : boolean
			if ( isset( $args['show_in_menu'] ) ) {
				$args['show_in_menu'] = $this->sanitize_bool( $args['show_in_menu'] );
			}

			// Validate: show_in_nav_menus : boolean
			if ( isset( $args['show_in_nav_menus'] ) ) {
				$args['show_in_nav_menus'] = $this->sanitize_bool( $args['show_in_nav_menus'] );
			}

			// Validate: show_in_rest : boolean
			if ( isset( $args['show_in_rest'] ) ) {
				$args['show_in_rest'] = $this->sanitize_bool( $args['show_in_rest'] );
			}

			// Validate: rest_base : string
			if ( isset( $args['rest_base'] ) ) {
				$args['rest_base'] = sanitize_text_field( $args['rest_base'] );
			}

			// Validate: rest_controller_class : string
			if ( isset( $args['rest_controller_class'] ) ) {
				$args['rest_controller_class'] = sanitize_text_field( $args['rest_controller_class'] );
			}

			// Validate: show_tag_cloud : boolean
			if ( isset( $args['show_tag_cloud'] ) ) {
				$args['show_tag_cloud'] = $this->sanitize_bool( $args['show_tag_cloud'] );
			}

			// Validate: show_in_quick_edit : boolean
			if ( isset( $args['show_in_quick_edit'] ) ) {
				$args['show_in_quick_edit'] = $this->sanitize_bool( $args['show_in_quick_edit'] );
			}

			// Validate: show_admin_column : boolean
			if ( isset( $args['show_admin_column'] ) ) {
				$args['show_admin_column'] = $this->sanitize_bool( $args['show_admin_column'] );
			}

			// Validate: hierarchical : boolean
			if ( isset( $args['hierarchical'] ) ) {
				$args['hierarchical'] = $this->sanitize_bool( $args['hierarchical'] );
			}

			// Validate: update_count_callback : string
			if ( isset( $args['update_count_callback'] ) ) {
				$args['update_count_callback'] = $this->sanitize_key_with_dashes( $args['update_count_callback'] );
			}

			// Validate: archives : string or boolean
			if ( isset( $args['query_var'] ) ) {
				$args['query_var'] = $this->sanitize_string_or_bool( $args['query_var'] );
			}

			// Validate: rewrite : boolean or array
			if ( isset( $args['rewrite'] ) ) {
				$args['rewrite'] = $this->sanitize_bool_or_array( $args['rewrite'] );
			}

			// Validate: capabilities : array
			if ( isset( $args['capabilities'] ) ) {
				if ( is_array( $args['capabilities'] ) ) {
					$this->sanitize_capabilities( $args['capabilities'], $meta, true );
				} else {
					unset( $args['capabilities'] );
				}
			}

			// Some sanitization: sort : boolean
			if ( isset( $args['sort'] ) ) {
				$args['sort'] = $this->sanitize_bool( $args['sort'] );
			}

			// return validated args, replace with sanitized options
			return array_replace( $args, [
				'labels' 		=> $taxonomy_labels,
				'description' 	=> $taxonomy_description,
				'public'      	=> $public
			] );
		}

		/**
		 * Validate post-types associated to taxonomy
		 *
		 * @param array $args
		 * @return array
		 */
		private function validate_post_types( $args ) {
			return ( isset( $args['post_types'] ) ) ? array_map( [ $this, 'sanitize_key_with_dashes' ], (array) $args['post_types'] ) : [];
		}

		/**
		 * Validate admin column argument
		 *
		 * @param array $args
		 * @return bool
		 */
		private function validate_admin_column( $args ) {
			return ( isset( $args['args']['show_admin_column'] ) ) ? $this->sanitize_bool( $args['args']['show_admin_column'] ) : false;
		}

		/**
		 * Sanitize singular taxonomy name
		 *
		 * @param string $taxonomy
		 * @param array $args
		 * @return string
		 */
		private function sanitize_singular( $taxonomy, $args ) {
			return ( isset( $args['singular'] ) && ! empty( $args['singular'] ) ) ? sanitize_text_field( $args['singular'] ) : ucwords( str_replace( [ '-', '_' ], ' ', $taxonomy ) );
		}

		/**
		 * Sanitize plural taxonomy name
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

			// Set up taxonomy args
			$args = ( isset( $args['args'] ) && is_array( $args['args'] ) ) ? $args['args'] : [];

			// Validate args
			foreach ( $args as $k => $v ) {

				// No built in
				if ( in_array( $k, $this->taxonomy_invalid, true ) ) {
					unset( $args[ $k ] );
					continue;
				}

				// Available args
				if ( ! in_array( $k, $this->taxonomy_valid, true ) ) {
					unset( $args[ $k ] );
					continue;
				}
			}

			// Return sanitized args
			return $args;
		}

		//----------------------------------------------
		//	Taxonomy Processing
		//----------------------------------------------

		/**
		 * Process taxonomy labels
		 *
		 * @param array $args
		 * @param string $taxonomy
		 * @param string $singular
		 * @param string $plural
		 * @return array $labels
		 */
		private function taxonomy_labels( $args, $taxonomy, $singular, $plural ) {

			// If set up in the args then use these, and fill with generic defaults, assume non-empty
			if ( isset( $args['labels'] ) ) {
				return $args['labels'];
			}

			// Otherwise set up taxonomy labels
			return (array) apply_filters(
				"ipress_{$taxonomy}_labels",
				[
					'name'                       => $plural,
					'singular_name'              => $singular,
					'menu_name'                  => $plural,
					'all_items'                  => sprintf( __( 'All %s', 'ipress' ), $plural ),
					'edit_item'                  => sprintf( __( 'Edit %s', 'ipress' ), $singular ),
					'view_item'                  => sprintf( __( 'View %s', 'ipress' ), $singular ),
					'update_item'                => sprintf( __( 'Update %s', 'ipress' ), $singular ),
					'add_new_item'               => sprintf( __( 'Add New %s', 'ipress' ), $singular ),
					'new_item_name'              => sprintf( __( 'New %s Name', 'ipress' ), $singular ),
					'parent_item'                => sprintf( __( 'Parent %s', 'ipress' ), $singular ),
					'parent_item_colon'          => sprintf( __( 'Parent %s:', 'ipress' ), $singular ),
					'search_items'               => sprintf( __( 'Search %s', 'ipress' ), $plural ),
					'popular_items'              => sprintf( __( 'Popular %s', 'ipress' ), $plural ),
					'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'ipress' ), $plural ),
					'add_or_remove_items'        => sprintf( __( 'Add or remove %s', 'ipress' ), $plural ),
					'choose_from_the_most_used'  => sprintf( __( 'Choose from the most used %s', 'ipress' ), $plural ),
					'not_found'                  => sprintf( __( 'No %s found', 'ipress' ), $plural ),
					'back_to_items'              => sprintf( __( '&#8617; Back to %s', 'ipress' ), $plural ),
				]
			);
		}

		/**
		 * Set taxonomy availability, public
		 *
		 * @param array $args
		 * @return boolean
		 */
		private function taxonomy_availability( $args ) {
			return ( isset( $v['public'] ) ) ? (bool) $v['public'] : true;
		}

		/**
		 * Set taxonomy description
		 *
		 * @param array $args
		 * @param string $singular
		 * @return boolean
		 */
		private function taxonomy_description( $args, $singular ) {
			return ( isset( $args['description'] ) && ! empty( $args['description'] ) ) ? sanitize_text_field( $args['description'] ) : sprintf( __( 'This is the %s taxonomy', 'ipress' ), $singular );
		}

		//----------------------------------------------
		//	Post-Type - Taxonomy Columns & Filters
		//----------------------------------------------

		/**
		 * Taxonomy columns and filters
		 */
		protected function taxonomy_columns() {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $k => $v ) {

				// Valid post-types
				$post_types = $this->validate_post_types( $v );
				if ( empty( $post_types ) ) {
					continue;
				}

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Validate: show_admin_column : boolean
				$show_admin_column = $this->validate_admin_column( $v );

				// Valid admin column?
				if ( true === $show_admin_column ) {

					// Sortable?
					if ( isset( $v['sortable'] ) && true === $v['sortable'] ) {

						// Get post-types
						foreach ( $post_types as $post_type ) {

							// Sanitize post-type... a-z_- only
							$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

							// Add sortable filters in columns
							add_filter( "manage_edit-{$post_type}_sortable_columns", [ $this, 'sortable_columns' ] );
							add_filter( 'posts_clauses', [ $this, 'sort_column' ], 10, 2 );
						}
					}
				}

				// Post-type taxonomy filter
				if ( isset( $v['filter'] ) && true === $v['filter'] ) {
					add_action( 'restrict_manage_posts', [ $this, 'post_type_filter' ] );
					add_filter( 'parse_query', [ $this, 'post_type_filter_query' ] );
				}
			}
		}

		/**
		 * Make filter column sortable
		 *
		 * @param array $columns
		 * @return array $columns
		 */
		public function sortable_columns( $columns ) {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $k => $v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Set column key
				$column_key = 'taxonomy-' . $taxonomy;

				// Add filter column to sortable list
				$columns[ $column_key ] = $taxonomy;
			}

			return $columns;
		}

		/**
		 * Sort custom taxonomy columns as required
		 *
		 * @param array $pieces
		 * @param array $wp_query
		 * @return array
		 */
		public function sort_column( $pieces, WP_Query $query ) {

			global $wpdb;

			// Ordering set?
			$orderby = $query->get( 'orderby' );
			if ( empty( $orderby ) ) {
				return $pieces;
			}

			// Only if admin main query
			if ( is_admin() && $query->is_main_query() ) {

				// Taxonomy columns & filters
				foreach ( $this->taxonomies as $k => $v ) {

					// Filter?
					if ( isset( $v['filter'] ) && true === $v['filter'] ) {

						// Sanitize taxonomy... a-z_- only
						$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

						// Matching taxonomy
						if ( $orderby === $taxonomy ) {

							// Get sql order
							$order = ( strtoupper( $query->get( 'order' ) ) !== 'DESC' ) ? 'ASC' : 'DESC';

							// Construct sql
							$pieces['join']    .= ' LEFT OUTER JOIN ' . $wpdb->term_relationships . ' as tr ON ' . $wpdb->posts . '.ID = tr.object_id
								LEFT OUTER JOIN ' . $wpdb->term_taxonomy . ' as tt USING (term_taxonomy_id)
								LEFT OUTER JOIN ' . $wpdb->terms . ' as t USING (term_id)';
							$pieces['where']   .= ' AND ( tt.taxonomy = "' . $taxonomy . '" OR tt.taxonomy IS NULL)';
							$pieces['groupby']  = 'tr.object_id';
							$pieces['orderby']  = 'GROUP_CONCAT( t.name ORDER BY name ASC) ';
							$pieces['orderby'] .= $order;

							// Matched...
							break;
						}
					}
				}
			}

			// Get pieces
			return $pieces;
		}

		//----------------------------------------------
		//	Taxonomy Filters
		//----------------------------------------------

		/**
		 * Add taxonomy type post list filtering
		 * - Called via restrict_manage_posts action
		 */
		public function post_type_filter() {

			global $typenow, $wp_query;

			// Iterate taxonomies
			foreach ( $this->taxonomies as $k => $v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Valid post-types
				$post_types = $this->validate_post_types( $v );
				if ( empty( $post_types ) ) {
					continue;
				}

				// Get post-types
				foreach ( $post_types as $post_type ) {

					// Sanitize post-type... a-z_- only
					$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

					// Only if current post-type
					if ( $typenow !== $post_type ) {
						continue;
					}

					// Get current taxonomy
					$current_taxonomy = get_taxonomy( $taxonomy );

					// Only if query_var
					if ( empty( $current_taxonomy->query_var ) ) {
						continue;
					}

					// Terms & term count
					$tax_terms      = get_terms( $taxonomy );
					$tax_term_count = (int) sizeof( $tax_terms );

					// Need terms...
					if ( 0 === $tax_term_count ) {
						continue;
					}

					// Dropdown select
					wp_dropdown_categories(
						[
							/* translators: %s: Show all taxonomy terms */
							'show_option_all' => sprintf( __( 'Show All %s', 'ipress' ), $current_taxonomy->label ),
							'taxonomy'        => $taxonomy,
							'name'            => $current_taxonomy->name,
							'orderby'         => 'name',
							'selected'        => ( isset( $wp_query->query[ $taxonomy ] ) ) ? $wp_query->query[ $taxonomy ] : '',
							'hierarchical'    => true,
							'depth'           => 3,
							'show_count'      => true,
							'hide_empty'      => true,
						]
					);
				}
			}
		}

		/**
		 * Filter query for post_type taxonomy
		 * - Called via parse_query filter
		 *
		 * @param object $query WP_Query
		 */
		public function post_type_filter_query( WP_Query $query ) {

			global $pagenow;

			// Test page
			if ( 'edit.php' !== $pagenow ) {
				return;
			}

			// Set filter
			$vars = &$query->query_vars;

			// Iterate taxonomies
			foreach ( $this->taxonomies as $k => $v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Edit page & matching taxonomy
				if ( 'edit.php' === $pagenow && isset( $vars[ $taxonomy ] ) && is_numeric( $vars[ $taxonomy ] ) ) {
					$term = get_term_by( 'id', $vars[ $taxonomy ], $taxonomy );
					if ( $term ) {
						$vars[ $taxonomy ] = $term->slug;
					}
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
			$this->register_taxonomies();
			flush_rewrite_rules(); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_flush_rewrite_rules
		}
	}

endif;

// Instantiate Taxonomy Class
return new IPR_Taxonomy;
