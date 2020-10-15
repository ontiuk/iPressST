<?php

/**
 * Content wrappers
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

// Source for the hook
$product_class = ( is_shop() ) ? 'shop-page product-archive' : 'product-page';

// Output the main wrapper
echo sprintf( '<main id="main" class="site-content %s" role="main">', $product_class );
