<?php

/**
 * The template for displaying comments list and comment form
 *
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Password protected?
if ( post_password_required() ) { return; } ?>

<?php do_action( 'ipress_before_comments' ); ?>

<section id="comments" class="<?php echo ( comments_open() ) ? 'comments-area' : 'comments-area comments-closed'; ?>" aria-label="Post Comments">

<?php if ( $comments ) : ?>

	<div class="comments">

		<?php $comments_number = absint( get_comments_number() ); ?>

		<div class="comments-header">

			<h2 class="comments-title">
			<?php 
				if ( have_comments() ) :
					if ( 1 === $comments_number ) :
 						/* translators: %s: post title */
						$comments_title = sprintf( _x( 'One comment on &ldquo;%s&rdquo;', 'comments title', 'ipress-child' ), '<span>' . get_the_title() . '</span>' );
					else :
						$comments_title = sprintf(
							/* translators: 1: number of comments, 2: post title */
							_nx( // phpcs:ignore WordPress.WP.I18n.MismatchedPlaceholders,
								'One comment on &ldquo;%2$s&rdquo;', // phpcs:ignore WordPress.WP.I18n.MissingSingularPlaceholder 
								'%1$s comment on &ldquo;%2$s&rdquo;', 
								$comments_number, 
								'comments title', 
								'ipress-child' 
							),
							number_format_i18n( $comments_number ),
							'<span>' . get_the_title() . '</span>'
						);
					endif;
					echo wp_kses_post( $comments_title );
				else :
					esc_html_e( 'Leave a comment.', 'ipress-child' );
				endif ?>
			</h2><!-- .comments-title -->

		</div><!-- comments-header -->

		<div class="comments-content">

			<ol class="comment-list">
			<?php
				wp_list_comments( [
					'avatar_size' => 120,
					'style'		 => 'ol'
				] );
			?>
			</ol><!-- .comment-list -->

		<?php

			$comment_pagination = paginate_comments_links(
				[
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __( 'Newer Comments', 'ipress-child' ) . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'ipress-child' )
				]
			);

			if ( $comment_pagination ) :

				// If we're only showing the "Next" link, add a class indicating so.
				$pagination_classes = ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) ? 'only-next' : '';
				?>

				<nav class="comments-pagination pagination <?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Comments', 'ipress-child' ); ?>">
					<?php echo wp_kses_post( $comment_pagination ); ?>
				</nav>

				<?php

			endif;
		?>

		</div><!-- comments-content -->

	</div><!-- comments -->

<?php endif; // Check for comments()

// Comments closed
if ( ! comments_open() && get_comments_number() ) :
	echo sprintf( '<p class="no-comments">%s</p>', esc_html_e( 'Comments are closed.', 'ipress-child' ) );
endif;

do_action( 'ipress_before_comment_form' );

if ( comments_open() || pings_open() ) :

	if ( $comments ) : echo '<hr class="comment-separator" aria-hidden="true" />'; endif;

	$args = apply_filters( 'ipress_comment_form_args', [
		'class_form'         => 'comment-form',
		'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</span>',
	] );
	
	comment_form( $args );

endif;
?>

</section><!-- #comments -->

<?php do_action( 'ipress_after_comments' );
