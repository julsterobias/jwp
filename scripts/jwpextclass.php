<?php
/*
jwptemplate functions
@package: Wordpress
@subpackage: jwptemplate
Developer: Juls Terobias
*/
include('jwpsetup.php');
include('jwpadmin/adminpost.php');
include('metabox/jmetabox.php');
class jwp_extClass{
	
	function __construct(){
		add_action( 'admin_menu', array( $this, 'jwp_Add_Menu' ) );
	}
	
	function jwp_Add_Menu() {
		add_menu_page(__('jwp settings','general_menu'), __('jwptemplate','general_menu'),'', 'jwp-settings', 'jwp_settings','dashicons-admin-generic');
		add_submenu_page('jwp-settings', __('General','general_menu'), __('General','jwp-settings'), 7, 'general', array( $this, 'jwp_CallFallBack' ));

		add_menu_page(__('participants panel','participant_menu'), __('Participants','participants_panel'),'', 'participants-panel', 'participants_panel','dashicons-groups');

		add_submenu_page('participants-panel', __('Entries','participant_menu'), __('Entries','participants-panel'), 7, 'participant-entries', array( $this, 'jwp_Participants' ));
	}
	
	function jwp_CallFallBack(){
		include('jwpadmin/general.php');
	}

	function jwp_Participants(){
		include('jwpadmin/participants.php');
	}

	function ExecCustomData(){
		global $wpdb;
		$get_cp = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'cp'");
		if(count($get_cp) > 0):
			foreach($get_cp as $cp):
				$labels = array(
					'name' => _x($cp->c_post_name, $cp->c_post_name),
					'singular_name' => _x($cp->c_post_sname, $cp->c_post_sname),
					'add_new' => _x('Add New', $cp->c_post_lname),
					'add_new_item' => __($cp->c_post_add_lname),
					'edit_item' => __($cp->c_post_edit_lname),
					'new_item' => __($cp->c_post_newI_lname),
					'view_item' => __($cp->c_post_viewI_lname),
					'search_items' => __($cp->c_post_searchI_lname),
					'not_found' =>  __($cp->c_post_404_lname),
					'not_found_in_trash' => __($cp->c_post_404t_lname),
					'parent_item_colon' => ''
				);
				$support_ = array();
				
				if(strlen($cp->c_post_s_title) > 0) 
					array_push($support_,'title');
					
				if(strlen($cp->c_post_s_editor) > 0) 
					array_push($support_,'editor');
				
				if(strlen($cp->c_post_s_author) > 0) 
					array_push($support_,'author');
				
				if(strlen($cp->c_post_s_thumbnail) > 0) 
					array_push($support_,'thumbnail');
				
				if(strlen($cp->c_post_s_excerpt) > 0) 
					array_push($support_,'expert');
				
				if(strlen($cp->c_post_s_trackbacks) > 0) 
					array_push($support_,'trackbacks');
				
				if(strlen($cp->c_post_s_customF) > 0) 
					array_push($support_,'custom-fields');
					
				if(strlen($cp->c_post_s_comments) > 0) 
					array_push($support_,'comments');
					
				if(strlen($cp->c_post_s_revisions) > 0) 
					array_push($support_,'revisions');
				
				if(strlen($cp->c_post_s_page_attributes) > 0) 
					array_push($support_,'page-attributes');
				
				if(strlen($cp->c_post_s_post_formats) > 0) 
					array_push($support_,'post-formats');
				
				$menupost = (int) $cp->c_post_menupos;
				
				$args = array(
					'labels' => $labels,
					'public' => ($cp->c_post_public == 'Y')? true : false,
					'publicly_queryable' => ($cp->c_post_publicQ == 'Y')? true : false,
					'show_ui' => ($cp->c_post_showUI == 'Y')? true : false,
					'has_archive' => ($cp->c_post_archieve == 'Y')? true : false,
					'query_var' => ($cp->c_post_Qvar == 'Y')? true : false,
					'menu_icon' => ($cp->c_post_icon != 'X')? trim($cp->c_post_icon) : NULL,
					'rewrite' => ($cp->c_post_rewrite == 'Y')? true : false, 
					'capability_type' => strtolower($cp->c_post_captype),
					'hierarchical' => ($cp->c_post_hierarchical)? true : false,
					'menu_position' => $menupost,
					'supports' => $support_,	
			  ); 
			
			  $cleaname = strtolower(str_replace(" ","-",$cp->c_post_name));
			  register_post_type( $cleaname , $args );
			 
			 if($cp->tax_c_post_name && $cp->tax_c_post_label && $cp->tax_c_post_s_label && strlen($cleaname) > 0):
				  register_taxonomy($cp->tax_c_post_name, array($cleaname), array("hierarchical" => true, "label" => $cp->tax_c_post_label, "singular_label" => $cp->tax_c_post_s_label, "rewrite" => true));
			 endif;	  
			
			endforeach;
		endif;
		
		$getsidewid = $wpdb->get_results("SELECT widget_sidebar_title, widget_sidebar_id, widget_sidebar_desc FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'wd'");
		if(count($getsidewid) > 0):
			foreach($getsidewid as $widata):
				register_sidebar( array(
				'name' => __( $widata->widget_sidebar_title, 'jwp' ),
				'id' => $widata->widget_sidebar_id,
				'description' => __( $widata->widget_sidebar_desc, 'jwp' )
				) );
			endforeach;
		endif;
		
		$getsidewid = $wpdb->get_results("SELECT cmenu_location, cmenu_name FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'cm'");
		if(count($getsidewid) > 0):
			foreach($getsidewid as $cmenu_):
				register_nav_menus( array($cmenu_->cmenu_location => __( $cmenu_->cmenu_name, 'jwp' )) );	
			endforeach;
		endif;

		$getcimage = $wpdb->get_results("SELECT cimage_name, cimage_w, cimage_h FROM ".$wpdb->prefix."jwp_settings WHERE `jwp_action` = 'ci'");
		if(count($getcimage) > 0):
			foreach($getcimage as $cimg):
				add_image_size( $cimg->cimage_name, $cimg->cimage_w, $cimg->cimage_h, true );	
			endforeach;
		endif;
		
	}

	function jwp_BreadCrumbs() {
 
	  		  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
			  $delimiter = '/'; // delimiter between crumbs
			  $home = 'Home'; // text for the 'Home' link
			  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
			  $before = '<span class="current">'; // tag before the current crumb
			  $after = '</span>'; // tag after the current crumb
			  
			  global $post;
			  $homeLink = get_bloginfo('url');
			  
			  if (is_home() || is_front_page()) {
			  
				if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
			  
			  } else {
			  
				echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
			  
				if ( is_category() ) {
				  $thisCat = get_category(get_query_var('cat'), false);
				  if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
				  echo $before .  single_cat_title('', false) . $after;
			  
				} elseif ( is_search() ) {
				  echo $before . 'Search results for "' . get_search_query() . '"' . $after;
			  
				} elseif ( is_day() ) {
				  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
				  echo $before . get_the_time('d') . $after;
			  
				} elseif ( is_month() ) {
				  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				  echo $before . get_the_time('F') . $after;
			  
				} elseif ( is_year() ) {
				  echo $before . get_the_time('Y') . $after;
			  
				} elseif ( is_single() && !is_attachment() ) {
				  if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
					if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				  } else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				  }
			  
				} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				  $post_type = get_post_type_object(get_post_type());
				  echo $before . $post_type->labels->singular_name . $after;
			  
				} elseif ( is_attachment() ) {
				  $parent = get_post($post->post_parent);
				  $cat = get_the_category($parent->ID);
				  echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
				  if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			  
				} elseif ( is_page() && !$post->post_parent ) {
				  if ($showCurrent == 1) echo $before . get_the_title() . $after;
			  
				} elseif ( is_page() && $post->post_parent ) {
				  $parent_id  = $post->post_parent;
				  $breadcrumbs = array();
				  while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
				  }
				  $breadcrumbs = array_reverse($breadcrumbs);
				  for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
				  }
				  if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			  
				} elseif ( is_tag() ) {
				  echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
			  
				} elseif ( is_author() ) {
				   global $author;
				  $userdata = get_userdata($author);
				  echo $before . 'Articles posted by ' . $userdata->display_name . $after;
			  
				} elseif ( is_404() ) {
				  echo $before . 'Error 404' . $after;
				}
			  
				if ( get_query_var('paged') ) {
				  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				  echo __('Page') . ' ' . get_query_var('paged');
				  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
				}
			  
				echo '</div>';
			   
	  }
	}


	function IncludeUIToAdmin(){
   		wp_enqueue_script( 'jquery-ui-sortable' );
	}


	function jwpGetContent($args_param = NULL){
		$data = array();

		if($args_param):
			$num_post = (isset($args_param['posts_per_page']))? $args_param['posts_per_page'] : -1;
			$post_type = (isset($args_param['post_type']))? $args_param['post_type'] : "post";
			$order = (isset($args_param['order']))? $args_param['order'] : "ASC";
			$orderby = (isset($args_param['orderby']))? $args_param['orderby'] : "menu_order";
			$post_status = (isset($args_param['post_status']))? $args_param['post_status'] : "publish";

			$args = array(
				'posts_per_page' => $num_post,
				'post_type' => $post_type,
				'order' => $order,
				'orderby' => $orderby,
				'post_status' => $post_status
			);

			if(isset($args_param['taxonomy'])):
				$args['tax_query'] = array(
					array(
						'taxonomy' => $args_param['taxonomy']['taxonomy_name'],
						'field' => 'slug',
						'terms' => $args_param['taxonomy']['terms']
					)
				);
			endif;

			if(isset($args_param['metabox'])):
				$args['meta_query'] = array(
					array(
						'key' => $args_param['metabox']['key'],
						'value' => $args_param['metabox']['value'],
						'compare' => $args_param['metabox']['compare']
					)
				);
			endif;

			if(isset($args_param['page_id'])):
				$args['page_id'] = $args_param['page_id'];
			endif;

			if(isset($args_param['post__not_in'])):
				$args['post__not_in'] = $args_param['post__not_in'];
			endif;

			$settings = new WP_query($args);
			if($settings->have_posts()):
				while($settings->have_posts()): $settings->the_post();
					$id = get_the_ID();
					$slug = str_replace('-','_',get_post_field( 'post_name', $id));
					$image_crop = (isset($args_param['image_size_name']))? $args_param['image_size_name'] : "full"; 
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($id),$image_crop);
					$metaboxes = get_post_meta($id);
					$metas = array();
					foreach ($metaboxes as $key => $value) {
						$key = str_replace("-", "_", $key);
						$metas[$key] = (is_array($value))? $value[0] : $value;
					}
					$data[$slug] = array(
						'id' => $id,
						'title' => get_the_title(),
						'content' => get_the_content(),
						'featured_image' => $image[0],
						'url' => get_the_permalink(),
						'metabox' => $metas
					);
				endwhile;
			endif;
			wp_reset_query();
			$json_parse = json_encode($data);
			return json_decode($json_parse);
		else:
			return NULL;
		endif;
	}	

}
session_start();
$jwp = new jwp_extClass();
global $jwp, $wpdb;
$jwp->ExecCustomData();
if(is_admin()){
	$jwp->IncludeUIToAdmin();
}
?>