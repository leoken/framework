<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: GOOGLE MAPS
//***********************************************

class tf_googlemaps_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_googlemaps_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-googlemaps', 'description' => __('This widget is used to show a Google Map of your business (based on your address in the options)', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-googlemaps-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-googlemaps-widget', __('Google Maps', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['gmaps-title'] );
                $headdesc = $instance['gmaps-headdesc'];
                $height = $instance['gmaps-height'];
                $zoom = $instance['gmaps-zoom'];
                $footdesc = $instance['gmaps-footdesc'];

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}

                // Grab Addresss Data

                $new_address = get_option('tf_address_street') . ', ' . get_option('tf_address_locality') . ', ' . get_option('tf_address_postalcode') . ' ' . get_option('tf_address_region') . ' ' . get_option('tf_address_country');

                // Choose

                if (get_option('tf_address_street') . get_option('tf_address_country') !== '')
                {
                    $valid_address = $new_address;    
                } else {
                    $valid_address = get_option('tf_business_address');
                }

                $address_url = preg_replace('/[^a-zA-Z0-9_ -]/s', '+', $valid_address);

                echo '<span itemprop="maps"><a href="http://maps.google.com/maps?q=' . $address_url . '" target="_blank"><img class="tf-googlemaps-front" src="http://maps.google.com/maps/api/staticmap?center=' . $address_url . '?>&zoom=' . $zoom . '&size=300x' . $height . '&markers=color:white|' . $address_url . '&sensor=false" /></a></span>';

                if ( $footdesc ) {echo '<p>' . $footdesc . '</p>';}

                echo $after_widget;
                }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['gmaps-title'] = strip_tags( $new_instance['gmaps-title'] );
                $instance['gmaps-headdesc'] = strip_tags( $new_instance['gmaps-headdesc'] );
                $instance['gmaps-height'] = strip_tags( $new_instance['gmaps-height'] );
                $instance['gmaps-zoom'] = strip_tags( $new_instance['gmaps-zoom'] );
                $instance['gmaps-footdesc'] = strip_tags( $new_instance['gmaps-footdesc'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'gmaps-title' => __('Our Location', 'themeforce'), 'gmaps-height' => '200', 'gmaps-zoom' => '14');
		$instance = wp_parse_args( (array) $instance, $defaults );
                $zoom = $instance['gmaps-zoom'];
                ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'gmaps-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'gmaps-title' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-title' ); ?>" value="<?php echo $instance['gmaps-title']; ?>" /></p>
                <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gmaps-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-headdesc' ); ?>"><?php echo $instance['gmaps-headdesc']; ?></textarea></p>
                <p><label for="<?php echo $this->get_field_id( 'gmaps-height' ); ?>"><?php _e('Height (in pixels):', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'gmaps-height' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-height' ); ?>" value="<?php echo $instance['gmaps-height']; ?>" /></p>
                <label><?php _e('Zoom Factor:', 'themeforce'); ?></label>
                <select id="<?php echo $this->get_field_id( 'gmaps-zoom' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-zoom' ); ?>">
                    <option value='1' <?php selected( $zoom, 1); ?>>1</option>
                    <option value='2' <?php selected( $zoom, 2); ?>>2</option>
                    <option value='3' <?php selected( $zoom, 3); ?>>3</option>
                    <option value='4' <?php selected( $zoom, 4); ?>>4</option>
                    <option value='5' <?php selected( $zoom, 5); ?>>5</option>
                    <option value='6' <?php selected( $zoom, 6); ?>>6</option>
                    <option value='7' <?php selected( $zoom, 7); ?>>7</option>
                    <option value='8' <?php selected( $zoom, 8); ?>>8</option>
                    <option value='9' <?php selected( $zoom, 9); ?>>9</option>
                    <option value='10' <?php selected( $zoom, 10); ?>>10</option>
                    <option value='11' <?php selected( $zoom, 11); ?>>11</option>
                    <option value='12' <?php selected( $zoom, 12); ?>>12</option>
                    <option value='13' <?php selected( $zoom, 13); ?>>13</option>
                    <option value='14' <?php selected( $zoom, 14); ?>>14</option>
                    <option value='15' <?php selected( $zoom, 15); ?>>15</option>
                    <option value='16' <?php selected( $zoom, 16); ?>>16</option>
                    <option value='17' <?php selected( $zoom, 17); ?>>17</option>
                    <option value='18' <?php selected( $zoom, 18); ?>>18</option>
                    <option value='19' <?php selected( $zoom, 19); ?>>19</option>
                    <option value='20' <?php selected( $zoom, 20); ?>>20</option>
                    <option value='21' <?php selected( $zoom, 20); ?>>21</option>
                </select>
                <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gmaps-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-footdesc' ); ?>"><?php echo $instance['gmaps-footdesc']; ?></textarea></p>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_googlemaps_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_googlemaps_load_widgets() {
	register_widget( 'tf_googlemaps_widget' );
}

?>