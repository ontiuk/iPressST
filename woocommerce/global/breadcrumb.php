<?php
/**
 * Shop breadcrumb
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

defined( 'ABSPATH' ) ||	exit; // Restrict direct access

// Nothing to do?
if ( empty( $breadcrumb ) ) {
	return;
}

// Get theme mod
$ip_wc_breadcrumbs = get_theme_mod( 'ipress_woocommerce_breadcrumbs', false );
if ( true !== $ip_wc_breadcrumbs ) {
	return;
}

// Use custom breadcrumb structure, e.g. bootstrap, default off
$ip_wc_custom_breadcrumbs = (bool) apply_filters( 'ipress_wc_custom_breadcrumbs', false );
if ( true === $ip_wc_custom_breadcrumbs ) {

	$template = '';

	// test for page template
	$page_template = ( is_page_template() ) ? get_page_template_slug() : '';

	// Test for page template or Woocommerce page type, not all are default e.g cart, checkout, my-account
	if ( is_cart() || 'template-cart.php' === $page_template ) {

		$template = 'cart.php';

	} elseif ( is_checkout() || 'template-checkout.php' === $page_template ) {

		$template = 'checkout.php';

	} elseif ( is_account_page() || 'template-account.php' === $page_template ) {

		$template = 'account.php';

	} elseif ( is_shop() || is_post_type_archive( 'product' ) ) {

		$template = 'product-archive.php';

	} elseif ( is_product() ) {

		$template = 'single-product.php';

	} elseif ( is_product_category() || is_product_taxonomy() ) {

		$template = 'product-cat.php';

	} elseif ( is_tax( 'product_tag' ) ) {

		$template = 'product-tag.php';

	} elseif ( is_woocommerce() ) {

		$template = 'default.php';

	}

	// No template set?
	if ( empty( $template ) ) {
		echo sprintf(
			/* translators: %s: template type */
			esc_html__( 'No Woocommerce Breadcrumb for this type [%s] yet!', 'ipress' ),
			esc_attr( $template )
		);
		return;
	}

	// Forward breadcrumb args
	$breadcrumb_args = [
		'breadcrumb'  => $breadcrumb,
		'wrap_before' => $wrap_before,
		'wrap_after'  => $wrap_after,
		'before'      => $before,
		'after'       => $after,
		'delim'       => $delimiter,
		'home'        => $home,
	];

	// Load breadcrumbs template from theme overrides
	wc_get_template( 'global/breadcrumbs/' . $template, $breadcrumb_args );

} else {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;
}
