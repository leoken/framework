<?php
/**
 * Comments
 */
?>
<div id="tf-comment">
<div id="comments">
    <?php if ( post_password_required() ) : ?>
    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'themeforce' ); ?></p>
</div><!-- #comments -->
<?php
/* Stop the rest of comments.php from being processed,
* but don't kill the script entirely -- we still have
* to fully load the template.
*/
return;
endif;
?>

<?php
// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
    <h3 id="comments-title"><?php
    printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'themeforce' ),
    number_format_i18n( get_comments_number() ), '' . get_the_title() . '' );
    ?></h3>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation">
    <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'themeforce' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'themeforce' ) ); ?></div>
</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

<ol class="commentlist">
    <?php
    /* Loop through and list the comments. Tell wp_list_comments()
    * to use themeforce_comment() to format the comments.
    * If you want to overload this in a child theme then you can
    * define themeforce_comment() and that will be used instead.
    * See themeforce_comment() in themeforce/functions.php for more.
    */
    wp_list_comments( array( 'callback' => 'themeforce_comment' ) );
    ?>
</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation">
    <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'themeforce' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'themeforce' ) ); ?></div>
</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

/* If there are no comments and comments are closed,
* let's leave a little note, shall we?
*/
if ( ! comments_open() ) :
?>
<p class="nocomments"><?php _e( '<!-- Comments are Closed -->', 'themeforce' ); ?></p>
<?php endif; // end ! comments_open() ?>
<?php endif; // end have_comments() ?>

<?php
$fields =  array(
    'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '&nbsp;' . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="40"' . $aria_req . ' /></p>',
    'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '&nbsp;' . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="40"' . $aria_req . ' /></p>',
    'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="40" /></p>',
);

$args = array(
    'fields' => $fields,
);

comment_form( $args );
?>

</div>
</div>