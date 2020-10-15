<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying Woocommerce checkout page content
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_checkout_before' ); ?>

<!-- Checkout -->
<section id="checkout" class="checkout-content">
	<?php the_content(); ?>
	<?php do_action( 'ipress_checkout' ); ?>
</section> <!-- #checkout / .checkout-content -->

<?php do_action( 'ipress_checkout_after' );
