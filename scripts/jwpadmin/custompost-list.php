<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<div class="jwp_mods" id="slider">
                <div class="padd">
                    <span class="modtitle left">Custom Post</span>
                    <div class="right">
                    	<input type="button" name="" class="button button-primary" value="Add" onclick="javascript:window.location='admin.php?page=general&tab=cp&action=add'" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="modcontent ">
                	<div id="">
                    	<table width="100%" border="0" cellspacing="0">
                            <tr>
                                <th width="20%">Name</th>
                                <th width="70%">Taxonomy</th>
                                <th width="10%">&nbsp;</th>
                            </tr>
                            <?php
                                $custompost = $wpdb->get_results("SELECT id, c_post_name, tax_c_post_label FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'cp'");
                                foreach($custompost as $cplist):
                            ?>
                            <tr>
                                <td><?php _e($cplist->c_post_name); ?></td>
                                <td><?php _e($cplist->tax_c_post_label); ?></td>
                                <td align="right"><a href="admin.php?page=general&tab=cp&action=edit&id=<?php _e($cplist->id); ?>">Edit</a> | <a href="javascript:void(0);" onclick="DoConfirm('admin.php?page=general&tab=t&action=delPost&id=<?php echo $cplist->id; ?>')">Remove</a></td>
                            </tr>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                	
                </div>
                <script type="text/javascript">
                    function DoConfirm(url){
                        if(confirm('Are you sure you want to delete entry?')){
                            window.location = url;
                        }else{
                            return false;
                        }
                        
                    }
                </script>
</div>      

<?php 
endif;
?>      