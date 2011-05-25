<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>
<div id="content">
<div class="container_12">
<div class="fullwidth post">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

        <?php if (get_option('chowforce_pagetitle') == 'true') { echo '<h1 class="post-title">'; echo the_title(); echo '</h1>';} ?>
        <?php the_content(); ?>
        <?php comments_template( '', true ); ?>

<?php endwhile; ?>
    </div>
</div>
</div>

<?php get_footer(); ?>