<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the generic site menu.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_site_navigation' ); ?>

<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php echo esc_attr__( 'Primary Navigation', 'ipress-standalone' ); ?>">
	<?php do_action( 'ipress_before_site_navigation_content' ); ?>

	<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
		<span class="menu-icon"><?php echo esc_html( apply_filters( 'ipress_menu_toggle_text', __( 'Menu', 'ipress-standalone' ) ) ); ?></span>
	</button>

	<?php do_action( 'ipress_site_navigation' ); ?>

	<?php
	wp_nav_menu(
		[
			'theme_location'  => 'primary',
			'container' => 'div',
			'container_class' => 'main-nav',
			'container_id' => 'primary-menu',
			'menu_class' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
		]
	);
	?>

	<?php do_action( 'ipress_after_site_navigation_content' ); ?>
</nav><!-- #site-navigation -->

<?php do_action( 'ipress_after_site_navigation' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
