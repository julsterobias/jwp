<?php get_header(); ?>
<div class="container padd60 nopaddleft nopaddright">
	<div class="row">
	    <div class="col-md-8">
	         <div>
				<div class="jwp_error"><?php echo $jwp_message; ?></div>
	            <div align="center"><a href="javascript:void(0);" onClick="goBack()">&laquo; Back to comment</a></div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-md-4">
<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
