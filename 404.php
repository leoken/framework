<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>
<div id="content" class="grid_8">
        <h1 class="post-title"><?php _e( 'Not Found (404)', 'themeforce' ); ?></h1>
        <div class="post"><p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'themeforce' ); ?></p>
        <?php get_search_form(); ?></div>

</div>

<?php get_footer(); ?>