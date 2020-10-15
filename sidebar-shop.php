<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Sidebar containing the main shop product archive widget area.
 * 
 * @package     iPress
 * @link        http://ipress.uk
 * @see         https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license     GPL-2.0+
 */
?>

<?php defined( 'ABSPATH' ) || exit; // Access restriction ?>

<?php if ( ! is_active_sidebar( 'shop' ) ) { return; } ?>

<?php do_action( 'ipress_before_sidebar_widget_area' ); ?>
	
<aside id="sidebar-shop" class="widget-area sidebar-shop" role="complementary">
    <?php dynamic_sidebar( 'shop' ); ?>
</aside><!-- #sidebar-shop / .sidebar-shop -->

<?php do_action( 'ipress_after_sidebar_widget_area' );
