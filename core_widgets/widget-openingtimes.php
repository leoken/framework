<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: OPENING TIMES
//***********************************************

class tf_openingtimes_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_openingtimes_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-openingtimes', 'description' => __('This widget is used to show Opening Times', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-openingtimes-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-openingtimes-widget', __('Opening Times', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['open-title'] );
                $headdesc = $instance['open-headdesc'];
                $footdesc = $instance['open-footdesc'];

                $d1 = $instance['open-d1'];
                $d2 = $instance['open-d2'];
                $d3 = $instance['open-d3'];
                $d4 = $instance['open-d4'];
                $d5 = $instance['open-d5'];
                $d6 = $instance['open-d6'];
                $d7 = $instance['open-d7'];

                $t1 = $instance['open-t1'];
                $t2 = $instance['open-t2'];
                $t3 = $instance['open-t3'];
                $t4 = $instance['open-t4'];
                $t5 = $instance['open-t5'];
                $t6 = $instance['open-t6'];
                $t7 = $instance['open-t7'];

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
                echo '<div class="openingtimes">';
                if ( $d1 ) { echo '<div class="openitem"><div class="openday">' . $d1 . '</div><div class="opentime">' . $t1 . '</div></div>'; }
                if ( $d2 ) { echo '<div class="openitem"><div class="openday">' . $d2 . '</div><div class="opentime">' . $t2 . '</div></div>'; }
                if ( $d3 ) { echo '<div class="openitem"><div class="openday">' . $d3 . '</div><div class="opentime">' . $t3 . '</div></div>'; }
                if ( $d4 ) { echo '<div class="openitem"><div class="openday">' . $d4 . '</div><div class="opentime">' . $t4 . '</div></div>'; }
                if ( $d5 ) { echo '<div class="openitem"><div class="openday">' . $d5 . '</div><div class="opentime">' . $t5 . '</div></div>'; }
                if ( $d6 ) { echo '<div class="openitem"><div class="openday">' . $d6 . '</div><div class="opentime">' . $t6 . '</div></div>'; }
                if ( $d7 ) { echo '<div class="openitem"><div class="openday">' . $d7 . '</div><div class="opentime">' . $t7 . '</div></div>'; }
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
		$instance['open-title'] = strip_tags( $new_instance['open-title'] );
                $instance['open-headdesc'] = strip_tags( $new_instance['open-headdesc'] );
                $instance['open-footdesc'] = strip_tags( $new_instance['open-footdesc'] );
                $instance['open-d1'] = strip_tags( $new_instance['open-d1'] );
                $instance['open-d2'] = strip_tags( $new_instance['open-d2'] );
                $instance['open-d3'] = strip_tags( $new_instance['open-d3'] );
                $instance['open-d4'] = strip_tags( $new_instance['open-d4'] );
                $instance['open-d5'] = strip_tags( $new_instance['open-d5'] );
                $instance['open-d6'] = strip_tags( $new_instance['open-d6'] );
                $instance['open-d7'] = strip_tags( $new_instance['open-d7'] );
                $instance['open-t1'] = strip_tags( $new_instance['open-t1'] );
                $instance['open-t2'] = strip_tags( $new_instance['open-t2'] );
                $instance['open-t3'] = strip_tags( $new_instance['open-t3'] );
                $instance['open-t4'] = strip_tags( $new_instance['open-t4'] );
                $instance['open-t5'] = strip_tags( $new_instance['open-t5'] );
                $instance['open-t6'] = strip_tags( $new_instance['open-t6'] );
                $instance['open-t7'] = strip_tags( $new_instance['open-t7'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'open-title' => __('Opening Times', 'themeforce'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'open-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'open-title' ); ?>" name="<?php echo $this->get_field_name( 'open-title' ); ?>" value="<?php echo $instance['open-title']; ?>" /></p>
                <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'open-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'open-headdesc' ); ?>"><?php echo $instance['open-headdesc']; ?></textarea></p>
                <p><label><?php _e('Enter Opening Hours:', 'themeforce'); ?></label>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d1' ); ?>" name="<?php echo $this->get_field_name( 'open-d1' ); ?>" value="<?php echo $instance['open-d1']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t1' ); ?>" name="<?php echo $this->get_field_name( 'open-t1' ); ?>" value="<?php echo $instance['open-t1']; ?>" />
                </p>
                <p>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d2' ); ?>" name="<?php echo $this->get_field_name( 'open-d2' ); ?>" value="<?php echo $instance['open-d2']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t2' ); ?>" name="<?php echo $this->get_field_name( 'open-t2' ); ?>" value="<?php echo $instance['open-t2']; ?>" />
                </p>
                <p>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d3' ); ?>" name="<?php echo $this->get_field_name( 'open-d3' ); ?>" value="<?php echo $instance['open-d3']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t3' ); ?>" name="<?php echo $this->get_field_name( 'open-t3' ); ?>" value="<?php echo $instance['open-t3']; ?>" />
                </p>
                <p>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d4' ); ?>" name="<?php echo $this->get_field_name( 'open-d4' ); ?>" value="<?php echo $instance['open-d4']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t4' ); ?>" name="<?php echo $this->get_field_name( 'open-t4' ); ?>" value="<?php echo $instance['open-t4']; ?>" />
                </p>
                <p>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d5' ); ?>" name="<?php echo $this->get_field_name( 'open-d5' ); ?>" value="<?php echo $instance['open-d5']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t5' ); ?>" name="<?php echo $this->get_field_name( 'open-t5' ); ?>" value="<?php echo $instance['open-t5']; ?>" />
                </p>
                <p>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d6' ); ?>" name="<?php echo $this->get_field_name( 'open-d6' ); ?>" value="<?php echo $instance['open-d6']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t6' ); ?>" name="<?php echo $this->get_field_name( 'open-t6' ); ?>" value="<?php echo $instance['open-t6']; ?>" />
                </p>
                <p>
                    <input class="widefat" style="width:100px;float:left;clear:none" id="<?php echo $this->get_field_id( 'open-d7' ); ?>" name="<?php echo $this->get_field_name( 'open-d7' ); ?>" value="<?php echo $instance['open-d7']; ?>" />
                    <input class="widefat" style="margin-left:5px;width:100px;" id="<?php echo $this->get_field_id( 'open-t7' ); ?>" name="<?php echo $this->get_field_name( 'open-t7' ); ?>" value="<?php echo $instance['open-t7']; ?>" />
                </p>
                 <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'open-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'open-footdesc' ); ?>"><?php echo $instance['open-footdesc']; ?></textarea></p>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_openingtimes_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_openingtimes_load_widgets() {
	register_widget( 'tf_openingtimes_widget' );
}
?>