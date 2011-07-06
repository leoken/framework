<?php

add_filter( 'tf_of_options', 'tf_qype_admin_options' );

/**
 * The options for qype (via the "options framework").
 * 
 * @param array $options
 * @return array
 */
function tf_qype_admin_options( $options ) {
		
	$options[] = array( 
		"name" => "Qype Settings",
	     "type" => "heading"
	);
	
	$options[] = array( 
		"name" => "Enable Qype Bar?",
		"desc" => "This will show the qype bar above in line with qype display requirements. The fields below need to be completed in order for this to work.",
		"id" => "tf_qype_enabled",
		"std" => "false",
		"type" => "checkbox"
	);
	
	$options[] = array( 
		"name" => "API Key",
		"desc" => "Required for Qype Button  <a target='_blank' href='http://www.qype.com/developers/getting_started/api_overview'>Get it from here (qype API)</a>",
		"id" => "tf_qype_api_key",
		"std" => "",
		"type" => "text"
	);
	
	$options[] = array( 
		"name" => "Phone number registered with qype",
		"desc" => "Required for qype Button (Used by the API to identify your business). Do not use special characters, only numbers.",
		"id" => "tf_qype_place",
		"std" => "",
		"type" => "text"
	);

	return $options;
}