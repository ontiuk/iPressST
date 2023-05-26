<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Sidebar containing the shop product widget area.
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! is_active_sidebar( 'shop-product' ) ) {
	return;
}
?>

<?php do_action( 'ipress_sidebar_widget_area_before' ); ?>

<aside id="secondary-shop-product" class="widget-area sidebar-shop-product" role="complementary">
	<?php dynamic_sidebar( 'shop-product' ); ?>
	<?php do_action( 'ipress_sidebar_widget_area', 'shop-product' ); ?>
</aside><!-- #sidebar-shop-product / .sidebar-shop-product -->

<?php do_action( 'ipress_sidebar_widget_area_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
