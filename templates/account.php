<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying Woocommerce account page content
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_account_before' ); ?>

<!-- Account -->
<section id="account" class="account-content">
	<?php the_content(); ?>
	<?php do_action( 'ipress_account' ); ?>
</section> <!-- #account / .account-content -->

<?php do_action( 'ipress_account_after' );
