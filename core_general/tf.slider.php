<?php

/*
 * Goal of TF Slider
 * 
 * - Create a Slider Post Type
 * - Create a Single Options Page whereby:
 * --- All Sliders are created/modified/deleted
 * --- Sorted via jQuery UI
 * 
 */


// Create Slider Post Type

function create_slider_postype() {

    $args = array(
        'label' => __('Slider'),
        'can_export' => true,
        'show_ui' => false,
        'show_in_nav_menus' => false,
        '_builtin' => false,
        'capability_type' => 'post',
        'menu_icon' => get_bloginfo('template_url').'/themeforce/assets/images/food_16.png',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "food-menu" ),
        'supports'=> array('title', 'thumbnail', 'editor', 'custom-fields') ,
    );

	register_post_type( 'tf_slider', $args);

}

add_action( 'init', 'create_slider_postype' );

// Load JQuery
// TODO Load on Slider Page only

if(is_admin()){
    wp_enqueue_script("jquery-ui-sortable");
    wp_enqueue_script("jquery-ui-draggable");
    wp_enqueue_script('thickbox');
    wp_enqueue_script( 'media-uploader-extensions', TF_URL . '/assets/js/media-uploader.extensions.js' );
    wp_enqueue_script('tfslider', TF_URL . '/assets/js/themeforce-slider.js', array('jquery'));
    wp_enqueue_style('tfslider', TF_URL . '/assets/css/themeforce-slider.css');
}

// Register Page

function themeforce_slider_addpage() {
    add_options_page('Slider Page Title', 'Manage Sliders', 'manage_options', 'themeforce_slider', 'themeforce_slider_page'); 
}

add_action('admin_menu','themeforce_slider_addpage');

// Create Page
// TODO Add functionality to edit existing slides.

function themeforce_slider_page() {
    ?>
    <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Slider Options</h2>
    <h3>Manage Slides</h3>
    <form method="post" action="" name="" onsubmit="return checkformf(this);">
    <ul id="tf-slider-list"> 
    
    <?php
    // Query Custom Post Types  
            $args = array(
                'post_type' => 'tf_slider',
                'post_status' => 'publish',
                'orderby' => 'meta_value_num',
                'meta_key' => '_tfslider_order',
                'order' => 'ASC',
                'posts_per_page' => 99
            );
			
            // - query -
            $my_query = null;
            $my_query = new WP_query($args);
			

            while ($my_query->have_posts()) : $my_query->the_post();

            // - variables -
			
            $custom = get_post_custom(get_the_ID());
            $id = ($my_query->post->ID);
            $order = $custom["_tfslider_order"][0];
            $post_image_id = get_post_thumbnail_id(get_the_ID());
	        if ($post_image_id) {
		             if( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=130&height=130&crop=1', false) ) 
                    	(string) $thumbnail = $thumbnail[0];
	        }
                    
             echo '<li id="listItem_' . $id . '" class="menu-item-handle slider-item">';
             echo '<div class="handle"></div>';
             
             // Thumbnail
             echo '<div class="slider-thumbnail">';
             if($thumbnail) {echo '<img src="' . $thumbnail . '"/>';} else { echo '<img src="' . TF_URL . '/assets/images/slider-empty.jpg">';}
             echo '</div>';
             
             // Content
             echo '<div class="slider-content">';
             echo '<h3>' . get_the_title($id) . '</h3>';
             echo '<p>' . get_the_content($id) . '</p>';
             echo '</div>';
             
             // Update Sortable List
             echo '<input type="text" name="' . 'slider[order][' . $id . ']" size="5" value="' . $order . '" id="input-title"/>';
             echo '</li>';     
                         
             endwhile;   
    ?>

    </ul> 
    
    <input type="hidden" name="update_post" value="1"/> 
    
    <input class="subput" type="submit" name="updatepost" value="Update"/> 
    </form>
    
<?php
// Create New Slide
?>
    
    <h3>Create New Slide</h3>
    
    <form method="post" action="" name="" onsubmit="return checkformf(this);">
        
        <?php _tf_tj_add_image_html_custom( '_tfslider_image', 'Add Image', 0, array( ), '', 'width=80&height=80&crop=1', '' ) ?>

        <input type="text" name="post_title" size="45" id="input-title"/>

        <textarea rows="5" name="post_content" cols="66" id="text-desc"></textarea></br>

        <ul><select name='_tfslider_type' id='slidertype' class='postform' > 
            <option value="image">Image Alone</option> 
            <option value="content">Image & Text</option> 
        </select> 
        </ul>

        <input type="hidden" name="new_post" value="1"/> 

        <input class="subput" type="submit" name="submitpost" value="Post"/> 

    </form>
    
    <?php
        
}

// Save New Slide

function themeforce_slider_catch_submit() {
        // Grab POST Data
        if(isset($_POST['new_post']) == '1') {
        $post_title = $_POST['post_title'];
        $post_content = $_POST['post_content'];
        $slidertype = $_POST['_tfslider_type'];
        $filename = $_POST['_tfslider_image'];
        $new_post = array(
              'ID' => '',
              'post_type' => 'tf_slider',
              'post_author' => $user->ID, 
              'post_content' => $post_content,
              'post_title' => $post_title,
              'post_status' => 'publish',
            );

        // Create New Slide
        $post_id = wp_insert_post($new_post);
        
        // Update Meta Data
        $order_id = intval($post_id)*100;
        update_post_meta( $post_id,'_tfslider_type', $slidertype);
        update_post_meta( $post_id,'_tfslider_order', $order_id);
        
        /*
         * Update Image Meta
         * 
        $wp_filetype = wp_check_filetype(basename($filename), null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
        // you must first include the image.php file
        // for the function wp_generate_attachment_metadata() to work
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data ); */
        
        // Exit
        wp_redirect(wp_get_referer());
        exit;
        }
}

add_action('admin_init', 'themeforce_slider_catch_submit');

// Update Slide
// TODO Add rest of slide content (only testing sort order atm)

function themeforce_slider_catch_update() {
    
    if(isset($_POST['update_post']) == '1') {
    foreach ( $_POST['slider']['order'] as $key => $val ) {
        $slider_order = intval($_POST['slider']['order'][$key]);
        update_post_meta($key, '_tfslider_order', $slider_order);
        }
    wp_redirect(wp_get_referer());
    exit;
    }
}

add_action('admin_init', 'themeforce_slider_catch_update');

// Display Slider
// TODO Alter to match Custom Post Types

function themeforce_slider_image_upload( $button_id, $title, $post_id, $image_ids, $classes, $size, $non_attached_text, $args = array() ) {

	$image_ids = array_filter( (array) $image_ids );

	$buttons = get_option( '_tf_tj_custom_media_buttons' );
	$button = $buttons[$button_id]; 
	$attachments = get_posts("post_type=attachment&post_parent=$post_id");
	
	$default_args = array( 'default_tab' => 'gallery' );
	
	$args = wp_parse_args( $args, $default_args );
	
	?>

	<style>
		.image-wrapper { text-align: center; display: block; padding: 5px; border: 1px solid #DFDFDF; float: left; margin-right: 7px; margin-bottom: 7px; background-color: #F1F1F1; -moz-border-radius: 4px; border-radius: 4px; }
		.sortable .image-wrapper { cursor: move; }
		.sortable .image-wrapper:hover { border-style: dashed; }
		.ui-sortable-placeholder { visibility: visible !important; background-color: transparent; border-style: dashed; }
		.image-wrapper img { display: block; }
		.image-wrapper a { display: block; cursor: pointer; margin: 3px 10px; }
		#<?php echo $button_id; ?>_container { display: block; overflow: hidden; }
		#normal-sortables .postbox .<?php echo $button_id; ?>_submit { padding: 0; margin: 6px 6px 8px; display: block; }
	</style>

	<p class="submit <?php echo $button_id; ?>_submit">
		<a class="add-image button thickbox" style="font-size:11px !important;" onclick="return false;" title="Add Image" href="media-upload.php?button=<?php echo $button_id ?>&amp;post_id=<?php echo $post_id ?><?php echo $post_id > 0 && $attachments && $args['default_tab'] == 'gallery' ? "&amp;tab=gallery" : '' ?>&amp;multiple=<?php echo $button['multiple'] == true ? 'yes' : 'no' ?>&amp;type=image&amp;TB_iframe=true&amp;width=640&amp;height=600">
			<?php echo $title ?>
		</a>

		<input type="hidden" name="<?php echo $button_id ?>" id="<?php echo $button_id ?>" value="<?php echo implode( ',', $image_ids ) ?>" />
	</p>

	<span id="<?php echo $button_id; ?>_container" rel="<?php echo $button_id ?>" class="<?php echo $classes; ?>">

	    <?php foreach( $image_ids as $image_id ) : ?>
	    	 <span class="image-wrapper" id="<?php echo $image_id ?>"><?php echo wp_get_attachment_image( $image_id, $size ); ?>
	    	 <a class="delete_custom_image" rel="<?php echo $button_id ?>:<?php echo $image_id ?>">Remove</a></span>
	    <?php endforeach; ?>

	    <?php if( !$image_ids ) : ?>
	    	<?php if( $non_attached_text === null ) : ?>
	    		<p class="empty-message">No <?php echo $button['text'] ?> Added</p>
	    	<?php else : ?>
	    		<p class="empty-message"><?php echo $non_attached_text ?></p>
	    	<?php endif; ?>
	    <?php endif; ?>

	</span>

	<div style="clear: both;"></div>

	<?php
}


function themeforce_slider_display() {

        ob_start();

        // counter
        $c = 1;

        // - loop -
        while($c <= 5):

        $raw_image = get_option('baseforce_slider_' . $c);
        $type = get_option('baseforce_slider_' . $c . 'type');
        $url = get_option('baseforce_slider_' . $c . 'url');
        $text = get_option('baseforce_slider_' . $c . 'text');
        $button = get_option('baseforce_slider_' . $c . 'button');

        // check if image exists
        if ( $raw_image != '' ) {
		
            if ( $type == 'image' ) {
                
            $image = wpthumb( $raw_image, 'width=960&height=300&crop=1', false);
            
            // show image
                
                echo '<li>';
                if($url != '') { echo '<a href="' . $url . '">'; }
                echo '<img src="' . $image . '" alt="' . __('Slide', 'themeforce') . ' ' . $c . '"';
                echo ' />';
                if($url != '') { echo '</a>'; }
                echo '</li>';
            
            } else {
                
            // show content                 
                
                echo '<li style="background: url(' . $image . ')">';
                echo '<div class="content-text">';
                echo '<span>'. $text . '</span>';
                if($url != '') {echo '<a href="' . $url . '"><div class="content-button">' . $button . '</div></a>';}
                echo '</div>';
                echo '</li>';
                
            }
            		
            $noslides .= $raw_image;
		
        // increase counter
            
        $c++;
        
        }
        endwhile;
                if ( $noslides == '' ) {
            // - check slide pause -
                if ( !get_option('baseforce_slider_pause')) {
                    update_option('baseforce_slider_pause', '4000');
                    }
				echo '<img src="' . get_bloginfo('template_url') . '/images/default_food_1.jpg" />';
				echo '<img src="' . get_bloginfo('template_url') . '/images/default_food_2.jpg" />';
				echo '<img src="' . get_bloginfo('template_url') . '/images/default_food_3.jpg" />';
                }
				
		$output = ob_get_contents();
        ob_end_clean();

        return $output;
		
		}
	
?>