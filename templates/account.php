<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template part for displaying WooCommerce account page content
 * - Displays the rendered [woocommerce_my_account] shortcode via the_content()
 * - Template overrides in /woocommerce/account
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_account' ); ?>

<!-- Account -->
<section id="account" class="account-content">
	<?php do_action( 'ipress_before_account_content' ); ?>
	<?php the_content(); ?>
	<?php do_action( 'ipress_account' ); ?>
</section><!-- #account / .account-content -->

<?php do_action( 'ipress_after_account' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
