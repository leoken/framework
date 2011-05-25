<?php

add_filter('tf_of_options','cf_of_options', 9);

function cf_of_options( $options ) {
	
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
						"id" => "tf_currency_symbol",
						"std" => "$",
						"type" => "text");
	
	$options[] = array( "name" => "Show currency for menu prices by default?",
						"desc" => "Otherwise you will need to set it manually by using the shortcode variable",
						"id" => "tf_menu_currency_symbol",
						"std" => "false",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Use advanced sort functionality for Menu?",
						"desc" => "If you don't use the advanced sort, menu items will be sorted alphabetically. ", //See <a href='http://'>this tutorial</a>for more information
						"id" => "tf_menu_sort_key",
						"std" => "false",
						"type" => "checkbox");
		
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
	
	update_option('of_themename',$themename);   
	update_option('of_shortname',$shortname);
	
	return $options;
}