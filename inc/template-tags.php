<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme template tag functions.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------  
// Template Tag Functions: Header
//
// ipress_header_style()
// ipress_header_image()
// ipress_site_title_or_logo()
// ipress_site_description()
//----------------------------------------------  

if ( ! function_exists( 'ipress_header_style' ) ) :
	
	/**
	 * Apply css styles & background imageto header.
	 *
	 * @uses  	get_header_image()
	 * @param	boolean	$echo	default true
	 * @return	string|void
	 */
	function ipress_header_style( $echo = true ) {

		// Header image?
		$is_header_image = get_header_image();

		// Header style defaults
		$header_style_defaults = ( $is_header_image ) ? [ 'background-image' => 'url(' . esc_url( $is_header_image ) . ')' ] : [];
		
		// Filterable output
		$ip_header_style = (array) apply_filters( 'ipress_header_style', $header_style_defaults );
		if ( empty( $ip_header_style ) ) { return; }

		// Set header style
		ob_start();
		foreach ( $ip_header_style as $style => $value ) {
			echo esc_attr( $style . ': ' . $value . '; ' );
		}
		$header_style = ob_get_clean();

		// Set header style
		$header_style =	sprintf( 'style="%s"', $header_style );

		// output or return, pre-sanitized
		if ( ! $echo ) { return $header_style; }
		echo $header_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_header_image' ) ) :
	
	/**
	 * Apply header image markup.
	 *
	 * @uses  get_header_image()
	 * @param	boolean	$echo	default true
	 * @return	string|void
	 */
	function ipress_header_image() {

		// Header image?
		if ( ! get_header_image() ) { return; }

		// Set header image class/es
		$ip_header_image_class = (array) apply_filters( 'ipress_header_image_class', [ 'header-image' ] );
		$ip_header_image_class = ( empty( $ip_header_image_class ) ) ? '' : sprintf( 'class="%s"', join( ' ', array_map( 'sanitize_html_class', $ip_header_image_class ) ) );

		// Set header image markup
		$ip_header_image = sprintf( '<div %s><a href="%s" rel="home"><img src="%s" width="%s" height="%s" alt="%s"></a></div>',
			$ip_header_image_class,
			esc_url( home_url( '/' ) ),
			get_header_image(),
			absint( get_custom_header()->width ),
			absint( get_custom_header()->height ),
			esc_attr( get_bloginfo( 'name', 'display' ) ) 
		);

		// Set header image html, pre-sanitized
		if ( ! $echo ) { return $ip_header_image; }
		echo $ip_header_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
	}
endif;

if ( ! function_exists( 'ipress_site_title_or_logo' ) ) :
	
	/**
	 * Get & display site title or logo. 
	 * - Based on twentytwenty site logo function.
	 *
	 * @param	array	$args
	 * @param	bool	$echo	default true
	 * @return	void|string
	 */
	function ipress_site_title_or_logo( $args = [], $echo = true ) {

		// Get basic details
		$logo       		= get_custom_logo();
		$site_title 		= get_bloginfo( 'name' );
		$site_description 	= get_bloginfo( 'description' );
		$contents   = '';
		$classname  = '';

		// Set default parameters
		$defaults = [
			'logo'        		=> '%1$s<span class="screen-reader-text">%2$s</span>',
			'logo_class'  		=> 'site-logo',
			'title'      		=> '<a href="%1$s" rel="home">%2$s</a>',
			'title_class' 		=> 'site-title',
			'description'		=> '<p class="%1$s">%2$s</p>',
			'description_class'	=> 'site-description',
			'home_tag'   		=> '<h1 class="%1$s site-home">%2$s</h1>',
			'page_tag'	 		=> '<div class="%1$s site-page">%2$s</div>',
			'condition'			=> ( is_front_page() || is_home() ) && ! is_page()
		];

		// Merge parameters and arguments
		$args = wp_parse_args( $args, $defaults );

		// Filterable site logo & title arguments
		$args = (array) apply_filters( 'ipress_site_title_logo_args', $args, $defaults );

		// Set up logo or title
		if ( has_custom_logo() ) {
			$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
			$classname = sanitize_html_class( $args['logo_class'] );
		} else {
			$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
			$classname = sanitize_html_class( $args['title_class'] );
		}

		// Home or page markup
		$tag = ( $args['condition'] ) ? 'home_tag' : 'page_tag';

		// Construct markup
		$html = sprintf( $args[ $tag ], $classname, $contents );

		// Filterable site logo & title merkup
		$html = (string) apply_filters( 'ipress_site_title_logo', $html, $args, $classname, $contents );

		// Add on the site decription?
		$html = (string) apply_filters( 'ipress_site_title_logo_description', $html, $args );

		// Return or display, should be pre-sanitized
		if ( ! $echo ) { return $html; }
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
	}
endif;

if ( ! function_exists( 'ipress_site_description' ) ) :
	
	/**
	 * Displays the site description
	 *
	 * @param	array	$args
	 * @param 	boolean $echo default true
	 * @return 	string 	$html 
	 */
	function ipress_site_description( $args = [], $echo = true ) {

		// Get description if available
		$description = get_bloginfo( 'description' );
		if ( ! $description ) {	return; }

		// Set default parameters
		$defaults = [
			'wrap'			=> '<div class="%1$s">%2$s</div><!-- .site-description -->',
			'wrap_class'	=> 'site-description'
		];

		// Merge parameters and arguments
		$args = wp_parse_args( $args, $defaults );

		// Filterable site logo & title arguments
		$args = (array) apply_filters( 'ipress_site_description_args', $args, $defaults );

		// Set description
		$html = sprintf( $args['wrap'], sanitize_html_class( $args['wrap_class'] ), esc_html( $description ) );

		// Return or display
		if ( ! $echo ) { return $html; }
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
	}
endif;

//----------------------------------------------  
// Template Tag Functions: Content Meta
// 
// ipress_post_date()
// ipress_post_time()
// ipress_post_datetime()
// ipress_post_author()
// ipress_get_attachment_meta()
//----------------------------------------------  

if ( ! function_exists( 'ipress_post_date' ) ) :
	
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @param	boolean	$datetime	default true	return <time>
	 */
	function ipress_post_date( $datetime = true ) {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }
		
		// Set the post time
		$ip_post_time = ( $datetime ) ? ipress_post_datetime() : ipress_post_time();

		// Set post link
		$ip_post_time = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $ip_post_time );

		/* translators: %s post date. */
		$ip_post_date = sprintf( '<span class="post-date">%1$s $2$s</span>', __( 'Posted on', 'ipress-child' ), $ip_post_time ); 

		// Allowed html tags for this functionality
		$allowed_html = (array) apply_filters( 'ipress_post_date_html', [
    		'a' => [
        		'href' 	=> [],
        		'title' => []
			],
			'span' => [
				'class'	=> [],
			],
			'time' => [
				'class'		=> [],
				'itemprop'	=> [],
				'datetime'	=> []
			]
		] );

		// output sanitized data with allowed html
		echo wp_kses( $post_date, $allowed_html );
	}
endif;

if ( ! function_exists( 'ipress_post_time' ) ) :
	
	/**
	 * Returns a formatted posted time stamp
	 */
	function ipress_post_time() {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return sprintf(
			/* translators: 1. post date link, 2. post time. */
			__( 'Posted on <a href="%1$s" rel="bookmark">%2$s</a>', 'ipress' ),
			esc_url( get_permalink() ),
			get_the_time( get_option( 'date_format' ) )
		);
	}
endif;

if ( ! function_exists( 'ipress_post_datetime' ) ) :
	
	/**
	 * Returns a formatted posted datetime stamp
	 */
	function ipress_post_datetime() {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		$date_modified = ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) );

		// Set up time string
		$time_string = ( $date_modified ) ? '<time class="post-time published" datetime="%1$s">%2$s</time><time class="post-time updated hidden" datetime="%3$s">%4$s</time>'
										  :	'<time class="post-time published" datetime="%1$s">%2$s</time>';

		// Format time string
		if ( $date_modified ) {
			return sprintf( $time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( DATE_W3C ) ),
				esc_html( get_the_modified_date() )
			);
		} else {
			return sprintf( $time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() ) 
			);
		}
	}
endif;

if ( ! function_exists( 'ipress_post_author' ) ) :
	
	/** 
	 * Prints HTML with meta information for the current author. 
	 */ 
	function ipress_post_author() { 
		
		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Supports author?
		if ( ! post_type_supports( get_post_type( get_the_ID() ), 'author' ) ) { return; }

		// Get the author name; wrap it in a link.
		$byline = sprintf( 
			/* translators: 1. post author link, 2. post author name. */
			__( 'By <span class="post-author"><a href="%1$s" class="post-author-link" rel="author"><span class="post-author-name">%2$s</span></a></span>', 'ipress' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author_meta( 'display_name' ) )
		); 

		/* translators: %s: post author. */ 
		$post_author = sprintf( '<span class="post-author">%s</span>', $byline ); 

		// Allowed html tags for this functionality
		$allowed_html = (array) apply_filters( 'ipress_post_author_html', [
    		'a' => [
        		'href' 		=> [],
				'title' 	=> [],
				'rel'		=> [],
				'itemprop' 	=> []
			],
			'span' => [
				'class'		=> [],
				'itemprop'	=> [],
				'itemscope'	=> [],
				'itemtype'	=> []
			]
		] );

		// output sanitized data with allowed html
		echo wp_kses( $post_author, $allowed_html );
	}
endif;

if ( ! function_exists( 'ipress_get_attachment_meta' ) ) :
	
	/**
	 * Get the image meta data
	 *
	 * @param	integer		$attachment_id
	 * @param	string		$size
	 * @return	array
	 */
	function ipress_get_attachment_meta( $attachment_id, $image, $size = '' ) {

		// Set up data
		$data = [
			'alt'			=> '',
			'caption'		=> '',
			'description'	=> '',
			'title'			=> '',
			'href'			=> '',
			'src'			=> '',
			'srcset'		=> '',
			'sizes'			=> '',
			'width'			=> '',
			'height'		=> ''
		];

		// Get attachment data
		$attachment = get_post( $attachment_id );

		// No valid attachment?
		if ( empty( $attachment ) ) { return $data; }
		
		// Image data
		list( $src, $width, $height ) = $image;

		// Get image meta data
		$image_meta = wp_get_attachment_metadata( $attachment_id );
 
		if ( is_array( $image_meta ) ) {
			$size_array = [ absint( $width ), absint( $height ) ];
			$srcset     = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attachment_id );
			$sizes      = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

			if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
				$data['srcset'] = $srcset;

				if ( empty( $attr['sizes'] ) ) {
					$data['sizes'] = $sizes;
				}
			}
		}

		// Construct data
		$data['alt']   			= strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
		$data['caption']		= $attachment->post_excerpt;
		$data['description']	= $attachment->post_content;
		$data['title']			= $attachment->post_title;
		$data['href']			= $attachment->guid;
		$data['src']			= $src;
		$data['width']			= $width;
		$data['height']			= $height;
	
		// Return image data	
		return $data;
	}
endif;

//----------------------------------------------  
// Template Tag Functions: Miscellaneous
//
// ipress_edit_post_link 
// ipress_post_thumbnail
// ipress_loop_image
// ipress_post_author_avatar
// ipress_post_categories
// ipress_post_tags
// ipress_post_comments_link
//----------------------------------------------  

if ( ! function_exists( 'ipress_edit_post_link' ) ) :
	
	/**
	 * Outputs an accessibility-friendly link to edit a post or page
	 */
	function ipress_edit_post_link() {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Set post link html
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit <span class="screen-reader-text">"%s"</span>', 'ipress' ),
				get_the_title()
			),
			'<div class="edit-link">',
			'</div>'
		);
	}
endif;

if ( ! function_exists( 'ipress_post_thumbnail' ) ) :

	/** 
	 * Displays an optional post thumbnail
	 * 
	 * Wraps the post thumbnail in an anchor element on index views, or a div 
	 * element when on single views. 
	 */ 
	function ipress_post_thumbnail( $size = 'full' ) { 

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Restrictions    
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) { return; } 

		// By Type, Single & Page don't need a link
		if ( is_singular() ) {
		   echo sprintf( '<div class="post-thumbnail">%s</div><!-- .post-thumbnail -->', esc_html( get_the_post_thumbnail( $size ) ) ); 
		} else { 
			echo sprintf( '<a class="post-thumbnail" href="%s" aria-hidden="true">%s</a>',
				esc_url( get_the_permalink() ),
				esc_html( get_the_post_thumbnail( 'post-thumbnail', [ 
					'alt' => the_title_attribute( [ 'echo' => false ] ), 
				] ) ) 
			); 
		} 
	} 
endif;

if ( ! function_exists( 'ipress_loop_image' ) ) :
	
	/**
	 * Post image display
	 *
	 * @param 	string $size default 'full'
	 */
	function ipress_loop_image( $size = 'full' ) {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Requires thumbnails
		if ( ! has_post_thumbnail() ) { return; }

		// Se up image markup
		$image_id 	= get_post_thumbnail_id( get_the_ID() );
		$image 		= wp_get_attachment_image_src( $image_id, $size ); 
		if ( $image ) {
			echo sprintf( '<div class="post-image"><a href="%s" title="%s"><img src="%s" /></a></div>',
				esc_url( get_permalink() ),
				esc_attr( the_title_attribute( [ 'echo' => false ] ) ),
				esc_url( $image[0] ) );
		}
	}
endif;

if ( ! function_exists( 'ipress_post_author_avatar' ) ) :
	
	/**
	 * Post Author display with avatar
	 */
	function ipress_post_author_avatar() {
		echo sprintf( '<span class="post-author author-avatar">%s<span>%s</span>%s</span>',
			get_avatar( get_the_author_meta( 'ID' ), 128 ),
			esc_html__( 'Written by', 'ipress' ),
			esc_url( get_the_author_posts_link() ) );
	}
endif;

if ( ! function_exists( 'ipress_post_categories' ) ) :
	
	/**
	 * Post Categories list
	 */
	function ipress_post_categories() {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Get category list
		if ( has_category() ) {
			echo sprintf( '<div class="post-categories"><span>%s</span>%s</div>',
				esc_html__( 'Posted in', 'ipress' ),
				get_the_category_list( ', ' ) );
		}
	}
endif;

if ( ! function_exists( 'ipress_post_tags' ) ) :
	
	/**
	 * Post Tags list
	 */
	function ipress_post_tags() {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Get the tag list
		if ( has_tag() ) {
			echo sprintf( '<div class="post-tags"><span>%s</span>%s</div>',
				esc_html__( 'Tagged in', 'ipress' ),
				get_the_tag_list( '', ', ' ) );
		}
	}
endif;

if ( ! function_exists( 'ipress_post_comments_link' ) ) :
	
	/**
	 * Prints comments template if available
	 */
	function ipress_post_comments_link() {

		// Not in the loop?
		if ( ! in_the_loop() ) { return; }

		// Test for password and comment status 
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo sprintf( '<div class="comments-link"><div class="comments-label">%s</div><span class="comments-link">%s</span></div>',
				esc_html__( 'Comments', 'ipress' ),
				esc_url( comments_popup_link() )
			);
		}
	}
endif;

// End
