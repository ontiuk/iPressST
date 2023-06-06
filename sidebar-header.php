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

if ( ! is_active_sidebar( 'header' ) ) {
	return;
}
?>

<?php do_action( 'ipress_before_sidebar_widget_area' ); ?>

<aside id="secondary-header" class="widget-area sidebar-header" role="complementary">
	<?php dynamic_sidebar( 'header' ); ?>
	<?php do_action( 'ipress_sidebar_widget_area', 'header' ); ?>
</aside><!-- #secondary / .sidebar-header-->

<?php do_action( 'ipress_after_sidebar_widget_area' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
