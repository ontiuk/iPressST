<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="<?php echo set_url_scheme('http://gmpg.org/xfn/11'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'ipress_before_site' ); ?>

	<div id="page" class="site-container">

	<?php
	/**
	 * Functions hooked into ipress_before_header hook.
	 *
	 * @hooked ipress_skip_links - 2
	 * @hooked ipress_top_bar - 5
	 */
	do_action( 'ipress_before_header' );?>

	<header id="masthead" <?php ipress_header(); ?>>

		<?php
		/**
		* Functions hooked into ipress_header_top action
		*
		* @hooked ipress_header_container - 10
		*/
		do_action( 'ipress_before_header_content' );
		?>

		<?php
		/**
		 * Functions hooked into ipress_header action
		 *
		 * @hooked ipress_site_branding      - 10
		 * @hooked ipress_primary_navigation - 20
		 */
		do_action( 'ipress_header' );
		?>

		<?php
		/**
		 * Functions hooked into ipress_header_bottom action
		 *
		 * @hooked ipress_header_container_close - 10
		 */
		do_action( 'ipress_after_header_content' );
		?>

	</header><!-- #masthead / .site-header -->

	<?php
		/**
		 * Functions hooked into ipress_before_content action
		 *
		 * @hooked ipress_breadcrumbs - 5
		 * @hooked ipress_hero - 10
		 */
	   	do_action( 'ipress_before_content' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
