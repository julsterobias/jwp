<?php
/*
jwptemplate functions
@package: Wordpress
@subpackage: jwptemplate
Developer: Juls Terobias
*/

add_action( 'after_setup_theme', 'jwp_setup' );

if ( ! function_exists( 'jwp_setup' ) ):
	function  jwp_setup() {	
		add_editor_style();
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		load_theme_textdomain( 'jwp' );
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'jwp' ),
			'secondary' => __( 'Footer Navigation', 'jwp' ),
		) );	
		global $wpdb;
		require_once('sql.php');
		foreach($sql_create as $sqlstr):
			$wpdb->query($sqlstr);
		endforeach;
	}
	
endif;


function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function jwp_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'jwp_page_menu_args' );

function jwp_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'jwp_excerpt_length' );

if ( ! function_exists( 'jwp_continue_reading_link' ) ) :
	function jwp_continue_reading_link() {
		return '<p><a href="'. get_permalink() . '">' . __( 'Read More &raquo;', 'jwp' ) . '</a></p>';
	}
endif;

function jwp_auto_excerpt_more( $more ) {
	return ' &hellip;' . jwp_continue_reading_link();
}
add_filter( 'excerpt_more', 'jwp_auto_excerpt_more' );

add_filter('show_admin_bar', '__return_false');

function jwp_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= jwp_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'jwp_custom_excerpt_more' );

function jwp_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}

// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'jwp_remove_gallery_css' );
	
	
function jwp_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'JWP Primary Widget Area', 'jwp' ),
		'id' => 'jwp-primary-widget-area',
		'description' => __( 'The primary widget area', 'jwp' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'JWP Header Widget Area', 'jwp' ),
		'id' => 'jwp-header-widget-area',
		'description' => __( 'The header widget area', 'jwp' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'JWP Footer Widget Area', 'jwp' ),
		'id' => 'jwp-footer-footer-widget-area',
		'description' => __( 'The footer widget area', 'jwp' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'jwp_widgets_init' );

function jwp_disabled_discussion( $post_ID, $post ) {
    remove_filter( current_filter(), __FUNCTION__ );

    $post->comment_status = 'closed';
	$post->ping_status = 'closed';

   wp_update_post( $post );
}
add_action( 'wp_insert_post', 'jwp_disabled_discussion', 10, 2 ); 


function jwp_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'jwp' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'jwp' ), get_the_author() ) ),
			get_the_author()
		)
	);
}


function jwp_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'jwp' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'jwp' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'jwp' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%1$s at %2$s', 'jwp' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'jwp' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'jwp' ), '<p class="edit-link">', '</p>' ); ?>
			</section>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'jwp' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</article>
	<?php
		break;
	endswitch; 
}

add_filter('wp_die_handler', 'get_my_custom_die_handler');
function get_my_custom_die_handler() {
    return 'jwp_comment_validation';
}
function jwp_comment_validation($jwp_message, $title='', $args=array()) {
 $errorTemplate = get_theme_root().'/'.get_template().'/jwperror.php';
 if(!is_admin() && file_exists($errorTemplate)) {
    $defaults = array( 'response' => 500 );
    $r = wp_parse_args($args, $defaults);
    $have_gettext = function_exists('__');
    if ( function_exists( 'is_wp_error' ) && is_wp_error( $jwp_message ) ) {
        if ( empty( $title ) ) {
            $error_data = $jwp_message->get_error_data();
            if ( is_array( $error_data ) && isset( $error_data['title'] ) )
                $title = $error_data['title'];
        }
        $errors = $jwp_message->get_error_messages();
        switch ( count( $errors ) ) :
        case 0 :
            $jwp_message = '';
            break;
        case 1 :
            $jwp_message = "{$errors[0]}";
            break;
        default :
            $jwp_message = "<ul>\n\t\t<li>" . join( "</li>\n\t\t<li>", $errors ) . "</li>\n\t</ul>";
            break;
        endswitch;
    } elseif ( is_string( $jwp_message ) ) {
        $jwp_message = "$jwp_message";
    }
    if ( isset( $r['back_link'] ) && $r['back_link'] ) {
        $back_text = $have_gettext? __('&laquo; Back') : '&laquo; Back';
        $jwp_message .= "\n<a href='javascript:history.back()'>$back_text</a>";
    }
    if ( empty($title) )
        $title = $have_gettext ? __('jwp &rsaquo; Error') : 'WordPress &rsaquo; Error';
    require_once($errorTemplate);
    die();
 } else {
    _default_wp_die_handler($jwp_message, $title, $args);
 }
}

?>