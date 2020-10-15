<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Post & page related shortcodes.
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
//	Post, Comment & Content Shortcodes
//	
//	ipress_post_edit
//	ipress_post_date
//	ipress_post_time
//  ipress_post_modified_date
//  ipress_post_modified_time
//  ipress_post_author
//  ipress_post_author_link
//  ipress_post_author_posts_link
//  ipress_post_comments
//  ipress_post_id_by_name
//  ipress_post_id_by_type_name
//  ipress_post_code
//  ipress_post_type_count
//  ipress_post_type_list
//---------------------------------------------

/**
 * Displays the edit post link for logged in users.
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_edit_shortcode( $atts ) {

	global $post;

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'link'		=> __( '(Edit)', 'ipress' ),
		'post_id'	=> 0
	];
	
	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_edit_defaults', $defaults );

	// Get shortcode attributes
	$atts 		= shortcode_atts( $defaults, $atts, 'ipress_post_edit' );
	$post_id 	= absint( $atts['post_id'] );
	$link  	 	= sanitize_text_field( $atts['link'] );

	// Not in loop? must have post_id
	if ( ! in_the_loop() && $post_id === 0 ) { return false; }

	// Get post_id if not set
	$post_id = ( $post_id > 0 ) ? $post_id : ( ( isset( $post->ID ) ) ? $post->ID : $post_id );
   	if ( $post_id === 0 ) { return false; }	

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );
	$class   = ( isset( $atts['class'] ) ) ? sanitize_html_class( $atts['class'] ) : '';

	// Capture output... no function return
	ob_start();
	edit_post_link( $link, $before, $after, $post_id, $class );
	$output = ob_get_clean();
	$output = (string) apply_filters( 'ipress_post_edit_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Post Edit Link Shortcode
add_shortcode( 'ipress_post_edit', 'ipress_post_edit_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Displays the date of post publication.
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_date_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'format'	=> get_option( 'date_format' ),
		'label'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_date_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_date' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );
	$label 	 = sanitize_text_field( $atts['label'] );

	// Generate filterable output
	$display = get_the_time( $atts['format'], get_the_ID() );
	$output = sprintf( '<time class="post-time">%s</time>', $before . $label . $display . $after );
	$output = (string) apply_filters( 'ipress_post_date_shortcode', $output, $atts );

	// Return  output
	return trim( $output );
}

// Post Date Shortcode
add_shortcode( 'ipress_post_date', 'ipress_post_date_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Display the time of post publication.
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_time_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'format'	=> get_option( 'time_format' ),
		'label'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_time_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_time' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );
	$label   = sanitize_html_class( $atts['label'] );

	// Generate outpur
	$output = sprintf( '<time class="post-time">%s</time>', $before . $label . get_the_time( $atts['format'], get_the_ID() ) . $after );
	$output = (string) apply_filters( 'ipress_post_time_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Post Time Shortcode
add_shortcode( 'ipress_post_time', 'ipress_post_time_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Produce the post last modified date.
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_modified_date_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'format'	=> get_option( 'date_format' ),
		'label'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_modified_date_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_modified_date' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );
	$label   = sanitize_html_class( $atts['label'] );

	// Generate filterable output
	$display = get_the_modified_time( $atts['format'] );
	$output = sprintf( '<time class="post-modified-time updated">%s</time>', $before . $label . $display . $after );
	$output = apply_filters( 'ipress_post_modified_date_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Post Modified Date Shortcode
add_shortcode( 'ipress_post_modified_date', 'ipress_post_modified_date_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Display the post last modified time.
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_modified_time_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'format'	=> get_option( 'time_format' ),
		'label'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_modified_time_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_modified_time' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );
	$label   = sanitize_html_class( $atts['label'] );

	// Generate filterable output
	$output = sprintf( '<time class="post-modified-time updated">%s</time>', $before . $label . get_the_modified_time( $atts['format'] ) . $after );
	$output = (string) apply_filters( 'ipress_post_modified_time_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Modified Time Shortcode
add_shortcode( 'ipress_post_modified_time', 'ipress_post_modified_time_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generates the author of the post (unlinked display name).
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_author_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'  => '',
		'before' => '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_taxonomy_term_count_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_author' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Get the current author
	$author = get_the_author();

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );
	
	// Generate filterable output
	$output = sprintf( '<span class="post-author">%s<span class="post-author-name">%s</span>%s</span>', $before, esc_html( $author ), $after );
	$output = (string) apply_filters( 'ipress_post_author_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Author Shortcode
add_shortcode( 'ipress_post_author', 'ipress_post_author_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the author of the post (link to author URL).
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_author_link_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'    => '',
		'before'   => '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_author_link_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_author_link' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Get author url
	$url = get_the_author_meta( 'url' );

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );

	// If no url, use post author shortcode function.
	if ( ! $url ) { return ipress_post_author_shortcode( $atts ); }

	// Get the current author
	$author = get_the_author();

	// Generate filterable output
	$output  = sprintf( 
		'<span class="post-author">%s<a href="%s" class="post-author-link"><span">%s</span></a>%s</span>',
		$before,
		$url,
		esc_html( $author ),
		$after 
	);
	$output = (string) apply_filters( 'ipress_post_author_link_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Author Link
add_shortcode( 'ipress_post_author_link', 'ipress_post_author_link_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generates the author of the post (link to author archive).
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_author_posts_link_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'  => '',
		'before' => '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_author_posts_link_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_author_posts_link' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Get the author & author url	  
	$author = get_the_author();
	$url	= get_author_posts_url( get_the_author_meta( 'ID' ) );

	// Extras
	$before  = sanitize_text_field( $atts['before'] );
	$after 	 = sanitize_text_field( $atts['after'] );

	// Generate filterable output
	$output  = sprintf( 
		'<span class="post-author">%s<a href="%s" class="post-author-link"><span>%s</span></a>%s</span>',
		$before,
		$url,
		esc_html( $author ),
		$after 
	);
	$output = (string) apply_filters( 'ipress_post_author_posts_link_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Author Posts Link Shortcode
add_shortcode( 'ipress_post_author_posts_link', 'ipress_post_author_posts_link_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate the link to the current post comments.
 *
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_comments_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		  => '',
		'before'	  => '',
		'hide_if_off' => 'enabled',
		'more'		  => __( '% Comments', 'ipress' ),
		'one'		  => __( '1 Comment', 'ipress' ),
		'zero'		  => __( 'Leave a Comment', 'ipress' ),
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_comments_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_comments' );

	// Must be in loop
	if ( ! in_the_loop() ) { return; }

	// Extras
	$before  		= sanitize_text_field( $atts['before'] );
	$after 	 		= sanitize_text_field( $atts['after'] );
	$hide_if_off	= sanitize_text_field( $atts['hide_it_off'] );
	$more		  	= sanitize_text_field( $atts['more'] ); 
	$one		  	= sanitize_text_field( $atts['one'] );
	$zero		  	= sanitize_text_field( $atts['zero'] );

	// No comments if turned off for post
	if ( ! comments_open() && 'enabled' === $atts['hide_if_off'] ) { return; }

	// Capture result... no function return
	ob_start();
	comments_number( $zero, $one, $more );
	$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), ob_get_clean() );

	// Generate filterable output 
	$output = sprintf( '<span class="post-comments-link">%s</span>', $before . $comments . $after );
	$output = (string) apply_filters( 'ipress_post_comments_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post Comments Shortcode
add_shortcode( 'ipress_post_comments', 'ipress_post_comments_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Output post/page id by name
 * 
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_id_by_name_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'  => '',
		'before' => '',
		'name'	 => ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_taxonomy_term_count_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_id_by_name_posts_link' );

	// Extras
	$before  		= sanitize_text_field( $atts['before'] );
	$after 	 		= sanitize_text_field( $atts['after'] );
	$name		  	= sanitize_title( $atts['name'] ); 

	// Get page data if available
	$page = get_page_by_title( $name, OBJECT, 'post' );
	if ( ! $page ) { return; }

	// Generate filterable output
	$output = sprintf( '<span class="post-id-by-name">%s</span>', $before . $page->ID . $after );
	$output = (string) apply_filters( 'ipress_post_id_by_name_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post ID From Title Shortcode
add_shortcode( 'ipress_post_id_by_name', 'ipress_post_id_by_name_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Output post/page id by name
 * 
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_id_by_type_name_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'  => '',
		'before' => '',
		'name'	 => '',
		'type'	 => '',
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_id_by_type_name_defaults', $defaults );
	
	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_id_by_type_name_posts_link' );

	// Extras
	$before = sanitize_text_field( $atts['before'] );
	$after 	= sanitize_text_field( $atts['after'] );
	$name	= sanitize_title( $atts['name'] ); 
	$type 	= sanitize_key( $atts['type'] );

	// Get page data if available
	$page = get_page_by_path( $name, OBJECT, $type );
	if ( ! $page ) { return; }

	// Generate filterable output
	$output = sprintf( '<span class="post-id-by-type-name">%s</span>', $before . $page->ID . $after );
	$output = (string) apply_filters( 'ipress_post_id_by_type_name_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Post ID From Custom Post Type Shortcode
add_shortcode( 'ipress_post_id_by_type_name', 'ipress_post_id_by_type_name_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Output text wrapped in code tags
 * 
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_code_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'text'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_code_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_code' );

	// Text field required
	if ( empty( $atts['text'] ) ) { return; }

	// Extras
	$before  		= sanitize_text_field( $atts['before'] );
	$after 	 		= sanitize_text_field( $atts['after'] );
	$text		  	= sanitize_text_field( $atts['text'] ); 

	// Generate filterable output
	$output = sprintf( '<code class="post-code">%s</code>', $before . esc_html( $text ) . $after );
	$output = (string) apply_filters( 'ipress_post_code_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Code Tag Shortcode
add_shortcode( 'ipress_post_code', 'ipress_post_code_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate custom post type post count
 * 
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_type_count_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'before'	=> '',
		'after'		=> '',
		'type'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_type_count_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_type_count' );

	// Extras
	$before  		= sanitize_text_field( $atts['before'] );
	$after 	 		= sanitize_text_field( $atts['after'] );
	$post_type	  	= sanitize_key( $atts['type'] ); 

	// Valid post type required
	if ( empty( $post_type ) || ! post_type_exists( $post_type ) ) { return; }

	// Get post count
	$num_posts = wp_count_posts( $post_type );

	// Generate output
	$output = sprintf( '<span class="post-type-count">%s</span>', $before . intval( $num_posts->publish ) . $after );
	$output = (string) apply_filters( 'ipress_post_type_count_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Custom Post Type Post Count Shortcode
add_shortcode( 'ipress_post_type_count', 'ipress_post_type_count_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Generate custom post type post list
 * 
 * @param	array|string $atts 
 * @return	string 
 */
function ipress_post_type_list_shortcode( $atts ) {

	global $post;

	// Set defaults
	$defaults = [
		'before'			=> '',
		'after'				=> '',
		'type'				=> '',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1 
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_type_list_defaults', $defaults );

	// Start post list
	$posts = [];

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_type_list' );

	// Extras
	$before  		= sanitize_text_field( $atts['before'] );
	$after 	 		= sanitize_text_field( $atts['after'] );
	$post_type	  	= sanitize_key( $atts['type'] ); 
	$post_status	= sanitize_text_field( $atts['post_status'] ); 
	$posts_per_page	= intval( $atts['posts_per_page'] ); 

	// Valid post type required
	if ( empty( $post_type ) || ! post_type_exists( $post_type ) ) { return; }

	// Set up query
	$args = [ 
		'post_type'		 => $post_type,
		'post_status'	 => $post_status,
		'posts_per_page' => $posts_per_page 
	];
	$the_query = new WP_Query( $args );

	// The loop
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$posts[$post->ID] = $post->post_title;
		}
	}
	wp_reset_postdata();

	// Generate filterable outpu
	$output = sprintf( '<span class="post-type-list">%s</span>', $before . print_r( $posts, true ) . $after );
	$output = (string) apply_filters( 'ipress_post_type_list_shortcode', $output, $atts );

	// Return output
	return trim( $output );
}

// Custom Post Type Post List Shortcode - Should be used with do_shortcode
add_shortcode( 'ipress_post_type_list', 'ipress_post_type_list_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//end
