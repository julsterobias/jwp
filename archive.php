<?php
get_header(); ?>

<div class="container padd60 nopaddleft nopaddright">
	<div class="row">
	      <div class="col-md-8">
        	 <div>

<?php
	if ( have_posts() )
		the_post();
?>

			<h1 class="page-title"><?php _e( 'Blog Archives', 'jwp' ); ?></h1>

<?php
	rewind_posts();
	 get_template_part( 'jwp', 'archive' );
?>

			</div><!-- #content -->
		</div><!-- #container -->
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
