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
			}
		}
	} elseif ( get_post_type() == 'tf_foodmenu' ) {
		
	} elseif( is_front_page() ) {
		$meta[] = array( 'property' => 'og:type', 'content' => 'website' );
	} elseif( !is_front_page() && is_home() ) {
		$meta[] = array( 'property' => 'og:type', 'content' => 'blog' );
	}


	
	foreach( $meta as $meta_item ) : ?>
		<meta property="<?php echo $meta_item['property'] ?>" content="<?php echo $meta_item['content'] ?>" />
		<?php error_log( '#META# ' . $meta_item['property'] . ' - ' . $meta_item['content'] ); ?>
	<?php endforeach;

}

add_action( 'wp_head', 'tf_add_og_meta_tags' );