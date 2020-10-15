<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop header.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_post_header_before' ); ?>

<header class="post-header">
<?php
	if ( is_singular() ) {
		the_title( '<h1 class="post-title single-title">', '</h1>' );
	} else {
		the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
	}
?>        
</header><!-- .post-header -->

<?php do_action( 'ipress_post_header_after' );
