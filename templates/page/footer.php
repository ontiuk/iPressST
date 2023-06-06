<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the page footer.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_page_footer' ); ?>

<footer class="page-footer"> 

	<?php do_action( 'ipress_page_footer' ); ?>

</footer><!-- .page-footer --> 

<?php do_action( 'ipress_after_page_footer' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
