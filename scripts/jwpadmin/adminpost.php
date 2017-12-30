<?php
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}

if(is_admin()):

$jwperror = NULL;
global $wpdb;
if(isset($_POST['savepost'])):
	if(strlen(trim(@$_POST['name'])) > 0):
		
		$vals = array(
				'jwp_action' => 'cp', 
				'c_post_name' => (@$_POST['name'])? @$_POST['name'] : 'X', 
				'c_post_sname' => (@$_POST['singular_name'])? @$_POST['singular_name'] : 'X',
				'c_post_lname' => (@$_POST['add_new'])? @$_POST['add_new'] : 'X',
				'c_post_add_lname' => (@$_POST['add_new_item'])? @$_POST['add_new_item'] : 'X',
				'c_post_edit_lname' => (@$_POST['edit_item'])? @$_POST['edit_item'] : 'X',
				'c_post_newI_lname' => (@$_POST['new_item'])? @$_POST['new_item'] : 'X',
				'c_post_viewI_lname' => (@$_POST['view_item'])? @$_POST['view_item'] : 'X',
				'c_post_searchI_lname' => (@$_POST['search_items'])? @$_POST['search_items'] : 'X',
				'c_post_404_lname' => (@$_POST['not_found'])? @$_POST['not_found'] : 'X',
				'c_post_404t_lname' => (@$_POST['not_found_in_trash'])? @$_POST['not_found_in_trash'] : 'X',
				'c_post_public' => (@$_POST['public'])? @$_POST['public'] : 'X',
				'c_post_publicQ' => (@$_POST['publicly_queryable'])? @$_POST['publicly_queryable'] : 'X',
				'c_post_showUI' => (@$_POST['show_ui'])? @$_POST['show_ui'] : 'X',
				'c_post_archieve' => (@$_POST['has_archive'])? @$_POST['has_archive'] : 'X',
				'c_post_Qvar' => (@$_POST['query_var'])? @$_POST['query_var'] : 'X',
				'c_post_icon' => (@$_POST['menu_icon'])? @$_POST['menu_icon'] : 'X',
				'c_post_rewrite' => (@$_POST['rewrite'])? @$_POST['rewrite'] : 'X',
				'c_post_captype' => $_POST['capability_type'],
				'c_post_hierarchical' => (@$_POST['hierarchical'])? @$_POST['hierarchical'] : 'X',
				'c_post_menupos' => (@$_POST['menu_position'])? @$_POST['menu_position'] : 'X', 
			);
		$support = @$_POST['support'];
		$supp = array();
		foreach($support as $index => $valss):
			$supp[$valss] = 'Y';	
		endforeach;
		$allvals = array_merge($vals,$supp);
		$datatype_count = count($support)+count($vals);
		$dataarr = array();
		for($cnt=0;$cnt<=$datatype_count;$cnt++):
			$dataarr[] = '%s'; 	
		endfor;

		if(@$_POST['posttype_'] == 'add'):
			$exist = $wpdb->get_var("SELECT COUNT(c_post_name) as cnt FROM ".$wpdb->prefix."jwp_settings WHERE LOWER(c_post_name) = '".strtolower($_POST['name'])."'");
			if($exist == 0):
				$res = $wpdb->insert($wpdb->prefix.'jwp_settings', $allvals, $dataarr);
			else:
				$jwperror = $_POST['name'].' is already exist. to avoid conflict please use other name.';
			endif;
		else:
			$allvals_clean = array('c_post_s_title'=> NULL,'c_post_s_editor'=> NULL,'c_post_s_author'=> NULL,'c_post_s_thumbnail'=> NULL,'c_post_s_excerpt'=> NULL,'c_post_s_trackbacks'=> NULL,'c_post_s_customF'=> NULL,'c_post_s_comments'=> NULL,'c_post_s_revisions'=> NULL,'c_post_s_page_attributes'=>NULL,'c_post_s_post_formats'=>NULL);

			$wpdb->update($wpdb->prefix.'jwp_settings', $allvals_clean, array('id' => @$_GET['id']),NULL,NULL);

			$res = $wpdb->update($wpdb->prefix.'jwp_settings', $allvals, array('id' => @$_GET['id']),NULL,NULL);
		endif;

		if($res):
			header('location:admin.php?page=general&tab=a&gmsg=1');
		endif;
		
	else:
		$jwperror = 'Custom post should have name';
	endif;
endif;

if(isset($_POST['savetax'])):
	if($_POST['taxo_mode'] == 'add'):
		if(isset($_POST['taxonomy_'])):
			
			if(isset($_POST['tax_c_post_name'])):
				$exist = $wpdb->get_var("SELECT COUNT(tax_c_post_name) as cnt FROM ".$wpdb->prefix."jwp_settings WHERE LOWER(tax_c_post_name) = '".strtolower($_POST['tax_c_post_name'])."'");
				if($exist == 0):
					$res = $wpdb->update($wpdb->prefix.'jwp_settings', 
					array(
						'tax_c_post_name' => @$_POST['tax_c_post_name'], 
						'tax_c_post_label' => @$_POST['tax_c_post_label'], 
						'tax_c_post_s_label' => @$_POST['tax_c_post_s_label']
					)
					, array('id' => @$_POST['taxonomy_']),array('%s','%s','%s'),array('%d'));
					if($res):
						header('location:admin.php?page=general&tab=a&gmsg=1');
					endif;
				else:
					$jwperror = 'Taxonomy name is already in use, to avoid conflict please use other unique taxonomy name';
				endif;
			else:
				$jwperror = 'Taxonomy name is required';
			endif;
		else:
			$jwperror = 'Please select parent custom post';
		endif;
	else:
		$res = $wpdb->query("UPDATE ".$wpdb->prefix."jwp_settings SET
			tax_c_post_name = '".@$_POST['tax_c_post_name']."',
			tax_c_post_label = '".@$_POST['tax_c_post_label']."',
			tax_c_post_s_label = '".@$_POST['tax_c_post_s_label']."'
		WHERE id = ".$_POST['wd_target_id']);
		if($res)
			header('location:admin.php?page=general&tab=a&gmsg=1');
	endif;	
endif;

if(@$_GET['action'] == 'deltax'):

		$res = $wpdb->query("UPDATE ".$wpdb->prefix."jwp_settings SET
			tax_c_post_name = NULL,
			tax_c_post_label = NULL,
			tax_c_post_s_label = NULL
		WHERE id = ".$_GET['id']);

	if($res)
		header('location:admin.php?page=general&tab=a&gmsg=1');
endif;


if(isset($_POST['slider'])):
	$targetpost = $_POST['slidepost'];
	$autoplay = (@$_POST['autoplay'])? $_POST['autoplay'] : 'N';
	$speed = (@$_POST['speed'])? $_POST['speed'] : '2000';
	$res = $wpdb->update($wpdb->prefix.'jwp_settings',array('slide_target'=>$targetpost,'slide_autoplay'=>$autoplay,'slide_speed'=>$speed),array('id' => $_POST['hiddenslid']),array('%s','%s','%s','%d'),array('%d'));
		header('location:admin.php?page=general&tab=m&res=1');
endif;

if(isset($_POST['sloff'])):
	$action = 'sl';
	$res = $wpdb->insert($wpdb->prefix.'jwp_settings',array('jwp_action'=>$action),array('%s'));
			header('location:admin.php?page=general&tab=m&res=1');
endif;

if(isset($_POST['slon'])):
	$res = $wpdb->Query("DELETE FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'sl'");
	if($res):
		header('location:admin.php?page=general&tab=m&res=1');
	endif;
endif;


if(isset($_POST['create_widget_sub'])):
	if($_POST['sidewidget_mode'] == 'add'):
		if(strlen(@$_POST['widget_name']) > 0 && strlen(@$_POST['widget_id']) > 0 && strlen(@$_POST['widget_desc']) > 0):
			$res = $wpdb->insert($wpdb->prefix.'jwp_settings',array('jwp_action'=>'wd','widget_sidebar_title'=>$_POST['widget_name'],'widget_sidebar_id'=>$_POST['widget_id'],'widget_sidebar_desc'=>$_POST['widget_desc']));
			if($res):
				header('location:admin.php?page=general&tab=a&gmsg=1');
			endif;
		endif;
		$error = "Error on saving data. please check required fields";
	else:
		if(strlen(@$_POST['widget_name']) > 0 && strlen(@$_POST['wd_target_id']) > 0 && strlen(@$_POST['widget_desc']) > 0):
			$res = $wpdb->update($wpdb->prefix.'jwp_settings',
				array(
					'jwp_action'=>'wd',
					'widget_sidebar_title'=>$_POST['widget_name'],
					'widget_sidebar_desc'=>$_POST['widget_desc']),
					array('id'=>$_POST['wd_target_id']),
					array('%s','%s','%s'),
					array('%d')
				);
			if($res):
				header('location:admin.php?page=general&tab=a&gmsg=1');
			endif;
		endif;
		$jwperror = "Error on saving data. please check required fields";
	endif;
endif;

if(isset($_POST['save_cmenu'])):
	if($_POST['cmenu_mode'] == 'add'):
		if(strlen(@$_POST['cmenu_location']) > 0 && strlen(@$_POST['cmenu_name']) > 0 &&  @$_POST['cmenu_location'] != 'primary' && @$_POST['cmenu_location'] != 'secondary'):
			$res = $wpdb->insert($wpdb->prefix.'jwp_settings',array('jwp_action'=>'cm','cmenu_location'=>$_POST['cmenu_location'],'cmenu_name'=>$_POST['cmenu_name']));
			if($res):
				header('location:admin.php?page=general&tab=a&gmsg=1');
			endif;
		endif;
		$jwperror = "Error on saving data. please check required fields";
	else:
		if(strlen(@$_POST['cmenu_location']) > 0 && strlen(@$_POST['cmenu_name']) > 0 &&  @$_POST['cmenu_location'] != 'primary' && @$_POST['cmenu_location'] != 'secondary'):
			$res = $wpdb->update($wpdb->prefix.'jwp_settings',array('jwp_action'=>'cm','cmenu_location'=>$_POST['cmenu_location'],'cmenu_name'=>$_POST['cmenu_name']),array('id'=>$_POST['cmenu_id']),array('%s','%s'),array('%d'));
			if($res):
				header('location:admin.php?page=general&tab=a&gmsg=1');
			endif;
		endif;
		$jwperror = "Error on saving data. please check required fields";
	endif;
endif;

if(isset($_POST['save_cimgsize'])):
	if($_POST['cimage_mode'] == 'add'):
		if(strlen(@$_POST['cimage_name']) > 0 && strlen(@$_POST['cimage_w']) > 0 && strlen(@$_POST['cimage_h']) > 0):
			$res = $wpdb->insert($wpdb->prefix.'jwp_settings',array('jwp_action'=>'ci','cimage_name'=>$_POST['cimage_name'],'cimage_w'=>$_POST['cimage_w'],'cimage_h'=>$_POST['cimage_h']));
			if($res):
				header('location:admin.php?page=general&tab=a&gmsg=1');
			endif;
		endif;
		$jwperror = "Error on saving data. please check required fields";
	else:
		if(strlen(@$_POST['cimage_name']) > 0 && strlen(@$_POST['cimage_w']) > 0 && strlen(@$_POST['cimage_h']) > 0):
			$res = $wpdb->update($wpdb->prefix.'jwp_settings',array('jwp_action'=>'ci','cimage_name'=>$_POST['cimage_name'],'cimage_w'=>$_POST['cimage_w'],'cimage_h'=>$_POST['cimage_h']),array('id'=>$_POST['cimage_id']),array('%s','%s','%d','%d'),array('%d'));
			if($res):
				header('location:admin.php?page=general&tab=a&gmsg=1');
			endif;
		endif;
		$jwperror = "Error on saving data. please check required fields";
	endif;
endif;

if(isset($_POST['lightview'])):
	$res = $wpdb->insert($wpdb->prefix.'jwp_settings',array('jwp_action'=>'lb'));
	if($res)
		header('location:admin.php?page=general&tab=m&res=1');
endif;
if(isset($_POST['dislightview'])):
	$res = $wpdb->Query("DELETE FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'lb' ");
	if($res)
		header('location:admin.php?page=general&tab=m&res=1');
endif;

if(isset($_POST['jwpnewsletter'])):
	$res = $wpdb->insert($wpdb->prefix.'jwp_settings',array('jwp_action'=>'nl','newsletter_name'=>'X','newsletter_email'=>'X'));
	if($res)
		header('location:admin.php?page=general&tab=m&res=1');
endif;

if(isset($_POST['Disabledjwpnewsletter'])):
	$res = $wpdb->Query("DELETE FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'nl' ");
	if($res)
		header('location:admin.php?page=general&tab=m&res=1');
endif;


if(isset($_GET['action']) && @$_GET['action'] == 'delPost'):
	if(is_numeric($_GET['id'])):
		$res = $wpdb->Query("DELETE FROM ".$wpdb->prefix."jwp_settings WHERE id = ".$_GET['id']." ");
		if($res)
			header('location:admin.php?page=general&tab=m&res=1&gmsg=1');
	endif;
endif;

if(isset($_POST['jwp_save_group'])):
	if(isset($_POST['jwp_meta_box_group'])):

		$data = json_encode($_POST);
		$res = $wpdb->insert($wpdb->prefix.'jwp_settings',
			array(
				'jwp_action'=>'mb',
				'c_post_name'=>$_POST['jwp_meta_box_group'],
				'mb_value'=>$data
			)
		);

		if($res):
			header('location:admin.php?page=general&tab=a&gmsg=1');
		endif;
	else:
		$jwperror = "Custom metabox has no name.";
	endif;
	
endif;

if(isset($_POST['jwp_save_update_group'])):
	if(isset($_POST['jwp_meta_box_group'])):

		$data = json_encode($_POST);

		$res = $wpdb->update($wpdb->prefix.'jwp_settings',
				array(
					'jwp_action'=>'mb',
					'c_post_name'=>$_POST['jwp_meta_box_group'],
					'mb_value'=>$data),
				array('id'=>$_POST['toedit_mb']),
				array('%s','%s','%s'),
				array('%d'));
		if($res):
			header('location:admin.php?page=general&tab=a&gmsg=1');
		endif;
	else:
		$jwperror = "Custom metabox has no name.";
	endif;
endif;

endif;

?>