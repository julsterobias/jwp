<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<script type="text/javascript">
    function EditSideTaxo(id_){
        if(id_ > 0){
            
            jQuery('#wd_target_id').val(id_);
            jQuery('#taxo_mode').val('edit');
            jQuery('#taxonomy_').val(id_);
            jQuery('#tax_c_post_name').val(jQuery('#tax_hid_name_'+id_).val());
            jQuery('#tax_c_post_label').val(jQuery('#tax_hid_label_'+id_).val());
            jQuery('#tax_c_post_s_label').val(jQuery('#tax_hid_slabel_'+id_).val());
            jQuery('#taxonomy_').hide();
        }else{
            jQuery('#taxo_mode').val('add');
            jQuery('#wd_target_id').val('');
            jQuery('#tax_c_post_name').val('');
            jQuery('#tax_c_post_label').val('');
            jQuery('#tax_c_post_s_label').val('');
        }
    }
    function NameAutoFill(obj){
        if(obj.options[obj.selectedIndex].value.length > 0){
            document.getElementById('tax_c_post_label').value = obj.options[obj.selectedIndex].innerHTML+' Categories';
            var cleans = obj.options[obj.selectedIndex].innerHTML.toLowerCase();
            var cleans_ = cleans.replace(/ /gi,"-");
            document.getElementById('tax_c_post_s_label').value = cleans_+'-categories';
            cleans_name = cleans.replace(/ /gi,"");
            document.getElementById('tax_c_post_name').value = cleans_name+'categories';
            
        }else{
            document.getElementById('tax_c_post_label').value = '';
            document.getElementById('tax_c_post_s_label').value = '';
        }
    }
</script>
<div class="jwp_mods" id="slider">
                <div class="padd">
                    <span class="modtitle left">Custom Taxonomy</span>
                    <div class="right"><input type="button" class="button button-primary" name="" value="Add" onclick="DoAdd_advance('add_taxo','taxo_list','open',0)" /></div>
                    <div class="clear"></div>
                </div>
                <div class="modcontent ">
                    <div id="taxo_list">
                        <table width="100%" border="0" cellspacing="0">
                        <tr>
                            <th width="20%">Name</th>
                            <th width="70%">Parent Custom Post</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                        <?php
                            $customtax = $wpdb->get_results("SELECT id, c_post_name, tax_c_post_label, tax_c_post_s_label, tax_c_post_name FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'cp' AND tax_c_post_label is not NULL");
                            foreach($customtax as $taxlist):
                        ?>
                        <tr>
                            <td><?php echo $taxlist->tax_c_post_name; ?></td>
                            <td><?php echo $taxlist->c_post_name; ?></td>
                            <td align="right"><a href="javascript:void(0);" onclick="DoAdd_advance('add_taxo','taxo_list','open',<?php _e($taxlist->id); ?>);">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="DeleteConfirm('Custom Taxonomy','admin.php?page=general&tab=t&action=deltax&id=<?php echo $taxlist->id; ?>');">Delete</a>
                            <input type="hidden" id="tax_hid_label_<?php echo $taxlist->id; ?>" value="<?php _e($taxlist->tax_c_post_label); ?>" />
                            <input type="hidden" id="tax_hid_name_<?php echo $taxlist->id; ?>" value="<?php _e($taxlist->tax_c_post_name); ?>" />
                            <input type="hidden" id="tax_hid_slabel_<?php echo $taxlist->id; ?>" value="<?php _e($taxlist->tax_c_post_s_label); ?>" />
                            
                            
                            </td>
                        </tr>
                        <?php
                            endforeach;
                        ?>
                    </table>
                    </div>
                    <div style="padding: 15px; display:none;" id="add_taxo">
                        <h3>Manage Taxonomy</h3>
                         <form method="post">
                            <p><select name="taxonomy_" id="taxonomy_" onchange="NameAutoFill(this)" >
                                    <option value="">Parent Custom Post Type:</option> 
                                    <?php 
                                        $custom_p = $wpdb->get_results("SELECT id, c_post_name FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'cp'"); 
                                        foreach($custom_p as $cp_list):
                                    ?>
                                            <option value="<?php echo $cp_list->id; ?>"><?php echo $cp_list->c_post_name; ?></option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select></p>
                            <p><input type="text" class="widefat" name="tax_c_post_name" id="tax_c_post_name" value="<?php echo @$jwp_edit->tax_c_post_name; ?>" placeholder="Taxonomy Name (required)" size="50" /></p>
                            <p><input type="text" class="widefat" name="tax_c_post_label" id="tax_c_post_label" value="<?php echo @$jwp_edit->tax_c_post_label; ?>" placeholder="Label Name" size="50" /></p>
                            <p><input type="text" class="widefat" name="tax_c_post_s_label" id="tax_c_post_s_label" value="<?php echo @$jwp_edit->tax_c_post_s_label; ?>" id="tax_c_post_s_label" placeholder="Label Name Singular" size="50" /></p>
                            <p>
                              <input type="submit" name="savetax" id="savetax" class="button button-primary" value="Save Custom Taxonomy" /><input type="button" class="button button-primary" name="" value="Cancel" onclick="DoAdd_advance('add_taxo','taxo_list','close',0)" style="margin-left:5px;" />
                                      
                              <input type="hidden" name="taxo_mode" id="taxo_mode" value="add" />
                              <input type="hidden" name="wd_target_id" id="wd_target_id" value="" />    
                                       
                               <div class="clear"></div>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

<?php 
endif;
?>