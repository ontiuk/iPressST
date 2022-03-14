<?php 
/**
 * Cart Page Header
 */ 
?>
<header class="woocommerce-cart-header cart-header">
	<h1 class="woocommerce-cart-header__title page-title"><?php echo esc_html( get_the_title( wc_get_page_id( 'cart' ) ) ); ?></h1>
</header>
