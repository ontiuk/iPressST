<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop footer.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_single_footer_before' ); ?>

<footer class="post-footer single-footer"> 

	<?php do_action( 'ipress_post_footer' ); ?>

</footer><!-- .post-footer / .single-footer --> 

<?php do_action( 'ipress_single_footer_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
