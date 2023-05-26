<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the generic site logo / text.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Get title, tagline & description
$blog_info = get_bloginfo( 'name' );
$description = get_bloginfo( 'description', 'display' );
$show_title = ( true === ipress_get_option( 'ipress_title_and_tagline', true ) );
$header_class = $show_title ? 'site-title' : 'screen-reader-text';
?>
<div class="site-branding">
	<?php the_custom_logo(); ?>
	<?php 
	if ( is_front_page() && ! is_paged() ) : 
		echo sprintf( 
			'<h1 class="%1$s">%2$s</h1>',
			$header_class,
			$blog_info
		); // phpcs:ignore WordPress.Security.EscapeOutput
	elseif ( is_front_page() && ! is_home() ) :
		echo sprintf(
			'<h1 class="%1$s"><a href="%2$s" rel="home">%3%s</a></h1>',
			$header_class, 
			esc_url( home_url( '/' ) ),
			$blog_info
	   	); // phpcs:ignore WordPress.Security.EscapeOutput
	else :
		echo sprintf( 
			'<div class="%1$s"><a href="%2$s" rel="home">%3$s</a></div>',
			$header_class,
			esc_url( home_url( '/' ) ),
			$blog_info
		); // phpcs:ignore WordPress.Security.EscapeOutput
	endif;

	if ( $description && $show_title ) :
		echo sprintf(
			'<p class="site-description">%s</p>',
			html_entity_decode( $description )
		); // phpcs:ignore WordPress.Security.EscapeOutput
	endif;
	?>
	<?php do_action( 'ipress_site_branding' ); ?>
</div>
