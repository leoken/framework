<?php

// Grab qype API Data

require_once( dirname( __FILE__ ) . '/tf.qype.admin-options.php' );

function tf_get_qype_api_xml() {

    $api_key = get_option('tf_qype_api_key');
    $api_place = get_option('tf_qype_place');
	// Consider adding language option for reviews

    $api_response = wp_remote_get("http://api.qype.com/v1/places/{$api_place}?consumer_key={$api_key}");
    $qype_response = wp_remote_retrieve_body($api_response);
	
	$xml_object = new SimpleXMLElement( $qype_response );
	
	//error checking
	if( isset( $xml_object->status->code ) )
		return new WP_Error( (int) $xml_object->status->code, (string) $xml_object->status->error );
	
    return $qype_response;
}

function tf_qype_transient() {

    // - get transient -
    $wp_xml = get_transient('tf_qype_xml');
	
	
    // - refresh transient -
    if ( !$wp_xml ) {
        $wp_xml = tf_get_qype_api_xml();
        set_transient('tf_qype_xml', $wp_xml, 180);
	}
	
    // - data -
    if( is_wp_error( $wp_xml ) )
    	$xml = $wp_xml;
    else if( $wp_xml )
		$xml = new SimpleXMLElement($wp_xml);
	else
		$xml = new WP_Error( 'no-xml-present', 'No XML was returned from the API' );
		
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

    ob_start();
    
    echo '<!-- qype bar -->';
    
    if (get_option('tf_qype_enabled') == 'true') {

        $qype = tf_qype_transient();
        if( !$qype )
            {
            return;
            } else {
        	echo '<div id="qypebar">';
        	echo '<div id="qypecontent" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
        	echo '<div class="qypeimg"><a href="' . $qype->link[1][href] . '" target="_blank">';
        	echo '<img src ="' . TF_URL . '/assets/images/qype_logo.jpg" alt="qype"></a></div>';
		echo '<div class="qypetext">' . __('users have rated our establishment', 'themeforce') . '</div>';
        	echo '<a href="' . $qype->link[1][href] . '" target="_blank">';
	        echo '<div class="qypeimg"><span itemprop="ratingValue" content="' . $qype->average_rating . '"><img src="' . TF_URL . '/assets/images/qype_stars_' . $qype->average_rating . '.jpg" alt="' . $qype->average_rating . '" style="padding-top:7px;" alt="Qype Rating" /></span><meta itemprop="bestRating" content="5" /></div>';
        	echo '</a></div></div>';
            }
        } else {
            echo '<!-- qype bar disabled (see theme options) -->'; 
        }

    echo '<!-- / qype bar -->'; 
    
    $output = ob_get_contents();
    ob_end_clean();    
    echo $output;
};

add_action('tf_body_top','tf_qype_bar', 12);
?>