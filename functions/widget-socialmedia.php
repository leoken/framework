<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: SOCIAL MEDIA ICONS
//***********************************************

class tf_socialmedia_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_socialmedia_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-socialmedia', 'description' => __('This widget is used to show the Wooden Social Media Icons', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-socialmedia-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-socialmedia-widget', __('TF - Wooden Social Media', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['sm-title'] );
                $twitter =  get_option('tf__twitter');
                $facebook =  get_option('tf_facebook');

                // widget display
                echo $before_widget;
                if ( $title ) {echo $before_title . $title . $after_title;}
                echo '<div id="chow-social">';
                if ($facebook) { echo '<a href="' . $facebook . '" target="_blank"><img src="' . get_bloginfo('template_url') . '/images/sm_fb.png" alt="Facebook" /></a>'; }
                if ($twitter) { echo '<a href="' . $twitter . '" target="_blank"><img src="' . get_bloginfo('template_url') . '/images/sm_twitter.png" alt="Twitter" /></a>'; }
                echo '<a href="' . get_bloginfo('atom_url') . '"><img src="' . get_bloginfo('template_url') . '/images/sm_rss.png" alt="RSS / Atom Feed" /></a>';
                echo '<div class="clearfix"></div></div>';
                echo $after_widget;
                }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['sm-title'] = strip_tags( $new_instance['sm-title'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'sm-title' => __('Connect with us', 'themeforce'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'sm-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'sm-title' ); ?>" name="<?php echo $this->get_field_name( 'sm-title' ); ?>" value="<?php echo $instance['sm-title']; ?>" /></p>
                <p>The Facebook & Twitter icons only show if the links within the General Settings ('Theme Options') are populated, otherwise they will not show.</p>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_socialmedia_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_socialmedia_load_widgets() {
	register_widget( 'tf_socialmedia_widget' );
}

?>