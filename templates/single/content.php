<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop content.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_post_content_before' ); ?>

<section class="post-content post-single">
<?php
	the_content( sprintf(
		/* translators: %s: name of current post. only visible to screen readers */
		__( 'Continue reading %s', 'ipress-child' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
	) );

	do_action( 'ipress_post_content' );
?>
</section><!-- .post-content / .post-single -->

<?php do_action( 'ipress_post_content_after' );
