<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Content and URL functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//---------------------------------------------
//	Content & URL
//
// ipress_is_home_page
// ipress_is_index
// ipress_is_subpage
// ipress_is_tree
// ipress_get_link_url
// ipress_canonical_url
// ipress_paged_post_url
// ipress_get_permalink_by_page
// ipress_excerpt
// ipress_content
// ipress_truncate
// ipress_ordinal_number
// ipress_do_shortcode
// ipress_posts_archive
// ipress_related_posts_archive
// ipress_featured_post_archive
// ipress_single_post_archive
//---------------------------------------------

if ( ! function_exists( 'ipress_is_home_page' ) ) :

	/**
	 * Check if the root page of the site is being viewed
	 *
	 * is_front_page() returns false for the root page of a website when
	 * - the WordPress 'Front page displays' setting is set to 'Static page'
	 * - 'Front page' is left undefined
	 * - 'Posts page' is assigned to an existing page
	 */
	function ipress_is_home_page() : bool {
		return ( is_front_page() || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) );
	}
endif;

if ( ! function_exists( 'ipress_is_index' ) ) :

	/**
	 * Check if the page being viewed is the index page
	 *
	 * @param string $page Page name 
	 */
	function ipress_is_index( $page ) : bool {
		return ( basename( $page ) === 'index.php' );
	}
endif;

if ( ! function_exists( 'ipress_is_subpage' ) ) :

	/**
	 * Determine if the page is a subpage
	 * 
	 * - Returns parent post ID if true
	 *
	 * @global $post
	 * @return boolean|integer
	 */
	function ipress_is_subpage() {
		global $post;
		return ( is_page() && $post->post_parent ) ? $post->post_parent : false;
	}
endif;

if ( ! function_exists( 'ipress_is_tree' ) ) :

	/**
	 * Check if page is current of ancestor
	 *
	 * @global $post
	 * @param integer $pid Post ID
	 */
	function ipress_is_tree( $pid ) : bool {

		global $post;

		// Current page
		if ( is_page( $pid ) ) {
			return true;
		}

		// Post ancestor
		$anc = get_post_ancestors( $post->ID );
		foreach ( $anc as $ancestor ) {
			if ( is_page() && $ancestor === $pid ) {
				return true;
			}
		}

		return false;
	}
endif;

if ( ! function_exists( 'ipress_get_link_url' ) ) {
	
	/**
	 * Return the post URL, defaults to the post permalink if no URL is found in the post
	 *
	 * @see get_url_in_content()
	 * @return string
	 */
	function ipress_get_link_url() {
		
		$has_url = get_url_in_content( get_the_content() );

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core filter name.
		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}

if ( ! function_exists( 'ipress_canonical_url' ) ) :

	/**
	 * Calculate and return the canonical URL
	 *
	 * @global $wp_query WP_Query
	 * @return string $canonical The canonical URL, if one exists
	 */
	function ipress_canonical_url() {

		global $wp_query;

		// Initialize output
		$canonical = '';

		// Pagination values
		$paged = absint( get_query_var( 'paged' ) );
		$page  = absint( get_query_var( 'page' ) );

		// Get the queried object id, returns int
		$id = $wp_query->get_queried_object_id();

		// Front page / home page
		if ( is_front_page() ) {
			$canonical = ( $paged > 0 ) ? get_pagenum_link( $paged ) : home_url( '/' );
		}

		// Single post
		if ( is_singular() && $id ) {
			$numpages  = substr_count( $wp_query->post->post_content, '<!--nextpage-->' ) + 1;
			$canonical = ( $numpages > 1 && $page > 1 ) ? ipress_paged_post_url( $page, $id ) : get_permalink( $id );
		}

		// Archive
		if ( ( is_category() || is_tag() || is_tax() ) && $id ) {
			$taxonomy  = $wp_query->queried_object->taxonomy;
			$canonical = ( $paged > 0 ) ? get_pagenum_link( $paged ) : get_term_link( $id, $taxonomy );
		}

		// Author
		if ( is_author() && $id ) {
			$canonical = ( $paged > 0 ) ? get_pagenum_link( $paged ) : get_author_posts_url( $id );
		}

		// Search
		if ( is_search() ) {
			$canonical = get_search_link();
		}

		return $canonical;
	}
endif;

if ( ! function_exists( 'ipress_paged_post_url' ) ) :

	/**
	 * Return the special URL of a paged post
	 * 
	 * - Adapted from _wp_link_page() in WP core
	 *
	 * @global $wp_rewrite
	 * @param int $page_id The page number to generate the URL from
	 * @param int $post_id The post ID
	 * @return string $url Unescaped URL
	 */
	function ipress_paged_post_url( $page_id, $post_id = 0 ) {

		global $wp_rewrite;

		// Get post by ID
		$post = get_post( $post_id );

		// Paged?
		if ( 1 === $page_id ) {
			$url = get_permalink( $post_id );
		} else {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ], true ) ) {
				$url = add_query_arg( 'page', $page_id, get_permalink( $post_id ) );
			} elseif ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $wp_rewrite->pagination_base . '/' . $page_id, 'single_paged' );
			} else {
				$url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $page_id, 'single_paged' );
			}
		}

		return $url;
	}
endif;

if ( ! function_exists( 'ipress_get_permalink_by_page' ) ) :

	/**
	 * Get url by page template
	 *
	 * @param string $template Page template name
	 * @return string
	 */
	function ipress_get_permalink_by_page( $template ) {

		// Get pages
		$page = get_pages(
			[
				'meta_key'   => '_wp_page_template',
				'meta_value' => $template . '.php',
			]
		);

		return ( empty( $page ) ) ? '' : get_permalink( $page[0]->ID );
	}
endif;

if ( ! function_exists( 'ipress_excerpt' ) ) :

	/**
	 * Create the Custom Excerpt
	 *
	 * @param string $length_callback Excerpt callback, default empty
	 * @param string $more_callback Callback function, default empty
	 * @param boolean $wrap Wrap excerpt, default true
	 */
	function ipress_excerpt( $length_callback = '', $more_callback = '', $wrap = true ) {

		// Excerpt length
		if ( ! empty( $length_callback ) && function_exists( $length_callback ) ) {
			add_filter( 'excerpt_length', $length_callback );
		}

		// Excerpt more
		if ( ! empty( $more_callback ) && function_exists( $more_callback ) ) {
			add_filter( 'excerpt_more', $more_callback );
		}

		// Get the excerpt
		$excerpt = get_the_excerpt();

		// No wrap, remove filter
		if ( ! $wrap ) {
			remove_filter( 'the_excerpt', 'wpautop' );
		}

		// Output the excerpt
		echo apply_filters( 'the_excerpt', $excerpt ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// No wrap, readd filter
		if ( ! $wrap ) {
			add_filter( 'the_excerpt', 'wpautop' );
		}
	}
endif;

if ( ! function_exists( 'ipress_content' ) ) :

	/**
	 * Trim the content by word count
	 *
	 * @param integer $length Content length, default 54
	 * @param string $before Before content text, default empty
	 * @param string $after After content text, default empty
	 */
	function ipress_content( $length = 54, $before = '', $after = '' ) {

		// Get the content
		$the_content = get_the_content();

		// Trim to word count and output, output as for the_content
		$the_content = $before . wp_trim_words( $content, $length, '...' ) . $after;
		$the_content = apply_filters( 'the_content', $the_content );
		echo str_replace( ']]>', ']]&gt;', $the_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_truncate' ) ) :

	/**
	 * Return a phrase shortened in length to a maximum number of characters
	 * 
	 * - Truncated at the last white space in the original string
	 *
	 * @param string $text Text top truncate
	 * @param integer $max_char Truncate length, default 54
	 * @return string $text
	 */
	function ipress_truncate( $text, $max_char = 54 ) {

		// Sanitize
		$text = trim( $text );

		// Test text length
		if ( strlen( $text ) > $max_char ) {

			// Truncate $text to $max_characters + 1
			$text = substr( $text, 0, $max_char + 1 );

			// Truncate to the last space in the truncated string
			$text = trim( substr( $text, 0, strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif;

if ( ! function_exists( 'ipress_ordinal_number' ) ) :

	/**
	 * Return a suffix for a number by type: st, rd, th
	 *
	 * @param integer|string $num Number to process
	 * @return string
	 */
	function ipress_ordinal_number( $num ) {

		// Typecast: string
		$num = trim( $num );

		// Test for outliers
		if ( in_array( ( $num % 100 ), [ 11, 12, 13 ], true ) ) {
			return 'th';
		}

		// Ok, general rules apply: handle 1st, 2nd, 3rd, nth
		switch ( $num % 10 ) {
			case 1:
				return 'st';
			case 2:
				return 'nd';
			case 3:
				return 'rd';
			default:
				return 'th';
		}
	}
endif;

//---------------------------------------------
//	Shortcode Functions
//---------------------------------------------

if ( ! function_exists( 'ipress_do_shortcode' ) ) :

	/**
	 * Call a shortcode function by tag name
	 *
	 * @param string $tag Shortcode whose function to call
	 * @param array $atts Shortcode attributes passed to shortcode
	 * @param array $content Shortcode content, default null
	 * @global $shortcode_tags
	 * @return string|bool
	 */
	function ipress_do_shortcode( $tag, $atts = [], $content = null ) {

		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) || ! is_array( $atts ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
endif;

if ( ! function_exists( 'ipress_posts_archive' ) ) :
	
	/**
	 * Retrieve a list of posts by parameters
	 *
	 * @param array $params
	 * @return array
	 */
	function ipress_posts_archive( $params = [] ) {

		// Set post-type settings
        $post_type 	    = 'post';
        $post_status    = 'publish';
        $orderby        = 'date';
        $excerpt_length = 20;
        $excerpt_more 	= '&hellip;';

		// Extract any arguments provided
        if ( $params ) {
            extract( $params, EXTR_OVERWRITE );
		}

        // Start setting up WP Query for case studies
        $query_args = [
            'post_type' 	=> $post_type,
            'post_status' 	=> $post_status,
            'orderby'       => $orderby
		];

		// Posts per page: int, default 6
		$query_args['posts_per_page'] = ( isset( $posts_per_page ) ) ? intval( $posts_per_page ) : 6;

		// Pagination: int
        if ( isset( $paged ) ) {
			$query_args['paged'] = $paged;
		}

		// Pages ID list: array
        if ( isset( $post__in ) ) {
			$query_args['post__in'] = $post__in;
		}

		// Category: int
		if ( isset( $cat ) ) {
			$query_args['cat'] = $cat;
		}

		// Pages ID list: array
        if ( isset( $post__not_in ) ) {
			$query_args['post__not_in'] = $post__not_in;
		}

        // Get the queried object if we're on an archive page - just in case we also have custom taxonomy
        $queried_object = ( is_archive() ) ? get_queried_object() : false;

		// Are we on the default category or a related taxonomy
		if ( $queried_object && $queried_object->taxonomy !== 'category' ) {

			// Set taxonomy query
			$query_args['tax_query'] = [
				[
	                'taxonomy'	=> $queried_object->taxonomy,
    	            'field'		=> 'term_id',
					'terms'		=> $queried_object->term_id
				]
			];

			// Taxonomy slug
            $custom_taxonomy = $queried_object->slug;
        }

		// Date: month : int
        if ( isset( $monthnum ) ) {
			$query_args['monthnum'] = intval( $monthnum );
		}

		// Date: year : int
        if ( isset( $year ) ) {
			$query_args['year'] = intval( $year );
		}

		// Tax query override: array
        if ( isset( $tax_query ) ) {
            $query_args['tax_query'] = $tax_query;
		}

		// Ordering: string
        if ( $orderby ) {
			$query_args['orderby'] = $orderby;
		}

        // Run the WP Query
        $posts_query = new WP_Query( $query_args );

		// Posts list
		$posts = [];

		// Iterate returned posts
		while ( $posts_query->have_posts() ) {

			// Set the current post
			$posts_query->the_post();

            // Get the product categories
            $category_data = get_the_category();

			// Initiate category list
			$categories = [];

			// Construct categories list if available
			if ( is_array( $category_data ) ) {

				foreach( $category_data as $category ) {

                    $categories[] = [
                        'id'	=> $category->term_id,
                        'name'	=> $category->name,
                        'link'	=> get_term_link( $category )
					];
                }
            }

			// Filterable posts list
			$posts[] = apply_filters( 
				'ipress_posts_archive_' . $post_type, 
				[
					'date'		=> new DateTime( get_the_date() ),
					'id'		=> get_the_id(),
					'title'		=> get_the_title(),
					'excerpt'	=> get_the_excerpt(),
					'link'		=> get_the_permalink(),
                	'image' 	=> [
                    	'url' => get_the_post_thumbnail_url( get_the_id(), 'large' ),
                    	'alt' => get_the_title(),
                	],
					'category'  => $categories
				]
			);
        }

		// Process results
        $result = [
            'max_posts_per_page' => $posts_query->query_vars['posts_per_page'],
            'total_pages' => $posts_query->max_num_pages,
            'posts_returned' => $posts_query->post_count,
            'total_posts' => $posts_query->found_posts,
            'current_page' => $posts_query->query_vars['paged'],
            'posts' => $posts
        ];

        wp_reset_postdata();

		// Ok, done...
        return $result;
    }
endif;

if ( ! function_exists( 'ipress_related_posts_archive' ) ) :
	
	/**
	 * Retrieve related news by post IDs
	 *
	 * @param array $post_array list of post IDs
	 * @return array
	 */
    function ipress_related_posts_archive( $post_array = [] ) {
		
		global $post;

		// Post in loop required
        if ( ! empty( $post ) ) {

			// Retrieve post category IDs
			$post_categories_ids = wp_get_post_categories( $post->ID, [ 'fields' => 'ids' ] );

			// Retrieve News posts
            return ipress_posts_archive(
				[
					'posts_per_page' => -1,
					'post_type' 	 => 'post',
					'paged' 		 => 1,
					'cat' 			 => implode ( ',' , $post_categories_ids ),
					'post__in' 		 => $post_array,
				]
			);
        }
	}
endif;

if ( ! function_exists( 'ipress_featured_post_archive' ) ) :

	/**
	 * Retrieve featured post article
	 */
	function ipress_featured_post_archive( $post = null ) {

		// Post should be set
		if ( ! empty( $post ) ) {

			// Retrieve category data
            $category_data = get_the_category( $post );
            $categories = [];

			// Set category list
            if ( is_array( $category_data ) ) {
                foreach ( $category_data as $category ) {
                    $categories[] = $category->name;
            	}
			}

			// Retrieve featured news variables
			return [
                'title' => get_the_title( $post ),
                'link' => get_the_permalink( $post ),
                'date' => get_the_date( 'j F Y', $post ),
                'date_machine_format' => get_the_date( 'Y-m-d', $post ),
                'excerpt' =>  get_field( 'excerpt', $post ),
                'image' => get_the_post_thumbnail_url( $post ),
                'categories' => $categories
            ];
		}

		// Ok, nothing to do
		return null;
    }
endif;

if ( ! function_exists( 'ipress_single_post_archive' ) ) :

	/**
	 * Retrieve single post archive
	 */
	function ipress_single_post_archive() {

		// Post should be set
		global $post;

		// Ok, loop post set
		if ( ! empty( $post ) ) {

			// Set post data
            $post_title = get_the_title( $post );
            $post_human_readable_date 	= get_the_date( 'j F Y', $post );
            $post_machine_readable_date = get_the_date( 'Y-m-d', $post );
			$image = get_the_post_thumbnail_url( $post );
   			
			// Retrieve post categories
			$single_categories = wp_get_post_categories( $post->ID, [ 'fields' => 'names' ] );

			// Retrieve post category IDs & category names
            $single_categories_ids = wp_get_post_categories( $post->ID, [ 'fields' => 'ids' ] );
            $single_categories_names = implode ( ', ' , $single_categories );

			// Retrieve related posts
			$single_related_posts = ipress_posts_archive(
				[
                    'posts_per_page' => 3,
                    'paged' 		 => 1,
                    'cat' 			 => implode ( ',' , $single_categories_ids ),
                    'post__not_in' 	 => [ $post->ID ],
				]
			);

			// retrieve post settings
            return [
                'title' 						=> $post_title,
                'image' 						=> $image,
                'excerpt' 						=> get_field( 'excerpt', $post ),
                'post_human_readable_date' 	 	=> $post_human_readable_date,
                'post_machine_readable_date' 	=> $post_machine_readable_date,
                'categories' 	 				=> $single_categories,
                'categories_names' 				=> $single_categories_names,
                'related_posts' 				=> $single_related_posts
            ];
        }
    }
endif;
