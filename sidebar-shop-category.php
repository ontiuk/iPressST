<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Sidebar containing the shop category page widget area.
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! is_active_sidebar( 'shop-category' ) ) {
	return;
}
?>

<?php do_action( 'ipress_sidebar_widget_area_before' ); ?>

<aside id="sidebar-shop-category" class="widget-area sidebar-shop-category" role="complementary">
	<?php dynamic_sidebar( 'shop-category' ); ?>
	<?php do_action( 'ipress_sidebar_widget_area' ); ?>
</aside><!-- #sidebar-shop-category / .sidebar-shop-category-->

<?php do_action( 'ipress_sidebar_widget_area_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
