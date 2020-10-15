<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop footer.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php if ( get_edit_post_link() ) : ?>
	<?php
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: name of current post. only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'ipress-child' ),
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
	?>
<?php endif; ?>
