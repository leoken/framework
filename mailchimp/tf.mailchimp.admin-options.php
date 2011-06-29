<?php

add_filter( 'tf_of_options', 'tf_mailchimp_admin_options' );

/**
 * The options for MailChimp (via the "options framework").
 * 
 * @param array $options
 * @return array
 */
function tf_mailchimp_admin_options( $options ) {
	
	$options[] = array( "name" => "MailChimp Settings",
						"type" => "heading");
						
	$options[] = array( "name" => "MailChimp API",
						"desc" => "Please enter your MailChimp API, if you need help finding it, <a href='http://kb.mailchimp.com/article/where-can-i-find-my-api-key/'>click here</a>.",
						"id" => "tf_mailchimp_api_key",
						"std" => "",
						"type" => "text");

	return $options;
}