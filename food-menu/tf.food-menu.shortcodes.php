<?php
/* ------------------- THEME FORCE ---------------------- */

/*
 * FOOD MENU SHORTCODES (CUSTOM POST TYPE)
 *
 * [tf-menu-full id='Desserts' header='yes' currency='yes' type='menu']
 * [tf-menu-list id='Mains' header='yes' currency='yes' type='menu']
 * [tf-menu-short id='Mains' header='yes' currency='yes' type='menu']
 *
 */

// 1) FULL MENU
//***********************************************

function tf_menu_full ( $atts ) {

        // - get options -
        $defaultfx = get_option('tf_menu_currency_symbol');

        // - define arguments -
        extract(shortcode_atts(array(
             'id' => '', // Menu Name or Post ID
             'header' => 'yes', // Menu Section Header On or Off
             'currency'=> $defaultfx, // Currency On or Off
             'type' => 'menu', // Menu or Single
             'align' => '', // For full width
             'posts_per_page' => 99,
         ), $atts));

    // ===== OUTPUT FUNCTION =====

        ob_start();

    // ===== OPTIONS =====

        // - full-width check -
        if( $align ) { echo '<div style="clear:' . $align . '"></div><div class="' . $align . ' half-col">';}

        // - header text -
        if ($header=="yes") {
             echo '<h2 class="full-menu">'. $id .'</h2>';}

        // - currency -
        $fx = null;
        if ($currency=='true') {
             $fx = get_option('tf_currency_symbol');}

        // - taxonomy group or single post -
        if ($type=="menu") {
            $posttype = 'tf_foodmenucat';
        } else {
            $posttype = 'p';}

     // ===== LOOP: FULL MENU SECTION =====

            // - get options -
                $sortfield = get_option('tf_menu_sort_key');
                $metakey = null;
                $orderby = 'title';
                if ($sortfield=='true') { $metakey = 'tf_menu_order'; $orderby = 'meta_value';}
		if ($posttype=='p') { $metakey = 'null'; $orderby = 'title';}

            // - arguments -
            $args = array(
                'post_type' => 'tf_foodmenu',
                $posttype => $id,
                'post_status' => 'publish',
                'orderby' => $orderby,
                'meta_key' => $metakey,
                'order' => 'ASC',
                'posts_per_page' => 99,
            );

            // - query -
            $my_query = null;
            $my_query = new WP_query($args);
            
            while ($my_query->have_posts()) : $my_query->the_post();

            // - variables -
            $custom = get_post_custom(get_the_ID());
            $price1 = $custom["tf_menu_price1"][0];
            $price2 = $custom["tf_menu_price2"][0];
            $price3 = $custom["tf_menu_price3"][0];
            $size2 = $custom["tf_menu_size2"][0];
            $size3 = $custom["tf_menu_size3"][0];
            $post_image_id = get_post_thumbnail_id(get_the_ID());
                    if ($post_image_id) {
                            if( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=60&height=60&crop=1', false) ) 
                            	(string) $thumbnail = $thumbnail[0];
                            if( $large = wp_get_attachment_image_src( $post_image_id, 'large' ) ) 
                            	(string) $large = $large[0];
                    }

            // - output -
            ?>

                <div class="full-menu">
                    <?php if( has_post_thumbnail() ) { ?>
                    <a class="thumb" href="<?php echo $large; ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" /></a>
                    <div class="thumb-text">
                    <?php } else { ?>
                    <div class="text">
                    <?php } ?>
                        <div class="title">
                            <div class="left"><?php the_title(); ?></div>
                            <div class="right"><?php echo $fx; echo $price1 ?></div>
                        </div>
                        <div class="desc"><?php the_content_rss(); ?></div>

                        <?php if ($size2=="") {?>
                        </div><?php ;} else { ?>
                        <div class="extrasizes"><?php echo $size2 ?> <strong> <?php echo $fx; echo $price2 ?></strong>
                        <?php if ($size3=="") {?></div></div><?php ;} else { ?> , <?php echo $size3 ?><strong> <?php echo $fx; echo $price3 ?></strong></div></div><?php ;}} ?>
                </div>
                <div class="clearfix"></div>
        <?php
        endwhile;
        if( $align ) { echo '</div>';}

    // ===== RETURN: FULL MENU SECTION =====
        
        $output = ob_get_contents();
        ob_end_clean();

        return $output;

        }

add_shortcode('tf-menu-full', 'tf_menu_full');


//------------------------------------------------------------------------------


// 2) LIST MENU
//***********************************************

function tf_menu_list ( $atts ) {

    extract(shortcode_atts(array(
         'id' => '', // Menu Name or Post ID
         'header' => 'yes',
         'currency'=> get_option('tf_menu_currency_symbol'),
         'type' => 'menu', // Menu or Single
         'posts_per_page' => 99,
         'align' => '', // For full width
     ), $atts));

    // ===== OUTPUT FUNCTION =====

    ob_start();

    // ===== OPTIONS =====

        // - full-width check -
        if( $align ) { echo '<div style="clear:' . $align . '"></div><div class="' . $align . ' half-col">';}

        // - header text -
        if ($header=="yes") {
             echo '<h2 class="full-menu">'. $id .'</h2>';}

        // - currency -
        $fx = null;
        if ($currency=='true') {
             $fx = get_option('tf_currency_symbol');}

        // - taxonomy group or single post -
        if ($type=="menu") {
            $posttype = 'tf_foodmenucat';
        } else {
            $posttype = 'p';}

     // ===== LOOP: LIST MENU SECTION =====

	// - get options -
	$sortfield = get_option('tf_menu_sort_key');
	$metakey = null;
	$orderby = 'title';
	if ($sortfield=='true') { $metakey = 'tf_menu_order'; $orderby = 'meta_value';}
	if ($posttype=='p') { $metakey = 'null'; $orderby = 'title';}
	 
            // - arguments -
            $args = array(
                'post_type' => 'tf_foodmenu',
                $posttype => $id,
                'post_status' => 'publish',
		'orderby' => $orderby,
                'meta_key' => $metakey,
                'order' => 'ASC',
                'posts_per_page' => 99,
                'align' => '', // For full width
            );

            // - query -
            $my_query = null;
            $my_query = new WP_query($args);
            while ($my_query->have_posts()) : $my_query->the_post();

            // - variables -
            $custom = get_post_custom(get_the_ID());
            $price1 = $custom["tf_menu_price1"][0];
            $price2 = $custom["tf_menu_price2"][0];
            $price3 = $custom["tf_menu_price3"][0];
            $size1 = $custom["tf_menu_size1"][0];
            $size2 = $custom["tf_menu_size2"][0];
            $size3 = $custom["tf_menu_size3"][0];

            // - output -
            ?>

            <div class="mid-menu">
            <div class="leftbox">
                <div class="title"><div class="left"><?php the_title(); ?></div></div>
                <div class="desc"><?php the_content_rss(); ?></div>
            </div>
            <div class="rightbox"><?php if ($size1!="") { ?><div class="size"><?php echo $size1 ?></div><?php ;} ?><div class="price"><?php echo $fx; echo $price1 ?></div></div>
                <?php if ($size2!="") {?><div class="rightbox"><div class="size"><?php echo $size2 ?></div><div class="price"><?php echo $fx; echo $price2 ?></div></div><?php ;} ?>
                <?php if ($size3!="") {?><div class="rightbox"><div class="size"><?php echo $size3 ?></div><div class="price"><?php echo $fx; echo $price3 ?></div></div><?php ;} ?>
        </div>
        <div class="clearfix"></div>
        <?php
        endwhile;
        if( $align ) { echo '</div>';}

$output = ob_get_contents();
ob_end_clean();

return $output;

}

add_shortcode('tf-menu-list', 'tf_menu_list');


//------------------------------------------------------------------------------


// 3) SMALL MENU
//***********************************************

function tf_menu_short ( $atts ) {

    $defaultfx = get_option('tf_menu_currency_symbol');

    extract(shortcode_atts(array(
         'id' => '', // Menu Name or Post ID
         'header' => 'yes',
         'currency'=> $defaultfx,
         'type' => 'menu', // Menu or Single
     ), $atts));

    // ===== OUTPUT FUNCTION =====

    ob_start();

    // ===== OPTIONS =====

        // - header text -
        if ($header=="yes") {
             echo '<h2 class="full-menu">'. $id .'</h2>';}

        // - currency -
        $fx = null;
        if ($currency=='true') {
             $fx = get_option('tf_currency_symbol');}

        // - taxonomy group or single post -
        if ($type=="menu") {
            $posttype = 'tf_foodmenucat';
        } else {
            $posttype = 'p';}

     // ===== LOOP: SMALL MENU SECTION =====

	// - get options -
	$sortfield = get_option('tf_menu_sort_key');
	$metakey = null;
	$orderby = 'title';
	if ($sortfield=='true') { $metakey = 'tf_menu_order'; $orderby = 'meta_value';}
	if ($posttype=='p') { $metakey = 'null'; $orderby = 'title';}
	 
            // - arguments -
            $args = array(
                'post_type' => 'tf_foodmenu',
                $posttype => $id,
                'post_status' => 'publish',
		'orderby' => $orderby,
                'meta_key' => $metakey,
                'order' => 'ASC',
                'posts_per_page' => 99,
            );

            // - query -
            $counter = 1;
            $global_counter = 0;
            $my_query = null;
            $my_query = new WP_query($args);
            while ($my_query->have_posts()) : $my_query->the_post();

            // - variables -
            $custom = get_post_custom(get_the_ID());
            $price1 = $custom["tf_menu_price1"][0];
            $price2 = $custom["tf_menu_price2"][0];
            $price3 = $custom["tf_menu_price3"][0];
            $size1 = $custom["tf_menu_size1"][0];
            $size2 = $custom["tf_menu_size2"][0];
            $size3 = $custom["tf_menu_size3"][0];
            $odd_even_checker = ($counter%2) ? TRUE : FALSE;

            // - output -
            ?>
            <div class="small-menu <?php if (!$odd_even_checker) { ?>right<?php } else { ?>left<?php } ?>">
            <div class="leftbox">
                <div class="title"><div class="lefttext"><?php the_title(); ?></div></div>
                <div class="desc"><?php the_content_rss(); ?></div>
            </div>
                <div class="rightbox"><?php if ($size1!="") { ?><div class="size"><?php echo $size1 ?></div><?php ;} ?><div class="price"><?php echo $fx; echo $price1 ?></div></div>
                <?php if ($size2!="") {?><div class="rightbox"><div class="size"><?php echo $size2 ?></div><div class="price"><?php echo $fx; echo $price2 ?></div></div><?php ;} ?>
                <?php if ($size3!="") {?><div class="rightbox"><div class="size"><?php echo $size3 ?></div><div class="price"><?php echo $fx; echo $price3 ?></div></div><?php ;} ?>
            </div>
            <div style="clear:<?php if ($odd_even_checker) { ?>right<?php } else { ?>left<?php } ?>;"></div>

        <?php
        $counter++;
        endwhile;
        ?><div class="clearfix"></div><?php
$output = ob_get_contents();
ob_end_clean();

return $output;

}

add_shortcode('tf-menu-short', 'tf_menu_short');

/**
 * Registers the Insert Shortcode tinymce plugin for Food menu.
 * 
 */
function tf_food_menu_register_tinymce_buttons() {
	
	if( !current_user_can( 'edit_posts' ) || 
		( isset( $_GET['post'] ) && !in_array( get_post_type( $_GET['post'] ), array( 'post', 'page' ) ) ) || 
		( isset( $_GET['post_type'] ) && !in_array( $_GET['post_type'], array( 'post', 'page' ) ) ) )
		return;
	
	add_filter( 'mce_buttons', 'tf_food_menu_add_tinymce_buttons' );
	add_filter( 'mce_external_plugins', 'tf_food_menu_add_tinymce_plugins' );
}
add_action( 'load-post.php', 'tf_food_menu_register_tinymce_buttons' );
add_action( 'load-post-new.php', 'tf_food_menu_register_tinymce_buttons' );

/**
 * Adds the Food Menu tinyMCE button.
 * 
 * @param array $buttons
 * @return array
 */
function tf_food_menu_add_tinymce_buttons( $buttons ) {
	array_push( $buttons, '', "tf_food_menu_shortcode_plugin" );

	return $buttons;
}

/**
 * Adds the Insert Shortcode tinyMCE plugin for the food menu.
 * 
 * @param array $plugin_array
 * @return array
 */
function tf_food_menu_add_tinymce_plugins( $plugin_array ) {
	$plugin_array['tf_food_menu_shortcode_plugin'] = TF_URL . '/food-menu/tinymce_plugins/insert_shortcode.js';
	
	return $plugin_array;
}
