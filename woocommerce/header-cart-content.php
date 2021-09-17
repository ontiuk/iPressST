<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Header Cart Content
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Check WC cart is available
if ( ! ipress_wc_cart_available() ) {
	return;
}
?>
<div id="headerCart" class="header-cart-content">
	<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
</div>
