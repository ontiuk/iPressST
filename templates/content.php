<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying post content.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_article', 'index' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to ipress_loop_post action.
	 *
	 * @hooked ipress_loop_header  - 10
	 * @hooked ipress_loop_meta    - 20
	 * @hooked ipress_loop_content - 30
	 * @hooked ipress_loop_footer  - 40
	 */
	do_action( 'ipress_loop' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_after_article', 'index' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
