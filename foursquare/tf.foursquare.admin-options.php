<?php

add_filter( 'tf_of_options', 'tf_foursquare_admin_options' );

/**
 * The options for forsquare (via the "options framework").
 * 
 * @param array $options
 * @return array
 */
function tf_foursquare_admin_options( $options ) {

	$options[] = array( 
		"name" => "foursquare Settings",
		"type" => "heading"
	);
	
	$options[] = array( 
		"name" => "Venue ID",
		"desc" => "If your profile URL is http://foursquare.com/venue/12345, then your Venue ID is 12345",
		"id" => "tf_fsquare_venue_id",
		"std" => "",
		"type" => "text"
	);
	
	$options[] = array( "name" => "Client ID",
		"desc" => "Request API access here, register <a href='https://foursquare.com/oauth/' target='_blank'>here</a>. Callback URL does not matter for the Venues APIv2 we'll be using.",
		"id" => "tf_fsquare_client_id",
		"std" => "",
		"type" => "text"
	);
	
	$options[] = array( "name" => "Client Secret",
		"desc" => "Request API access here, register <a href='https://foursquare.com/oauth/' target='_blank'>here</a>. Callback URL does not matter for the Venues APIv2 we'll be using.",
		"id" => "tf_fsquare_client_secret",
		"std" => "",
		"type" => "text"
	);

	return $options;
}