<?php if (have_posts()) : while (have_posts()) : the_post(); 

	// - custom variables -
	$custom = get_post_custom(get_the_ID());
	$sd = $custom["tf_events_startdate"][0];
	$ed = $custom["tf_events_enddate"][0];
		$post_image_id = get_post_thumbnail_id(get_the_ID());
	        if ($post_image_id) {
		             if( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=130&height=130&crop=1', false) ) 
                    	(string) $thumbnail = $thumbnail[0];
	        }
	
	// - determine date -
	$sqldate = date('Y-m-d H:i:s', $sd);
	$schema_startdate = date('Y-m-d\TH:i', $sd); // <- Date for Schema
	$schema_enddate = date('Y-m-d\TH:i', $ed); // <- Date for Schema
	$date_format = get_option('date_format');
	$local_startdate = mysql2date($date_format, $sqldate); // <- Date for Display
	
	// - determine duration -
	$schema_duration = ($ed-$sd)/60; // Duration for Schema

	// - local time format -
	$time_format = get_option('time_format');
	$stime = date($time_format, $sd); // <- Start Time
	$etime = date($time_format, $ed); // <- End Time

	// - grab categories -
	$category = tf_list_cats();

?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<!-- www.schema.org -->
	
	<!-- type --> <div itemscope itemtype="http://data-vocabulary.org/Event">
	
		<div class="events-single-meta">
		
		<?php if($thumbnail != '') {?>
		<!-- img -->  <img itemprop="photo" src="<?php echo $thumbnail; ?>" />
		<?php } ?>
        <!-- url -->  <a itemprop="url" href="<?php the_permalink(); ?>">
        <!-- name --> <h1 class="post-title" itemprop="summary"><?php the_title(); ?></h1>
        <!-- /url --> </a>
        <!-- category --> <?php if ( $category != '') { ?><div class=""><?php _e('Category: ','themeforce');?><span itemprop="eventType"><?php echo $category; ?></span></div><?php } ?>
	
        <!-- dates, time & duration -->
        <div class="events-single-meta-details"><?php _e('Date: ','themeforce');?><span itemprop="startDate" datetime="<?php echo $schema_startdate; ?>"><?php echo $local_startdate; ?> - <?php echo $stime; ?></span>
       	<span itemprop="endDate" datetime="<?php echo $schema_enddate; ?>">( <?php _e('Ends','themeforce');?> <?php echo $etime; ?> )</span></div>
        <meta itemprop="duration" content="PT<?php echo $schema_duration; ?>M" />
        
        <!-- location --> <div class="events-single-meta-details"><?php _e('Location: ','themeforce');?><span itemprop="location"><?php echo get_option('tf_business_name');?>, <?php echo get_option('tf_business_address');?></span></div>
     
    	</div> 
        
        <div class="post">
       
        <!-- desc --><span itemprop="description"><?php the_content(); ?></span>
            
    	</div>
    	
    </div>

    <!-- / www.schema.org -->
    
    </div>

    <?php comments_template( '', true ); ?>

<?php endwhile; else: ?>

    <div class="content">
        <p><?php _e('Sorry, this page is not available. Please return to the main page or use the navigation above. ', 'themeforce'); ?></p>
    </div>

<?php endif; ?>