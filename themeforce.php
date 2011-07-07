<?php /*

Theme-Force.com - WordPress Framework (v 3.2.1)
===================================================

Introduction
------------

The Theme Force Framework is the most comprehensive solution for restaurant websites based on WordPress. It is
structured as a modular feature-set highly relevant to industry needs.

Resources
---------

Developer Homepage: 	http://www.theme-force.com/developers
GitHub Homepage: 		https://github.com/themeforce/framework
Discussion & News: 		http://www.facebook.com/pages/Theme-Force/111741295576685

 /* Definitions
=========================================*/
 
define( 'TF_DIR_SLUG', end( explode( DIRECTORY_SEPARATOR, dirname( __FILE__ ) ) ) );
define( 'TF_PATH', dirname( __FILE__ ) );
define( 'TF_URL', get_bloginfo( 'template_directory' ) . '/' . TF_DIR_SLUG );


/* Theme Force Core Tools
=========================================*/

// Template Hooks
	require_once( TF_PATH . '/core_general/tf.template-hooks.php' );
	
// Common Assets
	require_once( TF_PATH . '/core_general/tf.assets.php' );	

// Food Menu
if( current_theme_supports( 'tf_food_menu' ) )
	require_once( TF_PATH . '/core_food-menu/tf.food-menu.php' );

// Events
if( current_theme_supports( 'tf_events' ) )
	require_once( TF_PATH . '/core_events/tf.events.php' );
	
// Google Maps
	require_once( TF_PATH . '/api_google/tf.googlemaps.shortcodes.php' );

// Schema Functions
	require_once( TF_PATH . '/core_seo/tf.schema.php' );
	
// Widgets
	require_once( TF_PATH . '/core_widgets/newsletter-widget.php' );

if( current_theme_supports( 'tf_widget_opening_times' ) )
	require_once( TF_PATH . '/core_widgets/widget-openingtimes.php' );

if( current_theme_supports( 'tf_widget_google_maps' ) )
	require_once( TF_PATH . '/core_widgets/widget-googlemaps.php' );
	
if( current_theme_supports( 'tf_widget_payments' ) )
	require_once( TF_PATH . '/core_widgets/widget-payments.php' );


	
/* 3rd Party Tools
=========================================*/

// WP Thumb
	require_once( TF_PATH . '/wpthumb/wpthumb.php' ); 
	require_once( TF_PATH . '/tf.rewrite.php' );
	
// Options Framework
	define('OF_FILEPATH', STYLESHEETPATH );
	define('OF_DIRECTORY', TF_URL . '/options-framework' );

	require_once( TF_PATH . '/options-framework/admin/admin-options.php' );
	require_once( TF_PATH . '/options-framework/admin/admin-functions.php');		// Custom functions and plugins
	require_once( TF_PATH . '/options-framework/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)	

/* SEO & Semantic Connections
=========================================*/	
	
// Facebook Open Graph Protocol
	require_once( TF_PATH . '/core_seo/tf.open_graph_protocol.php' );


/* API Connections
=========================================*/	

// Foursquare
if( current_theme_supports( 'tf_foursquare' ) ) {
	require_once( TF_PATH . '/api_foursquare/tf.foursquare.php' ); 
	require_once( TF_PATH . '/core_widgets/widget-foursquare-photos.php' );
	require_once( TF_PATH . '/core_widgets/widget-foursquare-tips.php' );
	/* require_once( TF_PATH . '/widgets/widget-foursquare-herenow.php' ); WIP */
}

// Yelp
if( current_theme_supports( 'tf_yelp' ) ) {
	require_once( TF_PATH . '/api_yelp/tf.yelp.php' );
}

// Qype
if( current_theme_supports( 'tf_qype' ) ) {
	require_once( TF_PATH . '/api_qype/tf.qype.php' );
}

// Gowalla
if( current_theme_supports( 'tf_gowalla' ) ) {
	// photos
	require_once( TF_PATH . '/api_gowalla/tf.gowalla.api-photos.php' );
	require_once( TF_PATH . '/core_widgets/widget-gowalla-photos.php' );
	// checkins
	require_once( TF_PATH . '/api_gowalla/tf.gowalla.api-checkins.php' );
	require_once( TF_PATH . '/core_widgets/widget-gowalla-checkins.php' );
}
// MailChimp
if( current_theme_supports( 'tf_mailchimp' ) )
	require_once( TF_PATH . '/api_mailchimp/mailchimp-widget.php' );
	
	
/* Add TF options to Options Framework
=========================================*/	

add_filter('tf_of_options','tf_of_business_options', 8);
function tf_of_business_options( $options ) {

	$shortname = "tf";
	
	// GENERAL BUSINESS OPTIONS
	// -----------------------------------------------------------------
	
	$options[] = array( "name" => "Business Options",
						"type" => "heading");
	
	$options[] = array( "name" => "Business Name",
						"desc" => "This is used within the Address HTML tags too, so make sure it's correct",
						"id" => $shortname."_business_name",
						"std" => "Your Business Name",
						"type" => "text");
	
	$options[] = array( "name" => "Address",
						"desc" => "It's always worth checking against <a href='http://maps.google.com'>Google Maps</a> to see if it is an address search engines can recognize.",
						"id" => $shortname."_business_address",
						"std" => "Please enter your address here.",
						"type" => "text");
	
	$options[] = array( "name" => "Phone Number",
						"desc" => "Your business phone number.",
						"id" => $shortname."_business_phone",
						"std" => "(123) 456 789",
						"type" => "text");
						
	$options[] = array( 
						"name" => "Fax Number",
						"desc" => "Your business fax number (if you have one).",
						"id" => $shortname."_business_fax",
						"std" => "",
						"type" => "text");
	
	// new 3.2.2	
	$options[] = array( "name" => "Description",
						"desc" => "A short description of the location.",
						"id" => $shortname."_business_description",
						"std" => "(123) 456 789",
						"type" => "text");
	
	if( get_current_theme() == 'Chowforce' ) {
		$options[] = array( "name" => "Short Contact Info",
							"desc" => "Visible contact information in the top-right corner (you can also leave blank)",
							"id" => "chowforce_biz_contactinfo",
							"std" => "Call us at +01 (02) 123 57 89",
							"type" => "text");
	}
	
	$options[] = array( "name" => "Menu Currency",
						"desc" => "Please enter your currency symbol or 3-letter code, whichever looks better to you. Is used for the menu.",
						"id" => "tf_currency_symbol",
						"std" => "$",
						"type" => "text");
	
	$options[] = array( "name" => "Show currency for menu prices by default?",
						"desc" => "Otherwise you will need to set it manually by using the shortcode variable",
						"id" => "tf_menu_currency_symbol",
						"std" => "false",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Use advanced sort functionality for Menu?",
						"desc" => "If you don't use the advanced sort, menu items will be sorted alphabetically. ", //See <a href='http://'>this tutorial</a>for more information
						"id" => "tf_menu_sort_key",
						"std" => "false",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Facebook Link",
						"desc" => "Icon will show automatically once a link entered.",
						"id" => $shortname."_facebook",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Twitter Link",
						"desc" => "Icon will show automatically once a link entered.",
						"id" => $shortname."_twitter",
						"std" => "",
						"type" => "text");
		
	$options[] = array( "name" => "Terminal Footer Text",
						"desc" => "This is a great place to put any Copyright Information or other short pieces of text",
						"id" => $shortname."_terminalnotice",
						"std" => "Terminal Footer Text",
						"type" => "text");
						
	$options[] = array( "name" => "Tracking Code",
						"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
						"id" => $shortname."_google_analytics",
						"std" => "",
						"type" => "textarea"); 
	
	// LOCATION OPTIONS
	// -----------------------------------------------------------------
	
	$options[] = array( "name" => "Location Details",
						"type" => "heading");					

	// Requires valid Google Maps API Key to be called in Header
						
	$options[] = array( "name" => "Picker",
						"desc" => "Pick your location",
						"id" => $shortname."_googlemapspicker",
						"std" => "",
						"type" => "googlemapspicker");

	return $options;
}

// Datepicker JS

function tf_sortable_admin_rows_scripts() {
	wp_enqueue_script('ui-datepicker-settings', TF_URL . '/assets/js/themeforce-admin.js', array('jquery'));

}
add_action( 'admin_print_scripts-edit.php', 'tf_sortable_admin_rows_scripts' );


/* Food Menu Sorting
=========================================*/	

function tf_sortable_admin_rows_order_table_rows_hook() {
	if( !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'tf_foodmenu' && !empty( $_GET['term'] ) )
		add_action( 'parse_query', 'tf_sortable_admin_rows_order_table_rows' );
}
add_action( 'load-edit.php', 'tf_sortable_admin_rows_order_table_rows_hook' );

function tf_sortable_admin_rows_order_table_rows( $wp_query ) {
	global $wpdb;
	$wp_query->query_vars['orderby'] = 'menu_order';
	$wp_query->query_vars['order'] = 'ASC';
}

function tf_sortable_admin_rows_column( $columns ) {

	if( !isset( $columns['tf_col_menu_cat'] ) || empty( $_GET['term'] ) )
		return $columns;
	
	$columns['tf_sortable_column'] = '';
	
	return $columns;
}
add_action( 'manage_edit-tf_foodmenu_columns', 'tf_sortable_admin_rows_column', 11 );

function tf_sortable_admin_row_cell( $column ) {
	
	if( $column != 'tf_sortable_column' )
		return $column;
	?>
	
	<a class="tf_sortable_admin_row_handle"></a>
	
	<?php
}
add_action( 'manage_posts_custom_column', 'tf_sortable_admin_row_cell' );

function tf_sortable_admin_row_request() {
	
	global $wpdb;
	
	foreach( (array) $_POST['posts'] as $key => $post_id ) {
		$wpdb->update( $wpdb->posts, array( 'menu_order' => $key ), array( 'ID' => $post_id ) );
	}
		
	exit;
}
add_action( 'wp_ajax_tf_sort_admin_rows', 'tf_sortable_admin_row_request' );


/* Theme Force Upgrade Tools
=========================================
   You won't require this for a fresh install
*/	

//upgrader from 2.x - 3.0 -> 3.2
	require_once( TF_PATH . '/tf.upgrade.php' );  	


/* Remaining Functions
=========================================*/	

// Enqueue Admin Styles
 
function tf_enqueue_admin_css() {
	wp_enqueue_style('tf-functions-css', TF_URL . '/assets/css/admin.css');
}
add_action('admin_init', 'tf_enqueue_admin_css');

// Add Widget Styling within Widget Admin Area
 
function tf_add_tf_icon_classes_to_widgets() {
	?>
	 <script type="text/javascript">
     	jQuery( document ).ready( function() {
    		
     		jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '_tf' ) > 1 )
					jQuery( object ).addClass('tf-admin-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '-gowalla-' ) > 1 )
					jQuery( object ).addClass('tf-gowalla-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '-fs-' ) > 1 )
					jQuery( object ).addClass('tf-fs-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '_mailchimp-' ) > 1 )
					jQuery( object ).addClass('tf-mailchimp-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( 'googlemaps' ) > 1 )
					jQuery( object ).addClass('tf-google-widget');
     		} );
     		
     	} );
     </script>
     
     <style text="text/css">
     	/* ThemeForce Icon */
		/* .tf-admin-widget .widget-top { background-image: url(<?php echo TF_URL ?>/assets/images/ui/icon-themeforce-18.png); background-repeat: no-repeat; background-position: 213px center; } */
		.tf-gowalla-widget.ui-draggable .widget-top { background-image: url(<?php echo TF_URL ?>/assets/images/ui/icon-gowalla-20.png) ; background-repeat: no-repeat; background-position: 175px center; }
		.tf-fs-widget.ui-draggable .widget-top { background-image: url(<?php echo TF_URL ?>/assets/images/ui/icon-fs-20.png) ; background-repeat: no-repeat; background-position: 175px center; }
		.tf-mailchimp-widget.ui-draggable .widget-top { background-image: url(<?php echo TF_URL ?>/assets/images/ui/icon-mailchimp-20.png) ; background-repeat: no-repeat; background-position: 175px center; }
		.tf-google-widget.ui-draggable .widget-top { background-image: url(<?php echo TF_URL ?>/assets/images/ui/icon-googlemaps-20.png) ; background-repeat: no-repeat; background-position: 145px center; }
     </style>
	<?php
}
add_action( 'in_admin_footer', 'tf_add_tf_icon_classes_to_widgets' );