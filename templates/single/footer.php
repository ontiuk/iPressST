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

<?php do_action( 'ipress_before_single_footer' ); ?>

<footer class="post-footer single-footer"> 

	<?php do_action( 'ipress_post_footer' ); ?>

</footer><!-- .post-footer / .single-footer --> 

<?php do_action( 'ipress_after_single_footer' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
