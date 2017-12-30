<?php
$galleryon = false;
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'custom_gallery');

function custom_gallery($attr) {
	global $galleryon;
	$galleryon = true;
	$post = get_post();

	static $instance = 0;
	$instance++;

	# hard-coding these values so that they can't be broken
	
	$attr['columns'] = 1;
	$attr['size'] = 'thumbnail';
	$attr['link'] = 'none';

	$attr['orderby'] = 'post__in';
	$attr['include'] = $attr['ids'];		

	#Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	
	if ( $output != '' )
		return $output;

	# We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'div',
		'icontag'    => 'div',
		'captiontag' => 'p',
		'columns'    => 1,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	$gallery_style = $gallery_div = '';

	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "<!-- see gallery_shortcode() in functions.php -->";
	
	$gallery_div = "<div id='".$post->ID."-jwp-gallery' class='jwp-gallery-wrap gallery gallery-columns-1 gallery-size-full'>";
	
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
	$output .= "<div id=\"divmenudish-".$post->ID."\" class=\"menuimgcon jwpgallery\" ><ul>";
	$cntmargin = 0;
	$nonmargin_gal = '';
	
	foreach ( $attachments as $id => $attachment ) {

		$link = wp_get_attachment_image_src($id, 'full', false);
		$img = wp_get_attachment_image($id,"thumbnail");

		if ( $captiontag && trim($attachment->post_excerpt) ):
			$title = wptexturize($attachment->post_excerpt);
		else:
			$title = NULL;
		endif;
		if($cntmargin == 2): 
			$nonmargin_gal = 'nonmargingal'; 
			$cntmargin = 0;
		else: 
			 $cntmargin++; 
			$nonmargin_gal = '';
		endif;
		
		$params = array( 'width' => 298, 'height' => 298 );
		$image = bfi_thumb( $link[0], $params );
		
		$output .= "<li class=\"$nonmargin_gal\">
                            	<a href=\"".$link[0]."\" title=\"".$title."\" class=\"fancybox\" rel=\"gallery\" ><span class=\"handlens\"></span><img src=\"$image\" /></a>
                  	</li>
			
			";
		$output .= "";
		
	}

	$output .= "</ul></div>
	<div class=\"clear\"></div>
	</div>
	";

	return $output;
}

?>