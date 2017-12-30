<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'jwp' ), 'after' => '</div>' ) ); ?>
					</div>
				</div>
				<?php comments_template( '/jwp-comments.php', true ); ?>

<?php endwhile; ?>
