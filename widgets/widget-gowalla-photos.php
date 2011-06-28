<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: gowalla PHOTOS
//***********************************************

class tf_gowalla_photos_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_gowalla_photos_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-gowalla-photos', 'description' => __('This widget is used to show Gowalla photos', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-gowalla-photos-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-gowalla-photos-widget', __('Gowalla Photos', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

				$title = apply_filters('widget_title', $instance['gowalla-photos-title'] );
                $headdesc = $instance['gowalla-photos-headdesc'];
                $footdesc = $instance['gowalla-photos-footdesc'];
                $limit = $instance['gowalla-photos-limit'];

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
                echo '<div class="gowalla-photos">';

                $spot = tf_gowalla_transient();
				 
				/*	
				if( is_wp_error( $spot ) || !$spot ) {
                	echo 'Please configure Gowalla in the Theme Options';
					
					if( is_wp_error( $spot ) )
						echo '<!-- gowalla returned error: ' . $spot->get_error_message() . '-->';
                } else {
				 */   
                	$counter=0;
                	foreach ($spot->activity as $items) {
                	    if ($counter < $limit) {
                	        $counter++;
                	        echo '<div class="gowalla-photos-item">';
                	        echo '<div class="gowalla-photos-thumb"><img src="' . $items->photo_urls->square_100 . '" style="padding:0;margin:0" /></div>';
                	        // echo '<div class="gowalla-photos-text"><strong>'. $items->user->firstName . ' ' . $items->user->lastName . __(' says ', 'themeforce') . '</strong><div class="gowalla-photos-quote">"' . $items->text . '"</div></div>';
                	        echo '</div>';
                	    }   
				    }
				// }

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
		$instance['gowalla-photos-title'] = strip_tags( $new_instance['gowalla-photos-title'] );
                $instance['gowalla-photos-headdesc'] = strip_tags( $new_instance['gowalla-photos-headdesc'] );
                $instance['gowalla-photos-footdesc'] = strip_tags( $new_instance['gowalla-photos-footdesc'] );
                $instance['gowalla-photos-limit'] = strip_tags( $new_instance['gowalla-photos-limit'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'gowalla-photos-title' => __('Guest photos', 'themeforce'), 'gowalla-photos-limit' => '6');
		$instance = wp_parse_args( (array) $instance, $defaults );
                $limit = $instance['gowalla-photos-limit'];
                ?>

		<!-- Widget Title: Text Input -->
                <p><label for="<?php echo $this->get_field_id( 'gowalla-photos-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'gowalla-photos-title' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-photos-title' ); ?>" value="<?php echo $instance['gowalla-photos-title']; ?>" /></p>
                <label><?php _e('Display Limit:', 'themeforce'); ?></label>
                <select id="<?php echo $this->get_field_id( 'gowalla-photos-limit' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-photos-limit' ); ?>">
                    <option value='1' <?php selected( $limit, 1); ?>>1</option>
                    <option value='2' <?php selected( $limit, 2); ?>>2</option>
                    <option value='3' <?php selected( $limit, 3); ?>>3</option>
                    <option value='4' <?php selected( $limit, 4); ?>>4</option>
                    <option value='5' <?php selected( $limit, 5); ?>>5</option>
                    <option value='6' <?php selected( $limit, 6); ?>>6</option>
                </select>
                <p><label><?php _e('Text above photos:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gowalla-photos-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-photos-headdesc' ); ?>"><?php echo $instance['gowalla-photos-headdesc']; ?></textarea></p>
                <p><label><?php _e('Text below photos:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gowalla-photos-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-photos-footdesc' ); ?>"><?php echo $instance['gowalla-photos-footdesc']; ?></textarea></p>
           <?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_gowalla_photos_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_gowalla_photos_load_widgets() {
	register_widget( 'tf_gowalla_photos_widget' );
}

?>