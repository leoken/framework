<?php

/**
 * Custon rewrites for ThemeForce things.
 * 
 */
function tf_setup_rewrite_rules() {

	tf_tj_add_rewrite_rule( 'events/([^/]+)/([^/]+)(/page/([0-9]+))?/?$', 'post_type=tf_events&name=$matches[2]&page=$matches[4]' );
}

add_action( 'init', 'tf_setup_rewrite_rules' );

// TJ Rewrites wrappers
function tf_tj_add_rewrite_rule( $rule, $query, $template = null, $args = array() ) {
	global $tf_tj_rewrite_rules;
	
	$tf_tj_rewrite_rules[ $rule ] = array( $rule, $query, $template, wp_parse_args($args) );
	
}
	
function tf_tj_remove_rewrite_rule( $rule ) {
	global $tf_tj_rewrite_rules;
	
	if( isset( $tf_tj_rewrite_rules[$rule] ) )
		unset( $tf_tj_rewrite_rules[$rule] );
}

function tf_tj_create_custom_rewrite_rules( $rules ) {
 	
 	// Define the custom permalink structure
 	global $tf_tj_rewrite_rules;
 	
 	$new_rules = array();
 	
 	foreach( (array) $tf_tj_rewrite_rules as $rule ) {
 		$new_rules[ $rule[0] ] = $rule[1];
 	}
 	
 	$rules = array_merge( (array) $new_rules, $rules );

	return $rules;
}
add_filter('rewrite_rules_array', 'tf_tj_create_custom_rewrite_rules');

function tf_tj_add_custom_page_variables( $public_query_vars ) {

	global $tf_tj_rewrite_rules;
	
	if( !isset( $tf_tj_rewrite_rules ) )
		return $public_query_vars;
	
	//make any query vars public
	foreach( (array) $tf_tj_rewrite_rules as $rule ) {
		$args = wp_parse_args( $rule[1] );

		foreach( $args as $arg => $val ) {
			if( !in_array( $arg, $public_query_vars ) )
				$public_query_vars[] = $arg;
		}
	}
	
	return $public_query_vars;
}
add_filter( 'query_vars', 'tf_tj_add_custom_page_variables' );


function tf_tj_set_custom_rewrite_rule_current_page( $request ) {

	global $tf_tj_rewrite_rules, $tf_tj_current_rewrite_rule, $wp_rewrite;
	
	if( isset( $tf_tj_rewrite_rules ) && array_key_exists( $request->matched_rule, (array) $tf_tj_rewrite_rules ) ) {
		$tf_tj_current_rewrite_rule = $tf_tj_rewrite_rules[$request->matched_rule];

		do_action_ref_array('tf_tj_parse_request_' . $request->matched_rule, array(&$request));
				
		$tf_tj_current_rewrite_rule[4] = $request->query_vars;
	}

	if( isset( $tf_tj_current_rewrite_rule[4] ) && $tf_tj_current_rewrite_rule[4] === $request ) {
		
		$tf_tj_current_rewrite_rule[3]['parse_query_properties'] = wp_parse_args( ( isset( $tf_tj_current_rewrite_rule[3]['parse_query_properties'] ) ? $tf_tj_current_rewrite_rule[3]['parse_query_properties'] : '' ), array( 'is_home' => false ) );
		//apply some post query stuff to wp_query
		if( isset( $tf_tj_current_rewrite_rule[3]['parse_query_properties'] ) ) {
			
			//$post_query
			foreach( wp_parse_args( $tf_tj_current_rewrite_rule[3]['parse_query_properties'] ) as $property => $value ) {
				$wp_query->$property = $value;
			}
		}
	}
	
}
add_filter( 'parse_request', 'tf_tj_set_custom_rewrite_rule_current_page' );

/**
 * Hooks into parse_query to modify any is_* etc properties of WP_Query, specify as $args['parse_query_properties'] in tf_tj_add_rewrite_rule.
 * 
 */
function tf_tj_modify_parse_query( $wp_query ) {

	global $tf_tj_rewrite_rules, $tf_tj_current_rewrite_rule;

	if( isset( $tf_tj_current_rewrite_rule ) && $tf_tj_current_rewrite_rule[4] === $wp_query->query ) {
		
		
		$tf_tj_current_rewrite_rule[3]['parse_query_properties'] = wp_parse_args( ( isset( $tf_tj_current_rewrite_rule[3]['parse_query_properties'] ) ? $tf_tj_current_rewrite_rule[3]['parse_query_properties'] : '' ), array( 'is_home' => false ) );
		//apply some post query stuff to wp_query
		if( isset( $tf_tj_current_rewrite_rule[3]['parse_query_properties'] ) ) {
			
			//$post_query
			foreach( wp_parse_args( $tf_tj_current_rewrite_rule[3]['parse_query_properties'] ) as $property => $value ) {
				$wp_query->$property = $value;
			}
		}
	}
	
}
add_filter( 'parse_query', 'tf_tj_modify_parse_query' );

function tf_tj_load_custom_templates( $template ) {
	
	global $wp_query, $tf_tj_rewrite_rules, $tf_tj_current_rewrite_rule;

	//Skip 404 temaplte includes
	if( is_404() && !isset( $tf_tj_current_rewrite_rule[3]['post_query_properties']['is_404'] ) )
		return;

	//show the correct template for the query
	if( isset( $tf_tj_current_rewrite_rule ) && $tf_tj_current_rewrite_rule[4] === $wp_query->query ) {
		
		//apply some post query stuff to wp_query
		if( isset( $tf_tj_current_rewrite_rule[3]['post_query_properties'] ) ) {
			
			//$post_query
			foreach( wp_parse_args( $tf_tj_current_rewrite_rule[3]['post_query_properties'] ) as $property => $value ) {
				$wp_query->$property = $value;
				
			}
		}

		if( !empty( $tf_tj_current_rewrite_rule[2] ) ) {
			//fire canonical if it is allowed
			if( empty( $tf_tj_current_rewrite_rule[3]['disable_canonical'] ) )
				redirect_canonical();
			else
				remove_action( 'template_redirect', 'redirect_canonical' );
			
			do_action( 'tf_tj_load_custom_template', $tf_tj_current_rewrite_rule[2], $tf_tj_current_rewrite_rule );
			include( $tf_tj_current_rewrite_rule[2] );
			exit;
		} else if( !empty( $tf_tj_current_rewrite_rule[3]['disable_canonical'] ) ) {
			remove_action( 'template_redirect', 'redirect_canonical', 10 );
		}
		
	}

	return $template;
}
add_action( 'template_redirect', 'tf_tj_load_custom_templates', 1 );

function tf_tj_custom_rewrite_rule_body_class( $classes ) {
	
	global $tf_tj_current_rewrite_rule;
	
	if ( !empty( $tf_tj_current_rewrite_rule[2] ) )
		$classes[] = sanitize_html_class( end( explode( '/', str_replace( '.php', '', $tf_tj_current_rewrite_rule[2] ) ) ) );
		
		
	return $classes;
	
} 
add_filter( 'body_class', 'tf_tj_custom_rewrite_rule_body_class' );

function tf_tj_add_args_to_current_rule( $args ) {
	
	global $tf_tj_current_rewrite_rule;
	
	$tf_tj_current_rewrite_rule[3] = array_merge_recursive( $tf_tj_current_rewrite_rule[3], $args );
	
}