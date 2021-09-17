<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the generic site logo / text.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>
<div class="site-branding">
	<?php ipress_site_title_or_logo(); ?>
	<?php do_action( 'ipress_site_branding' ); ?>
</div>
