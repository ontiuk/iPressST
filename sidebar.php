<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Sidebar containing the main widget area.
 * 
 * @package		iPress
 * @link		http://ipress.uk
 * @see			https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license		GPL-2.0+
 */
?>

<?php defined( 'ABSPATH' ) || exit; // Access restriction ?>

<?php if ( ! is_active_sidebar( 'primary' ) ) { return; } ?>

<?php do_action( 'ipress_before_sidebar_widget_area' ); ?>

<aside id="secondary" class="widget-area sidebar-primary" role="complementary">
	<?php dynamic_sidebar( 'primary' ); ?>
</aside><!-- #secondary / .sidebar-primary-->

<?php do_action( 'ipress_after_sidebar_widget_area' );
