<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: PAYMENT TYPES
//***********************************************

class tf_payments_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_payments_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-payments', 'description' => __('This widget is used to show Payment Types accepeted', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-payments-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-payments-widget', __('Payment', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['payment-title'] );
                $headdesc = $instance['payment-headdesc'];
                $footdesc = $instance['payment-footdesc'];
                $visa = isset($instance['payment-visa']) ? $instance['payment-visa'] : true;
                $mast = isset($instance['payment-mast']) ? $instance['payment-mast'] : true;
                $amex = isset($instance['payment-amex']) ? $instance['payment-amex'] : true;
                $disc = isset($instance['payment-disc']) ? $instance['payment-disc'] : true;
                $cirr = isset($instance['payment-cirr']) ? $instance['payment-cirr'] : true;
                $maes = isset($instance['payment-maes']) ? $instance['payment-maes'] : true;

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                if ( $headdesc ) {echo '<p>' . $headdesc . '</p>';}
                echo '<ul class="tf-payments">';
                if ( $visa == true ) { echo '<li class="payment-type"><img src="' . get_bloginfo('template_url') . '/themeforce/assets/images/payment-visa.png" alt="' . __('Visa Accepted', 'themeforce') . '" /></li>'; }
                if ( $mast == true ) { echo '<li class="payment-type"><img src="' . get_bloginfo('template_url') . '/themeforce/assets/images/payment-mast.png" alt="' . __('Mastercard Accepted', 'themeforce') . '" /></li>'; }
                if ( $amex == true ) { echo '<li class="payment-type"><img src="' . get_bloginfo('template_url') . '/themeforce/assets/images/payment-amex.png" alt="' . __('American Express Accepted', 'themeforce') . '" /></li>'; }
                if ( $disc == true ) { echo '<li class="payment-type"><img src="' . get_bloginfo('template_url') . '/themeforce/assets/images/payment-disc.png" alt="' . __('Discover Card Accepted', 'themeforce') . '" /></li>'; }
                if ( $cirr == true ) { echo '<li class="payment-type"><img src="' . get_bloginfo('template_url') . '/themeforce/assets/images/payment-cirr.png" alt="' . __('Cirrus Card Accepted', 'themeforce') . '" /></li>'; }
                if ( $maes == true ) { echo '<li class="payment-type"><img src="' . get_bloginfo('template_url') . '/themeforce/assets/images/payment-maes.png" alt="' . __('Maestro Card Accepted', 'themeforce') . '" /></li>'; }
                echo '</ul>';
                if ( $footdesc ) {echo '<p>' . $footdesc . '</p>';}

                echo $after_widget;
                }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

			  $instance = array( 'payment-visa' => 0, 'payment-mast' => 0, 'payment-amex' => 0, 'payment-disc' => 0, 'payment-cirr' => 0, 'payment-maes' => 0);
				  	foreach ( $instance as $field => $val ) {
				   if ( isset($new_instance[$field]) )
				    $instance[$field] = 1;
			  }
			  $instance['payment-title'] = strip_tags( $new_instance['payment-title'] );
			  $instance['payment-headdesc'] = strip_tags( $new_instance['payment-headdesc'] );
              $instance['payment-footdesc'] = strip_tags( $new_instance['payment-footdesc'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'payment-title' => __('Cards Accepted', 'themeforce'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'payment-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'payment-title' ); ?>" name="<?php echo $this->get_field_name( 'payment-title' ); ?>" value="<?php echo $instance['payment-title']; ?>" /></p>
                <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'payment-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'payment-headdesc' ); ?>"><?php echo $instance['payment-headdesc']; ?></textarea></p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['payment-visa'], true ); ?> id="<?php echo $this->get_field_id( 'payment-visa' ); ?>" name="<?php echo $this->get_field_name( 'payment-visa' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'payment-visa' ); ?>">Visa</label>
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['payment-mast'], true ); ?> id="<?php echo $this->get_field_id( 'payment-mast' ); ?>" name="<?php echo $this->get_field_name( 'payment-mast' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'payment-mast' ); ?>">Mastercard</label>
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['payment-amex'], true ); ?> id="<?php echo $this->get_field_id( 'payment-amex' ); ?>" name="<?php echo $this->get_field_name( 'payment-amex' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'payment-amex' ); ?>">American Express</label>
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['payment-disc'], true ); ?> id="<?php echo $this->get_field_id( 'payment-disc' ); ?>" name="<?php echo $this->get_field_name( 'payment-disc' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'payment-disc' ); ?>">Discovery</label>
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['payment-cirr'], true ); ?> id="<?php echo $this->get_field_id( 'payment-cirr' ); ?>" name="<?php echo $this->get_field_name( 'payment-cirr' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'payment-cirr' ); ?>">Cirrus</label>
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['payment-maes'], true ); ?> id="<?php echo $this->get_field_id( 'payment-maes' ); ?>" name="<?php echo $this->get_field_name( 'payment-maes' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'payment-maes' ); ?>">Maestro Card</label>
                </p>
                 <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'payment-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'payment-footdesc' ); ?>"><?php echo $instance['payment-footdesc']; ?></textarea></p>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_payments_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_payments_load_widgets() {
	register_widget( 'tf_payments_widget' );
}

?>