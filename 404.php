<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Template for displaying the 404 page.
 * 
 * @see https://codex.wordpress.org/Creating_an_Error_404_Page.
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php get_header(); ?>

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-content error-page">

		<?php get_template_part( 'templates/global/404' ); ?>

    </main><!-- #main / .site-content -->

<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer();
