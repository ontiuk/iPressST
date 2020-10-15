<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the page content.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php /** @hooked ipress_page_image - 10 */
do_action( 'ipress_page_content_before' ); ?>

<section class="page-attachment">
<?php
	$image_size = (string) apply_filters( 'ipress_attachment_image_size', 'large', get_the_ID() );
	$image 		= wp_get_attachment_image_src( get_the_ID(), $image_size ); 

	// Display attachment escerpt
	if ( has_excerpt() ) {
		echo sprintf( '<div class="page-caption"></div><!-- .page-caption -->', esc_html( get_the_excerpt() ) );
	}

	// Display if OK
	if ( $image ) {
    	$meta = ipress_get_attachment_meta( get_the_ID(), $image );

		// Meta data defaults
		$sizing = [ 'src', 'width', 'height', 'alt' ];
		$data	= [ 'exif' ];

		// Print sizes
		echo sprintf( '<div class="page-image image-%s">', get_the_ID() );
		foreach ( $sizing as $size ) {
			echo sprintf( '<span>%1$s: %2$s</span>', esc_attr( $size ), esc_attr( $meta[$size] ) );
		}
		echo sprintf( '<span>srcset: %s', esc_attr( $meta['srcset'] ) );
		echo sprintf( '<span>sizes: %s', esc_attr( $meta['sizes'] ) );
		echo '</div>';

		// Print meta
		echo '<div class="page-meta">';
		foreach ( $data as $d ) {
			echo sprintf( '<span>%1$s: %2$s</span>', esc_attr( $d ), esc_attr( $meta[$d] ) );
		}
		echo '</div>';
?>
</section><!-- .page-attachment -->

<?php do_action( 'ipress_page_content_after' );
