<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme footer - displays <footer> section content and containers.
 * 
 * @package		iPress
 * @link		http://ipress.uk
 * @see			https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @license		GPL-2.0+
 */
?>
	<?php do_action( 'ipress_before_footer' ); ?>

	<footer id="footer" class="site-footer">

		<?php do_action( 'ipress_footer_top' ); ?>

		<div class="wrap">

			<?php
			/**
			 * Functions hooked in to ipress_footer action
			 *
			 * @hooked ipress_footer_widgets - 10
			 * @hooked ipress_credit		 - 20
			 */
			do_action( 'ipress_footer' ); ?>

		</div>

		<?php do_action( 'ipress_footer_bottom' ); ?>

	</footer><!-- #footer / .site-footer -->

	<?php do_action( 'ipress_after_footer' ); ?>

	</div><!-- #page / .site-container -->

	<?php do_action( 'ipress_after' ); ?>

<?php wp_footer(); ?>

</body>
</html>
