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

<?php do_action( 'ipress_loop_header_before' ); ?>

<header class="post-header">
<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
	<?php 
		$featured_title = sprintf( 
			/* translators: %s: featured post */
			'<span class="sticky-post">%s</span>', esc_html_x( 'Featured', 'post', 'freeplants' ) ); 
	?>
	<?php echo wp_kses_post( $featured_title ); ?>
<?php endif; ?>

<?php echo sprintf( '<h2 class="post-title"><a href="%1$s" rel="bookmark">%2$s</a></h2>', esc_url( get_permalink() ), esc_html( get_the_title() ) ); ?>        
</header><!-- .post-header -->

<?php do_action( 'ipress_loop_header_after' );
