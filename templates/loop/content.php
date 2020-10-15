<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop content and thumbnail.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php do_action( 'ipress_loop_content_before' ); ?>

<section class="post-summary post-content">
<?php
	the_content( sprintf(
		/* translators: %s: name of current post. only visible to screen readers */
		__( 'Continue reading %s', 'ipress-child' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
	) );

	do_action( 'ipress_loop_content' );

	wp_link_pages( [
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ipress-child' ),
		'after'  => '</div>',
	] );
?>
</section><!-- .post-summary / .post-content -->

<?php do_action( 'ipress_loop_content_after' );
