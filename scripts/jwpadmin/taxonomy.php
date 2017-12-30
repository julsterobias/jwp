<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>

<?php global $wpdb; ?>
<script type="text/javascript">
	function NameAutoFill(obj){
		if(obj.options[obj.selectedIndex].value.length > 0){
			document.getElementById('tax_c_post_label').value = obj.options[obj.selectedIndex].innerHTML+' Categories';
			var cleans = obj.options[obj.selectedIndex].innerHTML.toLowerCase();
			cleans = cleans.replace(/ /gi,"-");
			document.getElementById('tax_c_post_s_label').value = cleans+'-categories';
		}else{
			document.getElementById('tax_c_post_label').value = '';
			document.getElementById('tax_c_post_s_label').value = '';
		}
	}
</script>
<div class="m">

<?php
	global $jwperror,$wpdb;
	if($jwperror):
?>
		<div class="jwp_error"><?php echo $jwperror; ?></div>
<?php
	endif;
	
	$taxbnt = 'savetax';
	$taxbtnlbl = 'Save Taxonomy';
	$showtable = NULL;
	$lbl = NULL;
	
	if(@$_GET['action'] == 'editax'):
		$taxbnt = 'savetaxedit';
		$taxbtnlbl = 'Save Changes';
		$showtable = 'hide';
		$lbl = 'Edit';
		$jwp_edit = $wpdb->get_row("SELECT tax_c_post_name,tax_c_post_label,tax_c_post_s_label FROM ".$wpdb->prefix."jwp_settings WHERE id = ".$_GET['id']);
	endif;
	
?>

<h2><?php echo $lbl; ?> Taxonomy <a href="http://codex.wordpress.org/Taxonomies" class="help" target="_blank">help</a></h2>
    
    <div class="left" style="width:30%;">
    <form method="post">
        <?php
			if(@$_GET['action'] != 'editax'):
		?>
        <p>
            <select name="taxonomy_" id="taxonomy_" onchange="NameAutoFill(this)">
                <option value="">Parent Custom Post Type:</option> 
                <?php 
                    $custom_p = $wpdb->get_results("SELECT id, c_post_name FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'cp' AND tax_c_post_name is NULL"); 
                    foreach($custom_p as $cp_list):
                ?>
                        <option value="<?php echo $cp_list->id; ?>"><?php echo $cp_list->c_post_name; ?></option>
                <?php
                    endforeach;
                ?>
            </select>
        </p>
        <?php
			endif;
		?>
        <p>
            <input type="text" name="tax_c_post_name" id="tax_c_post_name" value="<?php echo @$jwp_edit->tax_c_post_name; ?>" placeholder="Taxonomy Name (required)" size="50" />
        </p>
        <p>
            <input type="text" name="tax_c_post_label" id="tax_c_post_label" value="<?php echo @$jwp_edit->tax_c_post_label; ?>" placeholder="Label Name" size="50" />
        </p>
        <p>
            <input type="text" name="tax_c_post_s_label" value="<?php echo @$jwp_edit->tax_c_post_s_label; ?>" id="tax_c_post_s_label" placeholder="Label Name Singular" size="50" />
        </p>
        <p>
            <input type="button" value="Back" class="left" onClick="javascript:window.location='admin.php?page=general&tab=cp'" style="margin-right:5px;" /><input type="submit" class="left" name="<?php echo $taxbnt; ?>" value="<?php echo $taxbtnlbl; ?>" /> &nbsp;
           <?php if(@$_GET['action'] == 'editax'): ?>
           		<input type="button" value="Cancel" class="left" onClick="javascript:window.location='admin.php?page=general&tab=t'" style="margin-left:5px;" />
           <?php endif; ?>
            <div class="clear"></div>
        </p>
    </form>
    </div>
    <div class="left cplist taxlist <?php echo $showtable; ?>" >
    	<table width="100%" border="0" cellspacing="0">
        	<tr>
            	<th width="40%">Name</th>
                <th width="50%">Parent Custom Post</th>
                <th width="10%">&nbsp;</th>
            </tr>
            <?php
				$customtax = $wpdb->get_results("SELECT id, c_post_name, tax_c_post_label FROM wp_jwp_settings WHERE jwp_action = 'cp' AND tax_c_post_label is not NULL");
				foreach($customtax as $taxlist):
			?>
            <tr>
            	<td><?php echo $taxlist->tax_c_post_label; ?></td>
                <td><?php echo $taxlist->c_post_name; ?></td>
                <td><a href="admin.php?page=general&tab=t&action=editax&id=<?php echo $taxlist->id; ?>">Edit</a>&nbsp;|&nbsp;<a href="admin.php?page=general&tab=t&action=deltax&id=<?php echo $taxlist->id; ?>">Remove</a></td>
            </tr>
            <?php
				endforeach;
			?>
        </table>
    </div>
    <div class="clear"></div>

</div>
<?php 
endif;
?>