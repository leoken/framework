<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "chowforce";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
$options_yelp = array('US', 'CA', 'GB', 'IE', 'FR', 'DE', 'AT', 'NL');
$options_slider = array("textimage" => "Text & Image", "fullimage" => "Full Image");

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Set the Options Array
$options = array();

$options[] = array( "name" => "Business Settings",
                    "type" => "heading");

$options[] = array( "name" => "Business Name",
					"desc" => "Please enter the name of your business",
					"id" => $shortname."_biz_name",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Business Address",
					"desc" => "Please enter your business address",
					"id" => $shortname."_biz_address",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Short Contact Info",
					"desc" => "Visible contact information in the top-right corner (you can also leave blank)",
					"id" => $shortname."_biz_contactinfo",
					"std" => "Call us at +01 (02) 123 57 89",
					"type" => "text");

$options[] = array( "name" => "Facebook Link",
					"desc" => "Please enter your full facebook link",
					"id" => $shortname."_facebook",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Twitter Link",
					"desc" => "Please enter your full twitter link",
					"id" => $shortname."_twitter",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Terminal Notice",
					"desc" => "Displayed in the Terminal Footer (i.e. Copyright, etc.)",
					"id" => $shortname."_terminalnotice",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea"); 



// Design Options

$options[] = array( "name" => "Design Settings",
                    "type" => "heading");

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme (size must be <strong>300px by 160px</strong>), or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => "Show Titles on Regular Pages?",
					"desc" => "If you'd like to use a different title or no title on pages (i.e. the Menu, deactivate this and use the H1 tag within the page content)",
					"id" => $shortname."_pagetitle",
					"std" => "true",
					"type" => "checkbox");

$options[] = array( "name" => "Slider Pause",
					"desc" => "Time spent on each slide (in milliseconds, , i.e. '6000' = 6 seconds)",
					"id" => $shortname."_slider_pause",
					"std" => "6000",
					"type" => "text");

// COLOR

$options[] = array( "name" => "Color Settings",
					"type" => "heading");

$options[] = array( "name" => "Use Custom Colors?",
					"desc" => "If you'd like to override the regular colors, with the ones you choose below, check this box.",
					"id" => $shortname."_color_active",
					"std" => "false",
					"type" => "checkbox");


$options[] = array( "name" => "Primary (Light)",
					"desc" => "<strong>Uses:</strong> Drop-down Border",
					"id" => $shortname."_color_pri_light",
					"std" => "#73969e",
					"type" => "color");

$options[] = array( "name" => "Primary (Regular)",
					"desc" => "<strong>Uses:</strong> Headers, Important Text, Certain Backgrounds (i.e. Drop-Down)",
					"id" => $shortname."_color_pri_reg",
					"std" => "#486369",
					"type" => "color");

$options[] = array( "name" => "Primary (Dark)",
					"desc" => "<strong>Uses:</strong> Body Background, Regular Body Text ",
					"id" => $shortname."_color_pri_dark",
					"std" => "#303d40",
					"type" => "color");

$options[] = array( "name" => "Primary (Link)",
					"desc" => "<strong>Uses:</strong> Links (except Regular Footer)",
					"id" => $shortname."_color_pri_link",
					"std" => "#418898",
					"type" => "color");

$options[] = array( "name" => "Secondary (Regular)",
					"desc" => "<strong>Uses:</strong> Post Listing Headers, Post Headers (to help differntiate from Static Content & News)",
					"id" => $shortname."_color_sec_reg",
					"std" => "#b35143",
					"type" => "color");


// Food

$options[] = array( "name" => "Food Menu Settings",
                    "type" => "heading");


$options[] = array( "name" => "Menu Currency",
					"desc" => "Please enter your currency symbol or 3-letter code, whichever looks better to you. Is used for the menu.",
					"id" => $shortname."_fx",
					"std" => "$",
					"type" => "text");

$options[] = array( "name" => "Show currency for menu prices by default?",
					"desc" => "Otherwise you will need to set it manually by using the shortcode variable",
					"id" => $shortname."_menu_fx",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "Use advanced sort functionality for Menu?",
					"desc" => "If you don't use the advanced sort, menu items will be sorted alphabetically. ", //See <a href='http://'>this tutorial</a>for more information
					"id" => $shortname."_menu_sort",
					"std" => "false",
					"type" => "checkbox");

// Yelp

$options[] = array( "name" => "Yelp Settings",
                    "type" => "heading");

$options[] = array( "name" => "Enable Yelp Bar?",
					"desc" => "This will show the Yelp bar above in line with Yelp display requirements. The fields below need to be completed in order for this to work.",
					"id" => $shortname."_yelp_switch",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "API Key",
					"desc" => "Required for Yelp Button  <a target='_blank' href='http://www.yelp.com/developers/getting_started/api_overview'>Get it from here (Yelp API)</a>",
					"id" => $shortname."_yelp_api",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Country",
					"desc" => "Required so that your Phone Number below can be correctly identified",
					"id" => $shortname."_yelp_cc",
					"std" => "US",
					"type" => "select",
					"class" => "mini", //mini, tiny, small
					"options" => $options_yelp);

$options[] = array( "name" => "Phone number registered with Yelp",
					"desc" => "Required for Yelp Button (Used by the API to identify your business). Do not use special characters, only numbers.",
					"id" => $shortname."_yelp_phone",
					"std" => "",
					"type" => "text");

// foursquare

$options[] = array( "name" => "foursquare Settings",
                    "type" => "heading");

$options[] = array( "name" => "Venue ID",
					"desc" => "If your profile URL is http://foursquare.com/venue/12345, then your Venue ID is 12345",
					"id" => $shortname."_fsquare_venueid",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Client ID",
					"desc" => "Request API access here, register <a href='https://foursquare.com/oauth/' target='_blank'>here</a>. Callback URL does not matter for the Venues APIv2 we'll be using.",
					"id" => $shortname."_fsquare_clientid",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Client Secret",
					"desc" => "Request API access here, register <a href='https://foursquare.com/oauth/' target='_blank'>here</a>. Callback URL does not matter for the Venues APIv2 we'll be using.",
					"id" => $shortname."_fsquare_clientsecret",
					"std" => "",
					"type" => "text");

// slider 1

$options[] = array( "name" => "Slider #1",
                    "type" => "heading");

$options[] = array( "name" => "Slide Type",
					"desc" => "Choose the type of Slide you'd like. Full Image only makes use of the Slide Image & Link URL (optional)",
					"id" => $shortname."_s1_type",
					"std" => "textimage",
					"type" => "select2",
					"options" => $options_slider);

$options[] = array( "name" => "Slide Image",
					"desc" => "Upload your Image here, exactly <strong>960 x 300</strong> for full, and <strong>540 x 300</strong> for text & image.",
					"id" => $shortname."_s1_img",
					"std" => "",
					"type" => "upload_min");

$options[] = array( "name" => "Header (if Text)",
					"desc" => "The header/title of your text block.",
					"id" => $shortname."_s1_h",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Description (if text)",
					"desc" => "The regular text area of your text block.",
					"id" => $shortname."_s1_p",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Link Title (if text)",
					"desc" => "This will change the name of the link button.",
					"id" => $shortname."_s1_at",
					"std" => __('Read More', 'themeforce'),
					"type" => "text");

$options[] = array( "name" => "Link URL",
					"desc" => "The full link of the post/page you are linking too (i.e. http://www.restaurant.com/food-menu )",
					"id" => $shortname."_s1_a",
					"std" => "",
					"type" => "text");
// slider 2

$options[] = array( "name" => "Slider #2",
                    "type" => "heading");

$options[] = array( "name" => "Slide Type",
					"desc" => "Choose the type of Slide you'd like. Full Image only makes use of the Slide Image & Link URL (optional)",
					"id" => $shortname."_s2_type",
					"std" => "textimage",
					"type" => "select2",
					"options" => $options_slider);

$options[] = array( "name" => "Slide Image",
					"desc" => "Upload your Image here, exactly <strong>960 x 300</strong> for full, and <strong>540 x 300</strong> for text & image.",
					"id" => $shortname."_s2_img",
					"std" => "",
					"type" => "upload_min");

$options[] = array( "name" => "Header (if Text)",
					"desc" => "The header/title of your text block.",
					"id" => $shortname."_s2_h",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Description (if text)",
					"desc" => "The regular text area of your text block.",
					"id" => $shortname."_s2_p",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Link Title (if text)",
					"desc" => "This will change the name of the link button.",
					"id" => $shortname."_s2_at",
					"std" => __('Read More', 'themeforce'),
					"type" => "text");

$options[] = array( "name" => "Link URL",
					"desc" => "The full link of the post/page you are linking too (i.e. http://www.restaurant.com/food-menu )",
					"id" => $shortname."_s2_a",
					"std" => "",
					"type" => "text");

// slider 3

$options[] = array( "name" => "Slider #3",
                    "type" => "heading");

$options[] = array( "name" => "Slide Type",
					"desc" => "Choose the type of Slide you'd like. Full Image only makes use of the Slide Image & Link URL (optional)",
					"id" => $shortname."_s3_type",
					"std" => "textimage",
					"type" => "select2",
					"options" => $options_slider);

$options[] = array( "name" => "Slide Image",
					"desc" => "Upload your Image here, exactly <strong>960 x 300</strong> for full, and <strong>540 x 300</strong> for text & image.",
					"id" => $shortname."_s3_img",
					"std" => "",
					"type" => "upload_min");

$options[] = array( "name" => "Header (if Text)",
					"desc" => "The header/title of your text block.",
					"id" => $shortname."_s3_h",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Description (if text)",
					"desc" => "The regular text area of your text block.",
					"id" => $shortname."_s3_p",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Link Title (if text)",
					"desc" => "This will change the name of the link button.",
					"id" => $shortname."_s3_at",
					"std" => __('Read More', 'themeforce'),
					"type" => "text");

$options[] = array( "name" => "Link URL",
					"desc" => "The full link of the post/page you are linking too (i.e. http://www.restaurant.com/food-menu )",
					"id" => $shortname."_s3_a",
					"std" => "",
					"type" => "text");

// slider 4

$options[] = array( "name" => "Slider #4",
                    "type" => "heading");

$options[] = array( "name" => "Slide Type",
					"desc" => "Choose the type of Slide you'd like. Full Image only makes use of the Slide Image & Link URL (optional)",
					"id" => $shortname."_s4_type",
					"std" => "textimage",
					"type" => "select2",
					"options" => $options_slider);

$options[] = array( "name" => "Slide Image",
					"desc" => "Upload your Image here, exactly <strong>960 x 300</strong> for full, and <strong>540 x 300</strong> for text & image.",
					"id" => $shortname."_s4_img",
					"std" => "",
					"type" => "upload_min");

$options[] = array( "name" => "Header (if Text)",
					"desc" => "The header/title of your text block.",
					"id" => $shortname."_s4_h",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Description (if text)",
					"desc" => "The regular text area of your text block.",
					"id" => $shortname."_s4_p",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Link Title (if text)",
					"desc" => "This will change the name of the link button.",
					"id" => $shortname."_s4_at",
					"std" => __('Read More', 'themeforce'),
					"type" => "text");

$options[] = array( "name" => "Link URL",
					"desc" => "The full link of the post/page you are linking too (i.e. http://www.restaurant.com/food-menu )",
					"id" => $shortname."_s4_a",
					"std" => "",
					"type" => "text");

// slider 5

$options[] = array( "name" => "Slider #5",
                    "type" => "heading");

$options[] = array( "name" => "Slide Type",
					"desc" => "Choose the type of Slide you'd like. Full Image only makes use of the Slide Image & Link URL (optional)",
					"id" => $shortname."_s5_type",
					"std" => "textimage",
					"type" => "select2",
					"options" => $options_slider);

$options[] = array( "name" => "Slide Image",
					"desc" => "Upload your Image here, exactly <strong>960 x 300</strong> for full, and <strong>540 x 300</strong> for text & image.",
					"id" => $shortname."_s5_img",
					"std" => "",
					"type" => "upload_min");

$options[] = array( "name" => "Header (if Text)",
					"desc" => "The header/title of your text block.",
					"id" => $shortname."_s5_h",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Description (if text)",
					"desc" => "The regular text area of your text block.",
					"id" => $shortname."_s5_p",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Link Title (if text)",
					"desc" => "This will change the name of the link button.",
					"id" => $shortname."_s5_at",
					"std" => __('Read More', 'themeforce'),
					"type" => "text");

$options[] = array( "name" => "Link URL",
					"desc" => "The full link of the post/page you are linking too (i.e. http://www.restaurant.com/food-menu )",
					"id" => $shortname."_s5_a",
					"std" => "",
					"type" => "text");

update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
