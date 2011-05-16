<?php

add_action('init','of_options');

function of_options(){
	
	$options = array();
	
	$options = apply_filters( 'tf_of_options', $options ); 
	
	update_option('of_template',$options); 					  
}
