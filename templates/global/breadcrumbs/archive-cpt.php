<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for custom post-type archive breadcrumb.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

$the_post_type        = get_post_type();
$the_post_type_object = get_post_type_object();
$the_post_type_name   = get_post_type_labels( $the_post_type_object )->name;
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb archive-breadcrumb">
	<div class="container">
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress-standalone' ); ?></a></li>
			<li class="breadcrumb-item"><?php echo esc_html( $post_type_name ); ?></li>
			<li class="breadcrumb-item active"><?php post_type_archive_title(); ?></li>
		</ul>
	</div>
</section>
