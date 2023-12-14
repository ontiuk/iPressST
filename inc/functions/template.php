<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme template tag functions.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
// Template Functions: Attributes & Classes
//
// ipress_attr
// ipress_get_attr
// ipress_parse_attr
// ipress_context_classes
// ipress_get_context_classes
//----------------------------------------------

if ( ! function_exists( 'ipress_attr' ) ) :

	/**
	 * Output our string of HTML attributes
	 *
	 * @param string $context Context to process
	 * @param array $attr optional Context attributes, default []
	 * @param array $settings Optional custom data, default []
	 */
	function ipress_attr( $context, $attr = [], $settings = [] ) {
		echo ipress_get_attr( $context, $attr, $settings ); // phpcs:ignore -- Escaping done in function.
	}
endif;

if ( ! function_exists( 'ipress_get_attr' ) ) :
	
	/**
	 * Construct list of attributes into a string and apply contextual filter
	 *
	 * The contextual filter is of the form `ipress_attr_{context}_output`
	 *
	 * @param string $context Context to process
	 * @param array $attr optional Context attributes, default []
	 * @param array $settings Optional custom data, default []
	 * @return string
	 */
	function ipress_get_attr( $context, $attr = [], $settings = [] ) {

		// Retrieve sanitized attributes list		
		$attr = ipress_parse_attr( $context, $attr, $settings );

		// Initiate output
		$output = '';

		// Cycle through attributes, build tag attribute string
		foreach ( $attr as $key => $value ) {

			// Valid attr only
			if ( ! $value ) {
				continue;
			}

			// Deal with boolean values first
			if ( true === $value ) {
				$output .= esc_html( $key ) . ' ';
				continue;
			}

			// Remove any whitespace at the start or end of our classes
			if ( 'class' === $key ) {
				$value = trim( $value );
			}

			// Everything else...
			$output .= sprintf( '%1$s="%2$s" ', esc_html( $key ), esc_attr( $value ) );
		}
		return apply_filters( 'ipress_get_attr_output', $output, $attr, $context, $settings );
	}
endif;

if ( ! function_exists( 'ipress_parse_attr' ) ) :
	
	/**
	 * Merge array of attributes with defaults, and apply contextual filter on array
	 *
	 * The contextual filter is of the form `generate_attr_{context}`
	 *
	 * @param string $context Context to process
	 * @param array $attr optional Context attributes, default []
	 * @param array $settings Optional custom data, default []
	 * @return array
	 */
	function ipress_parse_attr( $context, $attr = [], $settings = [] ) {
		
		// Initialize a class attribute if not set
		$attr['class'] = ( isset( $attr['class'] ) ) ? array_map( 'sanitize_html_class', $attr['class'] ) : [];

		// Get any custom classes for context
		$classes = ipress_get_context_class( $context );
		if ( $classes ) {
			$attr['class'] = array_merge( $attr['class'], $classes );
		}

		// Stringify classes & add contextual attributes
		$attr['class'] = join( ' ', $attr['class'] );
		return apply_filters( 'ipress_parse_attr', $attr, $context, $settings );
	}
endif;

if ( ! function_exists( 'ipress_context_classes' ) ) :

	/**
	 * Display HTML classes for a context element
	 *
	 * @param string $context Element context
	 * @param array $class Custom classes
	 */
	function ipress_context_classes( $context, $class = [] ) {
		echo sprintf( 'class="%s"', join( ' ', ipress_get_context_classes( $context, $class ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
	}
endif;

if ( ! function_exists( 'ipress_get_context_classes' ) ) :

	/**
	 * Retrieve custom HTML classes for context
	 *
	 * @param string $context Element context
	 * @param array $class Custom classes
	 * @return array
	 */
	function ipress_get_context_classes( $context, $class = [] ) {
		$classes = ( $class ) ? array_map( 'sanitize_html_class', (array) $class ) : [];
		return apply_filters( "ipress_{$context}_class", $classes, $class );
	}
endif;

//----------------------------------------------
// Template Functions: Header
//
// ipress_header
// ipress_header_class
// ipress_get_header_class
// ipress_header_style
// ipress_get_header_style
// ipress_homepage_style
// ipress_header_image
// ipress_get_header_image
// ipress_site_description
// ipress_get_site_description
//----------------------------------------------

if ( ! function_exists( 'ipress_header' ) ) :

	/**
	 * Apply CSS classes & styles to header
	 */
	function ipress_header() {
		echo ipress_get_header_class() . ' ' . ipress_get_header_style(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_header_class' ) ) :

	/**
	 * Apply CSS classes to header
	 *
	 * @param array $class List of header classes
	 */
	function ipress_header_class( $class = [] ) {
		echo ipress_get_header_class( $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_header_class' ) ) :

	/**
	 * Apply CSS classes to header.
	 *
	 * @uses has_custom_logo()
	 * @param array $class List of header classes
	 * @return string
	 */
	function ipress_get_header_class( $class = [] ) {

		// Initialise classes, default 'site-header'
		$header_class = ( empty( $class ) ) ? [ 'site-header' ] : $class;

		// Custom logo?
		if ( has_custom_logo() ) {
			$header_class[] = 'has-logo';
		}

		// Title?
		if ( true === ipress_get_option( 'title_and_tagline', true ) ) {
			$header_class[] = 'has-title-and-tagline';
		}

		// Main Menu?
		if ( has_nav_menu( 'primary' ) ) {
			$header_class[] = 'has-menu';
		}

		// Return sanitized classes if set
		$ip_header_class = (array) apply_filters( 'ipress_header_class', $header_class );
		return ( empty( $ip_header_class ) ) ? '' : sprintf( 'class="%s"', join( ' ', array_map( 'sanitize_html_class', $ip_header_class ) ) );
	}
endif;

if ( ! function_exists( 'ipress_header_style' ) ) :

	/**
	 * Apply CSS styles & background image to header
	 */
	function ipress_header_style() {
		echo ipress_get_header_style(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_header_style' ) ) :

	/**
	 * Apply CSS styles & background image to header
	 *
	 * @uses get_header_image()
	 * @return string
	 */
	function ipress_get_header_style() {

		// Header image?
		$is_header_image = get_header_image();

		// Header style defaults
		$header_style_image = ( $is_header_image ) ? [ 'background-image' => 'url(' . esc_url( $is_header_image ) . ')' ] : [];

		// Filterable output
		$ip_header_style = (array) apply_filters( 'ipress_header_style', [] );
		array_walk( $ip_header_style, function( $item, $key ) {
			return esc_attr( $key . ': ' , $item ); 
		} );

		// Return sanitized header style
		$ip_header_style = ( empty( $ip_header_style ) ) ? $header_style_image : array_merge( $header_style_image, $ip_header_style ); 
		return ( empty( $ip_header_style ) ) ? '' : sprintf( 'style="%s"', join( ' ', $ip_header_style ) );
	}
endif;

if ( ! function_exists( 'ipress_homepage_style' ) ) :

	/**
	 * Apply CSS styles & background image to homepage header
	 *
	 * @uses get_header_image()
	 */
	function ipress_homepage_style() {

		// Inline style
		$ip_homepage_image_inline = (bool) apply_filters( 'ipress_homepage_image_inline', true );
		if ( false === $ip_homepage_image_inline ) {

			// Header image?
			$is_header_image = get_the_post_thumbnail_url( get_the_ID() );

			// Header style defaults
			$header_style_image = ( $is_header_image ) ? [ 'background-image' => 'url(' . esc_url( $is_header_image ) . ')' ] : [];

		} else {
			$header_style_image = [];
		}

		// Filterable output
		$ip_header_style = (array) apply_filters( 'ipress_homepage_style', [] );
		array_walk( $ip_header_style, function( $item, $key ) {
			return esc_attr( $key . ': ' , $item );
		} );

		// Return header style
		$ip_header_style = ( empty( $ip_header_style ) ) ? $header_style_image : array_merge( $header_style_image, $ip_header_style ); 
		echo ( empty( $ip_header_style ) ) ? '' : sprintf( 'style="%s"', join( ' ' , $ip_header_style ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_header_image' ) ) :

	/**
	 * Apply header image markup
	 */
	function ipress_header_image() {
		echo ipress_get_header_image(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_header_image' ) ) :

	/**
	 * Apply header image markup
	 *
	 * @uses get_header_image()
	 * @return string
	 */
	function ipress_get_header_image() {

		// Header image?
		if ( ! get_header_image() ) {
			return;
		}

		// Set header image class/es
		$ip_header_image_class = (array) apply_filters( 'ipress_header_image_class', [ 'header-image' ] );
		$ip_header_image_class = ( empty( $ip_header_image_class ) ) ? '' : sprintf( 'class="%s"', join( ' ', array_map( 'sanitize_html_class', $ip_header_image_class ) ) );

		// Set header image markup
		return sprintf(
			'<div %s><a href="%s" rel="home"><img src="%s" width="%s" height="%s" alt="%s"></a></div>',
			$ip_header_image_class,
			esc_url( home_url( '/' ) ),
			get_header_image(),
			absint( get_custom_header()->width ),
			absint( get_custom_header()->height ),
			esc_attr( get_bloginfo( 'name', 'display' ) )
		);
	}
endif;

if ( ! function_exists( 'ipress_site_description' ) ) :

	/**
	 * Displays the site description
	 *
	 * @param array $args Arguments for html wrappers
	 */
	function ipress_site_description( $args = [] ) {
		echo ipress_get_site_description( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
	}
endif;

if ( ! function_exists( 'ipress_get_site_description' ) ) :

	/**
	 * Displays the site description
	 *
	 * @param array $args Arguments for html wrappers
	 * @return string
	 */
	function ipress_get_site_description( $args = [] ) {

		// Get description if available
		$description = get_bloginfo( 'description' );
		if ( ! $description ) {
			return;
		}

		// Set default parameters
		$defaults = [
			'wrap'       => '<div class="%1$s">%2$s</div><!-- .site-description -->',
			'wrap_class' => 'site-description',
		];

		// Merge parameters and arguments
		$args = wp_parse_args( $args, $defaults );

		// Set description
		$args = (array) apply_filters( 'ipress_site_description_args', $args, $defaults );
		return sprintf( $args['wrap'], sanitize_html_class( $args['wrap_class'] ), esc_html( $description ) );
	}
endif;

//----------------------------------------------
// Template Functions: Content Meta
//
// ipress_post_date
// ipress_get_post_time
// ipress_get_post_datetime
// ipress_post_author
// ipress_get_attachment_meta
// ipress_get_page_info
// ipress_get_page_classes
//----------------------------------------------

if ( ! function_exists( 'ipress_post_date' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author
	 *
	 * @param boolean $datetime Display time or datetime, default true datetime
	 */
	function ipress_post_date( $datetime = true ) {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Set the post time, default full time
		$post_time = ( true === $datetime ) ? ipress_get_post_datetime() : ipress_get_post_time();

		// Set post link
		$post_date_link = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), $post_time );

		// Set the post prefix
		$ip_post_date_prefix = apply_filters( 'ipress_post_date_prefix', __( 'Posted on ', 'ipress-standalone' ) );

		/* translators: %s post date. */
		$post_date = sprintf( '<span class="post-date">%1$s%2$s</span>', $ip_post_date_prefix, $post_date_link );

		// Allowed html tags for this functionality
		$allowed_html = (array) apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'ipress_post_date_html',
			[
				'a'    => [
					'href'  => [],
					'title' => [],
				],
				'span' => [
					'class' => [],
				],
				'time' => [
					'class'    => [],
					'itemprop' => [],
					'datetime' => [],
				],
			]
		);

		// Output sanitized data with allowed html
		echo wp_kses( $post_date, $allowed_html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_post_time' ) ) :

	/**
	 * Returns a formatted posted time stamp
	 */
	function ipress_get_post_time() {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return sprintf(
			/* translators: 1. post date link, 2. post time. 3. post time.*/
			__( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>', 'ipress-standalone' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_html( get_the_time( get_option( 'time_format' ) ) )
		);
	}
endif;

if ( ! function_exists( 'ipress_get_post_datetime' ) ) :

	/**
	 * Returns a formatted posted datetime stamp
	 */
	function ipress_get_post_datetime() {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Has the post been modified?
		$date_modified = ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) );

		// Initialise up time string
		$time_string = '<time class="post-time published" datetime="%1$s">%2$s</time>';

		// Reset time string for updated dates
		if ( $date_modified ) {

			// Show all of time string or just updated?
			$ip_post_datetime_updated_only = ( bool) apply_filters( 'ipress_post_datetime_updated_only', false );

			// Define time string
			$time_string = ( true === $ip_post_datetime_updated_only ) ? '<time class="post-time updated-time" datetime="%3$s">%4$s</time>'
			   														   : '<time class="post-time updated hidden" datetime="%3$s">%4$s</time>' . $time_string;
		}

		// Format time string
		return sprintf(
			$time_string,
			esc_attr( get_the_time( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_time( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
	}
endif;

if ( ! function_exists( 'ipress_post_author' ) ) :

	/**
	 * Prints HTML with meta information for the current author.
	 */
	function ipress_post_author() {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Supports author?
		if ( ! post_type_supports( get_post_type( get_the_ID() ), 'author' ) ) {
			return;
		}

		// Display author link?
		$ip_post_author_link = (bool) apply_filters( 'ipress_post_author_link', true );

		/* translators: 1. post author link, 2. post author name. */
		$byline = ( true === $ip_post_author_link ) ? '<span class="author"><a href="%1$s" class="author-link" title="%2$s" rel="author"><span class="author-name">%3$s</span></a></span>'
													: '<span class="author"><span class="author-name">%3$s</span></span>';

		// Get the author name; wrap it in a link.
		$byline = sprintf(
			$byline,
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'ipress-standalone' ), get_the_author() ) ),
			esc_html( get_the_author_meta( 'display_name' ) )
		);

		// Set the post author wrapper
		$post_author = sprintf( '<span class="post-author">%1$s%2$s</span>', apply_filters( 'ipress_post_author_meta', ''), $byline );

		// Allowed html tags for this functionality
		$allowed_html = (array) apply_filters(
			'ipress_post_author_html',
			[
				'a'    => [
					'href'     => [],
					'title'    => [],
					'rel'      => [],
					'itemprop' => [],
				],
				'span' => [
					'class'     => [],
					'itemprop'  => [],
					'itemscope' => [],
					'itemtype'  => [],
				],
			]
		);

		// Output sanitized data with allowed html
		echo wp_kses( $post_author, $allowed_html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_attachment_meta' ) ) :

	/**
	 * Get the image meta data
	 *
	 * @param integer $attachment_id Attachment ID
	 * @param string $image Image data
	 * @param string $size Default image size, default ''
	 * @return array
	 */
	function ipress_get_attachment_meta( $attachment_id, $image, $size = '' ) {

		// Set up data
		$data = [
			'alt'         => '',
			'caption'     => '',
			'description' => '',
			'title'       => '',
			'href'        => '',
			'src'         => '',
			'srcset'      => '',
			'sizes'       => '',
			'width'       => '',
			'height'      => '',
		];

		// Get attachment data
		$attachment = get_post( $attachment_id );

		// No valid attachment?
		if ( empty( $attachment ) ) {
			return $data;
		}

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

		// Construct image data
		$data['alt']         = strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
		$data['caption']     = $attachment->post_excerpt;
		$data['description'] = $attachment->post_content;
		$data['title']       = $attachment->post_title;
		$data['href']        = $attachment->guid;
		$data['src']         = $src;
		$data['width']       = $width;
		$data['height']      = $height;
		return $data;
	}
endif;

if ( ! function_exists( 'ipress_get_page_info' ) ) :

	/**
	 * Retrieve page info
	 *
	 * @param array $custom_parent Parent post ID
	 * @return array
	 */
	function ipress_get_page_info( array $custom_parent = [] ) {

		// Post should be set
		global $post;

		// No post?
		if ( empty( $post ) ) {
			return [];
		}

		// Set parent details		
        if ( ! empty( $custom_parent ) ) {
            $parent_id 	 = $custom_parent['parent_id'];
            $parent_name = $custom_parent['parent_name'];
		} else {
	        $parent_id 	 = $post->post_parent;
    	    $parent_name = ( $parent_id > 0 ) ? get_post( $post->post_parent )->post_name : '';
		}

		// Primary details
        $page_id 	= $post->ID;
        $page_name 	= $post->post_name;

		// Post data
        $post_date = [
            'display' => get_the_date( 'j F Y', $post ),
            'default' => get_the_date( 'Y-m-d', $post ),
        ];

		// Post category by post ID
		$post_categories = wp_get_post_categories( 
			$post->ID, 
			[
                'fields' => 'ids',
                'fields' => 'names'
            ]
        );

		// Set post categories
		$post_categories_list_names = ( ! empty( $post_categories['names'] ) ) ? implode ( ', ' , $post_categories['names'] ) : '';

		// Return page info
		return [
			'page_id' 		=> $page_id,
			'page_name' 	=> $page_name,
			'parent_id' 	=> $parent_id,
			'parent_name' 	=> $parent_name,
			'post_date' 	=> $post_date,
			'post_categories' => $post_categories,
			'post_categories_list_names' => $post_categories_list_names,
		];
    }
endif;

if ( ! function_exists( 'ipress_get_page_classes' ) ) :

	/**
	 * Retrieve page body classes
	 *
	 * @return array
	 */
	function ipress_get_page_classes() {

		// Retrieve the current page info
		$page_info = ipress_get_page_info();

		// Initiate body classes
		$body_classes = [];

		// Structure body classes
		if ( $page_info ) {

			// Core classes
			$body_classes[] = 'page_id-' . $page_info['page_id'];
			$body_classes[] = 'page_name-' . $page_info['page_name'];

			// Parent classes
            if ( ! empty( $page_info['parent_id'] ) ) {
				$body_classes[] = 'parent_id-' . $page_info['parent_id'];
				$body_classes[] = 'parent_name-' . $page_info['parent_name'];
            };
		}

		// Return class list
		return join( ' ', $body_classes );
	}
endif;

//----------------------------------------------
// Template Functions: Miscellaneous
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
		if ( ! in_the_loop() ) {
			return;
		}

		// Set post link html
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit <span class="screen-reader-text">"%s"</span>', 'ipress-standalone' ),
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
	 * - Wraps the post thumbnail in an anchor element on index views, or a div element when on single views
	 *
	 * @param string $size Image size, default full
	 */
	function ipress_post_thumbnail( $size = 'full' ) {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Restrictions
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		// By Type, Single & Page don't need a link
		if ( is_singular() ) {
			echo sprintf(
				'<div class="post-thumbnail">%s</div><!-- .post-thumbnail -->',
				esc_html( get_the_post_thumbnail( $size ) )
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
			return;
		}

		// All other pages
		echo sprintf( 
			'<a class="post-thumbnail" href="%1$s" aria-hidden="true">%2$s</a>',
			esc_url( get_the_permalink() ),
			esc_html( get_the_post_thumbnail( 'post-thumbnail', [ 'alt' => the_title_attribute( [ 'echo' => false ] ) ] ) )
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
	}
endif;

if ( ! function_exists( 'ipress_loop_image' ) ) :

	/**
	 * Post image display
	 *
	 * @param string $size Image size, default 'full'
	 */
	function ipress_loop_image( $size = 'full' ) {

		// Not in the loop ?Or Requires thumbnails
		if ( ! has_post_thumbnail() ) {
			return;
		}

		// Se up image markup
		$image_id = get_post_thumbnail_id( get_the_ID() );
		$image    = wp_get_attachment_image_src( $image_id, $size );
		if ( $image ) {
			echo sprintf(
				'<div class="post-image"><a href="%1$s" title="%2$s"><img src="%3$s" /></a></div>',
				esc_url( get_permalink() ),
				esc_attr( the_title_attribute( [ 'echo' => false ] ) ),
				esc_url( $image[0] )
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
		}
	}
endif;

if ( ! function_exists( 'ipress_post_author_avatar' ) ) :

	/**
	 * Post Author display with avatar
	 */
	function ipress_post_author_avatar() {
		echo sprintf(
			'<span class="post-author author-avatar">%s<span>%s</span>%s</span>',
			get_avatar( get_the_author_meta( 'ID' ), 128 ),
			esc_html__( 'Written by', 'ipress-standalone' ),
			esc_url( get_the_author_posts_link() )
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
	}
endif;

if ( ! function_exists( 'ipress_post_categories' ) ) :

	/**
	 * Post Categories list
	 */
	function ipress_post_categories() {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Set category list separator
		$ip_cat_term_separator = apply_filters( 'ipress_cat_term_separator', _x( ', ', 'Used between category list items.', 'ipress-standalone' ), 'categories' );

		// Set the category list prefix
		$ip_category_list_prefix = apply_filters( 'ipress_cat_list_prefix', esc_html__( 'Posted in', 'ipress-standalone' ) );

		// Get the categories
		$category_list = get_the_category_list( $ip_cat_term_separator );
		
		// Get category list
		if ( $category_list ) {
			echo sprintf(
				'<div class="post-categories"><span>%3$s</span><span class="screen-reader-text">%1$s</span>%2$s</div>',
				esc_html_x( 'Categories', 'Used before category list.', 'ipress-standalone' ),
				$category_list,
		   		$ip_category_list_prefix
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
		}
	}
endif;

if ( ! function_exists( 'ipress_post_tags' ) ) :

	/**
	 * Post Tags list
	 */
	function ipress_post_tags() {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Set tags list separator
		$ip_tag_term_separator = apply_filters( 'ipress_tag_term_separator', _x( ', ', 'Used between tag names.', 'ipress-standalone' ), 'categories' );

		// Set the tag name prefix
		$ip_tag_list_prefix = apply_filters( 'ipress_tag_name_prefix', esc_html__( 'Tagged in', 'ipress-standalone' ) );

		// Get the tag list
		$tag_list = get_the_tag_list( '', $ip_tag_term_separator );

		// Get the tag list
		if ( $tag_list ) {
			echo sprintf(
				'<div class="post-tags"><span>%3$s</span><span class="screen-reader-text">%1$s</span>%2$s</div>',
				esc_html_x( 'Tags', 'Used before tag names.', 'ipress-standalone' ),
				$tag_list,
				$ip_tag_list_prefix
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
		}
	}
endif;

if ( ! function_exists( 'ipress_post_comments_link' ) ) :

	/**
	 * Prints comments template if available
	 */
	function ipress_post_comments_link() {

		// Not in the loop?
		if ( ! in_the_loop() ) {
			return;
		}

		// Set comment link text
		$ip_comments_link_prefix = apply_filters( 'ipress_comments_link_prefix', esc_html__( 'Comments', 'ipress-standalone' ) );

		// Test for password and comment status
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo sprintf(
				'<span class="comments-link"><span class="comments-label">%1$s</span>%2$s</span></span>',
				$ip_comments_link_prefix,
				comments_popup_link( __( 'Leave a comment', 'ipress-standalone' ), __( '1 Comment', 'ipress-standalone' ), __( '% Comments', 'ipress-standalone' ) )
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
		}
	}
endif;
