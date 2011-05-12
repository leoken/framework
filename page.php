<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
<div id="content" class="grid_8">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="post">

    <?php if (get_option('chowforce_pagetitle') == 'true') { echo '<h1 class="post-title">'; echo the_title(); echo '</h1>';} ?>
    <?php the_content(); ?>
    <?php edit_post_link( __( 'Edit', 'themeforce' ), '', '' ); ?>

<?php comments_template( '', true ); ?>
</div>
<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>