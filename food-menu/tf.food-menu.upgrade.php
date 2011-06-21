<?php

function tf_food_menu_migrate_menu_order_upgrade( $scripts ) {
	
	global $wpdb;
	
	if( $wpdb->get_var( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'tf_menu_order'" ) )
		$scripts[] = 'tf_food_menu_migrate_menu_order';
		
	return $scripts;
}
add_filter( 'tf_upgrade_scripts', 'tf_food_menu_migrate_menu_order_upgrade' );

function tf_food_menu_migrate_menu_order() {
	
	global $wpdb;
	
	$posts = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'tf_menu_order' ORDER BY meta_value ASC" );
	
	foreach( $posts as $key => $post_id ) {
		
		$wpdb->update( $wpdb->posts, array( 'menu_order' => $key ), array( 'ID' => $post_id ) );
		delete_post_meta( $post_id, 'tf_menu_order' );
		
	}
	
}