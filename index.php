<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Main fallback template displaying generic posts list.
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php get_header(); ?>

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-content index-page">

	<?php do_action( 'ipress_archive_before' ); ?>

	<?php if ( have_posts() ) : ?>
   
		<header class="page-header">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<h1 class="page-title single-title"><?php single_post_title(); ?></h1>
		<?php else : ?>
			<h1 class="page-title index-title"><?php esc_html_e( 'Our Latest Posts', 'ipress-child' ); ?></h1>
			<?php the_archive_description( '<div class="archive-description index-archive">', '</div>' ); ?>
		<?php endif; ?>
		</header><!-- .page-header -->

		<?php get_template_part( 'templates/index' ); ?>

	<?php else: ?>
	
		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

    </main><!-- #main / .site-content -->

	<?php do_action( 'ipress_sidebar' ); ?>
	
<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer();
