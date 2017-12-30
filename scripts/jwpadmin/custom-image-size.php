<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<script type="text/javascript">
	function EditCustomImageS(id_){
		if(id_ > 0){
			jQuery('#cimage_id').val(id_);
			jQuery('#cimage_mode').val('edit');
			jQuery('#cimage_name').val(jQuery('#cimage_name_'+id_).val());
			jQuery('#cimage_w').val(jQuery('#cimage_w_'+id_).val());
			jQuery('#cimage_h').val(jQuery('#cimage_h_'+id_).val());
		}else{
			jQuery('#cimage_mode').val('add');
			jQuery('#cimage_id').val('');
			jQuery('#cimage_name').val('');
			jQuery('#cimage_w').val('');
			jQuery('#cimage_h').val('');
		}
	}
</script>
<div class="jwp_mods" id="slider">
                <div class="padd">
                    <span class="modtitle left">Custom Image Size</span>
                    <div class="right"><input type="button" name="" class="button button-primary" value="Add" onclick="DoAdd_advance('add_cimage_s','cimage_list','open',0)" /></div>
                    <div class="clear"></div>
                </div>
                <div class="modcontent ">
                	<div id="cimage_list">
                    	<table width="100%" border="0" cellspacing="0">
                            <tr>
                                <th width="20%">Size Name</th>
                                <th width="20%">Width</th>
                                <th width="20%">Height</th>
                                <th width="30%">Call Function</th>
                                <th width="10%">&nbsp;</th>
                            </tr>
                     <?php
					 	$getwidgets = $wpdb->get_results("SELECT id, cimage_name, cimage_w, cimage_h FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'ci'");
						foreach($getwidgets as $widgets_data):
					 ?>       
                            <tr>
                            	<td><?php _e($widgets_data->cimage_name); ?></td>
                                <td><?php _e($widgets_data->cimage_w); ?></td>
                                <td><?php _e($widgets_data->cimage_h); ?></td>
                                <td> the_post_thumbnail( '<?php _e($widgets_data->cimage_name); ?>' ); </td>
                                <td align="right"><a href="javascript:void(0);" onclick="DoAdd_advance('add_cimage_s','cimage_list','open',<?php _e($widgets_data->id); ?>)" id="DoEdit">Edit</a> | <a href="javascript:void(0);" onclick="DeleteConfirm('Custom Image Size','admin.php?page=general&tab=a&action=delPost&id=<?php _e($widgets_data->id); ?>');">Delete</a>
                                <input type="hidden"  id="cimage_name_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->cimage_name); ?>" />
                                <input type="hidden" id="cimage_w_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->cimage_w); ?>" />
                                <input type="hidden" id="cimage_h_<?php _e($widgets_data->id); ?>" value="<?php _e($widgets_data->cimage_h); ?>" />
                                </td>
                            </tr>
                     <?php
					 	endforeach;
					 ?>
                        </table>
                    </div>
                	<div style="padding: 15px; display:none;" id="add_cimage_s">
                        <h3>Add New Image Size</h3>
                        <form method="post">
                            <p><input type="text" class="widefat" name="cimage_name" id="cimage_name" placeholder="Image Size Name" maxlength="255"  /></p>
                            <p><input type="text" class="widefat" name="cimage_w" id="cimage_w" placeholder="Custom Size Width" maxlength="5" /></p>
                            <p><input type="text" class="widefat" name="cimage_h" id="cimage_h" placeholder="Custom Size Height" maxlength="5" /></p>
                            <p><input type="submit" name="save_cimgsize" class="button button-primary" value="Save Image Size" /><input type="button" class="button button-primary" name="" value="Cancel" onclick="DoAdd_advance('add_cimage_s','cimage_list','close',0)" style="margin-left:5px;" />
                            </p>
                            <div class="clear"></div>
                            <input type="hidden" name="cimage_mode" id="cimage_mode" value="add" />
                            <input type="hidden" name="cimage_id" id="cimage_id" value="" />
                        </form>
                    </div>
                </div>
</div>
<?php 
endif;
?>