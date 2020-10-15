<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Category and Taxonomy shortcodes.
 *
 * @package		iPress\Shortcodes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

//---------------------------------------------
//	Category, Tag And Taxonomy Shortcodes
//	
//	ipress_post_tags
//	ipress_post_categories
//	ipress_post_terms
//	ipress_post_category_id
//	ipress_post_category_parent_id
//	ipress_post_category_slug
//	ipress_post_category_name
//	ipress_post_category_count
//	ipress_taxonomy_term_count
//	ipress_post_tags
//	ipress_post_categories
//	ipress_post_terms
//	ipress_post_category_id
//	ipress_post_category_parent_id
//	ipress_post_category_slug
//	ipress_post_category_name
//	ipress_post_category_count
//	ipress_taxonomy_term_count
//---------------------------------------------

/**
 * Produces the tag links list
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_tags_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> __( 'Tagged With: ', 'ipress' ),
		'sep'		=> ', ',
		'post_id'	=> 0
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_tags_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_tags' );
	
	// Tags if present in post
	$post_id 	= absint( $atts['post_id'] );
	$tags 		= ( $post_id === 0 ) ? 	get_the_tag_list( sanitize_text_field( $atts['before'] ), sanitize_text_field( $atts['sep'] ) . ' ', sanitize_text_field( $atts['after'] ) ) :
										get_the_tag_list( sanitize_text_field( $atts['before'] ), sanitize_text_field( $atts['sep'] ). ' ', sanitize_text_field( $atts['after'] ), $post_id );
	// None found?
	if ( ! $tags ) { return; }

	// Generate output
	$output = sprintf( '<div class="post-tags">%s</div>', $tags );
	$output = (string) apply_filters( 'ipress_post_tags_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Post Tags Shortcode
add_shortcode( 'ipress_post_tags', 'ipress_post_tags_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the category links list
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_categories_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'sep'		=> ', ',
		'before'	=> __( 'Filed Under: ', 'ipress' ),
		'after'		=> '',
		'parents'	=> '',
		'post_id'	=> 0
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_categories_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_categories' );

	// Get category list
	$post_id 	= absint( $atts['post_id'] );
	$cats 		= ( $post_id === 0 ) ? 	get_the_category_list( sanitize_text_field( $atts['sep'] ) . ' ', sanitize_text_field( $atts['parents'] ) ) :
								 		get_the_category_list( sanitize_text_field( $atts['sep'] ) . ' ', sanitize_text_field( $atts['parents'] ), $post_id );
	// None found?
	if ( ! $cats ) { return ''; }

	// Generate filterable output
	$output = sprintf( '<div class="post-categories">%s</div>', $atts['before'] . $cats . $atts['after'] );
	$output = (string) apply_filters( 'ipress_post_categories_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Categories Shortcode
add_shortcode( 'ipress_post_categories', 'ipress_post_categories_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the linked post taxonomy terms list
 *
 * @param	array|string $atts 
 * @return	string|boolean 
 */
function ipress_post_terms_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> __( 'Filed Under: ', 'ipress' ),
		'sep'		=> ', ',
		'taxonomy'	=> 'category',
		'post_id'	=> 0
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_terms_shortcode_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_terms' );

	// Category terms
	$post_id 	= absint( $atts['post_id'] );
	$terms 		= ( $post_id === 0 ) ? 	get_the_term_list( get_the_ID(), sanitize_text_field( $atts['taxonomy'] ), sanitize_text_field( $atts['before'] ), sanitize_text_field( $atts['sep'] ) . ' ', sanitize_text_field( $atts['after'] ) ) :
								  		get_the_term_list( $post_id , sanitize_text_field( $atts['taxonomy'] ), sanitize_text_field( $atts['before'] ), sanitize_text_field( $atts['sep'] ) . ' ', sanitize_text_field( $atts['after'] ) );

	// Bad terms, none there?
	if ( is_wp_error( $terms ) || empty( $terms ) ) { return; }

	// Generate filterable output
	$output = sprintf( '<div class="post-terms">%s</div>', $terms );
	$output = (string) apply_filters( 'ipress_post_terms_shortcode', $output, $terms, $atts );

	// Return output
	return trim( $output );
}

// Post Terms Shortcode
add_shortcode( 'ipress_post_terms', 'ipress_post_terms_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the post category ID
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_category_id_shortcode( $atts ) {

	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'post_id'	=> 0,
		'link'		=> false
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_category_id_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_category_id' );

	// Retrieve categories
	$post_id 	= absint( $atts['post_id'] );
	$cats 		= ( $post_id === 0 ) ? get_the_category() : get_the_category( $post_id );

	// None there?
	if ( ! $cats ) { return ''; }

	// Generate filterable output
	$output = ( $atts['link'] === true ) ? sprintf( '<span class="post-category-id">%s</span>', sanitize_text_field( $atts['before'] ) . '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" title="Category Link">' . (int) $cats[0]->cat_ID . '</a>' . sanitize_text_field( $atts['after'] ) ) :
										   sprintf( '<span class="post-category-id">%s</span>', sanitize_text_field( $atts['before'] ) . $cats[0]->cat_ID . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_post_category_id_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Category ID Shortcode
add_shortcode( 'ipress_post_category_id', 'ipress_post_category_id_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the post parent category ID
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_category_parent_id_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'post_id'	=> 0,
		'link'		=> false
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_category_parent_id_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_category_parent_id' );

	// Retrieve categories if available
	$post_id 	= absint( $atts['post_id'] );
	$cats 		= ( $post_id === 0 ) ? get_the_category() : get_the_category( $post_id );

	// None there?
	if ( ! $cats ) { return ''; }

	// Generate filterable output
	$output = ( $atts['link'] === true ) ? sprintf( '<span class="post-category-parent-id">%s</span>', sanitize_text_field( $atts['before'] ). '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" title="Category Link">' . (int) $cats[0]->category_parent . '</a>' . sanitize_text_field( $atts['after'] ) ) :
										   sprintf( '<span class="post-category-parent-id">%s</span>', sanitize_text_field( $atts['before'] ) . $cat[0]->category_parent . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_post_category_parent_id_shortcode', $output, $atts );

	// Return output 
	return trim( $output );
}

// Post Category Parent ID Shortcode
add_shortcode( 'ipress_post_category_parent_id', 'ipress_post_category_parent_id_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the post category slug
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_category_slug_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'post_id'	=> 0,
		'link'		=> false
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_category_slug_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_category_slug' );

	// Retrieve categories if available
	$post_id 	= absint( $atts['post_id'] );
	$cats 		= ( $post_id === 0 ) ? get_the_category() : get_the_category( $post_id );
	if ( ! $cats ) { return ''; }

	// Generate filterable output
	$output = ( $atts['link'] === true ) ? sprintf( '<span class="post-category-slug">%s</span>', sanitize_text_field( $atts['before'] ). '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" title="Category Link">' . $cats[0]->category_nicename . '</a>' . sanitize_text_field( $atts['after'] ) ) :
										   sprintf( '<span class="post-category-slug"%s></span>', sanitize_text_field( $atts['before'] ) . $cats[0]->category_nicename . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_post_category_slug_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Category Slug Shortcode
add_shortcode( 'ipress_post_category_slug', 'ipress_post_category_slug_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the post category name
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_category_name_shortcode( $atts ) {

	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'post_id'	=> 0,
		'link'		=> false
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_category_name_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_category_name' );

	// Retrieve categories if available
	$post_id 	= absint( $atts['post_id'] );
	$cats 		= ( $post_id === 0 ) ? get_the_category() : get_the_category( $post_id );
	if ( ! $cats ) { return ''; }

	// Generate output
	$output = ( $atts['link'] === true ) ? sprintf( '<span class="post-category-name">%s</span>', sanitize_text_field( $atts['before'] ) . '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" title="Category Link">' . $cats[0]->cat_name . '</a>' . sanitize_text_field( $atts['after'] ) ) :
										   sprintf( '<span class="post-category-name">%s</span>', sanitize_text_field( $atts['before'] ) . $cats[0]->cat_name . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_post_category_name_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Post Category Name
add_shortcode( 'ipress_post_category_name', 'ipress_post_category_name_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the post category count
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_category_count_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'post_id'	=> 0,
		'link'		=> false
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_category_count_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_category_count' );

	// Retrieve categories if available
	$post_id 	= absint( $atts['post_id'] );
	$cats 		= ( $post_id === 0 ) ? get_the_category() : get_the_category( $post_id );
	if ( ! $cats ) { return ''; }

	// Generate output
	$output = ( $atts['link'] === true ) ? sprintf( '<span class="post-category-count">%s</span>', sanitize_text_field( $atts['before'] ) . '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" title="Category Link">' . $cats[0]->category_count . '</a>' . sanitize_text_field( $atts['after'] ) ) :
										   sprintf( '<span class="post-category-count">%s</span>', sanitize_text_field( $atts['before'] ) . $cats[0]->category_count . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_post_category_count_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Post Category Count
add_shortcode( 'ipress_post_category_count', 'ipress_post_category_count_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//---------------------------------------------
//	Taxonomy Functions
//---------------------------------------------

/**
 * Generate the taxonomy term count
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_taxonomy_term_count_shortcode( $atts ) {

	global $wpdb;

	// Set defaults
	$defaults = [
		'taxonomy'	=> '',
		'term'		=> '',
		'before'	=> '',
		'after'		=> '',
		'link'		=> false
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_taxonomy_term_count_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_taxonomy_term_count' );

	// Taxonomy term required
	if ( empty( $atts['taxonomy'] ) || empty( $atts['term'] ) ) { return 0; }

	// Category by ID
	if ( is_numeric( $atts['term'] ) ) {
		$qs = $wpdb->prepare( 
			"SELECT {$wpdb->term_taxonomy}.count FROM {$wpdb->terms}, {$wpdb->term_taxonomy} 
			WHERE {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id 
			AND {$wpdb->term_taxonomy}.taxonomy=%s
			AND {$wpdb->term_taxonomy}.term_id=%d",
			sanitize_key( $atts['taxonomy'] ), 
			absint( $atts['term'] ) );
	} else {
		// Category by slug
		$qs = $wpdb->prepare( 
			"SELECT {$wpdb->term_taxonomy}.count FROM {$wpdb->terms}, {$wpdb->term_taxonomy} 
			WHERE {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id 
			AND {$wpdb->term_taxonomy}.taxonomy=%s
			AND {$wpdb->terms}.slug=%s",
			sanitize_key( $atts['taxonomy'] ), 
			strtolower( sanitize_text_field( $atts['term'] ) ) );
	}

	// Run query for cat count, pre-prepared
	$cat_count = (int)$wpdb->get_var( $qs ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

	// Generate output
	$output = ( $atts['link'] === true ) ? sprintf( '<span class="taxonomy-term-count">%s</span>', sanitize_text_field( $atts['before'] ) . '<a href="' . esc_url( get_term_link ( $atts['term'], $atts['taxonomy'] ) ) . '" title="Taxonomy Term Link">' . $cats[0]->category_count . '</a>' . sanitize_text_field( $atts['after'] ) ) :
										   sprintf( '<span class="taxonomy-term-count">%s</span>', sanitize_text_field( $atts['before'] ) . $cats[0]->category_count . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_taxonomy_term_count_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Taxonomy Count
add_shortcode( 'ipress_taxonomy_term_count', 'ipress_taxonomy_term_count_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//end
