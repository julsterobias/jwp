<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>

<div class="cp">
<?php
	global $jwperror,$wpdb;
	if($jwperror):
?>
		<div class="jwp_error"><?php echo $jwperror; ?></div>
<?php
	endif;
?>

<script type="text/javascript">
	function NameAutoFill(val){
		document.getElementById('singular_name').value = val.toLowerCase();
		document.getElementById('add_new').value = 'Add New '+val;
		document.getElementById('add_new_item').value = 'Add New '+val;
		document.getElementById('edit_item').value = 'Edit '+val;
		document.getElementById('new_item').value = 'New '+val;
		document.getElementById('view_item').value = 'View '+val;
		document.getElementById('search_items').value = 'Search '+val;
		document.getElementById('not_found').value = 'Not Found '+val;
		document.getElementById('not_found_in_trash').value = 'Empty Trash for '+val;
	}
</script>
	<?php
		if(@$_GET['action'] == 'add' || @$_GET['action'] == 'edit'):		
			
			if(@$_GET['action'] == 'edit'):
				$_info = $wpdb->get_row('SELECT c_post_name, c_post_sname, c_post_lname, c_post_add_lname, c_post_edit_lname, c_post_newI_lname, c_post_viewI_lname, c_post_searchI_lname, c_post_404_lname, c_post_404t_lname, c_post_public, c_post_publicQ, c_post_showUI, c_post_archieve, c_post_Qvar, c_post_icon, c_post_rewrite, c_post_captype, c_post_hierarchical, c_post_menupos, c_post_s_title, c_post_s_editor, c_post_s_author, c_post_s_thumbnail, c_post_s_excerpt, c_post_s_trackbacks, c_post_s_customF, c_post_s_comments, c_post_s_revisions, c_post_s_page_attributes, c_post_s_post_formats FROM '.$wpdb->prefix.'jwp_settings WHERE id = '.$_GET['id'].'');
			endif;
			
	?>
<div style="padding:15px;"> 
        <h3>Edit Post Type</h3>   
    	<form method="post" >
    	<div class="left" style="padding-right:50px;">
            <p>
            <input type="text" name="name" placeholder="Name (Required)" size="50" onkeyup="NameAutoFill(this.value)" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_name : @$_POST['name']; ?>" /></p>
            <p><input type="text" name="singular_name" id="singular_name" placeholder="Singular Name" size="50" <?php echo (@$_POST['singular_name'])? @$_POST['singular_name'] : NULL; ?> maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_sname : @$_POST['singular_name']; ?>" /></p>
            <p><input type="text" name="add_new" id="add_new" placeholder="Add new label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_lname : @$_POST['add_new']; ?>" /></p>
            <p><input type="text" name="add_new_item" id="add_new_item" placeholder="Add new item label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_add_lname : @$_POST['add_new_item']; ?>" /></p>
            <p><input type="text" name="edit_item" id="edit_item" placeholder="Edit item label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_edit_lname : @$_POST['edit_item']; ?>" /></p>
            <p><input type="text" name="new_item" id="new_item" placeholder="New item label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_newI_lname : @$_POST['new_item']; ?>" /></p>
            <p><input type="text" name="view_item" id="view_item" placeholder="View item label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_viewI_lname : @$_POST['view_item']; ?>" /></p>
            <p><input type="text" name="search_items" id="search_items" placeholder="Search item label" size="50" maxlength="100"  value="<?php echo ($_GET['action']=='edit')? $_info->c_post_searchI_lname : @$_POST['search_items']; ?>"/></p>
            <p><input type="text" name="not_found" id="not_found" placeholder="Not found label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_404_lname : @$_POST['not_found']; ?>"/></p>
            <p><input type="text" name="not_found_in_trash" id="not_found_in_trash" placeholder="Not found in trash label" size="50" maxlength="100" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_404t_lname : @$_POST['not_found_in_trash']; ?>" /></p>
        </div>
        <div class="left">
        	<p><input type="checkbox" name="public" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_public == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Public</p>
            <p><input type="checkbox" name="publicly_queryable" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_publicQ == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Public Queryable</p>
            <p><input type="checkbox" name="show_ui" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_showUI == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Show UI</p>
            <p><input type="checkbox" name="has_archive" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_archieve == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Has Archive</p>
            <p><input type="checkbox" name="query_var" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_Qvar == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Query Var</p>
            <p><input type="text" name="menu_icon" id="menu_icon" placeholder="Select icon" size="50" maxlength="255" value="<?php echo ($_GET['action']=='edit')? $_info->c_post_icon : @$_POST['menu_icon']; ?>" /></p>
            <p><input type="checkbox" name="rewrite" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_rewrite == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Rewrite</p>
            <p>
            
            Capability Type:&nbsp;&nbsp;<input type="radio" name="capability_type" value="Post" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_captype == 'Post')? 'checked' : NULL;  else: echo 'checked';  endif; ?> /> Post&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capability_type" value="Page" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_captype == 'Page')? 'checked' : NULL; /*do nothing*/ endif; ?> /> Page</p>
            <p><input type="checkbox" name="hierarchical" value="Y" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_hierarchical == 'Y')? 'checked' : NULL;  else:   endif; ?> />&nbsp;&nbsp;Hierarchical</p>
            <p>
            	Menu Position &nbsp;&nbsp;<select name="menu_position">
                	<option value="100" <?php echo ($_info->c_post_menupos == '100')? 'selected' : NULL;  ?>>below second separator</option>
            		<option value="5" <?php echo ($_info->c_post_menupos == '5')? 'selected' : NULL;  ?>>below Posts</option>
					<option value="10" <?php echo ($_info->c_post_menupos == '10')? 'selected' : NULL;  ?>>below Media</option>
					<option value="15" <?php echo ($_info->c_post_menupos == '15')? 'selected' : NULL;  ?>>below Links</option>
                    <option value="20" <?php echo ($_info->c_post_menupos == '20')? 'selected' : NULL;  ?>>below Pages</option>
                    <option value="25" <?php echo ($_info->c_post_menupos == '25')? 'selected' : NULL;  ?>>below comments</option>
                    <option value="60" <?php echo ($_info->c_post_menupos == '60')? 'selected' : NULL;  ?>>below first separator</option>
                    <option value="65" <?php echo ($_info->c_post_menupos == '65')? 'selected' : NULL;  ?>>below Plugins</option>
                    <option value="70" <?php echo ($_info->c_post_menupos == '70')? 'selected' : NULL;  ?>>below Users</option>
                    <option value="75" <?php echo ($_info->c_post_menupos == '75')? 'selected' : NULL;  ?>>below Tools</option>
                    <option value="80" <?php echo ($_info->c_post_menupos == '80')? 'selected' : NULL;  ?>>below Settings</option>
                    
                </select>
            </p>
        </div>
        <div class="left" style="margin-left:50px;">
        	<p>
            	Supports:&nbsp;&nbsp;
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_title" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_title == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Title
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_editor" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_editor == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Editor (content)
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_author" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_author == 'Y')? 'checked' : NULL;  else:   endif; ?> />&nbsp;&nbsp;Author
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_thumbnail" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_thumbnail == 'Y')? 'checked' : NULL;  else: echo 'checked';  endif; ?> />&nbsp;&nbsp;Thumbnail
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_excerpt" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_excerpt == 'Y')? 'checked' : NULL;  else:   endif; ?> />&nbsp;&nbsp;Excerpt
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_trackbacks" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_trackbacks == 'Y')? 'checked' : NULL;  else:   endif; ?> />&nbsp;&nbsp;Trackbacks
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_customF" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_customF == 'Y')? 'checked' : NULL;  else:   endif; ?>/>&nbsp;&nbsp;Custom-Fields
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_comments" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_comments == 'Y')? 'checked' : NULL;  else:   endif; ?>/>&nbsp;&nbsp;Comments
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_revisions" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_revisions == 'Y')? 'checked' : NULL;  else:   endif; ?>/>&nbsp;&nbsp;Revisions
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_page_attributes" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_page_attributes == 'Y')? 'checked' : NULL;  else:   endif; ?> />&nbsp;&nbsp;Page-Attributes
            </p>
            <p>
            	<input type="checkbox" name="support[]" value="c_post_s_post_formats" <?php  if(@$_GET['action'] == 'edit'): echo($_info->c_post_s_post_formats == 'Y')? 'checked' : NULL;  else:   endif; ?>/>&nbsp;&nbsp;Post Formats
            </p>
       	    

            
			
        </div>
        <div class="clear"></div>
        <div>
        	
        	<input type="submit" class="button button-primary" name="savepost" value="<?php echo (@$_GET['action'] == 'add')? 'Save New Post Type' : 'Save Changes'; ?>" />
            <input type="button" class="button button-primary" value="Back" onClick="javascript:window.location='admin.php?page=general&tab=a'" style="margin-left:5px;" />
            <input type="hidden" name="posttype_" value="<?php echo (@$_GET['action'] == 'add')? 'add' : 'edit'; ?>" />
            <div class="clear"></div>
        </div>
        </form>
</div>
    <?php	
	

/********
*
*
List all custom products
*
*
********/	
	
	
		else:
	?>

    
    <div class="cplist">
    	<table width="100%" border="0" cellspacing="0">
        	<tr>
            	<th width="50%">Name</th>
                <th width="39%">Taxonomy</th>
                <th width="11%">&nbsp;</th>
            </tr>
            <?php
				$custompost = $wpdb->get_results("SELECT id, c_post_name, tax_c_post_label FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'cp'");
				foreach($custompost as $cplist):
			?>
            <tr>
            	<td><?php _e($cplist->c_post_name); ?></td>
                <td><?php _e($cplist->tax_c_post_label); ?></td>
                <td align="right"><a href="admin.php?page=general&tab=cp&action=edit&id=<?php _e($cplist->id); ?>">Edit</a> | <a href="#">Delete</a></td>
            </tr>
            <?php
				endforeach;
			?>
        </table>
        <div>
        	<br/>
        	<a href="admin.php?page=general&tab=cp&action=add" class="buy left">Add New</a>
        </div>
    </div>
    <?php
		endif;
	?>
</div>


<div class="icon_popup_screen">
    <div class="icon_selector">
        <h3>SELECT ICON <a href="javascript:void(0);" class="button button-primary close_icon_selector">x</a></h3>
        <div class="icon_list">
        <ul>
            <li><i class="dashicons-before dashicons-menu"></i></li>
            <li><i class="dashicons-before dashicons-admin-site"></i></li>
            <li><i class="dashicons-before dashicons-dashboard"></i></li>
            <li><i class="dashicons-before dashicons-admin-post"></i></li>
            <li><i class="dashicons-before dashicons-admin-media"></i></li>
            <li><i class="dashicons-before dashicons-admin-links"></i></li>
            <li><i class="dashicons-before dashicons-admin-page"></i></li>
            <li><i class="dashicons-before dashicons-admin-comments"></i></li>
            <li><i class="dashicons-before dashicons-admin-appearance"></i></li>
            <li><i class="dashicons-before dashicons-admin-plugins"></i></li>
            <li><i class="dashicons-before dashicons-admin-users"></i></li>
            <li><i class="dashicons-before dashicons-admin-tools"></i></li>
            <li><i class="dashicons-before dashicons-admin-settings"></i></li>
            <li><i class="dashicons-before dashicons-admin-network"></i></li>
            <li><i class="dashicons-before dashicons-admin-home"></i></li>
            <li><i class="dashicons-before dashicons-admin-generic"></i></li>
            <li><i class="dashicons-before dashicons-admin-collapse"></i></li>
            <li><i class="dashicons-before dashicons-welcome-write-blog"></i></li>
            <li><i class="dashicons-before dashicons-welcome-add-page"></i></li>
            <li><i class="dashicons-before dashicons-welcome-view-site"></i></li>
            <li><i class="dashicons-before dashicons-welcome-widgets-menus"></i></li>
            <li><i class="dashicons-before dashicons-welcome-comments"></i></li>
            <li><i class="dashicons-before dashicons-welcome-learn-more"></i></li>
            <li><i class="dashicons-before dashicons-format-aside"></i></li>
            <li><i class="dashicons-before dashicons-format-image"></i></li>
            <li><i class="dashicons-before dashicons-format-gallery"></i></li>
            <li><i class="dashicons-before dashicons-format-video"></i></li>
            <li><i class="dashicons-before dashicons-format-status"></i></li>
            <li><i class="dashicons-before dashicons-format-quote"></i></li>
            <li><i class="dashicons-before dashicons-format-chat"></i></li>
            <li><i class="dashicons-before dashicons-format-audio"></i></li>
            <li><i class="dashicons-before dashicons-camera"></i></li>
            <li><i class="dashicons-before dashicons-images-alt"></i></li>
            <li><i class="dashicons-before dashicons-images-alt2"></i></li>
            <li><i class="dashicons-before dashicons-video-alt"></i></li>
            <li><i class="dashicons-before dashicons-video-alt2"></i></li>
            <li><i class="dashicons-before dashicons-video-alt3"></i></li>
            <li><i class="dashicons-before dashicons-image-crop"></i></li>
            <li><i class="dashicons-before dashicons-image-rotate-left"></i></li>
            <li><i class="dashicons-before dashicons-image-rotate-right"></i></li>
            <li><i class="dashicons-before dashicons-image-flip-vertical"></i></li>
            <li><i class="dashicons-before dashicons-image-flip-horizontal"></i></li>
            <li><i class="dashicons-before dashicons-undo"></i></li>
            <li><i class="dashicons-before dashicons-redo"></i></li>
            <li><i class="dashicons-before dashicons-editor-bold"></i></li>
            <li><i class="dashicons-before dashicons-editor-italic"></i></li>
            <li><i class="dashicons-before dashicons-editor-ul"></i></li>
            <li><i class="dashicons-before dashicons-editor-ol"></i></li>
            <li><i class="dashicons-before dashicons-editor-quote"></i></li>
            <li><i class="dashicons-before dashicons-editor-alignleft"></i></li>
            <li><i class="dashicons-before dashicons-editor-aligncenter"></i></li>
            <li><i class="dashicons-before dashicons-editor-alignright"></i></li>
            <li><i class="dashicons-before dashicons-editor-insertmore"></i></li>
            <li><i class="dashicons-before dashicons-editor-spellcheck"></i></li>
            <li><i class="dashicons-before dashicons-editor-distractionfree"></i></li>
            <li><i class="dashicons-before dashicons-editor-kitchensink"></i></li>
            <li><i class="dashicons-before dashicons-editor-underline"></i></li>
            <li><i class="dashicons-before dashicons-editor-justify"></i></li>
            <li><i class="dashicons-before dashicons-editor-textcolor"></i></li>
            <li><i class="dashicons-before dashicons-editor-paste-word"></i></li>
            <li><i class="dashicons-before dashicons-editor-paste-text"></i></li>
            <li><i class="dashicons-before dashicons-editor-removeformatting"></i></li>
            <li><i class="dashicons-before dashicons-editor-video"></i></li>
            <li><i class="dashicons-before dashicons-editor-customchar"></i></li>
            <li><i class="dashicons-before dashicons-editor-outdent"></i></li>
            <li><i class="dashicons-before dashicons-editor-indent"></i></li>
            <li><i class="dashicons-before dashicons-editor-help"></i></li>
            <li><i class="dashicons-before dashicons-editor-strikethrough"></i></li>
            <li><i class="dashicons-before dashicons-editor-unlink"></i></li>
            <li><i class="dashicons-before dashicons-editor-rtl"></i></li>
            <li><i class="dashicons-before dashicons-align-left"></i></li>
            <li><i class="dashicons-before dashicons-align-right"></i></li>
            <li><i class="dashicons-before dashicons-align-center"></i></li>
            <li><i class="dashicons-before dashicons-align-none"></i></li>
            <li><i class="dashicons-before dashicons-lock"></i></li>
            <li><i class="dashicons-before dashicons-calendar"></i></li>
            <li><i class="dashicons-before dashicons-visibility"></i></li>
            <li><i class="dashicons-before dashicons-post-status"></i></li>
            <li><i class="dashicons-before dashicons-edit"></i></li>
            <li><i class="dashicons-before dashicons-trash"></i></li>
            <li><i class="dashicons-before dashicons-arrow-up"></i></li>
            <li><i class="dashicons-before dashicons-arrow-down"></i></li>
            <li><i class="dashicons-before dashicons-arrow-right"></i></li>
            <li><i class="dashicons-before dashicons-arrow-left"></i></li>
            <li><i class="dashicons-before dashicons-arrow-up-alt"></i></li>
            <li><i class="dashicons-before dashicons-arrow-down-alt"></i></li>
            <li><i class="dashicons-before dashicons-arrow-right-alt"></i></li>
            <li><i class="dashicons-before dashicons-arrow-left-alt"></i></li>
            <li><i class="dashicons-before dashicons-arrow-up-alt2"></i></li>
            <li><i class="dashicons-before dashicons-arrow-down-alt2"></i></li>
            <li><i class="dashicons-before dashicons-arrow-right-alt2"></i></li>
            <li><i class="dashicons-before dashicons-arrow-left-alt2"></i></li>
            <li><i class="dashicons-before dashicons-sort"></i></li>
            <li><i class="dashicons-before dashicons-leftright"></i></li>
            <li><i class="dashicons-before dashicons-list-view"></i></li>
            <li><i class="dashicons-before dashicons-exerpt-view"></i></li>
            <li><i class="dashicons-before dashicons-share"></i></li>
            <li><i class="dashicons-before dashicons-share-alt"></i></li>
            <li><i class="dashicons-before dashicons-share-alt2"></i></li>
            <li><i class="dashicons-before dashicons-twitter"></i></li>
            <li><i class="dashicons-before dashicons-rss"></i></li>
            <li><i class="dashicons-before dashicons-facebook"></i></li>
            <li><i class="dashicons-before dashicons-facebook-alt"></i></li>
            <li><i class="dashicons-before dashicons-googleplus"></i></li>
            <li><i class="dashicons-before dashicons-networking"></i></li>
            <li><i class="dashicons-before dashicons-hammer"></i></li>
            <li><i class="dashicons-before dashicons-art"></i></li>
            <li><i class="dashicons-before dashicons-migrate"></i></li>
            <li><i class="dashicons-before dashicons-performance"></i></li>
            <li><i class="dashicons-before dashicons-wordpress"></i></li>
            <li><i class="dashicons-before dashicons-wordpress-alt"></i></li>
            <li><i class="dashicons-before dashicons-pressthis"></i></li>
            <li><i class="dashicons-before dashicons-update"></i></li>
            <li><i class="dashicons-before dashicons-screenoptions"></i></li>
            <li><i class="dashicons-before dashicons-info"></i></li>
            <li><i class="dashicons-before dashicons-cart"></i></li>
            <li><i class="dashicons-before dashicons-feedback"></i></li>
            <li><i class="dashicons-before dashicons-cloud"></i></li>
            <li><i class="dashicons-before dashicons-translation"></i></li>
            <li><i class="dashicons-before dashicons-tag"></i></li>
            <li><i class="dashicons-before dashicons-category"></i></li>
            <li><i class="dashicons-before dashicons-yes"></i></li>
            <li><i class="dashicons-before dashicons-no"></i></li>
            <li><i class="dashicons-before dashicons-no-alt"></i></li>
            <li><i class="dashicons-before dashicons-plus"></i></li>
            <li><i class="dashicons-before dashicons-minus"></i></li>
            <li><i class="dashicons-before dashicons-dismiss"></i></li>
            <li><i class="dashicons-before dashicons-marker"></i></li>
            <li><i class="dashicons-before dashicons-star-filled"></i></li>
            <li><i class="dashicons-before dashicons-star-half"></i></li>
            <li><i class="dashicons-before dashicons-star-empty"></i></li>
            <li><i class="dashicons-before dashicons-flag"></i></li>
            <li><i class="dashicons-before dashicons-location"></i></li>
            <li><i class="dashicons-before dashicons-location-alt"></i></li>
            <li><i class="dashicons-before dashicons-vault"></i></li>
            <li><i class="dashicons-before dashicons-shield"></i></li>
            <li><i class="dashicons-before dashicons-shield-alt"></i></li>
            <li><i class="dashicons-before dashicons-search"></i></li>
            <li><i class="dashicons-before dashicons-slides"></i></li>
            <li><i class="dashicons-before dashicons-analytics"></i></li>
            <li><i class="dashicons-before dashicons-chart-pie"></i></li>
            <li><i class="dashicons-before dashicons-chart-bar"></i></li>
            <li><i class="dashicons-before dashicons-chart-line"></i></li>
            <li><i class="dashicons-before dashicons-chart-area"></i></li>
            <li><i class="dashicons-before dashicons-groups"></i></li>
            <li><i class="dashicons-before dashicons-businessman"></i></li>
            <li><i class="dashicons-before dashicons-id"></i></li>
            <li><i class="dashicons-before dashicons-id-alt"></i></li>
            <li><i class="dashicons-before dashicons-products"></i></li>
            <li><i class="dashicons-before dashicons-awards"></i></li>
            <li><i class="dashicons-before dashicons-forms"></i></li>
            <li><i class="dashicons-before dashicons-portfolio"></i></li>
            <li><i class="dashicons-before dashicons-book"></i></li>
            <li><i class="dashicons-before dashicons-book-alt"></i></li>
            <li><i class="dashicons-before dashicons-download"></i></li>
            <li><i class="dashicons-before dashicons-upload"></i></li>
            <li><i class="dashicons-before dashicons-backup"></i></li>
            <li><i class="dashicons-before dashicons-lightbulb"></i></li>
            <li><i class="dashicons-before dashicons-smiley"></i></li>
        </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.close_icon_selector').click(function(){
            jQuery('.icon_popup_screen').hide(); 
        });
        jQuery('#menu_icon').focus(function(){
            jQuery('.icon_popup_screen').show(); 
        });

        jQuery('.icon_selector ul li').click(function(){
            var getclass = jQuery(this).find('i').attr('class');
            getclass = getclass.split('dashicons-before');
            jQuery('#menu_icon').val(getclass[1]); 
            jQuery('.icon_popup_screen').hide();
        });

        
        
    });
</script>

<?php 
endif; ?>