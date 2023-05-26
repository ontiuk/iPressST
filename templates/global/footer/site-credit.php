<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the generic site info & credits.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>
<div class="site-info">
	<?php 
	echo sprintf(
		/* translators: 1. blog name, 2. formatted date. */
		'<span class="copy">&copy; %1$s %2$s</span>',
		esc_html( get_bloginfo( 'name' ) ),
		esc_attr( date( 'Y' ) )
	);
	?>
	<?php
	echo sprintf(
		/* translators: 1. Theme author link. 2. Theme prefix, 2. Theme name */
		'<span class="site-name">%2$s <a href="%1$s" rel="author">%3$s</a></span>',
		esc_url( 'https://ipress.uk' ),
		_x( 'Theme By', 'iPress', 'ipress' ),
		__( 'iPress', 'ipress' )
	);
	?>
	</span>
</div>
