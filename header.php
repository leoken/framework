<?php
/*
 *  HEADER
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />

<!-- default css -->

    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    
<!-- theme picker -->
    
    <?php
    if (get_option('chowforce_color_active') == 'true') {
        echo '<link rel="stylesheet" type="text/css" media="screen" href="' . get_template_directory_uri() . '/css/color-options.php"  />';
    };
    ?>

<!-- custom css -->

    <link href="<?php bloginfo('template_url'); ?>/custom.css" type="text/css" rel="stylesheet" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- js -->

    <?php wp_enqueue_script('jquery'); ?>
    <?php
    if ( is_singular() && get_option( 'thread_comments' ) )
        { wp_enqueue_script( 'comment-reply' ) ;}
    wp_head();
    ?>
    <?php if (get_option('chowforce_yelp_switch') == 'true') { ?>
        <script type="text/javascript">
            jQuery().ready(function () {
                var stickyPanelOptions = {
                    topPadding: 0,
                    savePanelSpace: true
                };
                jQuery("#yelpbar").stickyPanel(stickyPanelOptions);
            });
        </script>
    <?php ;} ?>
</head>

<body <?php body_class(); ?>>

<?php if (get_option('chowforce_yelp_switch') == 'true') {
    echo '<!-- yelp bar -->';
    $yelpbar = themeforce_yelp_bar();
    echo $yelpbar;
    echo '<!-- / yelp bar -->';
    } else {
    echo '<!-- yelp bar disabled (see theme options) -->';
    } ?>

<!-- logo & nav -->
<div id="header-wrap">
    <div class="container_12">
        <div id="logo">
            <img src="<?php if( get_option('chowforce_logo') == '' ) { echo  bloginfo('template_url') . '/images/logo.png';} else { echo get_option('chowforce_logo');}?>" alt="<?php _e('Logo','themeforce') ?>"/>
        </div>
        <div id="header-topright">
            <?php echo stripslashes(get_option('chowforce_biz_contactinfo')); ?>
        </div>
        <div id="header-nav">
            <?php
            $wp_nav_header = array(
              'container'       => 'div',
              'container_class' => 'nav',
              'menu_class'      => 'sf-menu',
              'fallback_cb'     => 'themeforce_suckerfish',
              'theme_location'  => 'primary');
            wp_nav_menu( $wp_nav_header);
            ?>
        </div>
    </div>
    <div id="header-btm"></div>
</div>

<!-- / logo & nav -->

<!-- slider -->
<div id="slider-wrap">
<div id="slider-box">
<ul id="slider">
    <?php
    // Load Slider Function (with Fallback)
    $slider = themeforce_slider();
    echo $slider;
    ?>
</ul>
    <div id="slideshow-nav"><ul id="slideshow-nav-inner"><li style="display:none;"><!-- Validaiton Only --></li></ul></div>
</div>
    </div>
<div class="clearfix"></div>
<!-- / slider -->

<!-- main -->
<div id="main-wrap">
    <div id="main-top"></div>
    <div class="clearfix"></div>
    <div id="main" class="container_12">