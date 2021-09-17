<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the content not found message.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_none_before' ); ?>

<section class="no-results not-found">

	<header class="page-header">
		<h1 class="page-title page-none"><?php esc_html_e( 'Nothing to display.', 'ipress' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( ipress_is_home_page() && current_user_can( 'publish_posts' ) ) : ?>

		<p>
			<?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ipress' ),
						[
							'a' => [
								'href' => [],
							],
						]
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
			?>
		</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again with different keywords.', 'ipress' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'We can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ipress' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page-content -->

</section><!-- .no-results -->

<?php do_action( 'ipress_none_after' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
