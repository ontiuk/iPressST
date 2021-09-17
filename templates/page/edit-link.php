<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop edit link.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Display if using the link
if ( get_edit_post_link() ) :
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: name of current post. only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'ipress' ),
				[
					'span' => [
						'class' => [],
					],
				]
			),
			get_the_title()
		),
		'<div class="edit-link">',
		'</div>'
	);
endif;
