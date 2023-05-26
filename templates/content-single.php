<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying a single post.
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

	<?php
	/**
	 * Functions hooked into ipress_single_post add_action
	 *
	 * @hooked ipress_single_header  - 10
	 * @hooked ipress_single_meta    - 20
	 * @hooked ipress_single_content - 30
	 * @hooked ipress_single_footer  - 40
	 */
	do_action( 'ipress_single' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_article_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
