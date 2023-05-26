<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * The Template for displaying single product pagination
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Show only products in the same category?
$ip_in_same_term   = apply_filters( 'ipress_single_product_pagination_same_category', true );
$ip_excluded_terms = apply_filters( 'ipress_single_product_pagination_excluded_terms', '' );
$ip_taxonomy = apply_filters( 'ipress_single_product_pagination_taxonomy', 'product_cat' );

// Retrieve previous and next products if available
$previous_product = ipress_get_previous_product( $ip_in_same_term, $ip_excluded_terms, $ip_taxonomy );
$next_product = ipress_get_next_product( $ip_in_same_term, $ip_excluded_terms, $ip_taxonomy );

// No products at all? Otherwise display nav template with image links
if ( ! $previous_product && ! $next_product ) {
	return;
}
?>
<nav class="ipress-product-pagination" aria-label="<?php esc_attr_e( 'More products', 'ipress' ); ?>">

<?php if ( $previous_product ) : ?>
	<?php
	echo sprintf(
		'<a href="%s" rel="prev" class="ipress-previous-product" title="%s">%s<span class="ipress-product-pagination__title">%s</span></a>',
		esc_url( $previous_product->get_permalink() ),
		esc_attr__( 'Display Previous Product', 'ipress' ),
		wp_kses_post( $previous_product->get_image() ),
		wp_kses_post( $previous_product->get_name() );
	);
	?>
<?php endif; ?>

<?php if ( $next_product ) : ?>
	<?php
	echo sprintf(
		'<a href="%s" rel="next" class="ipress-next-product" title="%s">%s<span class="ipress-product-pagination__title">%s</span></a>',
		esc_url( $next_product->get_permalink() ),
		esc_attr__( 'Display Next Product', 'ipress' ),
		wp_kses_post( $next_product->get_image() ),
		wp_kses_post( $next_product->get_name() )
	);
	?>
<?php endif; ?>

</nav><!-- .ipress-product-pagination -->
