<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: FOURSQUARE TIPS
//***********************************************

class tf_fs_tips_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_fs_tips_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-fs-tips', 'description' => __('This widget is used to show Foursquare Tips', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-fs-tips-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-fs-tips-widget', __('Foursquare Tips', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		// - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['fs-tips-title'] );

		$headdesc = $instance['fs-tips-headdesc'];
		$footdesc = $instance['fs-tips-footdesc'];
		$limit = $instance['fs-tips-limit'];
		
		// widget display
		
		echo $before_widget;
		
		if ( $title ) {echo $before_title . $title . $after_title;}
		if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
		echo '<div class="fs-tips">';
		
		        $venue = tf_foursquare_transient();
		        if( is_wp_error( $venue ) || !$venue ) {
                	echo 'Please configure foursquare in the Theme Options';
					
					if( is_wp_error( $venue ) )
						echo '<!-- FourSquare returned error: ' . $venue->get_error_message() . '-->';
                } else {
		
		       		// -display meta code -
		       		echo '<!-- Foursquare Response Code: ' . $venue->meta->code . ' -->';
		       		
		       		$counter=0;
		       		foreach ($venue->response->venue->tips->groups[0]->items as $items) {
		       		    if ($counter < $limit) {
		       		        $counter++;
		       		        echo '<div class="fs-tips-item">';
		       		        echo '<div class="fs-tips-thumb"><img src="' . $items->user->photo . '" width="50px" height="50px" style="padding:0;margin:0;line-height:0;" /></div>';
		       		        echo '<div class="fs-tips-text"><strong>'. $items->user->firstName . ' ' . $items->user->lastName . __(' says ', 'themeforce') . '</strong><div class="fs-tips-quote">"' . $items->text . '"</div></div>';
		       		        echo '</div><div class="clearfix"></div>';
		       		    }
		       		}
		       	}
		       		
		echo '</div>';
		if ( $footdesc ) {echo '<p>' . $footdesc . '</p>';}
		
		echo $after_widget;
		}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['fs-tips-title'] = strip_tags( $new_instance['fs-tips-title'] );
		$instance['fs-tips-headdesc'] = strip_tags( $new_instance['fs-tips-headdesc'] );
		$instance['fs-tips-footdesc'] = strip_tags( $new_instance['fs-tips-footdesc'] );
		$instance['fs-tips-limit'] = strip_tags( $new_instance['fs-tips-limit'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'fs-tips-title' => __('Guest Tips', 'themeforce'), 'fs-tips-limit' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults );
		$limit = $instance['fs-tips-limit'];
		?>

		<!-- Widget Title: Text Input -->
		<p><label for="<?php echo $this->get_field_id( 'fs-tips-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'fs-tips-title' ); ?>" name="<?php echo $this->get_field_name( 'fs-tips-title' ); ?>" value="<?php echo $instance['fs-tips-title']; ?>" /></p>
		<select id="<?php echo $this->get_field_id( 'fs-tips-limit' ); ?>" name="<?php echo $this->get_field_name( 'fs-tips-limit' ); ?>">
			<option value='1' <?php selected( $limit, 1); ?>>1</option>
			<option value='2' <?php selected( $limit, 2); ?>>2</option>
			<option value='3' <?php selected( $limit, 3); ?>>3</option>
			<option value='4' <?php selected( $limit, 4); ?>>4</option>
			<option value='5' <?php selected( $limit, 5); ?>>5</option>
			<option value='6' <?php selected( $limit, 6); ?>>6</option>
			<option value='7' <?php selected( $limit, 7); ?>>7</option>
			<option value='8' <?php selected( $limit, 8); ?>>8</option>
			<option value='9' <?php selected( $limit, 9); ?>>9</option>
			<option value='10' <?php selected( $limit, 10); ?>>10</option>
		</select>
		<p><label><?php _e('Text above Tips:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'fs-tips-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'fs-tips-headdesc' ); ?>"><?php echo $instance['fs-tips-headdesc']; ?></textarea></p>
		<p><label><?php _e('Text below Tips:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'fs-tips-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'fs-tips-footdesc' ); ?>"><?php echo $instance['fs-tips-footdesc']; ?></textarea></p>
           <?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_fs_tips_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_fs_tips_load_widgets() {
	register_widget( 'tf_fs_tips_widget' );
}