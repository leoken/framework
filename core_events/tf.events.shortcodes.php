<?php
/* ------------------- THEME FORCE ---------------------- */

/*
 * EVENTS SHORTCODES (CUSTOM POST TYPE)
 *
 * [tf-events-full limit='10']
 * [tf-events-feat limit='1' group='Featured' header='yes' text='Featured Events']
 *
 */

function tf_list_cats() {
	$terms = get_the_terms($post->id, 'tf_eventcategory');
	foreach ($terms as $term) {
		if($term->name != __('Featured','themeforce')) {
		  return $term->name;
		}
	};
};
 
 
// 1) FULL EVENTS
//***********************************************************************************

function tf_events_full ( $atts ) {
	
	// - define arguments -
	extract(shortcode_atts(array(
	    'limit' => '30', // # of events to show
	 ), $atts));
	
	// ===== OUTPUT FUNCTION =====
	
	ob_start();
	
	// ===== LOOP: FULL EVENTS SECTION =====
	
	// - make sure it's a number for our query -
	
	$limit = intval($limit);
	
	// - hide events that are older than 6am today (because some parties go past your bedtime) -
	
	$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );
	
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
	
	// - declare fresh day -
	$daycheck = null;
	$date_format = get_option('date_format');
	
	echo '<!-- www.schema.org -->';
	
	// - loop -
	if ($events):
	global $post;
	foreach ($events as $post):
	
	setup_postdata($post);
	
	// - custom variables -
	$custom = get_post_custom(get_the_ID());
	$sd = $custom["tf_events_startdate"][0];
	$ed = $custom["tf_events_enddate"][0];
		$post_image_id = get_post_thumbnail_id(get_the_ID());
	        if ($post_image_id) {
		             if( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=130&height=130&crop=1', false) ) 
                    	(string) $thumbnail = $thumbnail[0];
	        }
			
	// - determine if it's a new day -
	$sqldate = date('Y-m-d H:i:s', $sd);
	$longdate = mysql2date($date_format, $sqldate);
	if ($daycheck == null) { echo '<h2 class="full-events">' . $longdate . '</h2>'; }
	if ($daycheck != $longdate && $daycheck != null) { echo '<h2 class="full-events">' . $longdate . '</h2>'; }		
	
	// - determine date -
	$sqldate = date('Y-m-d H:i:s', $sd);
	$schema_startdate = date('Y-m-d\TH:i', $sd); // <- Date for Google Rich Snippets
	$schema_enddate = date('Y-m-d\TH:i', $ed); // <- Date for Google Rich Snippets
	$date_format = get_option('date_format');
	$local_startdate = mysql2date($date_format, $sqldate); // <- Date for Display
	
	// - determine duration -
	$schema_duration = ($ed-$sd)/60; // Duration for Google Rich Snippets

	// - local time format -
	$time_format = get_option('time_format');
	$stime = date($time_format, $sd); // <- Start Time
	$etime = date($time_format, $ed); // <- End Time
	
	// TODO add fallback for nothumb
	
	// - output - ?>
	<div itemprop="events" itemscope itemtype="http://schema.org/Event">
	<div class="full-events">
	    <div class="text">
	        <div class="title">
				<?php if($thumbnail != '') {?>
				<!-- img -->  <meta itemprop="photo" content="<?php echo $thumbnail; ?>" />
				<?php } ?>
	            <!-- date --> <div class="time"><span itemprop="startDate" content="<?php echo $schema_startdate; ?>"><?php echo $stime . ' - ' . $etime; ?></span></div>
				<!-- duration --> <meta itemprop="duration" content="PT<?php echo $schema_duration; ?>M" />
				<!-- category --> <meta itemprop="eventType" content="<?php tf_list_cats(); ?>" />
	            <!-- url & name --> <div class="eventtext"><a itemprop="url" href="<?php the_permalink(); ?>"><div itemprop="name"><?php the_title(); ?></div></a></div>
				<!-- location --> <meta itemprop="location" content="<?php echo get_option('tf_business_name') . ', ' . get_option('tf_business_address');?>" />
	        </div>
	    </div>
	    <!-- description --><div class="desc" itemprop="description"><?php the_content() ?></div>
	</div>
	</div>
	
	<!-- www.schema.org -->  
	
	<?php
	
	// - fill daycheck with the current day -
	$daycheck = $longdate;
	// - .... and back to the top now -
	
	endforeach;
	else :
	endif;
	
	echo '<!-- / www.schema.org -->';
	
	// ===== RETURN: FULL EVENTS SECTION =====
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	
}
	
add_shortcode('tf-events-full', 'tf_events_full');
	
	
// 1) FEATURED EVENT
//***********************************************************************************
	
function tf_events_feat ( $atts ) {

	wp_reset_query();
	
	// - define arguments -
	extract(shortcode_atts(array(
	    'limit' => '2', // # of events to show
	    'group' => 'Featured', // taxonomy to use
	    'header' => 'yes', // show header?
	    'text' => 'Featured Events', // header text to use?
	 ), $atts));
	
	// ===== OUTPUT FUNCTION =====
	
	ob_start();
	
	// ===== OPTIONS =====
	
	    // - header text -
	    if ($header=="yes") {
	         echo '<h2 class="full-events">'. $text .'</h2>';}
	
	// ===== LOOP: FEATURED EVENT SECTION =====
	
	// - hide events that are older than 6am today (because some parties go past your bedtime)
	
	$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );
	
	// - query -
	global $wpdb;
	$querystr = "
	    SELECT *
	    FROM $wpdb->postmeta metastart, $wpdb->postmeta metaend, $wpdb->posts
	    LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
	    LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
	    LEFT JOIN $wpdb->terms ON($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
	    WHERE ($wpdb->posts.ID = metastart.post_id AND $wpdb->posts.ID = metaend.post_id)
	    AND $wpdb->term_taxonomy.taxonomy = 'tf_eventcategory'
	    AND $wpdb->terms.name = '$group'
	    AND (metaend.meta_key = 'tf_events_enddate' AND metaend.meta_value > $today6am )
	    AND metastart.meta_key = 'tf_events_enddate'
	    AND $wpdb->posts.post_type = 'tf_events'
	    AND $wpdb->posts.post_status = 'publish'
	    ORDER BY metastart.meta_value ASC LIMIT $limit
	 ";
	
	$events = $wpdb->get_results($querystr, OBJECT);
	
	// - declare fresh day -
	$daycheck = null;
	$date_format = get_option('date_format');
	
	// - loop -
	if ($events):
	global $post;
	foreach ($events as $post):
	setup_postdata($post);
	
	// - custom variables -
	$custom = get_post_custom(get_the_ID());
	$sd = $custom["tf_events_startdate"][0];
	$ed = $custom["tf_events_enddate"][0];
	$post_image_id = get_post_thumbnail_id(get_the_ID());
	        if ($post_image_id) {
		             if( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=130&height=130&crop=1', false) ) 
                    	(string) $thumbnail = $thumbnail[0];
                     if( $large = wp_get_attachment_image_src( $post_image_id, 'large' ) ) 
                    	(string) $large = $large[0];
                    }
	
	// - determine if it's a new day -
	$sqldate = date('Y-m-d H:i:s', $sd);
	$longdate = mysql2date($date_format, $sqldate);
	
	// - local time format -
	$time_format = get_option('time_format');
	$stime = date($time_format, $sd);
	$etime = date($time_format, $ed);
	
	// - output - ?>
	    <div class="feat-events">
	        <?php if( has_post_thumbnail() ) { ?>
	            <a class="thumb" href="<?php echo $large; ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" /></a>
	            <div class="thumb-text">
	        <?php } else { ?>
	            <div class="text">
	        <?php } ?>
	                <div class="eventtitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
	                <div class="time"><?php echo $stime . ' - ' . $etime; ?></div>
	                <div class="time"><?php echo $longdate; ?></div>
	                <div class="desc"><?php the_excerpt() ?></div>
	            </div>
	    </div>
	    <div class="clearfix"></div>
	<?php
	endforeach;
	else : // It's important now to show anything otherwise (people forget to update events so you won't want to be showing an error to visitors
	endif;
	
	// ===== RETURN: FULL EVENT SECTION =====
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;

}

add_shortcode('tf-events-feat', 'tf_events_feat');

?>