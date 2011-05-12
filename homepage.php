<?php
/**
 * Template Name: Homepage
 */

get_header(); ?>
<div id="content">
    <div class="container_12">
    <div class="fullwidth">
        <div class="post">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <?php if (get_option('chowforce_pagetitle') == 'true') { echo '<h1>'; echo the_title(); echo '</h1>';} ?>
    <?php the_content(); ?>

<?php endwhile; ?>
    </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="container_12" id="homewidgets">
    <div class="grid_4">
        <?php dynamic_sidebar( 'first-home-widget-area' ); ?>
    </div>
    <div class="grid_4">
        <?php dynamic_sidebar( 'second-home-widget-area' ); ?>
    </div>
    <div class="grid_4">
        <?php dynamic_sidebar( 'third-home-widget-area' ); ?>
    </div>
</div>

<?php get_footer(); ?>