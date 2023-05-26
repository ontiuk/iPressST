<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the main 404 page content in Woocommerce activate.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_404_before' ); ?>

<section class="error-404 not-found">

	<header class="page-header">
		<h1 class="page-title error-title"><?php echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'ipress' ); ?></h1>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Return home?', 'ipress' ); ?></a></p>
	</header><!-- .page-header -->

	<div id="post-404" class="page-content">

		<p><?php echo esc_html__( 'Nothing found at this location.', 'ipress' ); ?></p>
		<?php the_widget( 'WC_Widget_Product_Search' ); ?>

		<nav class="error-product-categories" aria-label="<?php echo esc_html__( 'Product Categories', 'ipress' ); ?>">

			<h2><?php echo esc_html__( 'Product Categories', 'ipress' ); ?></h2>
			<?php the_widget( 'WC_Widget_Product_Categories', [ 'count' => 1, 'title' => '' ] ); ?>

		</nav>

		<section class="error-popular-products" aria-label="<?php echo esc_html__( 'Popular Products', 'ipress' ); ?>">

			<h2><?php echo esc_html__( 'Popular Products', 'ipress' ); ?></h2>

			<?php
			$ip_shortcode_content = ipress_do_shortcode(
				'best_selling_products',
				[
					'per_page' => 4,
					'columns'  => 4,
				]
			);
			echo $ip_shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</section>

		<?php do_action( 'ipress_404' ); ?>

	</div><!-- .page-content -->

</section><!-- .error-404 -->

<?php do_action( 'ipress_404_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
