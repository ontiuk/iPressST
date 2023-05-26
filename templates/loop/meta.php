<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop meta data.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( 'post' !== get_post_type() ) {
	return;
}
?>
<section class="post-meta">
	<?php
	// Test modified date
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
	$post_time = sprintf(
		$time_string,
		esc_attr( get_the_time( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_time( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	// Set post link
	$post_date_link = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), $post_time );

	// Set the post prefix
	$ip_post_date_prefix = apply_filters( 'ipress_post_date_prefix', __( 'Posted on ', 'ipress' ) );

	/* translators: %s post date. */
	$post_date = sprintf( '<span class="post-date">%1$s%2$s</span>', $ip_post_date_prefix, $post_date_link );

	// Allowed html tags for this functionality
	$allowed_html = (array) apply_filters(
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

	// output sanitized data with allowed html
	$post_date = wp_kses( $post_date, $allowed_html );

	// Post author if supported
	if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) ) {

		// Display author link?
		$ip_post_author_link = (bool) apply_filters( 'ipress_post_author_link', true );

		/* translators: 1. post author link, 2. post author name. */
		$byline = ( true === $ip_post_author_link ) ? '<span class="author"><a href="%1$s" class="author-link" title="%2$s" rel="author"><span class="author-name">%3$s</span></a></span>'
													: '<span class="author"><span class="author-name">%3$s</span></span>';

		// Get the author name; wrap it in a link.
		$byline = sprintf(
			$byline,
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'ipress' ), get_the_author() ) ),
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
		
		// Construct author with allowed html
		$post_author = wp_kses( $post_author, $allowed_html );

		// output sanitized data
		echo sprintf( '%1$s %2$s', $post_date, $post_author );
	}
	?>
</section>
