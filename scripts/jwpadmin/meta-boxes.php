<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<div class="jwp_mods" id="slider">
                <div class="padd">
                    <span class="modtitle left">Custom Meta Boxes</span>
                    <div class="right"><input type="button" class="button button-primary" name="" value="Add" onclick="DoAdd_advance('add_cmenu_mbox','cmetaboxe_list','open',0)" /></div>
                    <div class="clear"></div>
                </div>
                <div class="modcontent ">
                  
                    	<div id="cmetaboxe_list">
                        	<table width="100%" border="0" cellspacing="0">
                                
                                <tr>
                                    <th width="20%">Group ID</th>
                                    <th width="70%">Post Type</th>
                                    <th width="30%">&nbsp;</th>
                                </tr>
                                <?php
                                    $getwidgets = $wpdb->get_results("SELECT id, c_post_name, mb_value FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'mb'");
                                    foreach($getwidgets as $meta_box_data):
                                        $data = json_decode($meta_box_data->mb_value);

                                 ?>
                                <tr>
                                	<td><?php echo $meta_box_data->c_post_name; ?></td>
                                	<td><?php echo $data->jwp_meta_box_custom_posts; ?></td>
                                	<td align="right"><a href="admin.php?page=general&tab=mb&action=edit&id=<?php _e($meta_box_data->id); ?>">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="DeleteConfirm('delete meta box?','admin.php?page=general&tab=t&action=delPost&id=<?php echo $meta_box_data->id; ?>');">Delete</a>
                                        <input type="hidden" id="jwp_meta_box_group_<?php echo $meta_box_data->id; ?>" value="<?php echo $meta_box_data->c_post_name; ?>">
                                        <input type="hidden" id="meta_json_<?php echo $meta_box_data->id; ?>" value='<?php echo $meta_box_data->mb_value; ?>'>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                       	 	</table>

                       	</div>

                      <div class="padd">
                       
                        <div id="add_cmenu_mbox" style="display:none;">
                            
                            <form method="post">
                                <div>
                                    <h3>Add New Custom Meta Box Group</h3>
                                    <p>Group ID<br/>
                                       <input type="text" class="widefat" name="jwp_meta_box_group" id="jwp_meta_box_group" value="" placeholder='sample: "group-id"'>
                                       <i>Be careful of editing the group ID, make sure no data is linked to this ID before making any changes</i>
                                  
                                    </p>
                                    <p>Post Type<br/>
                                        <?php 
                                        $get_post_types = get_post_types();
                                        ?>
                                        <select name="jwp_meta_box_custom_posts" id="jwp_meta_box_custom_posts" class="widefat" >
                                        <?php foreach($get_post_types as $index => $values): 
                                            if($values != 'attachment' && $values != 'revision' && $values != 'nav_menu_item'):
                                        ?>
                                            <option value="<?php echo $values; ?>"><?php echo ucfirst($values); ?></option>
                                        <?php
                                            endif; 
                                        endforeach; ?>
                                        </select>
                                    </p>

                                    <p>Group Label<br/>
                                        <input type="text" class="widefat" name="jwp_meta_box_group_label" id="jwp_meta_box_group_label" value="">
                                    </p>

                                    <p>Type<br/>
                                        <select id="meta_type" name="meta_type" class="widefat">
                                            <option value="Normal">Normal</option>
                                            <option value="Side">Side</option>
                                        </select>
                                    </p>


                                    <p>Priority<br/>
                                        <select id="meta_priority" name="meta_priority" class="widefat">
                                            <option value="High">High</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </p>

                                   
                                    <div class="clear"></div>
                                </div>
                                <br/>
                                <h3>Fields</h3>
                                <table class="widefat" id="new_c_meta_table">
                                    <tr>
                                        <th><b>Field Name</b></th>
                                        <th><b>Field Type</b></th>
                                        <th><b>Field Description</b></th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </table>

                                <div class="jwp_metabox_field" >

                                    <p>Field Name<br/>
                                        <input type="text" class="widefat" id="c_metabox_field_name" value="">
                                    </p>

                                    <p>Field Description<br/>
                                        <input type="text" class="widefat" id="c_metabox_field_desc" value="">
                                    </p>
                                    
                                    <p>Field Type<br/>
                                       <select id="meta_field_type" class="widefat">
                                           <option value="text">Text</option>
                                           <option value="select" target_div="jwp_box_options_select">Select</option>
                                           <option value="checkbox" target_div="jwp_box_options_checkbox">Checkbox</option>
                                           <option value="radio" target_div="jwp_box_options_radio">Radio</option>
                                           <option value="email">Email</option>
                                           <option value="textarea">TextArea</option>
                                           <option value="date">Date</option>
                                           <option value="number">Number</option>
                                           <option value="media_upload">Single Media</option>
                                           <option value="media_upload" disabled>Media Set</option>
                                       </select>
                                    </p>
                                    
                                    <p class="jwp_box_options_select options_select" style="display: none;">
                                        Select Dropdown Options<br/>
                                        <textarea id="jwp_meta_box_select_options" name="jwp_meta_box_select_options[]" class="widefat" rows="7"></textarea>
                                        <i style="font-size: 11px;">Options separated by new line</i>
                                    </p>
                                    <p class="jwp_box_options_checkbox options_select" style="display: none;">
                                        Checkbox Options<br/>
                                        <textarea id="jwp_meta_box_checkbox_options" name="jwp_meta_box_checkbox_options[]" class="widefat" rows="7"></textarea>
                                        <i style="font-size: 11px;">Options separated by new line</i>
                                    </p>
                                    <p class="jwp_box_options_radio options_select" style="display: none;">
                                        Radio Options<br/>
                                        <textarea id="jwp_box_options_radio" name="jwp_box_options_radio[]" class="widefat" rows="7"></textarea>
                                        <i style="font-size: 11px;">Options separated by new line</i>
                                    </p>

                                    
                                    <p><input type="button" name="" class="button button-primary" id="add_meta_box_field" value="Add Field"></p>

                                     
                                </div>


                                <p><input type="submit" class="button button-primary" name="jwp_save_group" value="Save Group"><input type="button" class="button button-primary" name="" value="Cancel" onclick="DoAdd_advance('add_cmenu_mbox','cmetaboxe_list','close',0)" style="margin-left:5px;"></p>
                                
                            </form>
                        </div>
                        
                    </div>
                </div>

               
</div>

<script type="text/javascript">
    var rowbncnt = 0;
    jQuery("#meta_field_type").change(function(){
        var gettarget = jQuery("#meta_field_type option:selected").attr('target_div');
        jQuery(".options_select").hide();
        jQuery("."+gettarget).show();
    });

    jQuery('#add_meta_box_field').click(function(){
  
        if(jQuery('#c_metabox_field_name').val().length > 0){
            var c_metabox_field_name = jQuery('#c_metabox_field_name').val();
            var c_metabox_field_desc = (jQuery('#c_metabox_field_desc').val().length > 0)? jQuery('#c_metabox_field_desc').val() : " ";
            var meta_field_type = jQuery('#meta_field_type').val();

            var field_options = "";
            if(meta_field_type == "select"){
                var field_options = jQuery('#jwp_meta_box_select_options').val();
            }else if(meta_field_type == "checkbox"){
                var field_options = jQuery('#jwp_meta_box_checkbox_options').val();
            }else if(meta_field_type == "radio"){
                var field_options = jQuery('#jwp_box_options_radio').val();;
            }
            var meta_type = jQuery('#meta_type').val();
            var meta_priority = jQuery('#meta_priority').val();

            rowbncnt++;

            var data = "<tr id=\"row_add_"+rowbncnt+"\">"+
            "<td>"+c_metabox_field_name+" <input type=\"hidden\" name=\"c_metabox_field_name[]\" value=\""+c_metabox_field_name+"\" /></td>"+
            "<td>"+meta_field_type+" <input type=\"hidden\" name=\"meta_field_type[]\" value=\""+meta_field_type+"\" /><input type=\"hidden\" name=\"meta_field_options[]\" value=\""+field_options+"\" /></td>"+
            "<td>"+c_metabox_field_desc+" <input type=\"hidden\" name=\"c_metabox_field_desc[]\" value=\""+c_metabox_field_desc+"\" /></td>"+
            "<td align=\"right\"><a href=\"javascript:void()\" onclick=\"DeleteMetaField("+rowbncnt+")\">Delete</a></td>"+
            "</tr>";

            jQuery('#new_c_meta_table').append(data);

            jQuery('#c_metabox_field_name').val('');
            jQuery('#c_metabox_field_desc').val('');
            jQuery('#meta_field_type').val('');
            jQuery('#jwp_meta_box_select_options').val('');
            jQuery('#jwp_meta_box_checkbox_options').val('');
            jQuery('#jwp_box_options_radio').val('');
        }else{
            alert("field name is required");
        }
    });

    function DeleteMetaField(id){
        jQuery('#row_add_'+id).remove();
    }


</script>

<?php endif; ?>