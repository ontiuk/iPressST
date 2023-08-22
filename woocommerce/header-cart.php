<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Woocommerce header cart wrapper
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Show product search
$show_search = (bool) ipress_get_option( 'woocommerce_product_search', true );

// Get Woocomerce details if available
$account_url = wc_get_page_permalink( 'myaccount' ); 
$cart_url = wc_get_cart_url();
$cart_count = WC()->cart->get_cart_contents_count();

$ip_wc_header_cart_dropdown = (bool) apply_filters( 'ipress_wc_header_cart_dropdown', false );

?>
<div class="header-cart">
	<ul class="navbar-nav">

		<?php if ( $show_search ) : ?>
		<li class="nav-item search-nav-item">
			<a href="#" id="getProductSearch">
				<svg xmlns="http://www.w3.org/2000/svg" width="36" height="22" class="bi bi-search" viewBox="-2 -2 20 20">
				  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
				</svg>
			</a>
		</li>
		<?php endif; ?>

		<!-- WC Header Account Login -->
		<li class="nav-item account-nav-item">
		<a href="<?php echo $account_url; ?>" class="header-account-link" title="<?php echo esc_attr__( 'View your account &amp; orders', 'ipress' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="36" height="24" class="bi bi-person-fill" viewBox="0 0 16 16">
				  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
				</svg>
			</a>
		</li>

		<!-- WC Header Cart -->
		<li class="nav-item cart-nav-item">
			<!-- WC Header Cart -->
			<a href="<?php echo $cart_url; ?>" id="getHeaderCart" class="header-cart-link" title="<?php echo esc_attr__( 'View your basket', 'ipress' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="36" height="20" class="bi bi-cart-fill" viewBox="0 0 16 16">
				  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
				</svg>
				<span class="cart-items-number"><?php echo $cart_count; ?></span>
			</a>
			<?php if ( $ip_wc_header_cart_dropdown ) : ?>			
				<?php wc_get_template_part( 'header-cart-content' ); ?>
			<?php endif; ?>
		</li>
	</ul>
</div>
