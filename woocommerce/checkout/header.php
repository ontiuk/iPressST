<?php 
/**
 * Checkout Page Header
 */ 
?>
<header class="woocommerce-checkout-header checkout-header">
	<h1 class="woocommerce-checkout-header__title page-title"><?php echo esc_html( get_the_title( wc_get_page_id( 'checkout' ) ) ); ?></h1>
</header>
