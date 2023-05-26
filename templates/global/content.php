<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for global page & post content.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_article_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<section class="page-content">
		<?php the_content(); ?>
	</section><!-- .page-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_article_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
