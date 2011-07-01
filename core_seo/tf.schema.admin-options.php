<?php

/* 
Schema.org - General Options
----------------------------
Spec used here: http://schema.org/FoodEstablishment

Events are handled via another segment of Theme Force

*/

add_filter( 'tf_of_options', 'tf_schema_admin_options' );

// SCHEMA :  - List Values -
//========================================

$options_cuisine = array('Afghan', 'African', 'American (New)', 'American (Traditional)', 'Argentine', 'Asian Fusion', 'Barbeque', 'Basque', 'Belgian', 'Brasseries', 'Brazilian', 'Breakfast & Brunch', 'British', 'Buffets', 'Burgers', 'Burmese', 'Cafes', 'Cajun/Creole', 'Cambodian', 'Caribbean', 'Cheesesteaks', 'Chicken Wings', 'Chinese', 'Creperies', 'Cuban', 'Delis', 'Diners', 'Ethiopian', 'Fast Food', 'Filipino', 'Fish & Chips', 'Fondue', 'Food Stands', 'French', 'Gastropubs', 'German', 'Gluten-Free', 'Greek', 'Halal', 'Hawaiian', 'Himalayan/Nepalese', 'Hot Dogs', 'Hungarian', 'Indian', 'Indonesian', 'Irish', 'Italian', 'Japanese', 'Korean', 'Kosher', 'Latin American', 'Live/Raw Food', 'Malaysian', 'Mediterranean', 'Mexican', 'Middle Eastern', 'Modern European', 'Mongolian', 'Moroccan', 'Pakistani', 'Persian/Iranian', 'Peruvian', 'Pizza', 'Polish', 'Portuguese', 'Russian', 'Sandwiches', 'Scandinavian', 'Seafood', 'Singaporean', 'Soul Food', 'Soup', 'Southern', 'Spanish', 'Steakhouses', 'Sushi Bars', 'Taiwanese', 'Tapas Bars', 'Tapas/Small Plates', 'Tex-Mex', 'Thai', 'Turkish', 'Ukrainian', 'Vegan', 'Vegetarian', 'Vietnamese');

$options_pricerange = array ('$','$$','$$$','$$$$');

$options_yesno = array ('yes','no');

// SCHEMA :  - Header & On/Off -
//========================================

function tf_schema_admin_options( $options ) {

	$options[] = array( 
		"name" => "Schema Settings",
		"type" => "heading"
	);
	
	$options[] = array( 
		"name" => "Enable Schema?",
		"desc" => "Schema is a microdata format used to better describe your business to search engines (in particular; Google, Yahoo & Bing). This will contribute to more relevant search rankings.",
		"id" => "tf_schema_enabled",
		"std" => "false",
		"type" => "checkbox"
	);

// SCHEMA :  - General -
//========================================
	
	// SCHEMA :  - description - Text - A short description of the item.

		$options[] = array( 
			"name" => "Description",
			"desc" => "A short description of the location.",
			"id" => "tf_schema_description",
			"std" => "",
			"type" => "text"
		);

	// Items left out or already covered for this section:
	// ---------------------------------------------------	
		// SCHEMA :  - image - URL - URL of an image of the item.
		// SCHEMA :  - name - Text - The name of the item.
		// SCHEMA :  - url - URL - URL of the item.


// SCHEMA :  - Properties from Place - 
//======================================

	// SCHEMA :  - aggregateRating - AggregateRating - The overall rating, based on a collection of reviews or ratings, of the item.

		/* There are more variables to this: http://schema.org/AggregateRating */

		$options[] = array( 
			"name" => "Enable Yelp Rating for Schema Rating?",
			"desc" => "Schema is a microdata format used to better describe your business to search engines (in particular; Google, Yahoo & Bing). This will contribute to more relevant search rankings.",
			"id" => "tf_schema_rating",
			"std" => "false",
			"type" => "checkbox"
		);

	// SCHEMA :  - faxNumber - Text - The fax number.

		$options[] = array( 
			"name" => "Fax Number",
			"desc" => "The fax number",
			"id" => "tf_schema_fax",
			"std" => "",
			"type" => "text"
		);

	// SCHEMA :  - geo - GeoCoordinates - The geo coordinates of the place.

		$options[] = array( 
			"name" => "GeoCoordinates - Latitude",
			"desc" => "For example 37.42242",
			"id" => "tf_schema_lat",
			"std" => "",
			"type" => "text"
		);
		
		$options[] = array( 
			"name" => "GeoCoordinates - Longitude",
			"desc" => "For example -122.08585.",
			"id" => "tf_schema_long",
			"std" => "",
			"type" => "text"
		);


	// SCHEMA :  - maps - URL - A URL to a map of the place.

		$options[] = array( 
			"name" => "Map URL",
			"desc" => "URL to a map of this place",
			"id" => "tf_schema_map",
			"std" => "",
			"type" => "text"
		);

	// SCHEMA :  - photos - Photograph orImageObject - Photographs of this place.

		// TODO Schema Photos should be handled by Widgets (Foursquare & Gowalla)

	// Items left out or already covered for this section:
	// ---------------------------------------------------
		// SCHEMA :  - address - PostalAddress - Physical address of the item.
		// SCHEMA :  - events - Event - The events held at this place or organization.
		// SCHEMA :  - containedIn - Place - The basic containment relation between places.
		// SCHEMA :  - interactionCount - Text - A count of a specific user interactions with this item—for example, 20 UserLikes, 5 UserComments, or 300 UserDownloads. The user interaction type should be one of the sub types of UserInteraction.
		// SCHEMA :  - reviews - Review - Review of the item.
		// SCHEMA :  - telephone - Text - The telephone number.


// SCHEMA :  - Properties from Organization - 
//============================================

	// SCHEMA :  - email - Text - Email address.

		$options[] = array( 
			"name" => "Business E-mail",
			"desc" => "E-mail used for business purposes.",
			"id" => "tf_schema_email",
			"std" => "",
			"type" => "text"
		);

		
	// Items left out or already covered for this section:
	// ---------------------------------------------------
		// SCHEMA :  - contactPoints - ContactPoint - A contact point for a person or organization.
		// SCHEMA :  - employees - Person - People working for this organization.
		// SCHEMA :  - founders - Person - A person who founded this organization.
		// SCHEMA :  - foundingDate - Date - The date that this organization was founded.
		// SCHEMA :  - location - Place orPostalAddress - The location of the event or organization.
		// SCHEMA :  - members - Person orOrganization - A member of this organization.


// SCHEMA :  - Properties from LocalBusiness - 
//=============================================

	// SCHEMA :  - currenciesAccepted - Text - The currency accepted (in ISO 4217 currency format).

		$options[] = array( 
			"name" => "Currency Accepted",
			"desc" => "The currency accepted (in ISO 4217 currency format) - <a href='http://www.xe.com/iso4217.php' target='_blank'>See List for Codes</a>",
			"id" => "tf_schema_currency",
			"std" => "Cash, Credit Cards",
			"type" => "text"
		);

	// SCHEMA :  - openingHours - Duration - The opening hours for a business. Opening hours can be specified as a weekly time range, starting with days, then times per day. Multiple days can be listed with commas ',' separating each day. Day or time ranges are specified using a hyphen '-'.
	// SCHEMA :  -  -  - - Days are specified using the following two-letter combinations: Mo, Tu, We, Th, Fr, Sa, Su.
	// SCHEMA :  -  -  - - Times are specified using 24:00 time. For example, 3pm is specified as 15:00. 
	// SCHEMA :  -  -  - - Here is an example: <time itemprop="openingHours" datetime="Tu,Th 16:00-20:00">Tuesdays and Thursdays 4-8pm</time>. 
	// SCHEMA :  -  -  - - If a business is open 7 days a week, then it can be specified as <time itemprop="openingHours" datetime="Mo-Su">Monday through Sunday, all day</time>.

		$options[] = array( 
			"name" => "Opening Hours",
			"desc" => "The opening hours for a business. Opening hours can be specified as a weekly time range, starting with days, then times per day. Multiple days can be listed with commas ',' separating each day. Day or time ranges are specified using a hyphen '-'. Days are specified using the following two-letter combinations: Mo, Tu, We, Th, Fr, Sa, Su. Times are specified using 24:00 time. For example, 3pm is specified as 15:00. (Example: Mo-Fr 16:00-24:00,Sa 12:00-18:00 )",
			"id" => "tf_schema_openinghours",
			"std" => "Mo-Fr 16:00-24:00,Sa 12:00-18:00",
			"type" => "text"
		);
		
	// SCHEMA :  - paymentAccepted - Text - Cash, credit card, etc.

		$options[] = array( 
			"name" => "Payment Accepted",
			"desc" => "List the types of payments you accept, separate by comma.",
			"id" => "tf_schema_paymentaccepted",
			"std" => "Cash, Credit Cards",
			"type" => "text"
		);

	// SCHEMA :  - priceRange - Text - The price range of the business, for example $$$.


			$options[] = array( 
			"name" => "Price Range",
			"desc" => "US Example: Price range is the approximate cost per person for a meal including one drink, tax, and tip. We're going for averages here, folks. $ = Cheap, Under $10 * $$ = Moderate, $11 - $30 * $$$ = Spendy, $31 - $60 * $$$$ = Splurge, Above $61",
			"id" => "tf_schema_pricerange",
			"std" => "",
			"type" => "select",
			"class" => "small", //mini, tiny, small
			"options" => $options_pricerange
		);

	// Items left out or already covered for this section:
	// ---------------------------------------------------	
		// SCHEMA :  - branchOf - Organization - The larger organization that this local business is a branch of, if any.
	
	
// SCHEMA :  - Properties from FoodEstablishment -
//=================================================

	// SCHEMA :  - acceptsReservations - Text or URL - Either Yes/No, or a URL at which reservations can be made.

		$options[] = array( 
			"name" => "Accept Reservations",
			"desc" => "Do you accept reservations at all?",
			"id" => "tf_schema_reservations",
			"std" => "",
			"type" => "select",
			"class" => "small", //mini, tiny, small
			"options" => $options_yesno
		);

	// SCHEMA :  - servesCuisine - Text - The cuisine of the restaurant.

		$options[] = array( 
			"name" => "Cuisine",
			"desc" => "The cuisine of the restaurant. Uses the Yelp cuisine categorization.",
			"id" => "tf_schema_cuisine",
			"std" => "",
			"type" => "select",
			"class" => "small", //mini, tiny, small
			"options" => $options_cuisine
		);
		
	// Items left out or already covered for this section:
	// ---------------------------------------------------		
		// SCHEMA :  - menu - Text or URL - Either the actual menu or a URL of the menu.	
	
	return $options;
}?>