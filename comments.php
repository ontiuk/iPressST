<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * The template for displaying comments list and comment form
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Password protected? Don't load comments if no password entered
if ( post_password_required() ) {
	return;
}
?>

<?php do_action( 'ipress_before_comments' ); ?>

<section id="comments" class="<?php echo ( comments_open() ) ? 'comments-area' : 'comments-area comments-closed'; ?>" aria-label="<?php echo esc_attr__( 'Post Comments', 'ipress' ); ?>">

<?php if ( $comments ) : ?>

	<div class="comments">

		<?php $comments_number = absint( get_comments_number() ); ?>

		<div class="comments-header">

			<h2 class="comments-title">
			<?php
			if ( have_comments() ) {
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					$comments_title = sprintf( _x( 'One comment on &ldquo;%s&rdquo;', 'comments title', 'ipress' ), '<span>' . get_the_title() . '</span>' );
				} else {
					$comments_title = sprintf(
						/* translators: %s: Comment count number. */
						_nx( '%s comment', '%s comments', $comments_number, 'Comments title', 'ipress' ),
						number_format_i18n( $comments_number ),
						'<span>' . get_the_title() . '</span>'
					);
				}
				echo wp_kses_post( $comments_title );
			} else {
				esc_html_e( 'Leave a comment.', 'ipress' );
			}
			?>
			</h2><!-- .comments-title -->

		</div><!-- comments-header -->

		<div class="comments-content">

			<ol class="comment-list">
			<?php
			wp_list_comments(
				[
					'avatar_size' => 120,
					'style'       => 'ol',
				]
			);
			?>
			</ol><!-- .comment-list -->

			<?php
			$comment_pagination = paginate_comments_links(
				[
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __( 'Newer Comments', 'ipress' ) . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'ipress' ),
				]
			);

			if ( $comment_pagination ) {

				// If we're only showing the "Next" link, add a class indicating so.
				$pagination_classes = ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) ? 'only-next' : '';

				echo sprintf(
					'<nav id="comment-pagination" class="comments-pagination pagination %s" aria-label="%s">%s</nav>',
					esc_attr( $pagination_classes ),
					esc_attr__( 'Comments', 'ipress' ),
					wp_kses_post( $comment_pagination )
				);
			}
			?>
		</div><!-- comments-content -->

	</div><!-- comments -->

<?php endif; // Check for comments() ?>

<?php
// Comments closed?
if ( ! comments_open() && get_comments_number() ) :
	echo sprintf( '<p class="no-comments">%s</p>', esc_html_e( 'Comments are closed.', 'ipress' ) );
endif;
?>

<?php do_action( 'ipress_before_comment_form' ); ?>

<?php
// Comments / Pings open?
if ( comments_open() || pings_open() ) :
	if ( $comments ) :
		echo '<hr class="comment-separator" aria-hidden="true" />';
	endif;

	$args = apply_filters(
		'ipress_comment_form_args',
		[
			'class_form'         => 'comment-form',
			'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</span>',
		]
	);

	// Display comment form
	comment_form( $args );
endif;
?>

</section><!-- #comments -->

<?php do_action( 'ipress_after_comments' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
