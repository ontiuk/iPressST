<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme image functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	Images & Media
//
// ipress_post_image_id
// ipress_post_image
// ipress_image_sizes
// ipress_get_post_attachement
// ipress_post_thumbnail_url
// ipress_site_title_or_logo
// ipress_hex2rgb
// ipress_hex_is_light
//----------------------------------------------

if ( ! function_exists( 'ipress_post_image_id' ) ) :

	/**
	 * Pull an attachment ID from a post, if one exists
	 *
	 * @param integer $index default 0
	 * @param integer $post_id default null
	 * @return integer|boolean
	 */
	function ipress_post_image_id( $index = 0, $post_id = null ) {

		// Get image_ids for current or passed post
		$image_ids = array_keys(
			get_children(
				[
					'post_parent'    => ( $post_id ) ? absint( $post_id ) : get_the_ID(),
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'orderb'         => 'menu_order',
					'order'          => 'ASC',
				]
			)
		);

		// Set or not?
		return ( isset( $image_ids[ $index ] ) ) ? $image_ids[ $index ] : false;
	}
endif;

if ( ! function_exists( 'ipress_post_image' ) ) :

	/**
	 * Return an image pulled from the media gallery
	 *
	 * Supported $args keys are:
	 *
	 * - format   - string, default is 'html'
	 * - size     - string, default is 'full'
	 * - num      - integer, default is 0
	 * - attr     - string, default is ''
	 * - fallback - mixed, default is 'first-attached'
	 *
	 * Applies ipress_post_image_args, ipress_pre_post_image and ipress_get_image filters.
	 *
	 * @uses ipress_post_image_id()
	 * @param array|string $args default []
	 * @return string|boolean
	 */
	function ipress_post_image( $args = [] ) {

		// Set some image arg defaults
		$defaults = [
			'post_id'  => null,
			'format'   => 'html',
			'size'     => 'full',
			'num'      => 0,
			'attr'     => '',
			'fallback' => 'first-attached',
			'context'  => '',
			'echo'     => false,
		];

		// Filter default parameters used by ipress_post_image()
		$ip_defaults = (array) apply_filters( 'ipress_post_image_args', $defaults, $args );
		$args        = wp_parse_args( $args, $ip_defaults );

		// Allow filter to short-circuit this function
		$ip_pre_post_image = (bool) apply_filters( 'ipress_pre_post_image', false, $args, get_post() );
		if ( true === $ip_pre_post_image ) {
			return $ip_pre_post_image;
		}

		// If post thumbnail exists, use its id
		if ( has_post_thumbnail( $args['post_id'] ) && ( 0 === $args['num'] ) ) {

			$id = get_post_thumbnail_id( $args['post_id'] );

		} elseif ( 'first-attached' === $args['fallback'] ) {

			// If the first (default) image attachment is the fallback, use its id
			$id = ipress_post_image_id( $args['num'], $args['post_id'] );

		} elseif ( is_int( $args['fallback'] ) ) {

			// Else if fallback id is supplied, use it
			$id = $args['fallback'];

		}

		// If we have an id, get the html and url
		if ( isset( $id ) && is_int( $id ) ) {

			$html        = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
			list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );

		} elseif ( is_array( $args['fallback'] ) ) {

			// Else if fallback html and url exist, use them
			$id   = 0;
			$html = $args['fallback']['html'];
			$url  = $args['fallback']['url'];

		} else {

			// Else, return false (no image)
			return false;
		}

		// Source path, relative to the root
		$src = str_replace( esc_url( home_url() ), '', $url );

		// Set format
		$format = strtolower( $args['format'] );

		// Determine output
		switch ( $format ) {
			case 'html':
				$output = $html;
				if ( $echo ) {
					echo esc_html( $output );
				}
				break;
			case 'url':
				$output = $url;
				if ( $echo ) {
					echo esc_url( $output );
				}
				break;
			default:
				$output = $src;
				if ( $echo ) {
					echo esc_url( $output );
				}
				break;
		}

		// Output or return
		if ( ! $echo ) {
			return trim( $ip_output );
		}
	}
endif;

if ( ! function_exists( 'ipress_image_sizes' ) ) :

	/**
	 * Return all registered image sizes arrays, including the standard sizes
	 * - two-dimensional array of standard and additionally registered image sizes, with width, height and crop sub-keys
	 *
	 * @see wp_get_registered_image_sizes
	 * @uses ipress_additional_image_sizes()
	 * @param boolean $additional default true
	 * @return array
	 */
	function ipress_image_sizes( $additional = true ) {

		// Set generic image sizes
		$builtin_sizes = [
			'large'        => [
				'width'  => intval( get_option( 'large_size_w' ) ),
				'height' => intval( get_option( 'large_size_h' ) ),
				'crop'   => false,
			],
			'medium'       => [
				'width'  => intval( get_option( 'medium_size_w' ) ),
				'height' => intval( get_option( 'medium_size_h' ) ),
				'crop'   => false,
			],
			'medium_large' => [
				'width'  => intval( get_option( 'medium_large_size_w' ) ),
				'height' => intval( get_option( 'medium_large_size_h' ) ),
				'crop'   => false,
			],
			'thumbnail'    => [
				'width'  => intval( get_option( 'thumbnail_size_w' ) ),
				'height' => intval( get_option( 'thumbnail_size_h' ) ),
				'crop'   => get_option( 'thumbnail_crop' ),
			],
		];

		// Set custom additional image sizes
		$additional_sizes = ( true === $additional ) ? wp_get_additional_image_sizes() : [];

		// Return image sizes
		return ( empty( $additional_sizes ) ) ? $builtin_sizes : array_merge( $builtin_sizes, $additional_sizes );
	}
endif;

if ( ! function_exists( 'ipress_get_post_attachment' ) ) :

	/**
	 * Get post attachements by attachment mime type
	 *
	 * @param string $att_type
	 * @param integer $post_id default 0, uses current post in loop
	 * @param integer $count default 0, retrieve all
	 * @return array $post_attachments
	 */
	function ipress_get_post_attachment( $att_type, $post_id = 0, $count = 0 ) {

		// Sanitize post id, may require loop
		$post_id = absint( $post_id );
		$count   = absint( $count );
		if ( ! $post_id && ! in_the_loop() ) {
			return;
		}

		// Get attachment data
		$post_attachments = get_posts(
			[
				'post_type'      => 'attachment',
				'post_mime_type' => $att_type,
				'numberposts'    => ( 0 === $count ) ? -1 : $count,
				'post_parent'    => ( $post_id ) ? $post_id : get_the_ID(),
			]
		);

		// Return attachments
		return $post_attachments;
	}
endif;

if ( ! function_exists( 'ipress_post_thumbnail_url' ) ) :

	/**
	 * Retrieve the post thumbnail url if set
	 *
	 * @param string $size default full
	 * @return string
	 */
	function ipress_post_thumbnail_url( $size = 'full' ) {
		$thumbnail_id = (int) get_post_thumbnail_id();
		return ( $thumbnail_id > 0 ) ? wp_get_attachment_image_src( $thumbnail_id, $size, true )[0] : '';
	}
endif;

if ( ! function_exists( 'ipress_hex2rgb' ) ) :

	/**
	 * convert color form hex to rgb
	 *
	 * @param string $hex
	 * @param bool $array return array|string default string
	 * @return string
	 */
	function ipress_hex2rgb( $hex, $string = true ) {

		// Convert hex...
		$hex = str_replace( '#', '', $hex );

		// Condensed?
		if ( 3 === strlen( $hex ) ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}

		// ...to rgb
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		// RGB array
		$rgb = [
			'r' => $r,
			'g' => $g,
			'b' => $b,
		];

		// Return rgb value
		return ( true === $string ) ? $r . ', ' . $g . ', ' . $b : $rgb;
	}
endif;

if ( ! function_exists( 'ipress_hex_is_light' ) ) :

	/**
	 * Returns true for light colors and false for dark colors.
	 *
	 * @param strong $hex Hex color e.g. #111111.
	 * @return boolean True if the average lightness of the three components of the color is higher or equal than 127.5.
	 */
	function ipress_hex_is_light( $hex ) {
		$rgb_values    = ipress_hex2rgb( $hex, false );
		$avg_lightness = ( $rgb_values['r'] + $rgb_values['g'] + $rgb_values['b'] ) / 3;
		return $avg_lightness >= 127.5;
	}
endif;
