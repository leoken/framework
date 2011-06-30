<?php 

/**
 * Adds the OpenGraph meta tags to the head.
 * 
 */
function tf_add_og_meta_tags() {
	
	global $post;
	
	if( is_admin() )
		return;
	
	$meta = array();
	
	if( get_current_theme() == 'Chowforce' ) 
		$image = array( 'property' => 'og:image', 'content' => get_option('chowforce_logo') );
	elseif( get_current_theme() == 'Pubforce' ) 
		$image = array( 'property' => 'og:image', 'content' => get_option('pubforce_logo') );
	
	//Site name
	$meta[] = array( 'property' => 'og:site_name', 'content' => get_bloginfo() );
	
	if( is_single() ) {
		$meta[] = array( 'property' => 'og:title', 'content' => get_the_title() );
		$meta[] = array( 'property' => 'og:url', 'content' => get_permalink() );
		$meta[] = array( 'property' => 'og:description', 'content' => get_the_excerpt() );
		
		// Content Type
		if( get_post_type() == 'post' ) {
			
			$meta[] = array( 'property' => 'og:type', 'content' => 'article' );
			
			// Post Image
			// we dont use get_post_thumbnail_id as we want to be able
			// to fall back on embadded images etc, which is done through the "post_thumbnail_html"
			// hook, so we get the html and preg_match the image src
			
			$post_thumbnail_html = get_the_post_thumbnail( $post->ID, 'width=100&height=100&crop=1' );
			
			if( $post_thumbnail_html ) {
				
				preg_match( '/ src="([^"]*)/', $post_thumbnail_html, $matches );
			
				if( !empty( $matches[1] ) ) {
			
					$post_thumbnail = $matches[1];
					$meta[] = array( 'property' => 'og:image', 'content' => $post_thumbnail );
				}
			} else {
				$meta[] = $image;
			}
		} elseif ( get_post_type() == 'tf_events' ) {
			
			$meta[] = array( 'property' => 'og:type', 'content' => 'activity' );
			
			// Post Image
			// we dont use get_post_thumbnail_id as we want to be able
			// to fall back on embadded images etc, which is done through the "post_thumbnail_html"
			// hook, so we get the html and preg_match the image src
			
			$post_thumbnail_html = get_the_post_thumbnail( $post->ID, 'width=100&height=100&crop=1' );
			
			if( $post_thumbnail_html ) {
				
				preg_match( '/ src="([^"]*)/', $post_thumbnail_html, $matches );
			
				if( !empty( $matches[1] ) ) {
			
					$post_thumbnail = $matches[1];
					$meta[] = array( 'property' => 'og:image', 'content' => $post_thumbnail );
				}
			} else {
				$meta[] = $image;
			}	
		
		} elseif ( get_post_type() == 'tf_foodmenu' ) {
		
		}
		
	} elseif( is_front_page() ) {
		
		$meta[] = array( 'property' => 'og:type', 'content' => 'restaurant' );
		
		if( $description = get_bloginfo( 'description' ) )
			$meta[] = array( 'property' => 'og:description', 'content' => $description );
				
		if( $phone_number = get_option( 'tf_business_phone' ) ) {
			$meta[] = array( 'property' => 'og:phone_number', 'content' => $phone_number );
		}
		
		$meta[] = $image;
		
	} elseif( !is_front_page() && is_home() ) {
		$meta[] = array( 'property' => 'og:type', 'content' => 'blog' );
		$meta[] = $image;
	}

	foreach( $meta as $meta_item ) : 
		if( $meta_item['content'] ) :?>
			<meta property="<?php echo $meta_item['property'] ?>" content="<?php echo $meta_item['content'] ?>" />
		<?php endif;	
	endforeach;

}

add_action( 'wp_head', 'tf_add_og_meta_tags' );