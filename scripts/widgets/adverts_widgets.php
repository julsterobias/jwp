<?php
class JwpWidget_adverts extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'JwpWidget_adverts', // Base ID
			'Abu dhabi Adverts', // Name
			array( 'description' => __( 'Display advertising banners', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		global $jwp, $wp_query, $wpdb;
			$title = apply_filters( 'JwpWidget_title', $instance['title'] );
			$imgurl = apply_filters( 'JwpWidget_type', $instance['imgurl'] );
			$linkurl = apply_filters( 'JwpWidget_type', $instance['linkurl'] );
			if(strlen($imgurl)>0){
		?>
        	<li>
            	<a href="<?php echo $linkurl; ?>" target="_blank"><img src="<?php echo $imgurl; ?>"></a>
            </li>
        <?php
			}
			
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['imgurl'] = strip_tags( $new_instance['imgurl'] );
		$instance['linkurl'] = strip_tags( $new_instance['linkurl'] );
		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$imgurl = $instance[ 'imgurl' ];
			$linkurl = $instance[ 'linkurl' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        
        <label for="<?php echo $this->get_field_id( 'imgurl' ); ?>"><?php _e( 'Image:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'imgurl' ); ?>" name="<?php echo $this->get_field_name( 'imgurl' ); ?>" type="text" value="<?php echo esc_attr( $imgurl ); ?>" />
        
        <label for="<?php echo $this->get_field_id( 'linkurl' ); ?>"><?php _e( 'Link to:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'linkurl' ); ?>" name="<?php echo $this->get_field_name( 'linkurl' ); ?>" type="text" value="<?php echo esc_attr( $linkurl ); ?>" />

        
		</p>
		<?php 
	}

}


add_action( 'widgets_init', create_function( '', 'register_widget( "JwpWidget_adverts" );' ) ); 
add_query_arg( 'name');
?>