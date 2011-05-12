<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>
<div id="content" class="grid_8">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <h2 class="list-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <div class="post-meta">Posted by <?php the_author() ?> on <?php the_time( get_option('date_format') ); ?></div>

    <div class="post">
        <?php the_content(__('<div class="moretext">Read the rest here...</div>', 'themeforce')); ?>
    <div class="morecomments">
        <?php comments_popup_link(__('Comments (0)', 'themeforce'), __('Comments (1)', 'themeforce'), __('Comments (%)', 'themeforce')); ?>
    </div>
        <div class="clearfix"></div>
    </div>

    <?php wp_link_pages(); ?>
</div>

<?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.', 'themeforce'); ?></p>
<?php endif; ?>

<?php if (  $wp_query->max_num_pages > 1 ) : ?>
    <div id="nav-below" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'themeforce' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'themeforce' ) ); ?></div>
    </div>
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>