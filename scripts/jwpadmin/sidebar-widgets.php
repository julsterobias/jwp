<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<script type="text/javascript">
	function EditSideWidgets(id_){
		if(id_ > 0){
			jQuery('#sidewidget_mode').val('edit');
			jQuery('#widget_name').val(jQuery('#hide_wd_name_'+id_).val());
			jQuery('#widget_desc').val(jQuery('#widget_sidebar_desc_'+id_).val());
            jQuery('#wd_target_id_wa').val(id_);
		}else{
			jQuery('#sidewidget_mode').val('add');
			jQuery('#wd_target_id').val('');
			jQuery('#widget_name').val('');
			jQuery('#widget_id').val('');
			jQuery('#widget_desc').val('');
		}
	}
</script>
<div class="jwp_mods" id="slider">
                <div class="padd">
                    <span class="modtitle left">Widget Area</span>
                    <div class="right"><input type="button" name="" class="button button-primary" value="Add" onclick="DoAdd_advance('add_widget','widget_list','open',0)" /></div>
                    <div class="clear"></div>
                </div>
                <div class="modcontent ">
                	<div id="widget_list">
                    	<table width="100%" border="0" cellspacing="0">
                            <tr>
                                <th width="20%">Name</th>
                                <th width="20%">ID</th>
                                <th width="30%">Description</th>
                                <th width="20%">Call Function</th>
                                <th width="10%" align="right">&nbsp;</th>
                            </tr>
                     <?php
					 	$getwidgets = $wpdb->get_results("SELECT id, widget_sidebar_title, widget_sidebar_id, widget_sidebar_desc FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'wd'");
						foreach($getwidgets as $widgets_data):
					 ?>       
                            <tr>
                            	<td><?php _e($widgets_data->widget_sidebar_title); ?></td>
                                <td><?php _e($widgets_data->id); ?></td>
                                <td><?php _e($widgets_data->widget_sidebar_desc); ?></td>
                                <td>dynamic_sidebar('<?php _e($widgets_data->widget_sidebar_id); ?>')</td>
                                <td align="right"><a href="javascript:void(0);" onclick="DoAdd_advance('add_widget','widget_list','open',<?php _e($widgets_data->id); ?>)" id="DoEdit">Edit</a> | <a href="javascript:void(0);" onclick="DeleteConfirm('Widget SideBar','admin.php?page=general&tab=a&action=delPost&id=<?php _e($widgets_data->id); ?>');">Delete</a>
                                <input type="hidden" id="hide_wd_name_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->widget_sidebar_title); ?>" />
                                <input type="hidden" id="widget_sidebar_id_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->id); ?>" />
                                <input type="hidden" id="widget_sidebar_desc_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->widget_sidebar_desc); ?>" />
                                </td>
                            </tr>
                     <?php
					 	endforeach;
					 ?>
                        </table>
                    </div>
                	<div style="padding:15px; display:none;" id="add_widget">
                        <h3>Add New Widget</h3>
                        <form method="post">
                            <p><input type="text" class="widefat" name="widget_name" id="widget_name" placeholder="Widget Sidebar Name" onkeyup="DoAutoFill(this.value)" /></p>
                           
                            <p><input type="text" class="widefat" name="widget_desc" id="widget_desc" placeholder="Widget Sidebar Description" /></p>
                            <p><input type="submit" name="create_widget_sub" class="button button-primary" value="Save Widget Sidebar" /><input type="button" class="button button-primary" name="" value="Cancel" onclick="DoAdd_advance('add_widget','widget_list','close',0)" style="margin-left:5px;" />
                            </p>
                            <div class="clear"></div>
                            <input type="hidden" name="sidewidget_mode" id="sidewidget_mode" value="add" />
                            <input type="hidden" name="wd_target_id" id="wd_target_id_wa" value="" />
                            <input type="hidden" name="widget_id" id="widget_id" value="" />
                        </form>
                    </div>
                </div>
       		</div>
<?php 
endif;
?>