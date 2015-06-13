<?php
if ( post_password_required() )
	return;
?>
<?php if ( have_comments() ) : ?>
	<h2 class="comments-title">
		<span id="comments">
		<?php
			printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'vortex' ),
				get_comments_number(), '<span>' . get_the_title() . '</span>' );
		?>
		</span>
	</h2>
	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>
	<?php $comment_args = array( 'comment_notes_after' => '' ); ?>
	<?php comment_form($comment_args); ?>
<?php else: ?>
	<?php comment_form(array( 'comment_notes_after' => '' )); ?>
<?php endif; ?>