<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Template for displaying generic author archives.
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

	<main id="main" class="site-content author-page">

	<?php do_action( 'ipress_archive_before' ); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<header class="page-header">
		<?php 
			$author_name = sprintf(
				/* translators: %s: author name */
				__( 'Author: <span class="post-author">%s</span>', 'ipress-child' ), 
				get_the_author() 
			); 
		?>
			<h1 class="page-title author-title"><?php echo wp_kses_post( $author_name ); ?></h1>
		</header><!-- .page-header -->

		<?php $author_description = get_the_author_meta( 'description' ); ?>
		<?php if ( $author_description ) : ?>
		<section class="content-author">
			<?php echo esc_html( wpautop( $author_description ) ); ?>
		</section>	  
		<?php endif; ?>

		<?php rewind_posts(); ?>

		<?php get_template_part( 'templates/archive' ); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/global/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

    </main><!-- #main / .site-content -->

	<?php do_action( 'ipress_sidebar' ); ?>

<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer();
