<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for home page content.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Get post image details
$post_image_id      = get_post_thumbnail_id( get_the_ID() );
$display_post_image = apply_filters( 'ipress_homepage_image', false );
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php ipress_homepage_style(); ?> data-image-id="<?php echo esc_attr( $post_image_id ); ?>">

	<header class="page-header home-header">
		<?php
		if ( $display_post_image && $post_image_id ) :
			the_post_thumbnail( 'full' );
		endif;
		?>
		<?php the_title( '<h1 class="page-title home-title">', '</h1>' ); ?>
	</header><!-- .home-header -->

	<?php edit_post_link( __( 'Edit this section', 'ipress' ), '', '', '', 'button button-edit' ); ?>

	<section class="page-content home-content">
		<?php the_content(); ?>
	</section><!-- .home-content -->

</div><!-- #post-<?php the_ID(); ?> -->
