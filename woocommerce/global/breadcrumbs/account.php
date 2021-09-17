<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for woocommerce account page breadcrumb
 *
 * - WC_Breadcrumb does not product breadcrumb for this page type
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb account-breadcrumb">
	<div class="container">
	<?php echo esc_html( $wrap_before ); ?>
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?php esc_html_e( 'Account', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?php echo esc_html( get_the_author() ); ?></li>
		</ul>
	<?php echo esc_html( $wrap_after ); ?>
	</div>
</section>
