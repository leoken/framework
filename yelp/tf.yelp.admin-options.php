<?php

add_filter( 'tf_of_options', 'tf_yelp_admin_options' );

/**
 * The options for Yelp (via the "options framework").
 * 
 * @param array $options
 * @return array
 */
function tf_yelp_admin_options( $options ) {
	
	$options_yelp = array('US', 'CA', 'GB', 'IE', 'FR', 'DE', 'AT', 'NL');
	
	$options[] = array( 
		"name" => "Yelp Settings",
	     "type" => "heading"
	);
	
	$options[] = array( 
		"name" => "Enable Yelp Bar?",
		"desc" => "This will show the Yelp bar above in line with Yelp display requirements. The fields below need to be completed in order for this to work.",
		"id" => "tf_yelp_enabled",
		"std" => "false",
		"type" => "checkbox"
	);
	
	$options[] = array( 
		"name" => "API Key",
		"desc" => "Required for Yelp Button  <a target='_blank' href='http://www.yelp.com/developers/getting_started/api_overview'>Get it from here (Yelp API)</a>",
		"id" => "tf_yelp_api_key",
		"std" => "",
		"type" => "text"
	);
	
	$options[] = array( 
		"name" => "Country",
		"desc" => "Required so that your Phone Number below can be correctly identified",
		"id" => "tf_yelp_country_code",
		"std" => "US",
		"type" => "select",
		"class" => "mini", //mini, tiny, small
		"options" => $options_yelp
	);
	
	$options[] = array( 
		"name" => "Phone number registered with Yelp",
		"desc" => "Required for Yelp Button (Used by the API to identify your business). Do not use special characters, only numbers.",
		"id" => "tf_yelp_phone",
		"std" => "",
		"type" => "text"
	);

	return $options;
}