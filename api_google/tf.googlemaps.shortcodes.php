<?php
// Output Linked Google Map (with Schema)

function tf_googlemaps ( $atts ) {

    extract(shortcode_atts(array(
         'width' => '578',
         'height' => '200',
         'color' => 'green',
         'zoom' => '13',
         'align' => 'center'
     ), $atts));

    ob_start();
    
    // Grab Addresss Data
    
    $new_address = get_option('tf_address_street') . ', ' . get_option('tf_address_locality') . ', ' . get_option('tf_address_postalcode') . ' ' . get_option('tf_address_region') . ' ' . get_option('tf_address_country');
    
    // Choose
    
    if (get_option('tf_address_street') . get_option('tf_address_country') !== '')
    {
        $valid_address = $new_address;    
    } else {
        $valid_address = get_option('tf_business_address');
    }
    
    $address_url = preg_replace('/[^a-zA-Z0-9_ -]/s', '+', $valid_address);

    // Display ?>

    <span itemprop="maps"><a href="<?php echo 'http://maps.google.com/maps?q=' . $address_url; ?>" target="_blank"><img class="align<?php echo $align; ?> tf-googlemaps" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $address_url; ?>&zoom=<?php echo $zoom; ?>&size=<?php echo $width; ?>x<?php echo $height; ?>&markers=color:<?php echo $color; ?>|<?php echo $address_url; ?>&sensor=false"></a></span>
    
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;

    }

add_shortcode('tf-googlemaps', 'tf_googlemaps');
?>