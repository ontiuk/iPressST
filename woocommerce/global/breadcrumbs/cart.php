<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for woocommerce cart page breadcrumb
 *
 * - WC_Breadcrumb does not product breadcrumb for this page type
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Get the cart details
$cart_page_id = wc_get_page_id( 'cart' ); 
$page_title = get_the_title( $cart_page_id );
?> 
<!-- Breadcrumbs-->
<section class="header-breadcrumb cart-breabcrumb">
	<div class="container">
	<?php echo $wrap_before; ?>
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress-standalone' ); ?></a></li>
			<li class="breadcrumb-item active"><?php echo esc_html( $page_title ); ?></li>
		</ul>
	<?php echo $wrap_after; ?>
	</div>
</section>
