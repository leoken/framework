<?php
/*
 * FOOTER
 */
?>

</div><!-- content -->
<div class="clearfix"></div>
<div id="main-bottom"></div>
</div><!-- content-wrap -->
<div id="footer-outer">
<div id="footer-wrap">
    <div id="footer-mid">
    <div id="footer-top"></div>
    <div id="footer" class="container_12">
        <div class="grid_4">
            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
        </div>
        <div class="grid_4">
           <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
        </div>
        <div class="grid_4">
           <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    </div>
</div>
<div id="footer-btm"></div>

</div>
<!-- terminal footer -->
</div>
<div class="sec-footer-outer">
    <div class="sec-footer">
        <?php
        $wp_nav_footer = array(
        'container'       => 'div',
        'container_class' => 'footer-nav',
        'menu_class'      => 'footer-nav-ul',
        'fallback_cb'     => 'wp_page_menu',
        'theme_location'  => 'terminal',
        'depth' => 1);

        wp_nav_menu( $wp_nav_footer);
        ?>
        <div class="copyright">
        <?php echo stripslashes(get_option('chowforce_terminalnotice')); ?>
        </div>
        <div class="poweredby">
        <a href="http://www.theme-force.com">WordPress Theme by <img src="<?php bloginfo('template_url'); ?>/images/footer-logo.png" alt="Theme Force - Restaurant WordPress Theme"/></a>
        </div>
    </div>
</div>

<!-- / terminal footer -->
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<?php echo stripslashes(get_option('chowforce_google_analytics')); ?>
</body>
</html>