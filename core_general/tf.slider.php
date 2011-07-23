<?php

/*
 * Goal of TF Slider
 * 
 * - Create a Slider Post Type
 * - Create a Single Options Page whereby:
 * --- All Sliders are created/modified/deleted
 * --- Sorted via jQuery UI
 * - Not allow any outside manipulation (i.e. wp_insert_post)
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

if(is_admin()){
    wp_enqueue_script('tfslider', TF_URL . '/assets/js/themeforce-slider.js', array('jquery'));
    wp_enqueue_style('tfslider', TF_URL . '/assets/css/themeforce-slider.css');
}

// Register Page

function themeforce_slider_addpage() {
    add_options_page('Slider Page Title', 'Manage Sliders', 'manage_options', 'themeforce_slider', 'themeforce_slider_page'); 
}

add_action('admin_menu','themeforce_slider_addpage');

// Create Page

function themeforce_slider_page() {
    ?>
    <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Slider Options</h2>
    <h3>Manage Slides</h3>
    <ul id="test-list"> 
    
    <?php
    // Query Custom Post Types  
            $args = array(
                'post_type' => 'tf_slider',
                'post_status' => 'publish',
                'orderby' => 'title',
                'order' => 'ASC',
                'posts_per_page' => 99
            );
			
            // - query -
            $my_query = null;
            $my_query = new WP_query($args);
			
		
            while ($my_query->have_posts()) : $my_query->the_post();

            // - variables -
			
            $custom = get_post_custom(get_the_ID());
            /* $price1 = $custom["tf_menu_price1"][0]; */

            /* $post_image_id = get_post_thumbnail_id(get_the_ID());
                    if ($post_image_id) {
                            if( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=60&height=60&crop=1', false) ) 
                            	(string) $thumbnail = $thumbnail[0];
                            if( $large = wp_get_attachment_image_src( $post_image_id, 'large' ) ) 
                            	(string) $large = $large[0];
                    } */
                    
             echo '<li id="listItem_1" class="menu-item-handle slider-item">';
             echo '<div class="handle"></div>';
             echo '<strong>' . the_title() . '</strong></a>';
             echo '</li>';     
                    
                    
            endwhile;
            
    // Dummy Content for Comparison        
    ?>

      <li id="listItem_1" class="menu-item-handle slider-item"> 
        <div class="handle"></div>
        <strong>Slider 1 </strong></a> 
      </li> 
      <li id="listItem_2" class="menu-item-handle slider-item"> 
        <div class="handle"></div>
        <strong>Slider 2</strong> 
      </li> 
      <li id="listItem_3" class="menu-item-handle slider-item"> 
        <div class="handle"></div>
        <strong>Slider 3</strong> 
      </li> 
      <li id="listItem_4" class="menu-item-handle slider-item"> 
        <div class="handle"></div> 
        <strong>Slider 4</strong> 
      </li> 
    </ul> 
<?php
// Create New Slide
?>
    
    <h3>Create New Slide</h3>
    
    <form method="post" action="" name="" onsubmit="return checkformf(this);">

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

    <form action="options.php" method="post"></form>
    
    <?php
    
        if(isset($_POST['new_post']) == '1') {
        $post_title = $_POST['post_title'];
        $post_content = $_POST['post_content'];
        $slidertype = $_POST['_tfslider_type'];
        $new_post = array(
              'ID' => '',
              'post_type' => 'tf_slider',
              'post_author' => $user->ID, 
              'post_content' => $post_content,
              'post_title' => $post_title,
              'post_status' => 'publish',
            );

        $post_id = wp_insert_post($new_post);
        update_post_meta( $the_post_idit,'_tfslider_type', $slidertype);
        wp_redirect(wp_get_referer());
        exit;
        }

    
}

// Display Slider
// TODO Alter to match Custom Post Types

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