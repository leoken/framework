<?php

/* 
Schema.org
----------
Spec used here: http://schema.org/FoodEstablishment

This component is for the general details of the business. Events are handled through their own templates.

*/

// TODO Need to create template hooks

// Generate Schema Microdata

function tf_schema_headermeta() {
	
	// get options
	
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
		<meta itemprop="name" content="<?php echo $name; ?>" />
		<meta itemprop="url" content="<?php echo $url; ?>" />
		<meta itemprop="description" content="<?php echo $description; ?>" />
		<meta itemprop="telephone" content="<?php echo $telephone; ?>" />
		<meta itemprop="fax" content="<?php echo $fax; ?>" />
		<!-- address -->
		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<meta itemprop="streetAddress" content="<?php echo $streetaddress; ?>" />
			<meta itemprop="addressLocality" content="<?php echo $locality; ?>" />
			<meta itemprop="addressRegion" content="<?php echo $region; ?>" />
			<meta itemprop="postalCode" content="<?php echo $postalcode; ?>" />
		</div>
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
        $schemameta = tf_schema_headermeta();
        set_transient('themeforce_schema_meta', $schemameta, 3600);
	}

    // - data -
    return $schemameta;
}

?>