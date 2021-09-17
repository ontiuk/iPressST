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
// ipress_prev_next_post_nav
// ipress_pagination
// ipress_numeric_posts_nav
//----------------------------------------------

if ( ! function_exists( 'ipress_prev_next_posts_nav' ) ) :

	/**
	 * Generate pagination in Previous / Next Posts format
	 *
	 * @param boolean $echo default true
	 * @return string $output
	 */
	function ipress_prev_next_posts_nav( $echo = true ) {

		global $wp_query;

		if ( ! $wp_query->max_num_pages > 1 ) {
			return;
		}

		// Previous Next Context
		$ip_next_nav_link = (string) apply_filters( 'ipress_next_nav_link', __( '&larr; Older', 'ipress' ) );
		$ip_prev_nav_link = (string) apply_filters( 'ipress_prev_nav_link', __( 'Newer &rarr;', 'ipress' ) );

		// Get nav links
		ob_start()
		?>
		<section id="pagination" class="paginate posts-paginate">
			<nav class="pagination" role="navigation">
				<div class="nav-next nav-left"><?php echo esc_url( get_next_posts_link( trim( $ip_next_nav_link ) ) ); ?></div>
				<div class="nav-previous nav-right"><?php echo esc_url( get_previous_posts_link( trim( $ip_prev_nav_link ) ) ); ?></div>
			</nav>
		</section>
		<?php
		$output = ob_get_clean();

		// Send output
		if ( $echo ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $output;
		}
	}
endif;

if ( ! function_exists( 'ipress_prev_next_post_nav' ) ) :

	/**
	 * Display links to previous and next post from a single post
	 *
	 * @param boolean $echo
	 * @return string $output
	 */
	function ipress_prev_next_post_nav() {

		// Single post only
		if ( ! is_singular() ) {
			return;
		}

		// Previous Next Context
		$ip_single_next_nav_link = (string) apply_filters( 'ipress_single_next_nav_link', __( '&larr; Older', 'ipress' ) );
		$ip_single_prev_nav_link = (string) apply_filters( 'ipress_single_prev_nav_link', __( 'Newer &rarr;', 'ipress' ) );

		// Get nav links
		ob_start()
		?>
		<section id="pagination" class="paginate single-paginate">';
			<nav class="pagination" role="navigation"> 
				<div class="nav-next nav-left"><?php echo esc_url( get_next_post_link( trim( $ip_single_next_nav_link ) ) ); ?></div> 
				<div class="nav-previous nav-right"><?php echo esc_url( get_previous_post_link( trim( $ip_single_prev_nav_link ) ) ); ?></div> 
			</nav> 
		</section>
		<?php
		$output = ob_get_clean();

		// Send output
		if ( $echo ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $output;
		}
	}
endif;

if ( ! function_exists( 'ipress_pagination' ) ) :

	/**
	 * Pagination for archives
	 *
	 * @global $wp_query WP_Query
	 * @return string
	 */
	function ipress_pagination( $echo = true ) {

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
			[
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wp_query->max_num_pages,
				'type'      => 'array',
				'prev_text' => __( 'Prev', 'ipress' ),
				'next_text' => __( 'Next', 'ipress' ),
			]
		);

		// Get paged value
		$paged = ( get_query_var( 'paged' ) === 0 ) ? 1 : absint( get_query_var( 'paged' ) );

		// Generate list if set
		if ( is_array( $pages ) && $paged ) {
			$list = '<nav class="pagination">';
			foreach ( $pages as $page ) {
				$list .= sprintf( '<div class="nav-links>%d</div>', $page );
			}
			$list .= '</nav>';
		} else {
			$list = '';
		}

		// Send output
		if ( $echo ) {
			echo $list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $list;
		}
	}
endif;

if ( ! function_exists( 'ipress_posts_nav' ) ) :

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
	 * @param boolean $echo default true
	 * @return string
	 * @global WP_Query $wp_query Query object
	 */
	function ipress_posts_nav( $echo = true ) {

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
		$max   = intval( $wp_query->max_num_pages );

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
		$output = '<section id="pagination" class="paginate loop-paginate">';

		// Start list
		$output .= '<nav>';

		// Previous post link
		if ( get_previous_posts_link() ) {
			$output .= sprintf( '<div class="pagination-previous">%s</div>', esc_url( get_previous_posts_link( '&#x000AB; ' . __( 'Previous Page', 'ipress' ) ) ) );
		}

		// Link to first page, plus ellipses if necessary
		if ( ! in_array( 1, $links, true ) ) {

			$class   = ( 1 === $paged ) ? ' class="active"' : '';
			$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( 1 ) ), ' ' . '1' );

			if ( ! in_array( 2, $links, true ) ) {
				$output .= '<div class="pagination-omission">&#x02026;</div>';
			}
		}

		// Link to current page, plus 2 pages in either direction if necessary
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class   = ( $paged === $link ) ? ' class="active"  aria-label="' . __( 'Current page', 'ipress' ) . '"' : '';
			$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( $link ) ), ' ' . $link );
		}

		// Link to last page, plus ellipses if necessary
		if ( ! in_array( $max, $links, true ) ) {

			if ( ! in_array( $max - 1, $links, true ) ) {
				$output .= sprintf( '<div class="pagination-omission">%s</div>', '&#x02026;' );
			}

			$class   = ( $paged === $max ) ? ' class="active"' : '';
			$output .= sprintf( '<div%s><a href="%s">%s</a></div>', $class, esc_url( get_pagenum_link( $max ) ), ' ' . $max );
		}

		// Next post link
		if ( get_next_posts_link() ) {
			$output .= sprintf( '<div class="pagination-next">%s</div>', esc_url( get_next_posts_link( __( 'Next Page', 'ipress' ) ) . ' &#x000BB;' ) );
		}

		// Generate output
		$output .= '</nav></section>';

		// Send output
		if ( $echo ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		} else {
			return $output;
		}
	}
endif;
