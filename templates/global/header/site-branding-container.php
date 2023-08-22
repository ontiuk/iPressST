<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the site branding container.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Are we displaying the title & tagline?
$show_title_tagline = ( true === ipress_get_option( 'title_and_tagline', true ) );
if ( ! $show_title_tagline ) {
	return;
}
?>
<div class="site-branding-wrap">
