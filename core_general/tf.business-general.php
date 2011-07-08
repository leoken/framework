<?php

// Attach Tracking Code to Header

function tf_head_trackingcode ()
{
    echo stripslashes(get_option('tf_google_analytics'));    
}

add_action('tf_head_bottom','tf_head_trackingcode');

?>