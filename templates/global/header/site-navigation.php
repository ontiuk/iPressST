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

<?php do_action( 'ipress_site_navigation_top' ); ?>

<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php echo esc_attr__( 'Primary Navigation', 'ipress' ); ?>">
	<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_html( apply_filters( 'ipress_menu_toggle_text', __( 'Menu', 'ipress' ) ) ); ?></span></button>
	<?php
	wp_nav_menu(
		[
			'theme_location'  => 'primary',
			'container_class' => 'primary-navigation',
		]
	);
	?>
	<?php do_action( 'ipress_site_navigation' ); ?>
</nav><!-- #site-navigation -->

<?php do_action( 'ipress_site_navigation_bottom' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
