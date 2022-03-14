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
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php ipress_homepage_style(); ?> data-image-id="<?php echo (int) get_post_thumbnail_id( get_the_ID() ); ?>">

	<?php do_action( 'ipress_before_homepage_header' ); ?>

	<header class="page-header home-header">
		<?php the_title( '<h1 class="page-title home-title">', '</h1>' ); ?>
	</header><!-- .home-header -->

	<?php do_action( 'ipress_before_homepage_content' ); ?>

	<section class="page-content home-content">
		<?php the_content(); ?>
	</section><!-- .home-content -->

	<?php do_action( 'ipress_after_homepage_content' ); ?>

	<footer class="page-footer home-footer">
		<?php get_template_part( 'templates/front/edit-link' ); ?>
	</footer>

</div><!-- #post-<?php the_ID(); ?> -->
