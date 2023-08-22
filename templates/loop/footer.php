<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the post loop footer.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_before_loop_footer' ); ?>

<footer class="post-footer"> 

<?php do_action( 'ipress_before_loop_footer_content' ); ?>

<?php

// Get relevent post types
$ip_footer_post_types = (array) apply_filters( 'ipress_post_footer_types', [ 'post' ] );

// Hide category and tag text for pages
if ( in_array( get_post_type(), $ip_footer_post_types, true ) ) {

	// Set category list separator
	$ip_cat_term_separator = apply_filters( 'ipress_cat_term_separator', _x( ', ', 'Used between category list items.', 'ipress' ), 'categories' );

	// Set the category list prefix
	$ip_category_list_prefix = apply_filters( 'ipress_cat_list_prefix', esc_html__( 'Posted in', 'ipress' ) );

	// Get the categories
	$category_list = get_the_category_list( $ip_cat_term_separator );

	// Get category list
	if ( $category_list ) {
		$category_list = sprintf(
			'<span class="post-categories"><span>%3$s</span><span class="screen-reader-text">%1$s</span>%2$s</span>',
			esc_html_x( 'Categories', 'Used before category list.', 'ipress' ),
			$category_list,
			$ip_category_list_prefix
		);
	} else {
		$category_list = '';
	}

	// Set tags list separator
	$ip_tag_term_separator = apply_filters( 'ipress_tag_term_separator', _x( ', ', 'Used between tag names.', 'ipress' ), 'categories' );

	// Set the tag name prefix
	$ip_tag_list_prefix = apply_filters( 'ipress_tag_name_prefix', esc_html__( 'Tagged in', 'ipress' ) );

	// Get the tag list
	$tag_list = get_the_tag_list( '', $ip_tag_term_separator );

	// Get the tag list
	if ( $tag_list ) {
		$tag_list = sprintf( 
			'<span class="post-tags"><span>%3$s</span><span class="screen-reader-text">%1$s</span>%2$s</span>',
				esc_html_x( 'Tags', 'Used before tag names.', 'ipress' ),
				$tag_list,
				$ip_tag_list_prefix
			);
	} else {
		$tag_list = '';
	}

	// Output the category & tag lists
	if ( $category_list || $tag_list ) {
		echo sprintf( '<aside class="post-taxonomy">%1$s %2$s</aside>', $category_list, $tag_list );
	}
}
?>

<?php do_action( 'ipress_loop_footer' ); ?>

</footer><!-- .post-footer --> 

<?php do_action( 'ipress_after_loop_footer' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
