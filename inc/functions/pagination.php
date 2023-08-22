<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme pagination functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
// Pagination
//
// ipress_prev_next_posts_nav
// ipress_get_prev_next_posts_nav
// ipress_prev_next_post_nav
// ipress_get_prev_next_post_nav
// ipress_post_navigation
// ipress_get_post_navigation
// ipress_loop_navigation
// ipress_get_loop_navigation
// ipress_pagination
// ipress_get_pagination
// ipress_posts_navigation
// ipress_get_posts_navigation
//----------------------------------------------

if ( ! function_exists( 'ipress_prev_next_posts_nav' ) ) :

	/**
	 * Generate pagination in Previous / Next Posts format for post archive listings
	 * 
	 * - Default display with Older / Newer links
	 */
	function ipress_prev_next_posts_nav() {
		echo ipress_get_prev_next_posts_nav(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_prev_next_posts_nav' ) ) :

	/**
	 * Generate pagination in Previous / Next Posts format for post archive listings
	 *
	 * - Default display with Older / Newer links
	 *
	 * @return string $output
	 */
	function ipress_get_prev_next_posts_nav() {

		global $wp_query;

		// Archive pages only
		if ( is_single() ) {
			return;
		}

		// Don't print empty markup in archives if there's only one page
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}
		
		// Previous Next Context
		$ip_next_nav_link = (string) apply_filters( 'ipress_next_nav_link', __( '&larr; Older', 'ipress' ) );
		$ip_prev_nav_link = (string) apply_filters( 'ipress_prev_nav_link', __( 'Newer &rarr;', 'ipress' ) );

		// Get nav links
		ob_start();
		?>
		<section id="pagination" class="posts-pagination <?php echo sanitize_html_class( apply_filters( 'ipress_posts_navigation_class', '' ) );?>">
			<nav class="posts-navigation" role="navigation">
				<div class="nav-links">
					<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-next">
						<span class="next" title="<?php echo esc_attr__( 'Next', 'ipress' ); ?>">
							<?php echo get_next_posts_link( $ip_next_nav_link ); ?>
						</span>
					</div>
					<?php endif; ?>
	
					<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-previous">
						<span class="prev" title="<?php echo esc_attr__( 'Previous', 'ipress' ); ?>">
							<?php echo get_previous_posts_link( $ip_prev_nav_link ); ?>
						</span>
					</div>
					<?php endif; ?>
				</div>
			</nav>
		</section>
		<?php
	
		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'ipress_prev_next_post_nav' ) ) :

	/**
	 * Display links to previous and next post from a single post/page
	 *
	 * - Default display with Older / Newer links
	 */
	function ipress_prev_next_post_nav() {
		echo ipress_get_prev_next_post_nav(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_prev_next_post_nav' ) ) :

	/**
	 * Display links to previous and next post from a single post/page
	 *
	 * - Default display with Older / Newer links
	 *
	 * @return string $output
	 */
	function ipress_get_prev_next_post_nav() {

		// Singular post or page only
		if ( ! is_singular() ) {
			return;
		}

		// Set post navigation arguments
		$ip_post_navigation_args = apply_filters(
			'ipress_post_navigation_args',
			[
				'prev_format' => '<div class="nav-previous"><span class="prev" title="' . esc_attr__( 'Previous', 'ipress' ) . '">%link</span></div>',
				'next_format' => '<div class="nav-next"><span class="next" title="' .  esc_attr__( 'Next', 'ipress' ) . '">%link</span></div>',
				'prev_link' => '%title',
				'next_link' => '%title',
				'in_same_term' => apply_filters( 'ipress_post_navigation_term', false ),
				'excluded_terms' => '',
				'taxonomy' => 'category',
			]
		);

		return sprintf(
			'<section id="pagination" class="post-pagination %1$s"><nav class="post-navigation" role="navigation">%2$s%3$s</nav></section>',
			sanitize_html_class( apply_filters( 'ipress_post_navigation_class', '' ) ),
			get_previous_post_link(
				$ip_post_navigation_args['prev_format'],
				$ip_post_navigation_args['prev_link'],
				$ip_post_navigation_args['in_same_term'],
				$ip_post_navigation_args['excluded_terms'],
				$ip_post_navigation_args['taxonomy']
			),
			get_next_post_link(
				$ip_post_navigation_args['next_format'],
				$ip_post_navigation_args['next_link'],
				$ip_post_navigation_args['in_same_term'],
				$ip_post_navigation_args['excluded_terms'],
				$ip_post_navigation_args['taxonomy']
			)
		);
	}
endif;

if ( ! function_exists( 'ipress_post_navigation' ) ) :

	/**
	 * Display links to previous and next post from a single post/page
	 *
	 * - Default to next and previous post / page title
	 *
	 * @uses get_the_post_navigation()
	 */
	function ipress_post_navigation() {
		echo ipress_get_post_navigation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_post_navigation' ) ) :

	/**
	 * Display links to previous and next post from a single post/page
	 * 
	 * - Default to next and previous post / page title
	 *
	 * @uses get_the_post_navigation()
	 * @return string $output
	 */
	function ipress_get_post_navigation() {

		// Singular post or page only
		if ( ! is_singular() ) {
			return;
		}

		// Set pagination args
		$args = apply_filters(
			'ipress_post_navigation_args',
			[
				'next_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Next', 'ipress' ), '%title' ),
				'prev_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Previous', 'ipress' ), '%title' ),
				'in_same_term' => apply_filters( 'ipress_post_navigation_term', false ),
				'excluded_terms' => '',
				'taxonomy' => 'category',
				'screen_reader_text' => ''
			]
		);

		// Set post navigation class
		$ip_post_navigation_class = apply_filters( 'ipress_post_navigation_class', '' );

		return sprintf(
			'<section id="pagination" class="single-pagination %s">%s</section>',
			sanitize_html_class( $ip_post_navigation_class ),
			get_the_post_navigation( $args )
		);
	}
endif;

if ( ! function_exists( 'ipress_loop_navigation' ) ) :

	/**
	 * Display links to previous and next post from an archive listing
	 *
	 * - Default to next and previous post / page title
	 *
	 * @uses get_the_posts_navigation()
	 */
	function ipress_loop_navigation() {
		echo ipress_get_loop_navigation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_loop_navigation' ) ) :

	/**
	 * Display links to previous and next post from an archive listing
	 *
	 * - Default to next and previous post / page title
	 *
	 * @uses get_the_posts_navigation()
	 * @return string $output
	 */
	function ipress_get_loop_navigation() {

		// Singular post or page only
		if ( is_singular() ) {
			return;
		}

		// Set pagination args
		$args = apply_filters(
			'ipress_loop_navigation_args',
			[
				'next_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Next', 'ipress' ), _x( 'Next', 'Next Post', 'ipress' ) ),
				'prev_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Previous', 'ipress' ), _x( 'Previous', 'Previous Post', 'ipress' ) ),
				'in_same_term' => apply_filters( 'ipress_post_navigation_term', false ),
				'excluded_terms' => '',
				'taxonomy' => 'category',
				'screen_reader_text' => '',
				'class' => 'posts-navigation',
				'aria_label' => 'Posts Navigation'
			]
		);

		// Set post navigation class
		$ip_posts_navigation_class = apply_filters( 'ipress_posts_navigation_class', '' );
		
		return sprintf(
			'<section id="pagination" class="posts-pagination %s">%s</section>',
			sanitize_html_class( $ip_posts_navigation_class ),
			get_the_posts_navigation( $args )
		);
	}
endif;

if ( ! function_exists( 'ipress_pagination' ) ) :

	/**
	 * Pagination for archives with numerical display
	 *
	 * @global $wp_query WP_Query
	 */
	function ipress_pagination() {
		echo ipress_get_pagination(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_pagination' ) ) :

	/**
	 * Pagination for archives with numerical display
	 *
	 * @global $wp_query WP_Query
	 * @return string
	 */
	function ipress_get_pagination() {

		global $wp_query;

		// This is for archives only
		if ( is_singular() ) {
			return;
		}

		// Set big params
		$big = 999999999;

		// Check total pages, we need more than one
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		// Get pagination links
		$pages = paginate_links( 
			apply_filters( 'ipress_paginate_links_args',
				[
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'type'      => 'array',
					'next_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Next', 'ipress' ), _x( 'Next', 'Next Post', 'ipress' ) ),
					'prev_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Previous', 'ipress' ), _x( 'Previous', 'Previous Post', 'ipress' ) )
				]
			)
		);

		// Get paged value
		$paged = ( get_query_var( 'paged' ) === 0 ) ? 1 : absint( get_query_var( 'paged' ) );

		// Generate list if set
		if ( $paged && $pages ) {
			$items = array_map( function( $item ) {
				return sprintf( '<li class="nav-link%1$s">%2$s</li>', ( strpos( $item, 'current' ) !== false ) ? ' active' : '', $item );
			}, $pages );
		} else { $items = []; }

		// Set post navigation class
		$ip_posts_navigation_class = apply_filters( 'ipress_posts_navigation_class', '' );

		return ( empty( $items ) ) ? '' : sprintf(
			'<section id="pagination" class="posts-pagination %s"><nav class="posts-navigation"><ul class="nav-links">%s</ul></nav></section>',
			sanitize_html_class( $ip_posts_navigation_class ),
			join( '', $items )
		);
	}
endif;

if ( ! function_exists( 'ipress_posts_navigation' ) ) :

	/**
	 * Archive pagination in page numbers format
	 *
	 * - Links ordered as:
	 * - previous page arrow
	 * - first page
	 * - up to two pages before current page
	 * - current page
	 * - up to two pages after the current page
	 * - last page
	 * - next page arrow
	 *
	 * @global WP_Query $wp_query Query object
	 */
	function ipress_posts_navigation() {
		echo ipress_get_posts_navigation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
	}
endif;

if ( ! function_exists( 'ipress_get_posts_navigation' ) ) :

	/**
	 * Archive pagination in page numbers format
	 *
	 * - Links ordered as:
	 * - previous page arrow
	 * - first page
	 * - up to two pages before current page
	 * - current page
	 * - up to two pages after the current page
	 * - last page
	 * - next page arrow
	 *
	 * @return string
	 * @global WP_Query $wp_query Query object
	 */
	function ipress_get_posts_navigation() {
		
		global $wp_query;

		// archives only
		if ( is_singular() ) {
			return;
		}

		// Check total pages, we need more than one
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		// Get pagination values
		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max = intval( $wp_query->max_num_pages );

		// Add current page to the array
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		// Add the pages around the current page to the array
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		// Add the pages around the current page to the array
		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		// Set post navigation class
		$ip_posts_navigation_class = apply_filters( 'ipress_posts_navigation_class', '' );

		// Generate wrapper
		$output = sprintf( '<section id="pagination" class="posts-pagination %s">', sanitize_html_class( $ip_posts_navigation_class ) );

		// Start list
		$output .= '<nav class="posts-navigation"><ul class="nav-links">';

		add_filter( 'previous_posts_link_attributes', function() { 
			return 'class="prev page-numbers"';
		} );

		// Previous post link
		if ( get_previous_posts_link() ) {
			$output .= sprintf( '<li class="nav-link">%1$s</li>', get_previous_posts_link( '&#x000AB; ' . __( 'Previous', 'ipress' ) ) );
		}

		// Link to first page, plus ellipses if necessary
		if ( ! in_array( 1, $links, true ) ) {
			$output .= ( 1 === $paged ) ? '<li class="nav-link active"><span aria-current="page" class="page-numbers current">1</span></li>'
										: sprintf( '<li class="nav-link"><a class="page-numbers" href="%s">1</a></li>', esc_url( get_pagenum_link( 1 ) ) );

			if ( ! in_array( 2, $links, true ) ) {
				$output .= '<li class="nav-link omission"><span class="page-numbers dots">&#x02026;</span></li>';
			}
		}

		// Link to current page, plus 2 pages in either direction if necessary
		sort( $links );
		foreach ( $links as $link ) {
			$output .= ( $paged === $link ) ? sprintf( '<li class="nav-link active" aria-label="%1$s"><a class="page-numbers current" href="%2$s">%3$s</a></li>', __( 'Current page', 'ipress' ), esc_url( get_pagenum_link( $link ) ), $link )
											: sprintf( '<li class="nav-link"><a class="page-numbers" href="%1$s">%2$s</a></li>', esc_url( get_pagenum_link( $link ) ), $link );
		}

		// Link to last page, plus ellipses if necessary
		if ( ! in_array( $max, $links, true ) ) {

			if ( ! in_array( $max - 1, $links, true ) ) {
				$output .= '<li class="nav-link omission"><span class="page-numbers dots">&#x02026;</span></li>';
			}

			$output .= ( $max === $paged ) ? sprintf( '<li class="nav-link active"><a class="page-numbers" href="%1$s">%2$s</a></li>', esc_url( get_pagenum_link( $max ) ), $max )
										   : sprintf( '<li class="nav-link"><a class="page-numbers" href="%1$s">%2$s</a></li>', esc_url( get_pagenum_link( $max ) ), $max );
		}

		add_filter( 'next_posts_link_attributes', function() { 
			return 'class="next page-numbers"';
		} );

		// Next post link
		if ( get_next_posts_link() ) {
			$output .= sprintf( '<li class="nav-link">%1$s</li>', get_next_posts_link( __( 'Next', 'ipress' ) . ' &#x000BB;' ) );
		}

		// Generate output
		$output .= '</ul></nav></section>';
		return $output;
	}
endif;
