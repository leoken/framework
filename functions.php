<?php

/*
 * CHOWFORCE THEME FUNCTIONS
 * **********************************************
 *
 * CAUTION: DO NOT MAKE ANY CHANGES IN THIS FILE UNLESS YOU KNOW WHAT
 * YOU'RE DOING. KEEP THE FUNCTIONS SEPARATE IF THEY DON'T INTERARCT
 * WITH THE ONES BELOW (I.E. DIFFERENT FILE, EASIER FOR UPDATING CHOWFORCE
 * VERSIONS)
 *
 */

// Set up theme supports
add_theme_support( 'tf_food_menu' );
add_theme_support( 'tf_widget_opening_times' );
add_theme_support( 'tf_widget_google_maps' );
add_theme_support( 'tf_four_square' );
add_theme_support( 'tf_yelp' );

//TODO add_theme_support( 'tf_events' );

// Load the Theme Force Framework
require_once( TEMPLATEPATH . '/themeforce/themeforce.php' );

// - WIDGETS -
//---------------------------------------------

require_once (TEMPLATEPATH . '/functions/widget-socialmedia.php');

// - CUSTOM FUNCTIONS -
//---------------------------------------------

require_once (TEMPLATEPATH . '/custom.php');

// - CSS ENQUEUE-
//---------------------------------------------

function load_chowforce_css() {
    wp_enqueue_style('bxcss', (get_bloginfo('template_url')) . '/css/bx_styles.css');
    }

add_action('wp_print_styles', 'load_chowforce_css');


// - JAVASCRIPT ENQUEUE -
//---------------------------------------------

function load_chowforce_js()
{
    wp_enqueue_script('bxslider', (get_bloginfo('template_url')) . '/js/jquery.bxSlider.js', array('jquery'));
    wp_enqueue_script('bxsettings', (get_bloginfo('template_url')) . '/js/jquery.bxSettings.js', array('jquery'));
    if (get_option('chowforce_yelp_switch') == 'true') { wp_enqueue_script('yelpbar', (get_bloginfo('template_url')) . '/js/jquery.stickyPanel.js', array('jquery')); }
    wp_localize_script( 'bxsettings', 'chowforce', array(
            'pause' => get_option('chowforce_slider_pause'),
            ));
}
add_action('wp_print_scripts', 'load_chowforce_js');

// - POST-THEME SETUP LOAD -
//---------------------------------------------

add_action( 'after_setup_theme', 'themeforce_setup' );
if ( ! function_exists( 'themeforce_setup' ) ):

function themeforce_setup() {

	// - thumbnails -
        // TODO add thumbnail sizes
	add_theme_support( 'post-thumbnails' );

	// - rss -
	add_theme_support( 'automatic-feed-links' );

	// - internationalization -
	load_theme_textdomain( 'themeforce', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// - nav's -
	register_nav_menus( array('primary' => __( 'Header Navigation', 'themeforce' ),'terminal' => __( 'Terminal Footer Navigation', 'themeforce' )) );

	// - custom background -
	add_custom_background();

}
endif;

// - OPTIONS PANEL -
//---------------------------------------------

require_once (TEMPLATEPATH . '/themeoptions.php');

// - TITLE  -
//---------------------------------------------

function themeforce_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'themeforce' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'themeforce' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'themeforce' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'themeforce_filter_wp_title', 10, 2 );

// - ADD HOME TO REGULAR NAV FALLBACK  -
//---------------------------------------------

function themeforce_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'themeforce_page_menu_args' );

// - MAIN NAV FALLBACK -
//---------------------------------------------

function themeforce_suckerfish() {
    echo '<div class="nav"><ul id="menu-default" class="sf-menu"><li><a href="' . admin_url('nav-menus.php') . '">Set your custom menu here</a></li></ul></div>';
    }

// - EXCERPT LENGTH -
//---------------------------------------------

function themeforce_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'themeforce_excerpt_length' );

// - COMMENTS -
//---------------------------------------------

if ( ! function_exists( 'themeforce_comment' ) ) :

function themeforce_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>">
                <div class="comment-thumb"><?php echo get_avatar( $comment, $size='50' ); ?></div>
                <div class="commenttext">
                    <div class="comment-author vcard">
                    <?php printf( __( '%s <span class="says">says:</span>', 'themeforce' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                    </div><!-- .comment-author .vcard -->
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'themeforce' ); ?></em>
                    <br />
                    <?php endif; ?>
                    <div class="comment-meta commentmetadata">
                    <?php
                    printf( __( '%1$s at %2$s', 'themeforce' ), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( '(Edit)', 'themeforce' ), ' ' );
                    ?>
                    </div>
                    <div class="comment-body"><?php comment_text(); ?></div>
                    <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div>
                </div><div class="clearfix">
                </div>
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'themeforce' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'themeforce' ), ' ' ); ?></p>
	<?php
	break;
	endswitch;
}
endif;


/**
 * Updates the Pubforce options which have been moved to ThemeForce.
 * 
 */
function cf_update_pubforce_options_to_themeforce() {
	
	$options_to_change = array(
		'pubforce_h_foodtax'		=> 'tf_added_default_food_terms',
		'chowforce_fx'				=> 'tf_currency_symbol',	
		'chowforce_menu_fx'			=> 'tf_menu_currency_symbol',
		'chowforce_menu_sort'		=> 'tf_menu_sort_key',
		'chowforce_fsquare_venueid' => 'tf_fsquare_venue_id',
		'chowforce_fsquare_clientid'=> 'tf_fsquare_client_id',
		'chowforce_fsquare_clientsecret' => 'tf_fsquare_client_secret',
		'chowforce_yelp_api'		=> 'tf_yelp_api_key',
		'chowforce_yelp_phone'		=> 'tf_yelp_phone',
		'chowforce_yelp_cc'			=> 'tf_yelp_country_code',
		'chowforce_yelp_switch'		=> 'tf_yelp_enabled'
		
	);
	
	foreach( $options_to_change as $old_option => $new_option ) {
		update_option( $new_option, get_option( $old_option ) );
		delete_option( $old_option );
	}
	
}

/**
 * If the site is using old Pubforce options, show a nag to get them to migrate.
 * 
 */
function cf_update_pubforce_options_nag() {
	
	if( !get_option( 'pubforce_h_foodtax' ) && !get_option( 'chowforce_menu_fx' ) && !get_option( 'chowforce_menu_sort' ) )
		return;
	
	?>
	<div class="update-nag"><?php _e( 'You have legacy Chowforce options that need updating, click the following button to update them.' ) ?> <a href="<?php echo wp_nonce_url( add_query_arg( 'cf_action', 'update_legacy_options' ), 'update_legacy_options' ) ?>" class="button"><?php _e( 'Update Options' ) ?></a></div>
	<?php
	
}
add_action('admin_notices', 'cf_update_pubforce_options_nag' );

/**
 * Submit action for the chowforce options migrator.
 * 
 */
function cf_update_pubforce_legacy_options_action() {

	if( empty( $_GET['cf_action'] ) || $_GET['cf_action'] !== 'update_legacy_options' || !wp_verify_nonce( $_GET['_wpnonce'], 'update_legacy_options' ) )
		return;
	
	cf_update_pubforce_options_to_themeforce();
	
	wp_redirect( wp_get_referer() );
	exit;

}
add_action( 'admin_init', 'cf_update_pubforce_legacy_options_action' );


// - WIDGET INIT -
//---------------------------------------------

function themeforce_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Sidebar - Right', 'themeforce' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The secondary widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer - First Area', 'themeforce' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer - Second Area', 'themeforce' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer - Third Area', 'themeforce' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

        register_sidebar( array(
		'name' => __( 'Home - First Area', 'themeforce' ),
		'id' => 'first-home-widget-area',
		'description' => __( 'The first footer widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><div class="homebar"></div>',
	) );

	register_sidebar( array(
		'name' => __( 'Home - Second Area', 'themeforce' ),
		'id' => 'second-home-widget-area',
		'description' => __( 'The third footer widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><div class="homebar"></div>',
	) );

        register_sidebar( array(
		'name' => __( 'Home - Third Area', 'themeforce' ),
		'id' => 'third-home-widget-area',
		'description' => __( 'The third footer widget area', 'themeforce' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><div class="homebar"></div>',
	) );
}
add_action( 'widgets_init', 'themeforce_widgets_init' );


// - SLIDER -
//---------------------------------------------

function themeforce_slider() {

        ob_start();

        // counter
        $c = 1;

        // - loop -
        while($c <= 5):

        $simage = get_option('chowforce_s' . $c .'_img');
        $stype = get_option('chowforce_s' . $c .'_type');

        // check if image exists
        if ( $simage != '' ) {

            // check type and load approriate options
            if ( $stype == 'textimage') {
                $sheader = stripslashes(get_option('chowforce_s' . $c .'_h'));
                $sdesc = stripslashes(get_option('chowforce_s' . $c .'_p'));
                $slinktext = stripslashes(get_option('chowforce_s' . $c .'_at'));
            }
            $slink = get_option('chowforce_s' . $c .'_a');

            // show goodies
            if ($stype == 'textimage') {
                echo '<li><div class="slidetext">';
                if ( $sheader != '' ) {echo '<h3>' . $sheader . '</h3>';}
                echo '<p>' . $sdesc . '</p>';
                if ( $slink != '' ) {echo '<a href="' . $slink . '"><div class="slidebutton">' . $slinktext . '</div></a>';}
                echo '</div>';
                echo '<div class="slideimage"><img src="' . $simage . '" alt="' . __('Slide', 'themeforce') . ' ' . $c . '"></div>';
                } else {
                echo '<li><div class="slideimage-full"><a href="' . $slink . '"><img src="' . $simage . '" alt="' . __('Slide', 'themeforce') . ' ' . $c . '"></a></div></li>';
            }
        }
        // add default slide
        $noslides .= $simage;
        // increase counter
        $c++;
        endwhile;

        if ( $noslides == '' ) {
            // - check slide pause -
                if ( !get_option('chowforce_slider_pause')) {
                    update_option('chowforce_slider_pause', '5000');
                    }
            // - slide 1 -
                echo '<li><div class="slidetext">';
                echo '<h3>Thank you!</h3>';
                echo '<p>We hope you will enjoy Chowforce, and be able to make full use of it. We\'re always open to new ideas and would welcome your feedback & suggestions. To get started, click on the link below and you will see all our tutorials.</p>';
                echo '<a href="http://themeforce.zendesk.com/tickets/new"><div class="slidebutton">Chowforce Guide</div></a>';
                echo '</div>';
                echo '<div class="slideimage"><img src="' . get_bloginfo('template_url') . '/images/tf-chow.jpg" alt="Theme Force Chowforce"></div></li>';
            // - slide 2 -
                echo '<li><div class="slidetext">';
                echo '<h3>Need help?</h3>';
                echo '<p>In addition to our video tutorials, we also provide Chowforce support through our Zendesk ticket system. Just open a ticket and say hi, this way we can approve your account.</p>';
                echo '<a href="http://themeforce.zendesk.com/tickets/new"><div class="slidebutton">Open a Ticket</div></a>';
                echo '</div>';
                echo '<div class="slideimage"><img src="' . get_bloginfo('template_url') . '/images/tf-support.jpg" alt="Theme Force Support"></div></li>';
                }
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
        }