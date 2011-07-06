<?php

/*
----------------------------------------------------------
Schema.org
----------------------------------------------------------
Spec used here: http://schema.org/FoodEstablishment

This component is for the general details of the business.
Events are handled through their own templates.

*/

// Add after Body Tag

function tf_schema_showheadermeta() {
	echo tf_schema_generateheadermeta();
}

add_action('tf_top','tf_schema_showheadermeta');

// Generate Schema Microdata

function tf_schema_generateheadermeta() {
	
	// get options
	
	// TODO still needs massive cleanup
	
	$name = get_option('tf_business_name');
	$url = get_bloginfo('siteurl');
	$description = get_option('tf_business_description');
	
	$streetaddress = get_option('tf_address_street');
	$locality = get_option('tf_address_locality');
	$region = get_option('tf_address_region');
	$postalcode = get_option('tf_address_postalcode');
	
	$telephone = get_option('tf_business_phone');
	$fax = get_option('tf_business_fax');
	
	ob_start(); ?>
	
	<!-- schema.org general business information -->
	<div itemscope itemtype="http://schema.org/LocalBusiness">
		<!-- general -->
		<?php if ($name != '') { ?><meta itemprop="name" content="<?php echo $name; ?>" /><?php } ?>
		<?php if ($url != '') { ?><meta itemprop="url" content="<?php echo $url; ?>" /><?php } ?>
		<?php if ($description != '') { ?><meta itemprop="description" content="<?php echo $description; ?>" /><?php } ?>
		<?php if ($telephone != '') { ?><meta itemprop="telephone" content="<?php echo $telephone; ?>" /><?php } ?>
		<?php if ($fax != '') { ?><meta itemprop="fax" content="<?php echo $fax; ?>" /><?php } ?>
		<!-- address -->
		<?php if ($steetaddress != '') { ?><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<?php if ($streetaddress != '') { ?><meta itemprop="streetAddress" content="<?php echo $streetaddress; ?>" /><?php } ?>
			<?php if ($locality != '') { ?><meta itemprop="addressLocality" content="<?php echo $locality; ?>" /><?php } ?>
			<?php if ($region != '') { ?><meta itemprop="addressRegion" content="<?php echo $region; ?>" /><?php } ?>
			<?php if ($postalcode != '') { ?><meta itemprop="postalCode" content="<?php echo $postalcode; ?>" /><?php } ?>
		</div><?php } ?>
	</div>  
	<!-- / schema.org general business information -->
	<?php $output = ob_get_contents();
	ob_end_clean();
	return $output;
}

// Store Schema Microdata in Transient

function tf_schema_transient() {

    // - get transient -
    $schemameta = get_transient('themeforce_schema_meta');

    // - refresh transient -
    if ( !$schemameta ) {
        $schemameta = tf_schema_generateheadermeta();
        set_transient('themeforce_schema_meta', $schemameta, 3600);
	}

    // - data -
    return $schemameta;
}

// Update Schema Microdata on Update

function tf_delete_schema_transient_on_update_option() {
	
	delete_transient( 'themeforce_schema_meta' );
	
}
add_action( 'update_option_tf_business_name', 'tf_delete_schema_transient_on_update_option' );
add_action( 'update_option_tf_address_street', 'tf_delete_schema_transient_on_update_option' );

?>