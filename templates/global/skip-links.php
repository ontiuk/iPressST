<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying skip links.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

echo sprintf(
	'<a class="skip-link screen-reader-text" href="#site-navigation" title="%1$s">%2$s</a>
	<a class="skip-link screen-reader-text" href="#main" title="%3$s">%4$s</a>',
	esc_attr__( 'Skip to navigation', 'ipress' ),
	esc_html__( 'Skip to navigation', 'ipress' ),
	esc_attr__( 'Skip to content', 'ipress' ),
	esc_html__( 'Skip to content', 'ipress' )
);
