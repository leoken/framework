<?php

// Output Business Address (in Schema)
// Use in templates: do_shortcode('[tf-address]');

function tf_shortcode_address()
{
	$streetaddress = get_option('tf_address_street');
	$locality = get_option('tf_address_locality');
	$region = get_option('tf_address_region');
	$postalcode = get_option('tf_address_postalcode');
	$country = get_option('tf_address_country');
		
	ob_start(); 
	if ($streetaddress != '')
        {
            echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" style="display:inline">';
                    echo '<span itemprop="streetAddress">' . $streetaddress . '</span>';
                    if ($locality != '') { echo ', <span itemprop="addressLocality">' . $locality . '</span> ';}
                    if ($postalcode != '') { echo ', <span itemprop="postalCode">' . $postalcode . '</span>';}      
                    if ($region != '') { echo '<span itemprop="addressRegion">' . $region . '</span>';}
                    if ($country != '') { echo ', <span itemprop="postalCode">' . $country . '</span>';}
            echo '</div>';
        } else {
            // Fallback - Pre 3.2.2
            echo get_option('tf_business_address');
        }
               
        $output = ob_get_contents();
        ob_end_clean();
        return $output;	
}

add_shortcode( 'tf-address', 'tf_shortcode_address' );

// Output Phone Number (in Schema)
// Use in templates: do_shortcode('[tf-phone]');

function tf_shortcode_phone()
{
	$phone = get_option('tf_business_phone');
	$output = '<span itemprop="telephone">' . $phone . '</span>';
	return $output;
}

add_shortcode( 'tf-phone', 'tf_shortcode_phone' );
	
?>