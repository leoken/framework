<?php 

function tf_upgrade_scripts() {

	if( apply_filters( 'tf_upgrade_scripts', null ) )
		add_action( 'admin_notices', 'tf_upgrade_admin_notice' );
}
add_action( 'admin_init', 'tf_upgrade_scripts' );

function tf_upgrade_admin_notice() {

	?>
	<div class="update-nag"><?php _e( 'You have legacy ThemeForce options that need updating, click the following button to update them.' ) ?> <a href="<?php echo wp_nonce_url( add_query_arg( 'tf_action', 'update_legacy_options' ), 'update_legacy_options' ) ?>" class="button"><?php _e( 'Update Options' ) ?></a></div>
	<?php

}

/**
 * Submit action for the pubforce options migrator.
 * 
 */
function tf_upgrade_scripts_action() {

	if( empty( $_GET['tf_action'] ) || $_GET['tf_action'] !== 'update_legacy_options' || !wp_verify_nonce( $_GET['_wpnonce'], 'update_legacy_options' ) )
		return;
	
	tf_run_upgrade_scripts();
	
	wp_redirect( wp_get_referer() );
	exit;

}
add_action( 'admin_init', 'tf_upgrade_scripts_action' );

/**
 * Updates the Pubforce options which have been moved to ThemeForce.
 * 
 */
function tf_run_upgrade_scripts() {
	
	foreach( (array) apply_filters( 'tf_upgrade_scripts', null ) as $callback ) {
		call_user_func( $callback );
	}
	
}