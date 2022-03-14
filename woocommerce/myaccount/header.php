<?php 
/**
 * Account Page Header
 */ 
?>
<header class="woocommerce-account-header account-header">
	<h1 class="woocommerce-account-header__title page-title"><?php echo esc_html( get_the_title( wc_get_page_id( 'myaccount' ) ) ); ?></h1>
</header>
