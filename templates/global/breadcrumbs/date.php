<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for date archive page breadcrumb.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( is_year() ) {
	$date_type = 'Year';
	$date_item = get_the_date( _x( 'Y', 'yearly archives date format', 'ipress' ) );
} elseif ( is_month() ) {
	$date_type = 'Month';
	$data_item = get_the_date( _x( 'F Y', 'monthly archives date format', 'ipress' ) );
} elseif ( is_day() ) {
	$date_type = 'Day';
	$date_item = get_the_date( _x( 'F j, Y', 'daily archives date format', 'ipress' ) );
}
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb date-breadcrumb">
	<div class="container">
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?php echo esc_html( $date_type ); ?></a></li>
			<li class="breadcrumb-item active"><?php echo esc_html( $date_item ); ?></li>
		</ul>
	</div>
</section>
