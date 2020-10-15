<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying Woocommerce cart page content
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_cart_before' ); ?>

<!-- Cart -->
<section id="cart" class="cart-content">
	<?php the_content(); ?>
	<?php do_action( 'ipress_cart' ); ?>
</section> <!-- #cart / .cart-content -->

<?php do_action( 'ipress_cart_after' );
