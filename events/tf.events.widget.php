<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: EVENTS
//***********************************************

class Example_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Example_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => __('Displays events within the widget areas', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'example-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'example-widget', __('Events', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['title'] );
		$limit = $instance['limit'];
                $limit = intval($limit);

                echo $before_widget;
                if ( $title ) echo $before_title . $title . $after_title;

                // - hide events that are older than 6am today (because some parties go past your bedtime) -

                $today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );

                // - query -
                global $wpdb;
                $querystr = "
                    SELECT *
                    FROM $wpdb->posts wposts, $wpdb->postmeta metastart, $wpdb->postmeta metaend
                    WHERE (wposts.ID = metastart.post_id AND wposts.ID = metaend.post_id)
                    AND (metaend.meta_key = 'tf_events_enddate' AND metaend.meta_value > $today6am )
                    AND metastart.meta_key = 'tf_events_enddate'
                    AND wposts.post_type = 'tf_events'
                    AND wposts.post_status = 'publish'
                    ORDER BY metastart.meta_value ASC LIMIT $limit
                 ";

                $events = $wpdb->get_results($querystr, OBJECT);

                // - declare fresh day -
                $daycheck = null;

                // - loop -
                if ($events):
                global $post;
                foreach ($events as $post):
                setup_postdata($post);

                // - date option -
                $date_format = get_option('date_format');

                // - custom variables -
                $custom = get_post_custom(get_the_ID());
                $sd = $custom["tf_events_startdate"][0];
                $ed = $custom["tf_events_enddate"][0];
                $post_image_id = get_post_thumbnail_id(get_the_ID());
                        if ($post_image_id) {
                                $thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
                                if ($thumbnail) (string)$thumbnail = $thumbnail[0];
                        }

                // - determine if it's a new day -

                ?><div class="events-widget"><?php
                $sqldate = date('Y-m-d H:i:s', $sd);
                $longdate = mysql2date($date_format, $sqldate);
                if ($daycheck == null) { echo '<div class="longdate">' . $longdate . '</div>'; }
                if ($daycheck != $longdate && $daycheck != null) { echo '<div class="longdate">' . $longdate . '</div>'; }

                // - local time format -
                $time_format = get_option('time_format');
                $stime = date($time_format, $sd);
                $etime = date($time_format, $ed);

                // - output - ?>

                        <div class="eventitem"><a href="<?php the_permalink(); ?>"><?php echo $stime; ?> - <?php the_title(); ?></a></div>
                    </div>
                <?php

                // - fill daycheck with the current day -
                $daycheck = $longdate;
                // - .... and back to the top now -

                endforeach;
                else :
                endif;

                echo $after_widget;
                }




	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit'] = $new_instance['limit'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Events', 'themeforce'), 'limit' => '20');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" /></p>
                <p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Number of Events:', 'themeforce'); ?></label>
                <input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit']; ?>" type="text" size="3" /></p>

	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'example_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function example_load_widgets() {
	register_widget( 'Example_Widget' );
}

?>