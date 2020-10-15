<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for author archive page breadcrumb.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb author-breadcrumb">
	<div class="container">
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?php echo esc_html__( 'Author', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?php echo esc_html( get_the_author() ); ?></li>
		</ul>
	</div>
</section>
