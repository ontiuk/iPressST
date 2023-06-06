<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Sidebar containing the main shop product archive widget area.
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! is_active_sidebar( 'shop' ) ) {
	return;
}
?>

<?php do_action( 'ipress_before_sidebar_widget_area' ); ?>

<aside id="secondary-shop" class="widget-area sidebar-shop" role="complementary">
	<?php dynamic_sidebar( 'shop' ); ?>
	<?php do_action( 'ipress_sidebar_widget_area', 'shop' ); ?>
</aside><!-- #sidebar-shop / .sidebar-shop -->

<?php do_action( 'ipress_after_sidebar_widget_area' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
