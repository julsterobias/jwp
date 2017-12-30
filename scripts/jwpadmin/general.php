<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<?php
global $jwp,$wpdb;

function SelectedTab($attr){
	if(!@$attr[0] && $attr[1] == 'm'):
		return 'class="active"';
	elseif($attr[0] == $attr[1]):
		return 'class="active"';
	endif;
}

?>
<link href="<?php bloginfo('template_url'); ?>/scripts/jwpadmin/style.css" rel="stylesheet" type="text/css" />

<div class="jwp-holder">
	<div class="jwp-header">
    	<div class="padd_menu">
            <div align="center"><b>CONTROL PANEL</b></div>
        </div>
    </div>
    <div class="jwp-content wrap">
    	<div class="padd">
        <?php
			if(@$_GET['tab'] == 'm' || !@$_GET['tab']):
				require get_theme_root().'/'.get_current_theme().'/scripts/jwpadmin/advance.php';
			elseif(@$_GET['tab'] == 'cp'):
				require get_theme_root().'/'.get_current_theme().'/scripts/jwpadmin/custom-posts.php';
			elseif(@$_GET['tab'] == 'a'):
				require get_theme_root().'/'.get_current_theme().'/scripts/jwpadmin/advance.php';
			elseif(@$_GET['tab'] == 't'):
				require get_theme_root().'/'.get_current_theme().'/scripts/jwpadmin/taxonomy.php';
	   		elseif(@$_GET['tab'] == 'aa'):
				require get_theme_root().'/'.get_current_theme().'/scripts/jwpadmin/about.php';
			elseif(@$_GET['tab'] == 'mb'):
				require get_theme_root().'/'.get_current_theme().'/scripts/jwpadmin/edit-meta-boxes.php';
			endif;
		?>    
        </div>
    </div>
</div>
<?php endif; ?>