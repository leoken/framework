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

// Register Page

function themeforce_slider_addpage() {
    add_options_page('Slider Page Title', 'Manage Sliders', 'manage_options', 'themeforce_slider', 'themeforce_slider_page');
}

add_action('admin_menu','themeforce_slider_addpage');

// Load jQuery & relevant CSS

// js
function themeforce_slider_scripts() {
    // standards
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-draggable');
    wp_enqueue_script('thickbox');
    // other
    wp_enqueue_script( 'jalerts', TF_URL . '/assets/js/jquery.alerts.js' );
    wp_enqueue_script( 'media-uploader-extensions', TF_URL . '/assets/js/media-uploader.extensions.js' );
    // option page settings
    wp_enqueue_script( 'tfslider', TF_URL . '/assets/js/themeforce-slider.js', array('jquery'));
}

add_action( 'admin_print_scripts-settings_page_themeforce_slider', 'themeforce_slider_scripts' );

// css
function themeforce_slider_styles() {
    wp_enqueue_style( 'jalerts', TF_URL . '/assets/css/jquery.alerts.css');
    wp_enqueue_style( 'tfslider', TF_URL . '/assets/css/themeforce-slider.css');
}

add_action( 'admin_print_styles-settings_page_themeforce_slider', 'themeforce_slider_styles' );

// Create Page
// TODO Add functionality to edit existing slides.

function themeforce_slider_page() {
    ?>
    <div class="wrap" id="tf-slider-page">
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
            $link = $custom["tfslider_link"][0];
            $button = $custom["tfslider_button"][0];
            $image = $custom["_tfslider_image"][0];
            $thumbnail = wpthumb( $image, 'width=250&height=100&crop=1', false);
                    
             echo '<li id="listItem_' . $id . '" class="menu-item-handle slider-item">';
             echo '<div class="slider-controls">';
                 echo '<div class="handle"></div>';
                 echo '<div class="slider-edit"></div>';
                 echo '<div class="slider-delete"></div>';
             echo '</div>';
             
             // ID
             echo '<input type="hidden" name="' . 'slider[id][' . $id . ']" value="' . $id . '" />';
             
             // Thumbnail
             echo '<div class="slider-thumbnail">';
             if($thumbnail) {echo '<img src="' . $thumbnail . '"/>';} else { echo '<img src="' . TF_URL . '/assets/images/slider-empty.jpg">';}
             echo '</div>';
             
             // Content
             echo '<div class="slider-content">';
             echo '<h3><span>' . get_the_title($id) . '</span><input style="display:none;" type="text" name="' . 'slider[title][' . $id . ']" size="45" id="input-title" value="' . get_the_title($id)  . '" /></h3>';
             echo '<p><span>' . get_the_content($id) . '</span><textarea style="display:none;" rows="5" cols="40" name="' . 'slider[content][' . $id . ']">' . get_the_content($id)  . '</textarea></p>';
             echo '<p><span>' . $link . '</span><input style="display:none;" type="text" name="' . 'slider[link][' . $id . ']" size="45" id="input-title" value="' . $link  . '" /></p>';
             echo '<p><span>' . $button . '</span><input style="display:none;" type="text" name="' . 'slider[button][' . $id . ']" size="45" id="input-title" value="' . $button  . '" /></p>';
             echo '</div>';
             
             // Update Sortable List
             echo '<input type="hidden" name="' . 'slider[order][' . $id . ']" value="' . $order . '" id="input-title"/>';
             
             // Update Delete Field
             echo '<input type="hidden" name="' . 'slider[delete][' . $id . ']" value="false" id="input-title"/>';
             echo '</li>';     
                         
             endwhile;   
    ?>

    </ul> 
    
    <input type="hidden" name="update_post" value="1"/> 
    
    <input type="submit" name="updatepost" value="Update" class="button-primary" /> 
    </form>
    
<?php
// Create New Slide
?>
    
    <h3>Create New Slide</h3>
    
    <form method="post" action="" name="" onsubmit="return checkformf(this);">
    <div id="add-tf-slider">    
        <div id="add-tf-box">
            <strong>Image</strong>
            <div class="input-row">
                <label>Type of Slide<div class="required">*</div></label>
                <ul>
                    <select name='_tfslider_type' id='slidertype' class='postform' > 
                        <option value="image">Image Alone</option> 
                        <option value="content">Image & Text</option> 
                    </select> 
                </ul>
            </div>
            
            <div class="input-row">
                <?php // TODO Would be nice to have the 250x100 thumbnail replace the upload button once the image is ready ?>
                <label>Pick an Image<div class="required">*</div></label><input id="tfslider_image" type="text" name="_tfslider_image" value="" /><input id="upload_image_button" type="button" value="Upload Image" />
            </div>
            
            <div class="input-row">
                <label>Slide Link</label><input type="text" name="tfslider_link" size="45" id="input-title"/>
                <span>If you'd like your slide to link to a page, enter the URL here.</span>
            </div> 
            
        </div>
        
        <div style="clear:both"></div>
        
        <div id="add-tf-box">
            <strong>Additional Fields for Content Slides</strong>

            <div class="input-row">
                <label>Slider Header</label><input type="text" name="post_title" size="45" id="input-title"/>
            </div>    

            <div class="input-row">
                <label>Slide Description</label>
                <textarea rows="5" name="post_content" cols="66" id="text-desc"></textarea></br>
            </div> 
            
            <div class="input-row">
                <label>Button Text</label><input type="text" name="tfslider_button" size="45" id="input-title"/>
                <span>If you've chosen a link above, it'll turn into a button for content slides.</span>
            </div> 


        </div>
        </div>
        <input type="hidden" name="new_post" value="1"/> 

        <input type="submit" name="submitpost" class="button-primary menu-save" value="Post"/> 

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
        $imageurl = $_POST['_tfslider_image'];
        $link = $_POST['tfslider_link'];
        $button = $_POST['tfslider_button'];
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
        update_post_meta( $post_id,'_tfslider_image', $imageurl);
        update_post_meta( $post_id,'tfslider_link', $link);
        update_post_meta( $post_id,'tfslider_button', $button);
        
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
        
        // Grab General Data
        $my_post = array();
        $my_post['ID'] = $_POST['slider']['id'][$key];
        $my_post['post_title'] = $_POST['slider']['title'][$key];
        $my_post['post_content'] = $_POST['slider']['content'][$key];
        
        // Grab Delete Setting
        $delete = $_POST['slider']['delete'][$key];
        
        
        if ($delete == 'true') {
            
            // Delete selected sliders
            wp_delete_post( $key, true );
        
                
        } else {

            // Update Regular Post
            wp_update_post( $my_post );
            
            // Update Meta
            $button = intval($_POST['slider']['button'][$key]);
            $link = intval($_POST['slider']['link'][$key]);
            $slider_order = intval($_POST['slider']['order'][$key]);
            update_post_meta($key, 'tfslider_button', $button);
            update_post_meta($key, 'tfslider_link', $link);
            update_post_meta($key, '_tfslider_order', $slider_order);
        }
    }    
        
    wp_redirect(wp_get_referer());
    exit;
    }
}

add_action('admin_init', 'themeforce_slider_catch_update');

// Upload Image



//TODO Change function to match custom post types, not options.
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