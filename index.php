<?php
get_header(); ?>
<div class="container padd60 nopaddleft nopaddright">
	<div class="row">
	      <div class="col-md-8">
	         <div>
	         	<?php get_template_part( 'jwp', 'index' ); ?>
	         </div>
	      </div>
	      <div class="col-md-4">
	      		<?php get_sidebar(); ?>
	  	  </div>
	</div>
</div>
<?php get_footer(); ?>