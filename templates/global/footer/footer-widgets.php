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

// Test widget regions
if ( is_active_sidebar( 'footer-3' ) ) {
	$widget_columns = 3;
} elseif ( is_active_sidebar( 'footer-2' ) ) {
	$widget_columns = 2;
} elseif ( is_active_sidebar( 'footer-1' ) ) {
	$widget_columns = 1;
} else {
	$widget_columns = 0;
}

// Set dynamic column data
$widget_columns = (int) apply_filters( 'ipress_footer_widget_regions', $widget_columns );
if ( 0 === $widget_columns ) {
	return;
}
?>

<div class="footer-widgets col-<?php echo esc_attr( $widget_columns ); ?>">
<?php
$i = 0;
while ( $i < $widget_columns ) :
	$i++;
	if ( is_active_sidebar( 'footer-' . $i ) ) :
		?>
	<div class="block footer-widget-<?php echo intval( $i ); ?>">
		<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
	</div>
		<?php
	endif;
endwhile;
?>
</div><!-- /.footer-widgets  -->
