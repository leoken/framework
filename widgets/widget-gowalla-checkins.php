<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: gowalla checkins
//***********************************************

class tf_gowalla_checkins_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_gowalla_checkins_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-gowalla-checkins', 'description' => __('This widget is used to show Gowalla Check-ins', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-gowalla-checkins-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-gowalla-checkins-widget', __('Gowalla - Check-ins', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

				$title = apply_filters('widget_title', $instance['gowalla-checkins-title'] );
                $headdesc = $instance['gowalla-checkins-headdesc'];
                $footdesc = $instance['gowalla-checkins-footdesc'];
                $limit = $instance['gowalla-checkins-limit'];

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
                echo '<div class="gowalla-checkins">';

                $spot = tf_gowalla_checkins_transient();
				 
				/*	
				if( is_wp_error( $spot ) || !$spot ) {
                	echo 'Please configure Gowalla in the Theme Options';
					
					if( is_wp_error( $spot ) )
						echo '<!-- gowalla returned error: ' . $spot->get_error_message() . '-->';
                } else {
				 */   
                	$counter=0;
                	foreach ($spot->last_checkins as $items) {
                	    if ($counter < $limit) {
                	        $counter++;
                	        echo '<div class="gowalla-checkins-item">';
                	        echo '<div class="gowalla-checkins-thumb"><a class="thumb-iframe" href="http://www.gowalla.com' . $items->user->url . '"><img src="' . $items->user->image_url . '" style="padding:0;margin:0" alt="' . $items->user->first_name . ' ' . $items->user->last_name . '"/></a></div>';
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
		$instance['gowalla-checkins-title'] = strip_tags( $new_instance['gowalla-checkins-title'] );
                $instance['gowalla-checkins-headdesc'] = strip_tags( $new_instance['gowalla-checkins-headdesc'] );
                $instance['gowalla-checkins-footdesc'] = strip_tags( $new_instance['gowalla-checkins-footdesc'] );
                $instance['gowalla-checkins-limit'] = strip_tags( $new_instance['gowalla-checkins-limit'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'gowalla-checkins-title' => __('Latest Gowalla Check-ins', 'themeforce'), 'gowalla-checkins-limit' => '6');
		$instance = wp_parse_args( (array) $instance, $defaults );
                $limit = $instance['gowalla-checkins-limit'];
                ?>

		<!-- Widget Title: Text Input -->
                <p><label for="<?php echo $this->get_field_id( 'gowalla-checkins-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'gowalla-checkins-title' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-checkins-title' ); ?>" value="<?php echo $instance['gowalla-checkins-title']; ?>" /></p>
                <label><?php _e('Display Limit:', 'themeforce'); ?></label>
                <select id="<?php echo $this->get_field_id( 'gowalla-checkins-limit' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-checkins-limit' ); ?>">
                    <option value='3' <?php selected( $limit, 3); ?>>3</option>
                    <option value='6' <?php selected( $limit, 6); ?>>6</option>
                    <option value='9' <?php selected( $limit, 9); ?>>9</option>
                    <option value='12' <?php selected( $limit, 12); ?>>12</option>
                    <option value='15' <?php selected( $limit, 15); ?>>15</option>
                    <option value='18' <?php selected( $limit, 18); ?>>18</option>
					<option value='21' <?php selected( $limit, 21); ?>>21</option>
                    <option value='24' <?php selected( $limit, 24); ?>>24</option>
                </select>
                <p><label><?php _e('Text above checkins:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gowalla-checkins-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-checkins-headdesc' ); ?>"><?php echo $instance['gowalla-checkins-headdesc']; ?></textarea></p>
                <p><label><?php _e('Text below checkins:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gowalla-checkins-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'gowalla-checkins-footdesc' ); ?>"><?php echo $instance['gowalla-checkins-footdesc']; ?></textarea></p>
           <?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_gowalla_checkins_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_gowalla_checkins_load_widgets() {
	register_widget( 'tf_gowalla_checkins_widget' );
}

?>