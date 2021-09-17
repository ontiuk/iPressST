<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying main pagination within the loop.
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

global $wp_query;

$older = (string) apply_filters( 'ipress_next_nav_link', '&larr; Older' );
$newer = (string) apply_filters( 'ipress_prev_nav_link', 'Newer &rarr;' );

if ( $wp_query->max_num_pages > 1 ) :
	?>
<!-- pagination --> 
<section id="pagination" class="paginate post-paginate">

	<nav class="pagination" role="navigation"> 
		<div class="nav-next nav-left"><?php echo esc_html( get_next_posts_link( $older, $wp_query->max_num_pages ) ); ?></div> 
		<div class="nav-previous nav-right"><?php echo esc_html( get_previous_posts_link( $newer ) ); ?></div> 
	</nav>

</section>
<!-- //pagination --> 
	<?php
endif;
