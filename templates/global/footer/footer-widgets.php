<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying footer widgets.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Set dynamic footer widget columns, default 3
$ip_footer_widget_columns = (int) apply_filters( 'ipress_footer_widget_columns', 3 );
$ip_footer_widget_columns = ( $ip_footer_widget_columns >=0 && $ip_footer_widget_columns <=5 ) ? $ip_footer_widget_columns : 3;

// Singular pages get to override setting
if ( is_singular() ) {
	$footer_widget_columns = get_post_meta( get_the_ID(), '_ipress-footer-widget-columns', true );
	if ( $footer_widget_columns || '0' === $footer_widget_columns ) {
		$ip_footer_widget_columns = (int) $footer_widget_columns;
	}
}

// Base check
if ( $ip_footer_widget_columns <= 0 ) {
	return;
}

// Check something active, if not then bail
$is_active_sidebar = ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) ) ? true : false;
if ( ! $is_active_sidebar ) {
	return;
}

?>

<div id="footer-widgets" class="footer-widgets footer-widgets-col-<?php echo esc_attr( $ip_footer_widget_columns ); ?>">
<?php do_action( 'ipress_before_footer_widget_content' ); ?>

<?php
$i = 0;
while ( $i < $ip_footer_widget_columns ) :
	$i++;
	echo sprintf( '<div class="%1$s">%2$s</div>', 'footer-widget-' . $i, ( is_active_sidebar( 'footer-' . $i ) ) ? dynamic_sidebar( 'footer-' . $i ) : '' );
endwhile;
?>

<?php do_action( 'ipress_after_footer_widget_content' ); ?>
</div><!-- /.footer-widgets  -->

<?php do_action( 'generate_after_footer_widgets' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
