<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for taxonomy product category archive page breadcrumb
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Check breadcrumbs
$breadcrumb_count = count( $breadcrumb );
if ( ! $breadcrumb_count ) {
	return;
}
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb product-category-breadcrumb">
	<div class="container">
	<?php echo esc_html( $wrap_before ); ?>
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress' ); ?></a></li>
		<?php foreach ( $breadcrumb as $key => $crumb ) : ?>
			<?php if ( ! empty( $crumb[1] ) && $breadcrumb_count > ( $key + 1 ) ) : ?>
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress' ); ?></a></li>
			<?php else : ?>
			<li class="breadcrumb-item active"><?php echo esc_html( $crumb[0] ); ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	<?php echo esc_html( $wrap_after ); ?>
	</div>
</section>
