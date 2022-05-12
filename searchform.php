<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the standard search form.
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Search for ID and aria-label
$ip_unique_id  = uniqid( 'search-form-' );
$ip_aria_label = ( empty( $args['label'] ) ) ? '' : 'aria-label="' . esc_attr( $args['label'] ) . '"';

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo $ip_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> >
	<label for="<?php echo esc_attr( $ip_unique_id ); ?>">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'Search label', 'ipress' ); ?></span>
		<input type="search" id="<?php echo esc_attr( $ip_unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'ipress' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
	</label>
	<button type="submit" class="search-submit"><?php echo esc_html_x( 'Search', 'Submit button', 'ipress' ); ?></button>
</form>
