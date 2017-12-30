<?php
get_header(); ?>
<div class="container padd60 nopaddleft nopaddright">
	<div class="row">
	    <div class="col-md-8">
	        <div>
				<div id="post-0" class="post error404 not-found">
					<h1 class="entry-title"><?php _e( 'ERROR 404', 'jwp' ); ?></h1>
					<div class="entry-content">
						<p><?php _e( 'The requested page is not found', 'jwp' ); ?></p>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>