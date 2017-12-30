<?php

if ( post_password_required() )
	return;
?>
<div id="comments" class="comments-area">


	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _n( 'Comments for &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'jwp' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h3>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'jwp_comment', 'style' => 'ol' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'jwp' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'jwp' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'jwp' ) ); ?></div>
		</nav>
		<?php endif;?>

		<?php
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'jwp' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(array('comment_notes_after'=>'')); ?>

</div>