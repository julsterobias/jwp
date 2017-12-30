<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}

if(is_admin()):
?>

<script type="text/javascript">
	function DoAdd_advance(show_,hide_,mode_,id_){
		if(mode_ == 'open'){
			jQuery('#'+show_).fadeIn(200);
			jQuery('#'+hide_).hide();
		}else{
			jQuery('#'+show_).hide();
			jQuery('#'+hide_).fadeIn(200);
		}
		switch(show_){
			case 'add_widget':
				EditSideWidgets(id_);
			break;
			case 'add_cmenu':
				EditCustomMenu(id_);
			break;
			case 'add_cimage_s':
				EditCustomImageS(id_)
			break;
			case 'add_taxo':
				EditSideTaxo(id_)
			break;
		}
		jQuery('.jwpmsg').fadeOut(200);
	}
	function DoAutoFill(val){
		var cleaid = val.replace(/ /gi,'-');
		document.getElementById('widget_id').value = cleaid.toLowerCase();
	}
	function DeleteConfirm(name,url){
		if(confirm("Are you sure you want to delete "+name)){
			window.location = url;
		}
	}
</script>
<div class="a">

<?php
if(@$_GET['gmsg']):
?>
	<div class="jwpmsg">Changes has been saved</div>
<?php
endif;
?>
	<ul class="jwp_mods_">
    	<li>
        	<?php include('custompost-list.php'); ?>
        </li>
        <li>
        	<?php include('taxonomy-list.php'); ?>
        </li>
    	<li>
        	<?php include('sidebar-widgets.php'); ?>
        </li>
		<li>
        	<?php include('custom-menu.php'); ?>
        </li>
        <li>
        	<?php include('custom-image-size.php'); ?>
        </li>
        <li>
        	<?php include('meta-boxes.php'); ?>
        </li>
    </ul>
    <div class="clear"></div>
</div>

<?php endif; ?>