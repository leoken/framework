<?php 
header("content-type: text/css");

if(file_exists('../../../../wp-load.php')) :
	include '../../../../wp-load.php';
else:
	include '../../../../../wp-load.php';
endif; 

ob_flush(); 
?>

/*==========================================================================================
	
Colors generated here are pulled in from the 'Theme Options' within the Dashboard

==========================================================================================*/

<?php
$pri_light = get_option('chowforce_color_pri_light');
$pri_reg = get_option('chowforce_color_pri_reg');
$pri_dark = get_option('chowforce_color_pri_dark');
$pri_link = get_option('chowforce_color_pri_link');
$sec_reg = get_option('chowforce_color_sec_reg');
?>

/*- PRIMARY (Default: BLUE) -*/

    /*- Link Color #418898 -*/

    #content a,
    #regular a,
    .sec-footer-outer a
    {color:<?php echo $pri_link; ?>;}

    /*- Light Color #73969e-*/

    .sf-menu ul li,
    .sf-menu ul li:first-child
    {border-color:<?php echo $pri_light; ?>;}

    /*- Regular Color (default: #486369) -*/

    h1, h2, h3, h4, h5, h6,
    #header-topright,
    .slidebutton,
    .slidebutton:visited,
    .openingtimes,
    .full-menu .desc,
    .full-menu .extrasizes,
    .mid-menu .desc,
    .small-menu .desc,
    .small-menu .rightbox .size
    {color:<?php echo $pri_reg; ?>;}

    .sf-menu  a,
    .sf-menu a:hover,
     #navigation .sf-menu  a:visited,
     .sf-menu ul li,
     .sf-menu ul li ul li, .sf-menu ul li ul li:last-child,
     .sf-menu li ul a, .sf-menu li ul a:visited, .sf-menu li ul a:hover
    {background-color:<?php echo $pri_reg; ?>;}
    
    /*- Dark Color (default: #303d40) -*/

    body,
    .full-menu .extrasizes strong
    {color:<?php echo $pri_dark; ?>;}

    body
    {background-color:<?php echo $pri_dark; ?>;}
    

/*- SECONDARY (Default: RED) -*/

    /*- Link Color (#b35143) -*/

    #content h1.post-title,
    #content h2.list-title a {
    color:<?php echo $sec_reg; ?>;}


<?php ob_end_flush(); ?>