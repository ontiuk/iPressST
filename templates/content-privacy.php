<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying privacy page content in privacy-page.php.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_privacy' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to ipress_page add_action
	 *
	 * @hooked ipress_page_header     - 10
	 * @hooked ipress_privacy_content - 20
	 * @hooked ipress_page_footer     - 30
	 */
	do_action( 'ipress_privacy' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'ipress_after_privacy' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
