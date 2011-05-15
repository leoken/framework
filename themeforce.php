<?php

/*
 * Theme Force Framework
 *
 */
 
define( 'TF_PATH', dirname( __FILE__ ) );
define( 'TF_URL', str_replace( ABSPATH, get_bloginfo('url') . '/', TF_PATH ) );

//Food Menu
if( current_theme_supports( 'tf_food_menu' ) )
	require_once( TF_PATH . '/food-menu/tf.food-menu.php' );

//Events
if( current_theme_supports( 'tf_events' ) )
	require_once( TF_PATH . '/events/tf.events.php' );

//Widgets
require_once( TF_PATH . '/widgets/newsletter-widget.php' );

if( current_theme_supports( 'tf_widget_opening_times' ) )
	require_once( TF_PATH . '/widgets/widget-openingtimes.php' );

if( current_theme_supports( 'tf_widget_google_maps' ) )
	require_once( TF_PATH . '/widgets/widget-googlemaps.php' );

//Google Maps
require_once( TF_PATH . '/tf.googlemaps.shortcodes.php' );

//Options Framework
define('OF_FILEPATH', STYLESHEETPATH );
define('OF_DIRECTORY', TF_URL . '/options-framework' );
	
require_once ( TF_PATH . '/options-framework/admin/admin-functions.php');		// Custom functions and plugins
require_once ( TF_PATH . '/options-framework/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/**
 * Enqueue the admin styles for themeforce features.
 * 
 */
function tf_enqueue_admin_css() {
	wp_enqueue_style('tf-functions-css', TF_URL . '/assets/css/admin.css');
}
add_action('admin_init', 'tf_enqueue_admin_css');