<?php

/*
 * Theme Force Framework
 *
 */
 
define( 'TF_PATH', dirname( __FILE__ ) );
define( 'TF_URL', str_replace( ABSPATH, get_bloginfo('url') . '/', TF_PATH ) );

//Food Menu
require_once( TF_PATH . '/food-menu/tf.food-menu.php' );

//Events
require_once( TF_PATH . '/events/tf.events.php' );

//Options Framework
define('OF_FILEPATH', STYLESHEETPATH );
define('OF_DIRECTORY', TF_URL . '/options-framework' );
	
require_once ( TF_PATH . '/options-framework/admin/admin-functions.php');		// Custom functions and plugins
require_once ( TF_PATH . '/options-framework/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)