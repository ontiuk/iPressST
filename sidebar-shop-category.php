<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Sidebar containing the shop category page widget area.
 * 
 * @package     iPress
 * @link        http://ipress.uk
 * @see         https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license     GPL-2.0+
 */
?>

<?php defined( 'ABSPATH' ) || exit; // Access restriction ?>

<?php if ( ! is_active_sidebar( 'shop-category' ) ) { return; } ?>

<?php do_action( 'ipress_before_sidebar_widget_area' ); ?>

<aside id="sidebar-shop-category" class="widget-area sidebar-shop-category" role="complementary">
    <?php dynamic_sidebar( 'shop-category' ); ?>
</aside><!-- #sidebar-shop-category / .sidebar-shop-category-->

<?php do_action( 'ipress_after_sidebar_widget_area' );
