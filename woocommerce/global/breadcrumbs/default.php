<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for woocommerce archive page breadcrumb
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php defined( 'ABSPATH' ) || exit; ?>

<?php 
// Check breadcrumbs
$breadcrumb_count = count( $breadcrumb ); 
if ( ! $breadcrumb_count ) { return; }
?>
<!-- Breadcrumbs-->
<section class="header-breadcrumb shop-breadcrumb">
    <div class="container">
	<?php echo $wrap_before; ?>
		<ul class="breadcrumb">
		<?php foreach ( $breadcrumb as $key => $crumb ) : ?>
			<?php if ( ! empty( $crumb[1] ) && $breadcrumb_count > ( $key + 1 ) ) : ?>
			<li class="breadcrumb-item"><a href="<?php echo esc_url( $crumb[1] ); ?>"><?php echo esc_html( $crumb[0] ); ?></a></li>
			<?php else : ?>
			<li class="breadcrumb-item active"><?php echo $crumb[0] ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	<?php echo $wrap_after; ?>
    </div>
</section>
