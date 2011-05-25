<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>
<div id="content" class="grid_8">
<?php if ( have_posts() ) : ?>
				<h1><?php printf( __( 'Search Results for: %s', 'themeforce' ), '' . get_search_query() . '' ); ?></h1>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
                              
        <h1 class="post-title"><?php _e( 'Not Found (404)', 'themeforce' ); ?></h1>
        <div class="post"><p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'themeforce' ); ?></p>
        <?php get_search_form(); ?></div>
   
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
