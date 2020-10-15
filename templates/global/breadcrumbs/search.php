<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for search page breadcrumb.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb search-breadcrumb">
	<div class="container">
		<ul id="breadcrumblist" class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?php echo esc_html__( 'Search', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?php echo esc_html( ucfirst( get_search_query() ) ); ?></li>
		</ul>
	</div>
</section>
