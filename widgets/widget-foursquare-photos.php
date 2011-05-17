<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: FOURSQUARE PHOTOS
//***********************************************

class tf_fs_photos_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_fs_photos_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-fs-photos', 'description' => __('This widget is used to show Foursquare photos', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-fs-photos-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-fs-photos-widget', __('Foursquare Photos', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['fs-photos-title'] );
                $headdesc = $instance['fs-photos-headdesc'];
                $footdesc = $instance['fs-photos-footdesc'];
                $limit = $instance['fs-photos-limit'];

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
                echo '<div class="fs-photos">';

                        $venue = tf_foursquare_transient();

                        // -display meta code -
                        echo '<!-- Foursquare Response Code: ' . $venue->meta->code . ' -->';

                        $counter=0;
                        foreach ($venue->response->venue->photos->groups[1]->items as $items) {
                            if ($counter < $limit) {
                                $counter++;
                                echo '<div class="fs-photos-item">';
                                echo '<div class="fs-photos-thumb"><img src="' . $items->sizes->items[2]->url . '" style="padding:0;margin:0" /></div>';
                                // echo '<div class="fs-photos-text"><strong>'. $items->user->firstName . ' ' . $items->user->lastName . __(' says ', 'themeforce') . '</strong><div class="fs-photos-quote">"' . $items->text . '"</div></div>';
                                echo '</div>';
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
		$instance['fs-photos-title'] = strip_tags( $new_instance['fs-photos-title'] );
                $instance['fs-photos-headdesc'] = strip_tags( $new_instance['fs-photos-headdesc'] );
                $instance['fs-photos-footdesc'] = strip_tags( $new_instance['fs-photos-footdesc'] );
                $instance['fs-photos-limit'] = strip_tags( $new_instance['fs-photos-limit'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'fs-photos-title' => __('Guest photos', 'themeforce'), 'fs-photos-limit' => '6');
		$instance = wp_parse_args( (array) $instance, $defaults );
                $limit = $instance['fs-photos-limit'];
                ?>

		<!-- Widget Title: Text Input -->
                <p><label for="<?php echo $this->get_field_id( 'fs-photos-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'fs-photos-title' ); ?>" name="<?php echo $this->get_field_name( 'fs-photos-title' ); ?>" value="<?php echo $instance['fs-photos-title']; ?>" /></p>
                <label><?php _e('Display Limit:', 'themeforce'); ?></label>
                <select id="<?php echo $this->get_field_id( 'fs-photos-limit' ); ?>" name="<?php echo $this->get_field_name( 'fs-photos-limit' ); ?>">
                    <option value='1' <?php selected( $limit, 1); ?>>1</option>
                    <option value='2' <?php selected( $limit, 2); ?>>2</option>
                    <option value='3' <?php selected( $limit, 3); ?>>3</option>
                    <option value='4' <?php selected( $limit, 4); ?>>4</option>
                    <option value='5' <?php selected( $limit, 5); ?>>5</option>
                    <option value='6' <?php selected( $limit, 6); ?>>6</option>
                    <option value='7' <?php selected( $limit, 7); ?>>7</option>
                    <option value='8' <?php selected( $limit, 8); ?>>8</option>
                    <option value='9' <?php selected( $limit, 9); ?>>9</option>
                </select>
                <p><label><?php _e('Text above photos:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'fs-photos-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'fs-photos-headdesc' ); ?>"><?php echo $instance['fs-photos-headdesc']; ?></textarea></p>
                <p><label><?php _e('Text below photos:', 'themeforce'); ?></label><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'fs-photos-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'fs-photos-footdesc' ); ?>"><?php echo $instance['fs-photos-footdesc']; ?></textarea></p>
           <?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_fs_photos_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_fs_photos_load_widgets() {
	register_widget( 'tf_fs_photos_widget' );
}

?>