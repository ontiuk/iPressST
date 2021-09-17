<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying content in attachment.php.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_attachment_before' ); ?>

<article id="attachment-<?php the_ID(); ?>" <?php post_class(); ?> >

	<?php
	/**
	 * Functions hooked in to ipress_page add_action
	 *
	 * @hooked ipress_attachment_header  - 10
	 * @hooked ipress_attachment_content - 20
	 */
	do_action( 'ipress_attachment' );
	?>

</article><!-- #attachment-<?php the_ID(); ?> -->

<?php do_action( 'ipress_attachment_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
