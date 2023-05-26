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
// ipress_post_link_nav
// ipress_get_post_link_nav
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

		// No pagination, or single...
		if ( $wp_query->max_num_pages === 0 || is_single() ) {
			return;
		}

		// Previous Next Context
		$ip_next_nav_link = (string) apply_filters( 'ipress_next_nav_link', __( '&larr; Older', 'ipress' ) );
		$ip_prev_nav_link = (string) apply_filters( 'ipress_prev_nav_link', __( 'Newer &rarr;', 'ipress' ) );

		// Set flex paginate links, default center
		$ip_paginate_links = apply_filters( 'ipress_paginate_links', '' );

		// Get nav links
		ob_start()
		?>
		<section id="pagination" class="paginate posts-paginate <?php echo sanitize_html_class( $ip_paginate_links );?>">
			<nav class="pagination" role="navigation">
				<div class="nav-next nav-left"><?php echo esc_url( get_next_posts_link( $ip_next_nav_link ) ); ?></div>
				<div class="nav-previous nav-right"><?php echo esc_url( get_previous_posts_link( $ip_prev_nav_link ) ); ?></div>
			</nav>
		</section>
		<?php
		$output = ob_get_clean();
		return $output;
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

		// Previous Next Context
		$ip_single_next_nav_link = (string) apply_filters( 'ipress_single_next_nav_link', __( '&larr; Older', 'ipress' ) );
		$ip_single_prev_nav_link = (string) apply_filters( 'ipress_single_prev_nav_link', __( 'Newer &rarr;', 'ipress' ) );

		// Get testable links
		$ip_next_post_link = get_next_post_link( '%link', $ip_single_next_nav_link );
		$ip_prev_post_link = get_previous_post_link( '%link', $ip_single_prev_nav_link ); 

		// Has both links?
		$ip_has_post_links = ( empty( $ip_next_post_link ) || empty( $ip_prev_post_link) ) ? false : true;

		// Set flex paginate links, default center
		$ip_paginate_links = apply_filters( 'ipress_paginate_links', '' );

		// Get nav links
		ob_start()
		?>
		<section id="pagination" class="paginate single-paginate <?php echo sanitize_html_class( $ip_paginate_links ); ?>">
			<nav class="pagination" role="navigation">
				<?php if ( $ip_has_post_links ) : ?>		
				<div class="nav-next nav-left"><?php echo $ip_next_post_link; ?></div> 
				<div class="nav-previous nav-right"><?php echo $ip_prev_post_link; ?></div>
				<?php else : ?>
					<?php if ( $ip_next_post_link ) : ?>
					<div class="nav-next"><?php echo $ip_next_post_link; ?></div> 
					<?php endif; ?>
					<?php if ( $ip_prev_post_link ) : ?>
					<div class="nav-previous"><?php echo $ip_prev_post_link; ?></div>
					<?php endif; ?>
				<?php endif; ?>
			</nav> 
		</section>
		<?php
		$output = ob_get_clean();
		return $output;
	}
endif;

if ( ! function_exists( 'ipress_post_link_nav' ) ) :

	/**
	 * Display links to previous and next post from a single post/page
	 * 
	 * - Default to next and previous post / page title
	 */
	function ipress_post_link_nav() {
		echo ipress_get_post_link_nav(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_post_link_nav' ) ) :

	/**
	 * Display links to previous and next post from a single post/page
	 * 
	 * - Default to next and previous post / page title
	 *
	 * @return string $output
	 */
	function ipress_get_post_link_nav() {

		// Singular post or page only
		if ( ! is_singular() ) {
			return;
		}

		// Previous Next Context
		$ip_single_next_nav_link = (string) apply_filters( 'ipress_single_next_nav_link', __( '&larr; %title', 'ipress' ) );
		$ip_single_prev_nav_link = (string) apply_filters( 'ipress_single_prev_nav_link', __( '%title &rarr;', 'ipress' ) );

		// Get testable links
		$ip_next_post_link = get_next_post_link( '%link', $ip_single_next_nav_link );
		$ip_prev_post_link = get_previous_post_link( '%link', $ip_single_prev_nav_link ); 

		// Has both links?
		$ip_has_post_links = ( empty( $ip_next_post_link ) || empty( $ip_prev_post_link) ) ? false : true;

		// Set flex paginate links, default center
		$ip_paginate_links = apply_filters( 'ipress_paginate_links', '' );

		// Get nav links
		ob_start()
		?>
		<section id="pagination" class="paginate single-paginate <?php echo sanitize_html_class( $ip_paginate_links ); ?>">
			<nav class="pagination" role="navigation">
				<?php if ( $ip_has_post_links ) : ?>		
				<div class="nav-next nav-left"><?php echo $ip_next_post_link; ?></div> 
				<div class="nav-previous nav-right"><?php echo $ip_prev_post_link; ?></div>
				<?php else : ?>
					<?php if ( $ip_next_post_link ) : ?>
					<div class="nav-next"><?php echo $ip_next_post_link; ?></div> 
					<?php endif; ?>
					<?php if ( $ip_prev_post_link ) : ?>
					<div class="nav-previous"><?php echo $ip_prev_post_link; ?></div>
					<?php endif; ?>
				<?php endif; ?>
			</nav> 
		</section>
		<?php
		$output = ob_get_clean();
		return $output;
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
				'next_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Next post', 'ipress' ), '%title' ),
				'prev_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Previous post', 'ipress' ), '%title' )
			]
		);

		// Set flex paginate links, default center
		$ip_paginate_links = apply_filters( 'ipress_paginate_links', '' );
		return sprintf( '<section id="pagination" class="paginate single-paginate %s">%s</section>', sanitize_html_class( $ip_paginate_links ), get_the_post_navigation( $args ) );
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
				'next_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Next post', 'ipress' ), _x( 'Next', 'Next post', 'ipress' ) ),
				'prev_text' => sprintf( '<span class="screen-reader-text">%s</span>%s', esc_html__( 'Previous post', 'ipress' ), _x( 'Previous', 'Previous post', 'ipress' ) )
			]
		);

		// Set flex paginate links, default center
		$ip_paginate_links = apply_filters( 'ipress_paginate_links', '' );
		return sprintf( '<section id="pagination" class="paginate posts-paginate %s">%s</section>', sanitize_html_class( $ip_paginate_links ), get_the_posts_navigation( $args ) );
	}
endif;

if ( ! function_exists( 'ipress_pagination' ) ) :

	/**
	 * Pagination for archives
	 *
	 * @global $wp_query WP_Query
	 */
	function ipress_pagination() {
		echo ipress_get_pagination(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'ipress_get_pagination' ) ) :

	/**
	 * Pagination for archives
	 *
	 * @global $wp_query WP_Query
	 * @return string
	 */
	function ipress_get_pagination() {

		global $wp_query;

		// Set big params
		$big = 999999999;

		// Check total pages
		$total_pages = $wp_query->max_num_pages;
		if ( $total_pages <= 1 ) {
			return;
		}

		// Get pagination links
		$pages = paginate_links( 
			apply_filter( 'ipress_paginate_links_args',
				[
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'type'      => 'array',
					'prev_text' => __( 'Prev', 'ipress' ),
					'next_text' => __( 'Next', 'ipress' ),
				]
			)
		);

		// Get paged value
		$paged = ( get_query_var( 'paged' ) === 0 ) ? 1 : absint( get_query_var( 'paged' ) );

		// Generate list if set
		$list = [];
		if ( is_array( $pages ) && $paged ) {
			foreach ( $pages as $page ) {
				$list[] = sprintf( '<div class="nav-links>%d</div>', $page );
			}
		}
		return ( empty( $list ) ) ? '' : sprintf( '<section id="pagination" class="paginate posts-paginate"><nav class="pagination">%s</nav></section>', join( '', $list ) );
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

		// Stop execution if there's only 1 page
		if ( $wp_query->max_num_pages <= 1 ) {
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

		// Generate wrapper
		$output = '<section id="pagination" class="paginate posts-paginate">';

		// Start list
		$output .= '<nav>';

		// Previous post link
		if ( get_previous_posts_link() ) {
			$output .= sprintf( '<div class="pagination-previous">%s</div>', esc_url( get_previous_posts_link( '&#x000AB; ' . __( 'Previous Page', 'ipress' ) ) ) );
		}

		// Link to first page, plus ellipses if necessary
		if ( ! in_array( 1, $links, true ) ) {

			$class = ( 1 === $paged ) ? ' class="active"' : '';
			$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( 1 ) ), ' ' . '1' );

			if ( ! in_array( 2, $links, true ) ) {
				$output .= '<div class="pagination-omission">&#x02026;</div>';
			}
		}

		// Link to current page, plus 2 pages in either direction if necessary
		sort( $links );
		foreach ( $links as $link ) {
			$class = ( $paged === $link ) ? ' class="active"  aria-label="' . __( 'Current page', 'ipress' ) . '"' : '';
			$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( $link ) ), ' ' . $link );
		}

		// Link to last page, plus ellipses if necessary
		if ( ! in_array( $max, $links, true ) ) {

			if ( ! in_array( $max - 1, $links, true ) ) {
				$output .= sprintf( '<div class="pagination-omission">%s</div>', '&#x02026;' );
			}

			$class = ( $paged === $max ) ? ' class="active"' : '';
			$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( $max ) ), ' ' . $max );
		}

		// Next post link
		if ( get_next_posts_link() ) {
			$output .= sprintf( '<div class="pagination-next">%s</div>', esc_url( get_next_posts_link( __( 'Next Page', 'ipress' ) ) . ' &#x000BB;' ) );
		}

		// Generate output
		$output .= '</nav></section>';
		return $output;
	}
endif;
