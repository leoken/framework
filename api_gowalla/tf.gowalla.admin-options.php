<?php

add_filter( 'tf_of_options', 'tf_gowalla_admin_options' );

/**
 * The options for gowalla (via the "options framework").
 * 
 * @param array $options
 * @return array
 */
function tf_gowalla_admin_options( $options ) {

	$options[] = array( 
		"name" => "Gowalla Settings",
		"type" => "heading"
	);
	
	$options[] = array( 
		"name" => "Spot ID",
		"desc" => "If your profile URL is http://gowalla.com/spots/12345, then your Spots ID is 12345",
		"id" => "tf_gowalla_spot_id",
		"std" => "",
		"type" => "text"
	);
	
	$options[] = array( "name" => "API Key",
		"desc" => "Request API access here, register <a href='http://gowalla.com/api/keys' target='_blank'>here</a>. Callback URL does not matter for the API we'll be using.",
		"id" => "tf_gowalla_api_key",
		"std" => "",
		"type" => "text"
	);

	return $options;
}