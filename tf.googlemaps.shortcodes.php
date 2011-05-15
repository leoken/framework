<?php
/* ------------------- THEME FORCE ----------------------*/

// SHORTCODE: GOOGLE MAPS
//***********************************************

function tf_googlemaps ( $atts ) {

    extract(shortcode_atts(array(
         'width' => '578',
         'height' => '200',
         'color' => 'green',
         'zoom' => '13',
         'align' => 'center'
     ), $atts));

    ob_start();

    $address = get_option('pubforce_biz_address');
    $address_url = preg_replace('/[^a-zA-Z0-9_ -]/s', '+', $address)
    ?>
    <img class="align<?php echo $align; ?> tf-googlemaps" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $address_url; ?>&zoom=<?php echo $zoom; ?>&size=<?php echo $width; ?>x<?php echo $height; ?>&markers=color:<?php echo $color; ?>|<?php echo $address_url; ?>&sensor=false">
    <?php

    $output = ob_get_contents();
    ob_end_clean();
    return $output;

    }

add_shortcode('tf-googlemaps', 'tf_googlemaps');
?>