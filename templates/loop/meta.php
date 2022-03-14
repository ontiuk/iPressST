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

	// Set up time string
	$time_string = ( $date_modified ) ? '<time class="post-time published" datetime="%1$s">%2$s</time><time class="post-time updated hidden" datetime="%3$s">%4$s</time>' : '<time class="post-time published" datetime="%1$s">%2$s</time>';

	// Format time string
	if ( $date_modified ) {
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
	} else {
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
	}

	// Set post link
	$ip_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

	/* translators: %s post date. */
	$ip_post_date = sprintf( '<span class="post-date">%s %s</span>', __( 'Posted on', 'ipress' ), $ip_time_string );

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
	$ip_post_date = wp_kses( $ip_post_date, $allowed_html );

	// Post author if supported
	if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) ) {

		// Get the author name; wrap it in a link.
		$post_author = sprintf(
			/* translators: 1. post author link, 2. post author name. */
			__( 'By <span class="post-author"><a href="%1$s" class="post-author-link" rel="author"><span class="post-author-name">%2$s</span></a></span>', 'ipress' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author_meta( 'display_name' ) )
		);

		/* translators: %s: post author. */
		$ip_post_author = sprintf( '<span class="post-author">%s</span>', $post_author );

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
		$ip_post_author = wp_kses( $ip_post_author, $allowed_html );

		// output sanitized data
		echo sprintf( '%1$s %2$s', $ip_post_date, $ip_post_author );
	}
	?>
</section>
