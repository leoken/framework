<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: Legacy Widget (not used anymore, replace by MailChimp Widget)
//**********************************************************************

class TF_Newsletter_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function TF_Newsletter_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-newsletter', 'description' => __('This widget is used to invite your visitors to sign-up for the newsletter.', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-newsletter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-newsletter-widget', __('Newsletter', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

				$title = apply_filters('widget_title', $instance['newsletter-title'] );
				$url = $instance['newsletter-url'];
                $content = $instance['newsletter-content'];

                echo $before_widget;
                if ( $title ) {echo $before_title . $title . $after_title;}
                ?>
                <p><?php echo $content; ?></p>

                <div id="tf-newsletter-link"><a href="<?php echo $url; ?>" target="_blank">Newsletter Sign-up</a></div>

                <?php
                echo $after_widget;
                }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['newsletter-title'] = strip_tags( $new_instance['newsletter-title'] );
		$instance['newsletter-url'] = strip_tags( $new_instance['newsletter-url'] );
                $instance['newsletter-content'] = strip_tags( $new_instance['newsletter-content'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'newsletter-title' => __('Newsletter', 'themeforce'), 'newsletter-url' => __('Enter the Mailchimp link here', 'themeforce'), 'newsletter-content' => 'Would you like to receive periodic updates from our Pub? Subscribe to our Newsletter today.');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'newsletter-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'newsletter-title' ); ?>" name="<?php echo $this->get_field_name( 'newsletter-title' ); ?>" value="<?php echo $instance['newsletter-title']; ?>" /></p>
                <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'newsletter-content' ); ?>" name="<?php echo $this->get_field_name( 'newsletter-content' ); ?>"><?php echo $instance['newsletter-content']; ?></textarea>
                <p><label for="<?php echo $this->get_field_id( 'newsletter-url' ); ?>"><?php _e('Sign-up Form Link:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'newsletter-url' ); ?>" name="<?php echo $this->get_field_name( 'newsletter-url' ); ?>" value="<?php echo $instance['newsletter-url']; ?>" /></p>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_newsletter_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_newsletter_load_widgets() {
	register_widget( 'TF_Newsletter_Widget' );
}

?>