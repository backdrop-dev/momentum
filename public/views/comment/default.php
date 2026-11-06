<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comments', $data->comment ); ?>>

	<header class="comment-meta">
		<?php Backdrop\Comment\display_parent_link( [
			// Translators: %s is the parent comment link.
			'text'   => __( 'In reply to %s', 'momentum' ),
			'depth'  => 3,
			'class'  => 'comment__parent-link',
			'after'  => '<br />',
		] ) ?>

		<?php echo get_avatar( $data->comment, $data->args['avatar_size'], '', '', [
			'class' => 'comment-avatar'
		] ) ?>

		<?php Backdrop\Comment\display_author_link( [
			'class' => 'comment-author-link',
			'after' => '<br />',
		] ) ?>

		<?php
		Backdrop\Comment\display_permalink( [
			'text' => Backdrop\Comment\render_date()
		] );
		?>
		<?php Backdrop\Comment\display_edit_link( [ 'before' => Momentum\sep() ] ) ?>
		<?php Backdrop\Comment\display_reply_link( [ 'before' => Momentum\sep(), 'depth' => $data->depth, 'max_depth' => $data->args['max_depth'] ] ) ?>
	</header>

	<div class="comment-content">

		<?php if ( ! Backdrop\Comment\is_approved( $data->comment ) ) : ?>

			<p class="comment-moderation">
				<?php esc_html_e( 'Your comment is awaiting moderation.', 'momentum' ) ?>
			</p>

		<?php endif ?>

		<?php comment_text( $data->comment ) ?>
	</div>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
