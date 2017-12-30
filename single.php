<?php 
get_header(); ?>           
<div class="container padd60 nopaddleft nopaddright">
	<div class="row">
	    <div class="col-md-8">
         				<div>
                        		<div class="breadcrumbs" align="left"><?php echo $jwp->jwp_BreadCrumbs(); ?></div>
                               	<?php get_template_part( 'jwp', 'single' ); ?>
                             
                    	</div>
       </div>
        <div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>    

