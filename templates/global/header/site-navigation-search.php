<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the site navigation search.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'ipress_site_navigation_search_html',
	sprintf(
		'<form method="get" class="search-form site-navigation-search" action="%1$s">
			<input type="search" class="search-item" value="%2$s" name="s" title="%3$s" />
		</form>',
		esc_url( home_url( '/' ) ),
		esc_attr( get_search_query() ),
		esc_attr_x( 'Search', 'label', 'ipress-standalone' )
	)
);
