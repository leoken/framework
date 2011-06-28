<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: Foursquare Check-ins (API calls it 'Here Now'
//******************************************************

class tf_fs_herenow_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_fs_herenow_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-fs-herenow', 'description' => __('This widget is used to show Foursquare Check-ins', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-fs-herenow-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-fs-herenow-widget', __('Foursquare - Check-ins', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['fs-herenow-title'] );
                $headdesc = $instance['fs-herenow-headdesc'];
                $footdesc = $instance['fs-herenow-footdesc'];
                $limit = $instance['fs-herenow-limit'];

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
                echo '<div class="fs-herenow">';

                $venue = tf_foursquare_transient();
				    
				if( is_wp_error( $venue ) || !$venue ) {
                	echo 'Please configure foursquare in the Theme Options';
					
					if( is_wp_error( $venue ) )
						echo '<!-- FourSquare returned error: ' . $venue->get_error_message() . '-->';
                } else {
				    
                	$counter=0;
                	foreach ($venue->response->venue->hereNow->groups[1]->items as $items) {
                	    if ($counter < $limit) {
                	        $counter++;
                	        echo '<div class="fs-herenow-item">';
                	        echo '<div class="fs-herenow-thumb"><img src="' . $items->user->photo . '" style="padding:0;margin:0" /></div>';
                	        echo '</div>';
                	    }   
				    }
				}

                echo '<div class="clearfix"></div></div>';
                if ( $footdesc ) {echo '<p>' . $footdesc . '</p>';}

                echo $after_widget;
                }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['fs-herenow-title'] = strip_tags( $new_instance['fs-herenow-title'] );
                $instance['fs-herenow-headdesc'] = strip_tags( $new_instance['fs-herenow-headdesc'] );
                $instance['fs-herenow-footdesc'] = strip_tags( $new_instance['fs-herenow-footdesc'] );
                $instance['fs-herenow-limit'] = strip_tags( $new_instance['fs-herenow-limit'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'fs-herenow-title' => __('Latest Foursquare Check-ins', 'themeforce'), 'fs-herenow-limit' => '6');
		$instance = wp_parse_args( (array) $instance, $defaults );
                $limit = $instance['fs-herenow-limit'];
                ?>

		<!-- Widget Title: Text Input -->
                <p><label for="<?php echo $this->get_field_id( 'fs-herenow-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'fs-herenow-title' ); ?>" name="<?php echo $this->get_field_name( 'fs-herenow-title' ); ?>" value="<?php echo $instance['fs-herenow-title']; ?>" /></p>
                <label><?php _e('Display Limit:', 'themeforce'); ?></label>
                <select id="<?php echo $this->get_field_id( 'fs-herenow-limit' ); ?>" name="<?php echo $this->get_field_name( 'fs-herenow-limit' ); ?>">
                    <option value='3' <?php selected( $limit, 3); ?>>3</option>
                    <option value='6' <?php selected( $limit, 6); ?>>6</option>
                    <option value='9' <?php selected( $limit, 9); ?>>9</option>
                    <option value='12' <?php selected( $limit, 12); ?>>12</option>
                    <option value='15' <?php selected( $limit, 15); ?>>15</option>
                    <option value='18' <?php selected( $limit, 18); ?>>18</option>
					<option value='21' <?php selected( $limit, 21); ?>>21</option>
                    <option value='24' <?php selected( $limit, 24); ?>>24</option>
                </select>
                <p><label><?php _e('Text above herenow:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'fs-herenow-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'fs-herenow-headdesc' ); ?>"><?php echo $instance['fs-herenow-headdesc']; ?></textarea></p>
                <p><label><?php _e('Text below herenow:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'fs-herenow-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'fs-herenow-footdesc' ); ?>"><?php echo $instance['fs-herenow-footdesc']; ?></textarea></p>
           <?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_fs_herenow_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_fs_herenow_load_widgets() {
	register_widget( 'tf_fs_herenow_widget' );
}

?>