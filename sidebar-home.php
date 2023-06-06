<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Sidebar containing the header widget area.
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! is_active_sidebar( 'homepage' ) ) {
	return;
}
?>

<?php do_action( 'ipress_before_sidebar_widget_area' ); ?>

<aside id="secondary-homepage" class="widget-area sidebar-homepage" role="complementary">
	<?php dynamic_sidebar( 'homepage' ); ?>
	<?php do_action( 'ipress_sidebar_widget_area', 'homepage' ); ?>
</aside><!-- #secondary / .sidebar-homepage-->

<?php do_action( 'ipress_after_sidebar_widget_area' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
