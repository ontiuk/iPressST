<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying the_loop in search mode.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php do_action( 'ipress_loop_before' ); ?>

<?php  while ( have_posts() ) : the_post(); ?>
  
    <?php get_template_part( 'templates/content', 'search' ); ?>

<?php endwhile; ?>

<?php /** @hooked ipress_paging_nav - 10 */
do_action( 'ipress_loop_after' );
