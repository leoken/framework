<?php
/* 
* -------------------------------------
* Hook Functionality
* -------------------------------------
* 
* Applied from:
*
* Ptah Dunbar - Smarter Hooks
* http://ptahdunbar.com/wordpress/smarter-hooks/
* Posted on July 1st, 2009
* 
*/


// Declare Hook Locations
// -------------------------------------

// header
function tf_head() { tf_do_atomic( 'tf_head' ); }					
function tf_body_top() { tf_do_atomic( 'tf_body_top' ); }					
function tf_body_bottom() { tf_do_atomic( 'tf_body_bottom' ); }					
				

// Do Hook
// -------------------------------------

function tf_do_atomic( $tag = '', $args = '' ) {
	if ( !$tag )
		return false;

	/* Do actions on the basic hook. */
	do_action( $tag, $args );

	/* Loop through context array and fire actions on a contextual scale. */
	foreach ( (array) tf_get_query_context() as $context )
		do_action( "{$tag}_{$context}", $args );
}

// Retrieve Context of Hook
// -------------------------------------

function tf_get_query_context() {
	global $wp_query, $query_context;

	/* If $query_context->context has been set, don't run through the conditionals again. Just return the variable. */
	if ( is_array( $query_context->context ) )
		return $query_context->context;

	$query_context->context = array();

	/* Front page of the site. */
	if ( is_front_page() )
		$query_context->context[] = 'home';

	/* Blog page. */
	if ( is_home() )
		$query_context->context[] = 'blog';

	/* Singular views. */
	elseif ( is_singular() ) {
		$query_context->context[] = 'singular';
		$query_context->context[] = "singular-{$wp_query->post->post_type}";
		$query_context->context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";
	}

	/* Archive views. */
	elseif ( is_archive() ) {
		$query_context->context[] = 'archive';

		/* Taxonomy archives. */
		if ( is_tax() || is_category() || is_tag() ) {
			$term = $wp_query->get_queried_object();
			$query_context->context[] = 'taxonomy';
			$query_context->context[] = $term->taxonomy;
			$query_context->context[] = "{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
		}

		/* User/author archives. */
		elseif ( is_author() ) {
			$query_context->context[] = 'user';
			$query_context->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
		}

		/* Time/Date archives. */
		else {
			if ( is_date() ) {
				$query_context->context[] = 'date';
				if ( is_year() )
					$query_context->context[] = 'year';
				if ( is_month() )
					$query_context->context[] = 'month';
				if ( get_query_var( 'w' ) )
					$query_context->context[] = 'week';
				if ( is_day() )
					$query_context->context[] = 'day';
			}
			if ( is_time() ) {
				$query_context->context[] = 'time';
				if ( get_query_var( 'hour' ) )
					$query_context->context[] = 'hour';
				if ( get_query_var( 'minute' ) )
					$query_context->context[] = 'minute';
			}
		}
	}

	/* Search results. */
	elseif ( is_search() )
		$query_context->context[] = 'search';

	/* Error 404 pages. */
	elseif ( is_404() )
		$query_context->context[] = 'error-404';

	return $query_context->context;
}
?>