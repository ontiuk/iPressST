<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Images and media shortcodes.
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
// Images and Media Shortcodes 
//
// ipress_attachment_meta
// ipress_post_attachments
// ipress_image_hex_to_rgb
//---------------------------------------------

/**
 * Retrieve attachment meta data
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_attachment_meta_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'			=> '',
		'before'		=> '',
		'attachment'	=> '',
		'size'			=> ''
	];
	
	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_attachment_meta_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_attachment_meta' );

	// Attachment ID required
	if ( ! isset( $atts['attachment_id'] ) ) { return false; }

	// Get attachment data
	$attachment_id 	= absint( $atts['attachment_id'] );
	$attachment 	= get_post( $attachment_id );

	// Set thumbnail if available  
	$att_data_thumb = wp_get_attachment_image_src( $attachment_id, sanitize_text_field( $atts['size'] ) );
	if ( ! $att_data_thumb ) { return false; }
	
	// Generate attachment data
	$data = [];
	$data['alt']			= get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
	$data['caption']		= $attachment->post_excerpt;
	$data['description']	= $attachment->post_content;
	$data['href']			= $attachment->guid;
	$data['src']			= $att_data_thumb[0];
	$data['title']			= $attachment->post_title;

	// Generate output
	$output = sprintf( '<span class="attachment-meta">%s</span>', sanitize_text_field( $atts['before'] ) . print_r( $data, true ) . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_attachment_meta_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Attachment meta data shortcode
add_shortcode( 'ipress_attachment_meta', 'ipress_attachment_meta_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Get post attachements by attachement mime type 
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_post_attachments_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'				=> '',
		'before'			=> '',
		'post_mime_type'	=> '',
		'numberposts'		=> -1, // phpcs:ignore WPThemeReview.CoreFunctionality.PostsPerPage.posts_per_page_numberposts
		'post_parent'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_post_attachments_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_post_attachments' );

	// Parent & type required
	if ( empty( $atts['post_parent'] ) || empty( $atts['post_mime_type'] ) ) { return false; }

	// Set some defaults
	$numberposts =	intval( $atts['numberposts'] );
	$post_parent =	absint( $atts['post_parent'] );
	
	// Get attachment data if available
	$attachments = get_posts( [
		'post_type'			=> 'attachment',
		'post_mime_type'	=> sanitize_text_field( $atts['post_mime_type'] ),
		'numberposts'		=> $numberposts,
		'post_parent'		=> $post_parent
	] );
	if ( ! $attachments ) { return false; }

	// Generate output
	$output = sprintf( '<span class="post-attachment">%s</span>', sanitize_text_field( $atts['before'] ) . join( ' ', $attachments ) . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_post_attachments_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Attachments by post ID shortcode
add_shortcode( 'ipress_post_attachments', 'ipress_post_attachments_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

/**
 * Convert color form hex to rgb
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_image_hex_to_rgb_shortcode( $atts ) {

	// Set defaults
	$defaults = [
		'after'		=> '',
		'before'	=> '',
		'hex'		=> ''
	];

	// Set shortcode defaults
	$defaults = (array) apply_filters( 'ipress_image_hex_to_rgb_defaults', $defaults );

	// Get shortcode attributes
	$atts = shortcode_atts( $defaults, $atts, 'ipress_image_hex_to_rgb' );

	// Hex code required
	if ( empty( $atts['hex'] ) ) { return false; }

	// Hex with hash
	$hex_color = ( false === strpos( $atts['hex'], '#' ) ) ? sanitize_hex_color_without_hash( $atts['hex'] ) : sanitize_hex_color( $atts['hex'] );

	// Convert hex code...
	$hex_color = str_replace( '#', '', $hex_color );

	// ...to rgb data
	$r = hexdec( substr( $hex_color, 0, 2 ) );
	$g = hexdec( substr( $hex_color, 2, 2 ) );
	$b = hexdec( substr( $hex_color, 4, 2 ) );
	$rgb = $r . ',' . $g . ',' . $b; 

	// Generate output
	$output = sprintf( '<span class="image-hex-to-rgb">%s</span>', sanitize_text_field( $atts['before'] ) . esc_attr( $rgb ) . sanitize_text_field( $atts['after'] ) );
	$output = (string) apply_filters( 'ipress_image_hex_to_rgb_shortcode', $output, $atts );

	// Return filterable output
	return trim( $output );
}

// Hex Colour Code shortcode
add_shortcode( 'ipress_image_hex_to_rgb', 'ipress_image_hex_to_rgb_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//end
