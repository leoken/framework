<?php
function tf_events_rss() {

// - start collecting output -
ob_start();

// - rss header stuff -
header("Content-Type: application/rss+xml; charset=UTF-8");
echo '<?xml version="1.0"?>';
?>
<rss version="2.0">
<channel>
    
  <title><?php bloginfo('blognname'); _e(' - Events','themeforce'); ?></title>
  <link><?php echo the_permalink(); ?></link>
  <description><?php bloginfo('blognname'); ?></description>
  <language><?php bloginfo('language') ?></language>
  <pubDate><?php echo date(DATE_RSS, time()); ?></pubDate>
  <lastBuildDate><?php echo date(DATE_RSS, time()); ?></lastBuildDate>
  <managingEditor><?php bloginfo('admin_email'); ?></managingEditor>

<?php

// - grab date barrier -
$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );
$limit = get_option('pubforce_rss_limit');

// - query -
global $wpdb;
$querystr = "
    SELECT *
    FROM $wpdb->posts wposts, $wpdb->postmeta metastart, $wpdb->postmeta metaend
    WHERE (wposts.ID = metastart.post_id AND wposts.ID = metaend.post_id)
    AND (metaend.meta_key = 'tf_events_enddate' AND metaend.meta_value > $today6am )
    AND metastart.meta_key = 'tf_events_enddate'
    AND wposts.post_type = 'tf_events'
    AND wposts.post_status = 'publish'
    ORDER BY metastart.meta_value ASC LIMIT $limit
 ";

$events = $wpdb->get_results($querystr, OBJECT);
/*$counter = 0;*/

// - loop -
if ($events):
global $post;
foreach ($events as $post):
setup_postdata($post);

// - custom variables -
$custom = get_post_custom(get_the_ID());
$sd = $custom["tf_events_startdate"][0];
$ed = $custom["tf_events_enddate"][0];

// - grab GMT adjusted 'publish' date -
$gmt = date('Y-m-d H:i:s', $sd);
$gmt = get_gmt_from_date($gmt); // this function requires Y-m-d H:i:s, hence the back & forth.
$gmt = strtotime($gmt);

// - local time format -
$time_format = get_option('time_format');
$stime = date($time_format, $sd);
$etime = date($time_format, $ed);
/* $counter++;
$unique = time() - $counter; */

// - item output -
 ?>
  <item>
    <title><?php echo the_title(); ?></title>
    <link><?php echo the_permalink(); ?></link>
    <description><?php echo $stime . ' - ' . $etime; ?> - <?php the_excerpt_rss('', TRUE, '', 50); ?></description>
    <pubDate><?php echo date(DATE_RSS, $gmt) ?></pubDate>
    <guid><?php echo the_permalink(); ?></guid>
  </item>

<?php
endforeach;
else :
endif;
?>
</channel>
</rss>
<?php
// - full output -
$tfeventsrss = ob_get_contents();
ob_end_clean();
echo $tfeventsrss;
}

function add_tf_events_feed () {
    // - add it to WP RSS feeds -
    add_feed('tf-events', 'tf_events_rss');
}

add_action('init','add_tf_events_feed');
?>