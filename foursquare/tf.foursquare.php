<?php
// - FOURSQUARE TRANSIENTS -
//---------------------------------------------

require_once( dirname( __FILE__ ) . '/tf.foursquare.admin-options.php' );

/**
 * Retrieves the foursquare response.
 * 
 * @return object - JSON
 */
function tf_foursquare_api() {

    // - setup -
    $fs_api = 'https://api.foursquare.com/v2/venues/';

    $fs_venue = get_option('tf_fsquare_venue_id');
    $fs_id = '?client_id=' . get_option('tf_fsquare_client_id');
    $fs_secret = '&client_secret=' . get_option('tf_fsquare_client_secret');
    $fs_url = $fs_api . $fs_venue . $fs_id . $fs_secret;

    // - response -

    $api_response = wp_remote_get($fs_url, array( 'timeout' => 30, '_wp_http_get_object' => false, 'sslverify' => false  ));
	
	if( is_wp_error( $api_response ) )
		return $api_response;
	
    $json = wp_remote_retrieve_body($api_response);
    
    $response = json_decode($json);

	// error checking    
    if( !isset( $response->meta->code ) || $response->meta->code != 200 )
		return new WP_Error( 'fs-not-200', 'Foursquare did not return a valid code, returned: ' . $response->meta->code );
	
    return $response;
}

/**
 * Gets the foursquare data transient (lasts 180 seconds).
 * 
 * @return object
 */
function tf_foursquare_transient() {

    // - get transient -
    $json = get_transient('tf_foursquare_json');

    // - refresh transient - 
    if ( !$json ) {
        $json = tf_foursquare_api();
		
		if( !empty( $json ) && !is_wp_error( $json ) )
			set_transient('tf_foursquare_json', $json, 180);
    }
    return $json;
}

/**
 * If the Foursquare options are changed, we need to remove teh transient to there is no overlap of incorrect data
 * 
 */
function tf_delete_forsquare_transient_on_update_option() {
	
	delete_transient( 'tf_foursquare_json' );
}
add_action( 'update_option_tf_fsquare_venue_id', 'tf_delete_forsquare_transient_on_update_option' );
add_action( 'update_option_tf_fsquare_client_id', 'tf_delete_forsquare_transient_on_update_option' );
add_action( 'update_option_tf_fsquare_client_secret', 'tf_delete_forsquare_transient_on_update_option' );
