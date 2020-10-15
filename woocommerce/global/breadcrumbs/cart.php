<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for woocommerce cart page breadcrumb
 *
 * - WC_Breadcrumb does not product breadcrumb for this page type 
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php defined( 'ABSPATH' ) || exit; ?>

<!-- Breadcrumbs-->
<section class="header-breadcrumb cart-breabcrumb">
    <div class="container">
	<?php echo $wrap_before; ?>
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item active"><?php woocommerce_page_title(); ?></li>
		</ul>
	<?php echo $wrap_after; ?>
    </div>
</section>
