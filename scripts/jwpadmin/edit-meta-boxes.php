<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<div class="cp">
	<div style="padding:15px;"> 
		
		<?php 
			global $wpdb;
			$id = $_GET['id'];
			if(is_numeric($id)):
			$getwidgets = $wpdb->get_row("SELECT c_post_name, mb_value FROM ".$wpdb->prefix."jwp_settings WHERE id=".$id);
			$get_vals = json_decode($getwidgets->mb_value);
		?>

		<div class="padd">
                       
                        <div id="add_cmenu_mbox">
                            
                            <form method="post">
                            	<input type="hidden" name="toedit_mb" value="<?php echo $id; ?>">
                                <div>
                                  	<h3>Edit Meta Box</h3>
                                    <p>Group ID<br/>
                                       <input type="text" class="widefat" name="jwp_meta_box_group" id="jwp_meta_box_group" value="<?php echo $getwidgets->c_post_name; ?>" placeholder='sample: "group-id"'>
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
                                            <option value="<?php echo $values; ?>" <?php echo ($get_vals->jwp_meta_box_custom_posts == $values)? "selected" : NULL; ?>><?php echo ucfirst($values); ?></option>
                                        <?php
                                            endif; 
                                        endforeach; ?>
                                        </select>
                                    </p>

                                    <p>Group Label<br/>
                                        <input type="text" class="widefat" name="jwp_meta_box_group_label" id="jwp_meta_box_group_label" value="<?php echo $get_vals->jwp_meta_box_group_label; ?>">
                                    </p>

                                    <p>Type<br/>
                                        <select id="meta_type" name="meta_type" class="widefat">
                                            <option value="Normal" <?php echo ($get_vals->meta_type == "Normal")? "selected" : NULL; ?>>Normal</option>
                                            <option value="Side" <?php echo ($get_vals->meta_type == "Side")? "selected" : NULL; ?>>Side</option>
                                        </select>
                                    </p>


                                    <p>Priority<br/>
                                        <select id="meta_priority" name="meta_priority" class="widefat">
                                            <option value="High" <?php echo ($get_vals->meta_priority == "High")? "selected" : NULL; ?>>High</option>
                                            <option value="Low" <?php echo ($get_vals->meta_priority == "Low")? "selected" : NULL; ?>>Low</option>
                                        </select>
                                    </p>

                                   
                                    <div class="clear"></div>
                                </div>
                                <br/>
                                <h3 id="new_c_meta_table_title">Fields</h3>



                                <div>
                                    <ul>
                                        <li>
                                            <table class="widefat">
                                                <tr>
                                                    <th width="25%"><b>Field Name</b></th>
                                                    <th width="25%"><b>Field Type</b></th>
                                                    <th width="25%"><b>Field Description</b></th>
                                                    <th width="25%">&nbsp;</th>
                                                </tr>
                                            </table>
                                        </li>
                                    </ul>
                                    <ul id="new_c_meta_table">
                                          <?php
                                            	$rowcnt = 0; 
                                            	if($get_vals->c_metabox_field_name):
        	                                	foreach($get_vals->c_metabox_field_name as $index => $value):
        	                                		$rowcnt++;
        	                                ?>
                                          <li id="meta_field_<?php echo $rowcnt; ?>">
                                              <table class="widefat">
            	                                <tr>
                                                	<td width="25%"><span id="tble_lable_fn_<?php echo $rowcnt; ?>"><?php echo $value; ?></span>
                                                	<input type="hidden" name="c_metabox_field_name[]" id="rowcnt_fn_<?php echo $rowcnt; ?>" value="<?php echo $value; ?>" />
                                                	</td>
                                                	<td width="25%"><span id="tble_lable_ft_<?php echo $rowcnt; ?>"><?php echo $get_vals->meta_field_type[$index]; ?></span>
                                                	<input type="hidden" name="meta_field_type[]" id="rowcnt_ft_<?php echo $rowcnt; ?>" value="<?php echo $get_vals->meta_field_type[$index]; ?>" />

                                                	<?php 
                                                		if($get_vals->meta_field_type[$index] == "select" || $get_vals->meta_field_type[$index] == "radio" || $get_vals->meta_field_type[$index] == "checkbox"):
                                                	?>
                                                		<textarea style="visibility: hidden; height: 0px;"  name="meta_field_options[]" id="rowcnt_op_<?php echo $rowcnt; ?>"><?php echo $get_vals->meta_field_options[$index]; ?></textarea>
                                                	<?php
                                                		else:
                                                	?>
                                                		<textarea style="visibility: hidden; height: 0px;"  name="meta_field_options[]" id="rowcnt_op_<?php echo $rowcnt; ?>"> </textarea>
                                                	<?php
                                                		endif;
                                                	?>
                                                		<div id="options_<?php echo $rowcnt; ?>">
                                                			<hr/>
                                                			<?php echo str_replace("\r\n", ", ", $get_vals->meta_field_options[$index]); ?>
                                                		</div>
                                                	</td>
                                                	<td width="25%"><span id="tble_lable_fd_<?php echo $rowcnt; ?>"><?php echo $get_vals->c_metabox_field_desc[$index]; ?></span>
                                                	<input type="hidden" name="c_metabox_field_desc[]" id="rowcnt_fd_<?php echo $rowcnt; ?>" value="<?php echo $get_vals->c_metabox_field_desc[$index]; ?>" /></td>
                                                	<td width="25%" align="right"><a href="#jwp_metabox_field_edit_field" onclick="AsignMetaBox(<?php echo $rowcnt; ?>)">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" onclick="DeleteMetaField(<?php echo $rowcnt; ?>)">Delete</a></td>
                                                </tr>
                                                </table>
                                            </li>
                                            <?php 
                                            	endforeach;
                                            	endif;
                                            ?>
                                           
                                        

                                  </ul>
                                </div>

                                <div class="jwp_metabox_field" ><a name="jwp_metabox_field_edit_field"></a>

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

                                    <div align="center">
                                    	<p id="add_action"><input type="button" name="" class="button button-primary" id="add_meta_box_field" value="Add Field"></p>
                                    	<p id="add_edit" style="display: none;"><input type="button" name="" class="button button-primary" id="edit_meta_box_field" value="Update Field">&nbsp;<input type="button" name="" class="button button-primary" id="cancel_meta_box_field" value="Cancel"></p>
                                	</div>

                                     
                                </div>


                                <p><input type="submit" class="button button-primary" name="jwp_save_update_group" value="Save Group">
                                	<a href="admin.php?page=general&tab=a" class="button button-primary">Cancel</a>
                                </p>
                                
                            </form>
                        </div>
                        
        	</div>


        <?php endif; ?>

	</div>
</div>
<script>
  jQuery( function() {
    jQuery( "#new_c_meta_table" ).sortable();
    jQuery( "#new_c_meta_table" ).disableSelection();
  } );
</script>
<script type="text/javascript">

	var toedit = <?php echo $rowcnt; ?>;
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

            toedit++;

            var data = "<li id=\"meta_field_"+toedit+"\"><table class=\"widefat\"><tr>"+
            "<td width=\"25%\">"+c_metabox_field_name+" <input type=\"hidden\" name=\"c_metabox_field_name[]\" value=\""+c_metabox_field_name+"\" /></td>"+
            "<td width=\"25%\">"+meta_field_type+" <input type=\"hidden\" name=\"meta_field_type[]\" value=\""+meta_field_type+"\" /><textarea style=\"visibility: hidden; height: 0px;\" name=\"meta_field_options[]\" >"+field_options+"</textarea></td>"+
            "<td width=\"25%\">"+c_metabox_field_desc+" <input type=\"hidden\" name=\"c_metabox_field_desc[]\" value=\""+c_metabox_field_desc+"\" /></td>"+
            "<td width=\"25%\" align=\"right\"><a href=\"javascript:void()\" onclick=\"DeleteMetaField("+toedit+")\">Delete</a></td>"+
            "</tr></table></li>";

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


    jQuery('#cancel_meta_box_field').click(function(){
        	jQuery('#meta_field_type').val("");
       		jQuery('#c_metabox_field_name').val("");
       		jQuery('#c_metabox_field_desc').val("");
       		jQuery(".options_select").find('textarea').val("");
       		jQuery(".options_select").hide();
       		jQuery('#add_action').show();
       		jQuery('#add_edit').hide();	
    });


    function AsignMetaBox(id){
       toedit = id;

       jQuery('#add_action').hide();
       jQuery('#add_edit').show();	

       var field_name = jQuery('#rowcnt_fn_'+id).val();
       var field_type = jQuery('#rowcnt_ft_'+id).val();
       var field_description = jQuery('#rowcnt_fd_'+id).val();
       
       switch (field_type){
       		case 'select':
       			jQuery('.jwp_box_options_select').show();
       			jQuery('.jwp_box_options_checkbox').hide();
       			jQuery('.jwp_box_options_radio').hide();
       			jQuery('#jwp_meta_box_select_options').val(jQuery('#rowcnt_op_'+id).val());
       		break;
       		case 'checkbox':
       			jQuery('.jwp_box_options_checkbox').show();
       			jQuery('.jwp_box_options_select').hide();
       			jQuery('.jwp_box_options_radio').hide();
       			jQuery('#jwp_meta_box_checkbox_options').val(jQuery('#rowcnt_op_'+id).val());
       		break;
       		case 'radio':
       			jQuery('.jwp_box_options_radio').show();
       			jQuery('.jwp_box_options_select').hide();
       			jQuery('.jwp_box_options_checkbox').hide();
       			jQuery('#jwp_box_options_radio').val(jQuery('#rowcnt_op_'+id).val());
       		break;
       		default: 
       			jQuery('.jwp_box_options_select').hide();
       			jQuery('.jwp_box_options_checkbox').hide();
       			jQuery('.jwp_box_options_radio').hide();
       		break;
       }
       jQuery('#meta_field_type').val(field_type);
       jQuery('#c_metabox_field_name').val(field_name);
       jQuery('#c_metabox_field_desc').val(field_description);

    }

    
   	jQuery('#edit_meta_box_field').click(function(){
   		jQuery('#rowcnt_fn_'+toedit).val(jQuery('#c_metabox_field_name').val());
   		jQuery('#rowcnt_fd_'+toedit).val(jQuery('#c_metabox_field_desc').val());

   		jQuery("#tble_lable_fn_"+toedit).html(jQuery('#c_metabox_field_name').val());
   		jQuery("#tble_lable_fd_"+toedit).html(jQuery('#c_metabox_field_desc').val());
   		jQuery("#tble_lable_ft_"+toedit).html(jQuery('#meta_field_type').val());

   		if (jQuery('#meta_field_type').val() == "select"){	
   			jQuery('#rowcnt_op_'+toedit).html(jQuery('#jwp_meta_box_select_options').val());
   			jQuery('#options_'+toedit).html("<hr/>"+jQuery('#jwp_meta_box_select_options').val().replace(/(?:\r\n|\r|\n)/g, ', '));
   		}else if(jQuery('#meta_field_type').val() == "radio"){
   			jQuery('#rowcnt_op_'+toedit).html(jQuery('#jwp_box_options_radio').val());
   			jQuery('#options_'+toedit).html("<hr/>"+jQuery('#jwp_box_options_radio').val().replace(/(?:\r\n|\r|\n)/g, ', '));
   		}else if(jQuery('#meta_field_type').val() == "checkbox"){
   			jQuery('#rowcnt_op_'+toedit).html(jQuery('#jwp_meta_box_checkbox_options').val());
   			jQuery('#options_'+toedit).html("<hr/>"+jQuery('#jwp_meta_box_checkbox_options').val().replace(/(?:\r\n|\r|\n)/g, ', '));
   		}else{
   			
   		}
   		jQuery('#rowcnt_ft_'+toedit).val(jQuery("#meta_field_type").val());
   		jQuery('#c_metabox_field_name').val("");
   		jQuery('#c_metabox_field_desc').val("");
   		
   		jQuery('#jwp_meta_box_select_options').val("");
   		jQuery('#jwp_box_options_radio').val("");
   		jQuery('#jwp_meta_box_checkbox_options').val("");

   		jQuery('html,body').animate({
		   scrollTop: jQuery("#new_c_meta_table_title").offset().top
		});

    });

    function DeleteMetaField(rowid){
    	if(confirm("Are you sure you want to delete entry?")){
    		jQuery('#meta_field_'+rowid).remove();
    	}
    	
    }


</script>
<?php 
endif;
?>