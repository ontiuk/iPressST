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
			'custom',
			'customize_messenger_channel',
			'customized',
			'cpage',
			'day',
			'debug',
			'embed',
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
			'terms',
			'theme',
			'title',
			'type',
			'types',
			'w',
			'withcomments',
			'withoutcomments',
			'year',
		];

		/**
		 * Valid optional arguments for taxonomy registration 
		 *
		 * @var array $taxonomy_valid
		 */
		private $taxonomy_valid = [
			'label',
			'labels',
			'description',
			'public',
			'publicly_queryable',
			'hierarchical',
			'show_ui',
			'show_in_menu',
			'show_in_nav_menus',
			'show_in_rest',
			'rest_base',
			'rest_namespace',
			'rest_controller_class',
			'show_tag_cloud',
			'show_in_quick_edit',
			'show_admin_column',
			'meta_box_cb',
			'meta_box_sanitize_cb',
			'capabilities',
			'rewrite',
			'query_var',
			'update_count_callback',
			'default_term',
			'sort'
		];

		/**
		 * Built-in taxonomy names, do not use here
		 *
		 * @var array $taxonomy_invalid
		 */
		private $taxonomy_invalid = [
			'_builtin' 
		];

		/**
		 *  List of taxonomies to be processed
		 *
		 * @var array $taxonomies
		 */
		protected $taxonomies = [];

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Register parent hooks
			parent::__construct();

			// Initialize post-types and taxonomies
			add_action( 'init', [ $this, 'register' ], 0 );

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
		public function register() {

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
		 *     'singular' => __( 'Tax Name', 'ipress-standalone' ),
		 *     'plural' => __( 'Taxes', 'ipress-standalone' ),
		 *     'args' => [
		 *     		'description' => __( 'This is the Taxonomy name', 'ipress-standalone' ),
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
			foreach ( $this->taxonomies as $key => $args ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = $this->sanitize_key_with_dashes( $key );

				// Validate the taxonomy, or set error
				if ( false === $this->validate_taxonomy( $taxonomy ) ) {
					$this->taxonomy_errors[] = $taxonomy;
					continue;
				}

				// Assign to post-types?
				$post_types = $this->sanitize_post_types( $args );

				// Set up singluar & plural labels
				$singular = $this->sanitize_singular( $taxonomy, $args );
				$plural = $this->sanitize_plural( $singular, $args );

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
		 * - Checks for reserved words and maximum taxonomy length
		 *
		 * @param string $taxonomy Taxonomy name
		 * @return boolean
		 */
		private function validate_taxonomy( $taxonomy ) {
			return ( in_array( $taxonomy, $this->taxonomy_reserved, true ) || strlen( $taxonomy ) > 32 ) ? false : true;
		}

		/**
		 * Sanitize post-types associated to taxonomy
		 *
		 * @param array $args Arguments list for taxononomy processing
		 * @return array
		 */
		private function sanitize_post_types( $args ) {
			return ( isset( $args['post_types'] ) && is_array( $args['post_types'] ) ) ? array_map( [ $this, 'sanitize_key_with_dashes' ], $args['post_types'] ) : [];
		}

		/**
		 * Sanitize post-type args
		 *
		 * @param array $args Arguments list for taxonomy processing
		 * @return array $args
		 */
		protected function sanitize_args ( $args ) {

			// Set up taxonomy args - common options here @see https://codex.wordpress.org/Function_Reference/register_taxonomy
			$args = ( isset( $args['args'] ) && is_array( $args['args'] ) ) ? $args['args'] : [];

			// Validate args: no built-in args
			$args = array_filter( $args, function( $key ) {
				return ! in_array( $key, $this->taxonomy_invalid, true );
			}, ARRAY_FILTER_USE_KEY );

			// Validate args: available options
			$args = array_filter( $args, function( $key ) {
				return in_array( $key, $this->taxonomy_valid, true );
			}, ARRAY_FILTER_USE_KEY );

			return $args;
		}

		/**
		 * Validate taxonomy args
		 *
		 * @param array $args The pre-processed list of args for taxonomy registration
		 * @param string $key The current taxonomy key
		 * @param string $singular Singular taxonomy name
		 * @param string $plural Plural taxonomy name
		 * @return array $args 
		 */
		protected function validate_args( $args, $key, $singular, $plural ) {

			// Set taxonomy
			$taxonomy = $key;

			// Set up taxonomy labels : array
			$taxonomy_labels = $this->taxonomy_labels( $args, $taxonomy, $singular, $plural );

			// Set up description : string
			$taxonomy_description = $this->taxonomy_description( $args, $singular );

			// Set up availability : boolean, default: true
			$public = $this->taxonomy_availability( $args );

			// Validate: publicly_queryable : boolean, default: value of public argument
			if ( isset( $args['publicly_queryable'] ) ) {
				$args['publicly_queryable'] = $this->sanitize_bool( $args['publicly_queryable'], true );
			}

			// Validate: hierarchical : boolean, default: false
			if ( isset( $args['hierarchical'] ) ) {
				$args['hierarchical'] = $this->sanitize_bool( $args['hierarchical'] );
			}

			// Validate: show_ui : boolean, default: value of public argument
			if ( isset( $args['show_ui'] ) ) {
				$args['show_ui'] = $this->sanitize_bool( $args['show_ui'], true );
			}

			// Validate: show_in_menu : boolean, default: value of show_ui argument
			if ( isset( $args['show_in_menu'] ) ) {
				$args['show_in_menu'] = $this->sanitize_bool( $args['show_in_menu'], true );
			}

			// Validate: show_in_nav_menus : boolean, default: value of public argument
			if ( isset( $args['show_in_nav_menus'] ) ) {
				$args['show_in_nav_menus'] = $this->sanitize_bool( $args['show_in_nav_menus'], true );
			}

			// Validate: show_in_rest : boolean, default: false
			if ( isset( $args['show_in_rest'] ) ) {
				$args['show_in_rest'] = $this->sanitize_bool( $args['show_in_rest'] );
			}

			// Validate: rest_base : string, default: taxonomy name
			if ( isset( $args['rest_base'] ) ) {
				$args['rest_base'] = sanitize_text_field( $args['rest_base'] );
			}

			// Validate: rest_namespace : string, default: taxonomy name
			if ( isset( $args['rest_namespace'] ) ) {
				$args['rest_namespace'] = sanitize_text_field( $args['rest_namespace'] );
			}

			// Validate: rest_controller_class : string, default: WP_REST_Terms_Controller
			if ( isset( $args['rest_controller_class'] ) ) {
				$args['rest_controller_class'] = sanitize_text_field( $args['rest_controller_class'] );
			}

			// Validate: show_tag_cloud : boolean, default: value of show_ui argument
			if ( isset( $args['show_tag_cloud'] ) ) {
				$args['show_tag_cloud'] = $this->sanitize_bool( $args['show_tag_cloud'], true );
			}

			// Validate: show_in_quick_edit : boolean, default: value of show_ui argument
			if ( isset( $args['show_in_quick_edit'] ) ) {
				$args['show_in_quick_edit'] = $this->sanitize_bool( $args['show_in_quick_edit'] );
			}

			// Validate: show_admin_column : boolean, default: false
			if ( isset( $args['show_admin_column'] ) ) {
				$args['show_admin_column'] = $this->sanitize_bool( $args['show_admin_column'] );
			}

			// Validate: meta_box_cb : boolean | callable, default: null
			if ( isset( $args['meta_box_cb'] ) ) {
				if ( is_bool( $args['meta_box_cb'] ) ) {
					$args['meta_box_cb'] = $this->sanitize_bool( $args['meta_box_cb'] );
				} else {
					if ( ! is_callable(	$args['meta_box_cb'] ) ) {
						unset( $args['meta_box_cb'] );
					}
				}
			}

			// Validate: meta_box_cb : boolean | callable, default: null
			if ( isset( $args['meta_box_sanitize_cb'] ) ) {
				if ( ! is_callable(	$args['meta_box_sanitize_cb'] ) ) {
					unset( $args['meta_box_sanitize_cb'] );
				}
			}

			// Validate: capabilities : array
			if ( isset( $args['capabilities'] ) ) {
				if ( is_array( $args['capabilities'] ) ) {
					$this->sanitize_capabilities( $args['capabilities'], $meta, true );
				} else {
					unset( $args['capabilities'] );
				}
			}

			// Validate: rewrite : boolean | array, default: true
			if ( isset( $args['rewrite'] ) ) {
				$args['rewrite'] = $this->sanitize_bool_or_array( $args['rewrite'], true );
			}

			// Validate: archives : string | boolean, default: taxonomy name
			if ( isset( $args['query_var'] ) ) {
				$args['query_var'] = $this->sanitize_string_or_bool( $args['query_var'] );
			}

			// Validate: update_count_callback : string, default: none
			if ( isset( $args['update_count_callback'] ) ) {
				$args['update_count_callback'] = $this->sanitize_key_with_dashes( $args['update_count_callback'] );
			}

			// Validate: default_term : string | array, default: none
			if ( isset( $args['default_term'] ) ) {
				$args['default_term'] = $this->sanitize_string_or_array( $args['default_term'] );
			}

			// Some sanitization: sort : boolean. default: none
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
		 * Validate admin column argument
		 *
		 * @param array $args list of arguments for taxonomy processing
		 * @return boolean
		 */
		private function validate_admin_column( $args ) {
			return ( isset( $args['args']['show_admin_column'] ) ) ? $this->sanitize_bool( $args['args']['show_admin_column'] ) : false;
		}

		//----------------------------------------------
		//	Taxonomy Processing
		//----------------------------------------------

		/**
		 * Set taxonomy description
		 *
		 * @param array $args List of arguments for register_taxonomy() function
		 * @param string $singular Singular taxonomy name
		 * @return string
		 */
		private function taxonomy_description( $args, $singular ) {
			return ( isset( $args['description'] ) && ! empty( $args['description'] ) ) ? sanitize_text_field( $args['description'] ) : sprintf( __( 'This is the %s taxonomy', 'ipress-standalone' ), $singular );
		}

		/**
		 * Process taxonomy labels
		 *
		 * - If set up in the args then use these, and fill with generic defaults, assume non-empty
		 * - Otherwise set up taxonomy labels
		 *
		 * @param array $args List of arguments for register_taxonomy() function
		 * @param string $taxonomy Taxonomy key
		 * @param string $singular Singular taxonomy name
		 * @param string $plural Plural taxonomy name
		 * @return array
		 */
		private function taxonomy_labels( $args, $taxonomy, $singular, $plural ) {
			return ( isset( $args['labels'] ) && is_array( $args['labels'] ) ) ? $args['labels'] : (array) apply_filters(
				"ipress_{$taxonomy}_labels",
				[
					'name'                       => $plural,
					'singular_name'              => $singular,
					'menu_name'                  => $plural,
					'all_items'                  => sprintf( __( 'All %s', 'ipress-standalone' ), $plural ),
					'edit_item'                  => sprintf( __( 'Edit %s', 'ipress-standalone' ), $singular ),
					'view_item'                  => sprintf( __( 'View %s', 'ipress-standalone' ), $singular ),
					'update_item'                => sprintf( __( 'Update %s', 'ipress-standalone' ), $singular ),
					'add_new_item'               => sprintf( __( 'Add New %s', 'ipress-standalone' ), $singular ),
					'new_item_name'              => sprintf( __( 'New %s Name', 'ipress-standalone' ), $singular ),
					'parent_item'                => sprintf( __( 'Parent %s', 'ipress-standalone' ), $singular ),
					'parent_item_colon'          => sprintf( __( 'Parent %s:', 'ipress-standalone' ), $singular ),
					'search_items'               => sprintf( __( 'Search %s', 'ipress-standalone' ), $plural ),
					'popular_items'              => sprintf( __( 'Popular %s', 'ipress-standalone' ), $plural ),
					'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'ipress-standalone' ), $plural ),
					'add_or_remove_items'        => sprintf( __( 'Add or remove %s', 'ipress-standalone' ), $plural ),
					'choose_from_the_most_used'  => sprintf( __( 'Choose from the most used %s', 'ipress-standalone' ), $plural ),
					'not_found'                  => sprintf( __( 'No %s found', 'ipress-standalone' ), $plural ),
					'back_to_items'              => sprintf( __( '&#8617; Back to %s', 'ipress-standalone' ), $plural ),
				]
			);
		}

		/**
		 * Set taxonomy availability, public, default true
		 *
		 * @param array $args List of arguments for register_taxonomy() function
		 */
		private function taxonomy_availability( $args ) : bool {
			return ( isset( $args['public'] ) ) ? (bool) $args['public'] : true;
		}

		//----------------------------------------------
		//	Post-Type - Taxonomy Columns & Filters
		//----------------------------------------------

		/**
		 * Taxonomy columns and filters
		 */
		protected function taxonomy_columns() {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $key => $args ) {

				// Valid post-types
				$post_types = $this->sanitize_post_types( $args );
				if ( $post_types ) {

					// Sanitize taxonomy... a-z_- only
					$taxonomy = sanitize_key( str_replace( ' ', '_', $key ) );

					// Validate: show_admin_column : boolean
					$show_admin_column = $this->validate_admin_column( $args );

					// Valid admin column?
					if ( true === $show_admin_column ) {

						// Sortable?
						if ( isset( $args['sortable'] ) && true === $args['sortable'] ) {

							// Get post-types
							array_walk( $post_types, function( $post_type, $key ) {

								// Sanitize post-type... a-z_- only
								$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

								// Add sortable filters in columns
								add_filter( "manage_edit-{$post_type}_sortable_columns", [ $this, 'sortable_columns' ] );
								add_filter( 'posts_clauses', [ $this, 'sort_column' ], 10, 2 );
							} );
						}
					}

					// Post-type taxonomy filter
					if ( isset( $args['filter'] ) && true === $args['filter'] ) {
						add_action( 'restrict_manage_posts', [ $this, 'post_type_filter' ] );
						add_filter( 'parse_query', [ $this, 'post_type_filter_query' ] );
					}
				}
			}
		}

		/**
		 * Make filter column sortable
		 *
		 * @param array $columns List of admin columns
		 * @return array $columns
		 */
		public function sortable_columns( $columns ) {

			// Taxonomy columns & filters, add sortable column for post-type taxonomies
			array_walk( $this->taxonomies, function( $args, $key ) use ( &$columns ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $key ) );

				// Validate: show_admin_column : boolean
				$show_admin_column = $this->validate_admin_column( $args );

				// Valid admin column?
				if ( true === $show_admin_column ) {

					// Sortable?
					if ( isset( $args['sortable'] ) && true === $args['sortable'] ) {

						// Set column key
						$column_key = 'taxonomy-' . $taxonomy;

						// Add filter column to sortable list
						$columns[ $column_key ] = $taxonomy;
					}
				}
			} );

			return $columns;
		}

		/**
		 * Sort custom taxonomy columns as required
		 *
		 * @param array $pieces Column data
		 * @param array $wp_query Default WP_Query
		 * @return array $pieces
		 */
		public function sort_column( $pieces, WP_Query $query ) {
		
			// Only if admin main query & orderby
			if ( is_admin() && $query->is_main_query() && $query->get( 'orderby' ) ) {

				// Taxonomy columns & filters
				array_walk( $this->taxonomies, function( $args, $key ) use ( &$pieces, $query ) {

					global $wpdb;

					// Sortable?
					if ( isset( $args['sortable'] ) && true === $args['sortable'] ) {

						// Sanitize taxonomy... a-z_- only
						$taxonomy = sanitize_key( str_replace( ' ', '_', $key ) );

						// Matching taxonomy to orderby
						if ( $query->get( 'orderby' ) === $taxonomy ) {

							// Modify query order
							$order = ( strtoupper( $query->get( 'order' ) ) !== 'DESC' ) ? 'ASC' : 'DESC';

							// Construct sql
							$pieces['join']    .= ' LEFT OUTER JOIN ' . $wpdb->term_relationships . ' as tr ON ' . $wpdb->posts . '.ID = tr.object_id
								LEFT OUTER JOIN ' . $wpdb->term_taxonomy . ' as tt USING (term_taxonomy_id)
								LEFT OUTER JOIN ' . $wpdb->terms . ' as t USING (term_id)';
							$pieces['where']   .= ' AND ( tt.taxonomy = "' . $taxonomy . '" OR tt.taxonomy IS NULL)';
							$pieces['groupby']  = 'tr.object_id';
							$pieces['orderby']  = 'GROUP_CONCAT( t.name ORDER BY name ASC) ';
							$pieces['orderby'] .= $order;
						}
					}
				} );
			}

			return $pieces;
		}

		//----------------------------------------------
		//	Taxonomy Filters
		//----------------------------------------------

		/**
		 * Add taxonomy type post list filtering
		 *
		 * - Called via restrict_manage_posts action
		 */
		public function post_type_filter() {

			// Iterate taxonomies
			foreach ( $this->taxonomies as $key => $args ) {
				
				// Filterable?
				if ( isset( $args['filter'] ) && true === $args['filter'] ) {

					// Sanitize taxonomy... a-z_- only
					$taxonomy = sanitize_key( str_replace( ' ', '_', $key ) );

					// Valid post-types
					$post_types = $this->sanitize_post_types( $args );
					if ( $post_types ) {

						// Get post-types
						array_walk( $post_types, function( $post_type, $key ) use ( $taxonomy ) {
							
							global $typenow, $wp_query;

							// Sanitize post-type... a-z_- only
							$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

							// Only if current post-type
							if ( $typenow === $post_type ) {

								// Get current taxonomy
								$current_taxonomy = get_taxonomy( $taxonomy );

								// Only if query_var
								if ( $current_taxonomy->query_var ) {

									// Terms & term count
									$tax_terms = get_terms( $taxonomy );
									$tax_term_count = (int) sizeof( $tax_terms );

									// Need terms...
									if ( $tax_term_count > 0 ) {

										// Dropdown select
										wp_dropdown_categories(
											[
												/* translators: %s: Show all taxonomy terms */
												'show_option_all' => sprintf( __( 'Show All %s', 'ipress-standalone' ), $current_taxonomy->label ),
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
						} );
					}
				}
			}
		}

		/**
		 * Filter query for post_type taxonomy
		 *
		 * - Called via parse_query filter
		 *
		 * @param object $query WP_Query
		 */
		public function post_type_filter_query( WP_Query $query ) {

			global $pagenow;

			// Posts type page
			if ( 'edit.php' === $pagenow ) {

				// Iterate taxonomies
				array_walk( $this->taxonomies, function( $args, $key ) use ( $query ) {

					// Filterable?
					if ( isset( $args['filter'] ) && true === $args['filter'] ) {

						// Set filter
						$vars = &$query->query_vars;

						// Sanitize taxonomy... a-z_- only
						$taxonomy = sanitize_key( str_replace( ' ', '_', $key ) );

						// Edit page & matching taxonomy
						if ( isset( $vars[$taxonomy] ) && is_numeric( $vars[$taxonomy] ) ) {
							$term = get_term_by( 'id', $vars[$taxonomy], $taxonomy );
							if ( $term ) {
								$vars[$taxonomy] = $term->slug;
							}
						}
					}
				} );
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
return IPR_Taxonomy::Init();
