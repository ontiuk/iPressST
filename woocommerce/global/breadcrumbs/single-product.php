<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for woocommerce single product breadcrumb
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
<section class="header-breadcrumb single-product-breadcrumb">
    <div class="container">
	<?php echo $wrap_before; ?>
	<?php ( ipress_has_schema() ) : ?>
		<ul id="breadcrumblist" class="breadcrumb" <?php echo ipress_schema( 'breadcrumb' ); ?> >
			<li class="breadcrumb-item" <?php echo ipress_schema( 'breadcrumb-item' ); ?> ><a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo ipress_schema( 'breadcrumb-link' ); ?> ><span itemprop="name"><?php echo esc_html__( 'Home', 'ipress' ); ?></span></a><meta itemprop="position" content="1" /></li>
			<?php foreach ( $breadcrumb as $key => $crumb ) : ?>
				<?php if ( ! empty( $crumb[1] ) && $breadcrumb_count > ( $key + 1 ) ) : ?>
				<li class="breadcrumb-item" <?php echo ipress_schema( 'breadcrumb-item' ); ?> ><a href="<?php echo esc_url( $crumb[1] ); ?>" <?php echo ipress_schema( 'breadcrumb-link' ); ?> ><span itemprop="name"><?php echo esc_html( $crumb[0] ); ?></span></a><meta itemprop="position" content="<?php echo $key + 1; ?>" /></li>
			<?php else : ?>
				<li class="breadcrumb-item active" <?php echo ipress_schema( 'breadcrumb-item' ); ?> ><span itemprop="name"><?php echo $crumb[0] ?></span><meta itemprop="position" content="<?php echo $key + 1; ?>" /></li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	<?php else : ?>
	   <ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress' ); ?></a></li>
		<?php foreach ( $breadcrumb as $key => $crumb ) : ?>
			<?php if ( ! empty( $crumb[1] ) && $breadcrumb_count > ( $key + 1 ) ) : ?>
			<li class="breadcrumb-item"><a href="<?php echo esc_url( $crumb[1] ); ?>"><?php echo esc_html( $crumb[0] ); ?></a></li>
			<?php else : ?>
			<li class="breadcrumb-item active"><?php echo $crumb[0] ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
   	<?php echo $wrap_after; ?>
 </div>
</section>
