<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<script type="text/javascript">
	function EditCustomMenu(id_){
		if(id_ > 0){
			jQuery('#cmenu_id').val(id_);
			jQuery('#cmenu_mode').val('edit');
			jQuery('#cmenu_location').val(jQuery('#cmenu_location_'+id_).val());
			jQuery('#cmenu_name').val(jQuery('#cmenu_name_'+id_).val());
		}else{
			jQuery('#cmenu_mode').val('add');
			jQuery('#cmenu_id').val('');
			jQuery('#cmenu_location').val('');
			jQuery('#cmenu_name').val('');
		}
	}
</script>
<div class="jwp_mods" id="slider">
                <div class="padd">
                    <span class="modtitle left">Custom Menu</span>
                    <div class="right"><input type="button" class="button button-primary" name="" value="Add" onclick="DoAdd_advance('add_cmenu','cmenu_list','open',0)" /></div>
                    <div class="clear"></div>
                </div>
                <div class="modcontent ">
                	<div id="cmenu_list">
                    	<table width="100%" border="0" cellspacing="0">
                            <tr>
                                <th width="20%">Theme Location</th>
                                <th width="70%">Name</th>
                                <th width="10%">&nbsp;</th>
                            </tr>
                     <?php
					 	$getwidgets = $wpdb->get_results("SELECT id, cmenu_location, cmenu_name FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'cm'");
						foreach($getwidgets as $widgets_data):
					 ?>       
                            <tr>
                            	<td><?php _e($widgets_data->cmenu_location); ?></td>
                                <td><?php _e($widgets_data->cmenu_name); ?></td>
                                <td align="right"><a href="javascript:void(0);" onclick="DoAdd_advance('add_cmenu','cmenu_list','open',<?php _e($widgets_data->id); ?>)" id="DoEdit">Edit</a> | <a href="javascript:void(0);" onclick="DeleteConfirm('Custom Menu','admin.php?page=general&tab=a&action=delPost&id=<?php _e($widgets_data->id); ?>');">Delete</a>
                                <input type="hidden" id="cmenu_location_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->cmenu_location); ?>" />
                                <input type="hidden" id="cmenu_name_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->cmenu_name); ?>" />
                                </td>
                            </tr>
                     <?php
					 	endforeach;
					 ?>
                        </table>
                    </div>
                	<div style="padding: 15px; display:none;" id="add_cmenu">
                        <h3>Add New Menu</h3>
                        <form method="post">
                            <p><input type="text" class="widefat" name="cmenu_location" id="cmenu_location" placeholder="Theme location" maxlength="255"  /></p>
                            <p><input type="text" class="widefat" name="cmenu_name" id="cmenu_name" placeholder="Custom Menu Name" maxlength="255" /></p>
                            <p><input type="submit" name="save_cmenu" class="button button-primary" value="Save New Menu" /><input type="button" class="button button-primary" name="" value="Cancel" onclick="DoAdd_advance('add_cmenu','cmenu_list','close',0)" style="margin-left:5px;" />
                            </p>
                            <div class="clear"></div>
                            <input type="hidden" name="cmenu_mode" id="cmenu_mode" value="add" />
                            <input type="hidden" name="cmenu_id" id="cmenu_id" value="" />
                        </form>
                    </div>
                </div>
</div>
<?php endif; ?>