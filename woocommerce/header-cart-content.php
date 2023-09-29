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

// Cart content
$currency = get_woocommerce_currency();
$currency_code = get_woocommerce_currency_symbol();
$cart_count = ( is_object( WC()->cart) ) ? WC()->cart->get_cart_contents_count() : 0;
$cart_total = ( is_object( WC()->cart) ) ? WC()->cart->get_cart_total() : 0; 
$cart_contents = ( is_object( WC()->cart) ) ? WC()->cart->get_cart() : [];

// Cart urls
$cart_url = wc_get_cart_url();
$checkout_url = wc_get_checkout_url();

// Slider or dropdown menu
$ip_wc_header_cart_dropdown = (bool) apply_filters( 'ipress_wc_header_cart_dropdown', false );

// Header Cart Class
$header_cart_class = ( $ip_wc_header_cart_dropdown ) ? ' dropdown-menu' : '';

?>
<div id="headerCart" class="header-cart-content<?php echo $header_cart_class; ?>" aria-labelledby="getHeaderCart">

<?php if ( $cart_count === 0 ) : ?>
	<div class="cart-item no-items">
		<?php echo sprintf( '<h5>%s</h5>', __( 'Your basket is empty', 'ipress-standalone' ) ); ?>
	</div>
<?php else : ?>
	<?php foreach ( $cart_contents as $cart_item_key => $cart_item ) : ?>
<?php

		// Get current product 
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		// Test product ok to list
		if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] === 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) { continue; }

		// Get product details
        $thumbnail_id = get_post_thumbnail_id( $cart_item['product_id'] );
        $image_url = ( $thumbnail_id ) ? wp_get_attachment_image_url( $thumbnail_id, 'shop_thumbnail' )
                    	               : apply_filters( 'ipress_header_cart_image', WC()->plugin_url() . '/assets/images/placeholder.png' ); 
        $post_link = $_product->get_permalink();
        $post_title	= $_product->get_title();
        $price = $_product->get_price();
        $quantity = $cart_item['quantity'];
        $delete_url	= wc_get_cart_remove_url( $cart_item_key ); 
        $line_price	= number_format( ( $cart_item['line_subtotal'] + $cart_item['line_subtotal_tax'] ), 2, '.', '' );
?>
		<div class="cart-item">
			<div class="item-content">
				<div class="item-image">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_html( $post_title ); ?>" class="img-fluid" />
				</div>
				<div class="item-details">
                    <a href="<?php echo esc_url( $post_link ); ?>"><?php echo esc_html( $post_title ); ?></a>
                    <small><?php echo esc_html__( 'Quantity', 'ipress-standalone' ); ?>: <?php echo esc_attr( $quantity ); ?></small>
                    <span class="price"><?php echo esc_html( $currency_code ); ?><?php echo esc_html( $price ); ?></span>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="delete" data-id="<?php echo esc_attr( $cart_item['product_id'] ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="bi bi-x" viewBox="0 0 16 16">
							<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
						</svg>
					</a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

	<div class="cart-total">
		<span><?php echo esc_html__( 'Total', 'ipress-standalone' ); ?></span>
		<strong><?php echo $cart_total; ?></strong>
	</div>
	<div class="cart-links">
        <a href="<?php echo esc_url( $cart_url ); ?>" class="button"><?php echo esc_html__( 'View basket', 'ipress-standalone' ); ?></a>
        <a href="<?php echo esc_url( $checkout_url ); ?>" class="button"><?php echo esc_html__( 'Checkout', 'ipress-standalone' ); ?></a>
	</div>
	<a href="#" id="closeHeaderCart" class="close-link">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="bi bi-x" viewBox="0 0 16 16">
			<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
		</svg>
	</a>

</div>
