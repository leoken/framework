<?php

// Grab qype API Data

require_once( dirname( __FILE__ ) . '/tf.qype.admin-options.php' );

function tf_qype_api() {

    $api_key = get_option('tf_qype_api_key');
    $api_place = get_option('tf_qype_place');
	// Consider adding language option for reviews

    $api_response = wp_remote_get("http://api.qype.com/v1/places/{$api_place}?consumer_key={$api_key}");
    $qypefile = wp_remote_retrieve_body($api_response);
	$qype = new SimpleXMLElement($qypefile);
	
	//error checking
	if( isset( $qype->fat_response->status->code ))
		return null;
	
    return $qype;
}

function tf_qype_transient() {

    // - get transient -
    $xml = get_transient('tf_qype_xml');

    // - refresh transient -
    if ( !$xml ) {
        $xml = tf_qype_api();
        set_transient('tf_qype_xml', $xml, 180);
	}

    // - data -
    return $xml;
}

/**
 * Delete & Update the Transient upon settings update.
 * 
 */
function tf_delete_qype_transient_on_update_option() {
	
	delete_transient( 'tf_qype_xml' );
}
add_action( 'update_option_tf_qype_api_key', 'tf_delete_qype_transient_on_update_option' );
add_action( 'update_option_tf_qype_place', 'tf_delete_qype_transient_on_update_option' );


/* - QYPE BAR -
* ---------------------------------------------
*  - Follows Qype Display Requirements
*  - Schema enhanced now ( Thing > Intangible > Rating > AggregateRating )
*/

function tf_qype_bar() {

    $qype = tf_qype_transient();
    
    if( !$qype )
    	return;

    ob_start();
        // Shows Response Code for Debugging (as HTML Comment)
        echo '<div id="qypebar">';
        echo '<div id="qypecontent" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
        // Display Requirement: Follow Link back to qype.com
        echo '<div class="qypeimg"><a href="http://www.qype.com">';
        echo '<img src ="' . TF_URL . '/assets/images/qype_logo.jpg" alt="qype">';
        echo '</a></div>';
        // Show Venue specific details
        echo '<div class="qypetext">' . __('users have rated our establishment', 'themeforce') . '</div>';
        echo '<a href="' . $qype->url . '">';
        echo '<div class="qypeimg"><span itemprop="ratingValue" content="' . $qype->average_rating . '"><img src="' . TF_URL . '/assets/images/qype_stars_' . $qype->average_rating . '.jpg" alt="' . $qype->average_rating . '" style="padding-top:7px;" alt="Qype Rating" /></span><meta itemprop="bestRating" content="5" /></div>';
        echo '</a>';
        echo '</div></div>';
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
};
