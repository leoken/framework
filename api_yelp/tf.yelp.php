<?php

// Grab Yelp Options

require_once( dirname( __FILE__ ) . '/tf.yelp.admin-options.php' );



// Grab API

function tf_yelp_api() {

    $api_key = get_option('tf_yelp_api_key');
    $api_phone = get_option('tf_yelp_phone');
    $api_cc = get_option('tf_yelp_country_code');

    $api_response = wp_remote_get("http://api.yelp.com/phone_search?phone={$api_phone}&cc={$api_cc}&ywsid={$api_key}");
    $yelpfile = wp_remote_retrieve_body($api_response);
    $yelp = json_decode($yelpfile);
	
	//error checking
	if( !isset( $yelp->message->code ) || $yelp->message->code != 0 )
		return null;
	
    return $yelp;
}

// Store API Data

function tf_yelp_transient() {

    // - get transient -
    $json = get_transient('themeforce_yelp_json');

    // - refresh transient -
    if ( !$json ) {
        $json = tf_yelp_api();
        set_transient('themeforce_yelp_json', $json, 180);
	}

    // - data -
    return $json;
}


/**
 * Delete & Update the Transient upon settings update.
 * 
 */
function tf_delete_yelp_transient_on_update_option() {
	
	delete_transient( 'themeforce_yelp_json' );
}
add_action( 'update_option_tf_yelp_api_key', 'tf_delete_yelp_transient_on_update_option' );
add_action( 'update_option_tf_yelp_phone', 'tf_delete_yelp_transient_on_update_option' );
add_action( 'update_option_tf_yelp_country_code', 'tf_delete_yelp_transient_on_update_option' );

/* - YELP BAR -
* ---------------------------------------------
*  - Follows Yelp Display Requirements
*  - Schema enhanced now ( Thing > Intangible > Rating > AggregateRating )
*/

function tf_yelp_bar() {
    
    ob_start();
    
    echo '<!-- yelp bar -->';
    
    if (get_option('tf_yelp_enabled') == 'true') {

        $yelp = tf_yelp_transient();

        if( !$yelp )
            {
            return;
            } else {
                // Shows Response Code for Debugging (as HTML Comment)
                echo '<!-- Yelp Response Code: ' . $yelp->message->text . ' - ' . $yelp->message->code . ' - ' . $yelp->message->version . ' -->';
                echo '<div id="yelpbar">';
                echo '<div id="yelpcontent" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
                // Display Requirement: Follow Link back to Yelp.com
                echo '<div class="yelpimg"><a href="http://www.yelp.com">';
                echo '<img src ="' . TF_URL . '/assets/images/yelp_logo_50x25.png" alt="Yelp">';
                echo '</a></div>';
                // Show Venue specific details
                echo '<div class="yelptext">' . __('users have rated our establishment', 'themeforce') . '</div>';
                echo '<a href="' . $yelp->businesses[0]->url . '">';
                echo '<div class="yelpimg"><span itemprop="ratingValue" content="' . $yelp->businesses[0]->avg_rating . '"><img src="' . $yelp->businesses[0]->rating_img_url . '" alt="' . $yelp->businesses[0]->avg_rating . '" style="padding-top:7px;" alt="Yelp Rating" /></span><meta itemprop="bestRating" content="5" /></div>';
                echo '</a>';
                echo '<div class="yelptext">' . __('through', 'themeforce') . '</div>';
                echo '<div class="yelptext"><a href="' . $yelp->businesses[0]->url . '" target="_blank">';
                echo '<span itemprop="ratingCount">' . $yelp->businesses[0]->review_count . '</span>&nbsp;' . __( 'Reviews', 'themeforce' );
                echo '</a></div></div></div>';
            }
        } else {
            echo '<!-- yelp bar disabled (see theme options) -->'; 
        }

    echo '<!-- / yelp bar -->';    
        
    $output = ob_get_contents();
    ob_end_clean();    
    echo $output;
};

add_action('tf_body_top','tf_yelp_bar', 12);