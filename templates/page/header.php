<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the page content header.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php do_action( 'ipress_page_header_before' ); ?>

<header class="page-header">
	<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
</header><!-- .page-header -->
