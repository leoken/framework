<?php
// - GOWALLA TRANSIENTS -
// (currently for Spots only)
//---------------------------------------------

require_once( dirname( __FILE__ ) . '/tf.gowalla.admin-options.php' );

function tf_gowalla_api_photos() {

	// - setup -
	
	$spotid = get_option('tf_gowalla_spot_id');
	$apikey	= get_option('tf_gowalla_api_key');
	$apiserver = 'http://api.gowalla.com/'; 
	
	// - response -
	
	$url = $apiserver . 'spots/' . $spotid . '/photos';

	$args = array(
		'headers' => array(
		'X-Gowalla-API-Key' => $apikey,
		'Content-type' => 'application/json',
		'Accept' => 'application/json'
		)
	);
	$api_response = wp_remote_request( $url, $args );
	
	if( is_wp_error( $api_response ) )
		return $api_response;
	
    $json = wp_remote_retrieve_body($api_response);
    
    $response = json_decode($json);
	
	return $response;

	// - error checking -
	
	/* 
	
	Errors ( http://gowalla.com/api/docs#responses ):
		200: Success (upon a successful GET, PUT, or DELETE request)
		201: Created (upon a successful POST request)
		400: Resource Invalid (improperly-formatted request)
		401: Unauthorized (incorrect or missing authentication credentials)
		404: Resource Not Found (requesting a non-existent user, spot, or other resource)
		405: Method Not Allowed (e.g., trying to POST to a URL that responds only to GET)
		406: Not Acceptable (server can’t satisfy the Accept header specified by the client)
		500: Application Error
		
		*/

}

/**
 * Gets the Gowalla data transient (lasts 180 seconds).
 * 
 * @return object
 */
function tf_gowalla_photos_transient() {

    // - get transient -
    $json = get_transient('tf_gowalla_photos_json');

    // - refresh transient - 
    if ( !$json ) {
        $json = tf_gowalla_api_photos();
		
		if( !empty( $json ) && !is_wp_error( $json ) )
			set_transient('tf_gowalla_photos_json', $json, 180);
    }
    return $json;
}

/**
 * If the Gowalla options are changed, we need to remove teh transient to there is no overlap of incorrect data
 * 
 */
function tf_delete_gowalla_photos_transient_on_update_option() {
	
	delete_transient( 'tf_gowalla_photos_json' );
}
add_action( 'update_option_tf_gowalla_api_key', 'tf_delete_gowalla_photos_transient_on_update_option' );
add_action( 'update_option_tf_gowalla_spot_id', 'tf_delete_gowalla_photos_transient_on_update_option' );