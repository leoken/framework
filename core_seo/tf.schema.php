<?php

/*
--------------------------------------------------------------------------
Schema.org
--------------------------------------------------------------------------
Spec used here: http://schema.org/FoodEstablishment

The general concept behind the Schema structure used at Theme Force is a
modular build whereby the entire body is treated as a schema type (in this
case a Food Establishment), and various microdata is revealed with visible
content where possible.

*/

// Open

function tf_open_schema_restaurant() {
	echo '<div itemscope itemtype="http://schema.org/Restaurant">';
}

add_action('tf_body_top','tf_open_schema_restaurant', 8);

// Close

function tf_close_schema_restaurant() {
	echo '</div>';
}

add_action('tf_body_bottom','tf_close_schema_restaurant', 8);

// Special Content (i.e. not easily added inline

function tf_schema_meta() {
        echo '<!-- schema meta -->';
        echo '<meta itemprop="servesCuisine" content="' . get_option('tf_schema_cuisine') . '" />';
        echo '<meta itemprop="acceptsReservations" content="' . get_option('tf_schema_reservations') . '" />'; 
	echo '<meta itemprop="priceRange" content="' . get_option('tf_schema_pricerange') . '" />';
        echo '<!-- / schema meta -->';
}

add_action('tf_body_top','tf_schema_meta', 12);

?>