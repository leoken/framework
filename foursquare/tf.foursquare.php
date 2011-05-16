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
    $api_response = wp_remote_get($fs_url);
    $json = wp_remote_retrieve_body($api_response);
    $json = json_decode($json);

    // - data -
    return $json;   
}

function tf_foursquare_transient() {

    // - get transient -
    $json = get_transient('tf_foursquare_json');

    // - refresh transient -
    if ( false == $json ) {
        $json = tf_foursquare_api();
		set_transient('tf_foursquare_json', $json, 180);
    }

    // - data -
    return $json;
}
