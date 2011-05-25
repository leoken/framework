<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>
<div id="content" class="grid_8">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- post content -->

        <h1 class="post-title"><?php the_title(); ?></h1>
        <div class="info">Posted by <?php the_author() ?> on <?php the_time( get_option('date_format') ); ?></div>

        <div class="post">
            <?php the_content(); ?>
            <?php // TODO CSS for inter-postnavigation ?>
            <div id="nav-below">
                <div class="left">&larr; <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'themeforce' ) . '</span> %title' ); ?></div>
                <div class="right"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'themeforce' ) . '</span>' ); ?> &rarr;</div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <?php comments_template( '', true ); ?>

<?php endwhile; else: ?>

    <div class="content">
        <p><?php _e('Sorry, this page is not available. Please return to the main page or use the navigation above. ', 'themeforce'); ?></p>
    </div>

<?php endif; ?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>