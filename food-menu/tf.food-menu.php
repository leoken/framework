<?php
/* ------------------- THEME FORCE ---------------------- */

require_once( TF_PATH . '/food-menu/tf.food-menu.shortcodes.php' );
require_once( TF_PATH . '/food-menu/tf.food-menu.quick-edit.php' );

/*
 * FOOD MENU FUNCTION (CUSTOM POST TYPE)
 */

// 1. Custom Post Type Registration (Menu Items)

function create_foodmenu_postype() {

    $labels = array(
        'name' => __( 'Food Menu' ),
        'singular_name' => __( 'Food Menu' ),
        'add_new' => __( 'Add Menu Item' ),
        'add_new_item' => __( 'Add New Menu Item' ),
        'edit' => __( 'Edit' ),
        'edit_item' => __( 'Edit Menu Item' ),
        'new_item' => __( 'New Menu Item' ),
        'view' => __( 'View Menu Item' ),
        'view_item' => __( 'View Menu Item' ),
        'search_items' => __( 'Search  Menu Items' ),
        'not_found' => __( 'No  Menu Items found' ),
        'not_found_in_trash' => __( 'No  Menu Items found in Trash' ),
        'parent' => __( 'Parent Menu Item' ),
    );

    $args = array(
        'label' => __('Food Menu'),
        'labels' => $labels,
        'public' => true,
        'can_export' => true,
        'show_ui' => true,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'menu_icon' => get_bloginfo('template_url').'/themeforce/assets/images/food_16.png',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "food-menu" ),
        'supports'=> array('title', 'thumbnail', 'editor') ,
        'show_in_nav_menus' => true,
        'taxonomies' => array( 'tf_foodmenucat', 'post_tag')
    );

	register_post_type( 'tf_foodmenu', $args);

}

add_action( 'init', 'create_foodmenu_postype' );

// 2. Custom Taxonomy Registration (Menu Types)

function create_foodmenucategory_taxonomy() {

    $labels = array(
        'name' => __( 'Menu Categories' ),
        'singular_name' => __( 'Food Menu Category' ),
        'search_items' =>  __( 'Search Food Menu Categories' ),
        'popular_items' => __( 'Popular Food Menu Categories' ),
        'all_items' => __( 'All Food Menu Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Food Menu Category' ),
        'update_item' => __( 'Update Food Menu Category' ),
        'add_new_item' => __( 'Add New Food Menu Category' ),
        'new_item_name' => __( 'New Food Menu Category Name' ),
    );

    register_taxonomy('tf_foodmenucat','tf_foodmenu', array(
        'label' => __('Menu Category'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'menus' ),
    ));
}

add_action( 'init', 'create_foodmenucategory_taxonomy', 0 );

// 3. Show Columns

add_filter ("manage_edit-tf_foodmenu_columns", "tf_foodmenu_edit_columns");
add_action ("manage_posts_custom_column", "tf_foodmenu_custom_columns");

function tf_foodmenu_edit_columns($columns) {

 	$columns = array(
 		"cb" => "<input type=\"checkbox\" />",
 		"tf_col_menu_thumb" => '',
 		//"tf_col_menu_id" => __('ID'),
 		//"tf_col_menu_order" => __('Order'),
 		"title" => __('Item'),
 		"tf_col_menu_cat" => __('Section'),
 		"tf_col_menu_desc" => __('Description'),
 		"tf_col_menu_size" => __('Size(s)'),
 		"tf_col_menu_price" => __('Price(s)'),
 	);
 	
 	return $columns;
}

function tf_foodmenu_custom_columns($column)
{
	global $post;
	$custom = get_post_custom();
	switch ($column) {
		case "tf_col_menu_id":
				echo $post->ID;
				break;
		case "tf_col_menu_order":
				$order = $custom["tf_menu_order"][0];
				echo $order;
				break;
		case "tf_col_menu_cat":
				$menucats = get_the_terms($post->ID, "tf_foodmenucat");
				$menucats_html = array();
				if ($menucats) {
				foreach ($menucats as $menucat)
				        array_push($menucats_html, $menucat->name);
				
				echo implode($menucats_html, ", ");
				} else {
				        _e('None', 'themeforce');;
				}
				break;
		case "tf_col_menu_desc":
				add_filter( 'excerpt_length', '_tf_food_menu_excerpt_length' );
		       	the_excerpt();
		       	tf_food_menu_inline_date( $post->ID );
		       	break;
		case "tf_col_menu_thumb":
		       
				the_post_thumbnail( 'width=50&height=50&crop=1' );
				break;
		case "tf_col_menu_size":
				$size1 = $custom["tf_menu_size1"][0];
				$size2 = $custom["tf_menu_size2"][0];
				$size3 = $custom["tf_menu_size3"][0];
				$output = '';
				if ($size1 != '') { echo $size1; }
				if ($size2 != '') { echo '<br />'; echo $size2; }
				if ($size3 != '') { echo '<br />'; echo $size3; }
				break;    
		case "tf_col_menu_price":
				$price1 = $custom["tf_menu_price1"][0];
				$price2 = $custom["tf_menu_price2"][0];
				$price3 = $custom["tf_menu_price3"][0];
				
				$output = '';
				if ($price1 != '') { echo get_option('tf_currency_symbol').''.$price1; }
				if ($price2 != '') { echo '<br />'; echo get_option('tf_currency_symbol').''.$price2; }
				if ($price3 != '') { echo '<br />'; echo get_option('tf_currency_symbol').''.$price3; }
				break;
	}
}

// 4. Show Meta-Box

add_action( 'admin_init', 'tf_foodmenu_create' );

function tf_foodmenu_create() {
    add_meta_box('tf_foodmenu_meta', __('Food Menu','themeforce'), 'tf_foodmenu_meta', 'tf_foodmenu');
}

function tf_foodmenu_meta () {
    global $post;
    $custom = get_post_custom($post->ID);
    $metaorder = $custom["tf_menu_order"][0];
    $metasize1 = $custom["tf_menu_size1"][0];
    $metasize2 = $custom["tf_menu_size2"][0];
    $metasize3 = $custom["tf_menu_size3"][0];
    $metaprice1 = $custom["tf_menu_price1"][0];
    $metaprice2 = $custom["tf_menu_price2"][0];
    $metaprice3 = $custom["tf_menu_price3"][0];

    // - security -

    echo '<input type="hidden" name="tf-foodmenu-nonce" id="tf-foodmenu-nonce" value="' .
    wp_create_nonce( 'tf-foodmenu-nonce' ) . '" />';

    // - output -

    ?>

    <div class="tf-meta">
        <ul>
            <li><label>Order ID</label><input name="tf_menu_order" value="<?php echo $metaorder; ?>" /><em><?php _e('Enabled in Theme Options - Use a number to order menu items.', 'themeforce'); ?></em></li>
            <li><label>Size 1</label><input name="tf_menu_size1" value="<?php echo $metasize1; ?>" /><em><?php _e('All Sizes are Optional', 'themeforce'); ?></em></li>
            <li><label>Size 2</label><input name="tf_menu_size2" value="<?php echo $metasize2; ?>" /></li>
            <li><label>Size 3</label><input name="tf_menu_size3" value="<?php echo $metasize3; ?>" /></li>
            <li><label>Price 1</label><input name="tf_menu_price1" value="<?php echo $metaprice1; ?>" /><em><?php _e('Use the decimal format you want display (i.e. 1, 1.9 , 1.99)', 'themeforce'); ?></em></li>
            <li><label>Price 2</label><input name="tf_menu_price2" value="<?php echo $metaprice2; ?>" /></li>
            <li><label>Price 3</label><input name="tf_menu_price3" value="<?php echo $metaprice3; ?>" /></li>
        </ul>
    </div>

    <?php
}

// 5. Save Data

add_action ('save_post', 'save_tf_menuitem');

function save_tf_menuitem(){

    global $post;

    // - check nonce & permissions

    if ( !wp_verify_nonce( $_POST['tf-foodmenu-nonce'], 'tf-foodmenu-nonce' )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // - update post

    if(!isset($_POST["tf_menu_order"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_order", $_POST["tf_menu_order"]);

    if(!isset($_POST["tf_menu_size1"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_size1", $_POST["tf_menu_size1"]);

    if(!isset($_POST["tf_menu_size2"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_size2", $_POST["tf_menu_size2"]);

    if(!isset($_POST["tf_menu_size1"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_size3", $_POST["tf_menu_size3"]);

    if(!isset($_POST["tf_menu_price1"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_price1", $_POST["tf_menu_price1"]);

    if(!isset($_POST["tf_menu_price2"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_price2", $_POST["tf_menu_price2"]);

    if(!isset($_POST["tf_menu_price1"])):
    return $post;
    endif;
    update_post_meta($post->ID, "tf_menu_price3", $_POST["tf_menu_price3"]);
    
}

// 6. Customize Update Messages

add_filter('post_updated_messages', 'menu_updated_messages');

function menu_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['tf_foodmenu'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Menu item updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Menu item updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Menu item restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Menu item published. <a href="%s">View menu item</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Menu saved.'),
    8 => sprintf( __('Menu item submitted. <a target="_blank" href="%s">Preview menu item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Menu item scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview menu item</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Menu item draft updated. <a target="_blank" href="%s">Preview menu item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// 7. Create Initial Terms

add_action( 'init', 'create_foodmenu_tax', 10 );

function create_foodmenu_tax() {

    if (get_option('tf_added_default_food_terms') != 'updated') {
        // Create the terms
        if (term_exists('Appetizers', 'tf_foodmenucat') == false ) {
            wp_insert_term(
              'Appetizers',
              'tf_foodmenucat'
              );
         }
        if (term_exists('Main Courses', 'tf_foodmenucat') == false ) {
            wp_insert_term(
              'Main Courses',
              'tf_foodmenucat'
              );
         }
         if (term_exists('Desserts', 'tf_foodmenucat') == false ) {
            wp_insert_term(
              'Desserts',
              'tf_foodmenucat'
              );
         }
         // Register update so that it's not repeated
         update_option('tf_added_default_food_terms','updated');
    }
}

function tf_food_menu_restrict_manage_posts() {
	
	if( empty( $_GET['post_type'] ) || $_GET['post_type'] !== 'tf_foodmenu' )
		return;
	?>
	<style type="text/css">
		select[name="m"] { display: none; }
	</style>
	
	<select name="term">
		<option value="">Section</option>
		<?php foreach( get_terms( 'tf_foodmenucat' ) as $cat ) : ?>
			<option <?php selected( !empty( $_GET['term'] ) && $_GET['term'] == $cat->slug, true ) ?> value="<?php echo $cat->slug ?>"><?php echo $cat->name ?></option>
		<?php endforeach; ?>
	</select>
	<input name="taxonomy" value="tf_foodmenucat" type="hidden" />
	<?php

}
add_action( 'restrict_manage_posts', 'tf_food_menu_restrict_manage_posts' );


/**
 * Gets the varients of the food item (size and price).
 * 
 * @param int $post_id
 * @return array
 */
function tf_food_menu_get_food_varients( $post_id ) {

	$custom = get_post_custom($post_id);

    $metasize1 = $custom["tf_menu_size1"][0];
    $metasize2 = $custom["tf_menu_size2"][0];
    $metasize3 = $custom["tf_menu_size3"][0];
    $metaprice1 = $custom["tf_menu_price1"][0];
    $metaprice2 = $custom["tf_menu_price2"][0];
    $metaprice3 = $custom["tf_menu_price3"][0];
    
    $varients = array();
    
    if( $metasize1 || $metaprice1 )
    	$varients[] = array( 'size' => $metasize1, 'price' => $metaprice1 );

    if( $metasize2 || $metaprice2 )
    	$varients[] = array( 'size' => $metasize2, 'price' => $metaprice2 );
    
    if( $metasize3 || $metaprice3 )
    	$varients[] = array( 'size' => $metasize3, 'price' => $metaprice3 );
    
    return $varients;
}

function tf_food_menu_update_food_varients( $post_id, $varients ) {
	
	update_post_meta( $post_id, 'tf_menu_size1', $varients[0]['size'] );
	update_post_meta( $post_id, 'tf_menu_size2', $varients[1]['size'] );
	update_post_meta( $post_id, 'tf_menu_size3', $varients[2]['size'] );
	update_post_meta( $post_id, 'tf_menu_price1', $varients[0]['price'] );
	update_post_meta( $post_id, 'tf_menu_price2', $varients[1]['price'] );
	update_post_meta( $post_id, 'tf_menu_price3', $varients[2]['price'] );			
}

function _tf_food_menu_excerpt_length() {
	return 7;
}