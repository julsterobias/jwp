<?php get_header(); ?>
<div class="container padd60 nopaddleft nopaddright">
	<div class="row">
	    <div class="col-md-8">
         	<div>

<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'jwp' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php
				 get_template_part( 'jwp', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'jwp' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'jwp' ); ?></p>
					
					</div>
				</div>
<?php endif; ?>
			</div>
		</div>


		<div class="col-md-4">
<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
