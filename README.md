# Introduction

The **Theme Force Framework** is the most comprehensive solution for restaurant websites based on WordPress. It is
structured as a modular feature-set highly relevant to industry needs. This read-me only provides usage instructions, please see the developer page below for more information.

## Resources

**Must-Read** Developer Homepage: http://www.theme-force.com/developers
GitHub Homepage: https://github.com/themeforce/framework
Discussion & News: http://www.facebook.com/pages/Theme-Force/111741295576685

## Requirements

In order to make use of our complete feature set, you will need to use the Options Framework within your theme 
(maintained by @devinsays), it can be found here: https://github.com/devinsays/options-framework-plugin

## Activating within your Theme

We understand you may not want to use all the features, so it's normal that you only reduce the number of queries
that your theme executes. Our modular approach means that you only need to add theme support (i.e. the functions
below) that you need (within functions.php).

	add_theme_support( 'tf_food_menu' );
	add_theme_support( 'tf_events' );
	add_theme_support( 'tf_widget_opening_times' );
	add_theme_support( 'tf_widget_google_maps' );
	add_theme_support( 'tf_widget_payments' );
	add_theme_support( 'tf_foursquare' );
	add_theme_support( 'tf_gowalla' );
	add_theme_support( 'tf_yelp' );
	add_theme_support( 'tf_mailchimp' );
	
## Support

We can't actually help you with CSS, XHTML, PHP & JS so there's a certain degree of self-reliance that's required if you'd like to implement. It doesn't mean we won't guide you on the right path, but we'd like to keep the discussions relevant to bugs, enhancements and features.