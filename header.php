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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'ipress_before_site' ); ?>

	<div id="page" class="site-container">

	<?php do_action( 'ipress_before_header' );?>

	<header id="masthead" class="<?php ipress_header_classes(); ?>" <?php ipress_header_style(); ?>>

		<?php
		/**
		* Functions hooked into ipress_header_top action
		*
		* @hooked ipress_header_container - 10
		*/
		do_action( 'ipress_header_top' );
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
		do_action( 'ipress_header_bottom' );
		?>

	</header><!-- #masthead / .site-header -->

	<?php
	/**
	 * Functions hooked in to ipress_before_content
	 *
	 * @hooked ipress_header_widget - 10
	 */
	do_action( 'ipress_before_content' );
