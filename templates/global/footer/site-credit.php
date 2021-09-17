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

// Get site url
$ipress_url = apply_filters( 'ipress_url', 'https://ipress.uk' );
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
	<span class="site-name">
		<?php
		echo sprintf(
			/* translators: 1. Theme name, 2. Theme author link. */
			esc_attr__( 'Theme %1$s by %2$s.', 'ipress' ),
			'iPress',
			'<a href="' . esc_url( $ipress_url ) . '" title="iPress - WordPress Theme Framework" rel="author">iPress</a>'
		);
		?>
	</span>
</div>
