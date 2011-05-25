<?php
/*
 * Sidebar
 */
?>
</div>
<div class="grid_4">
<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
<div id="sidebar-top"></div>
<div id="sidebar">
    <div id="regular">
    
    
        <ul class="xoxo">
        <?php dynamic_sidebar( 'primary-widget-area' ); ?>
        </ul>
    
    </div>
    
</div>
<div id="sidebar-bottom"></div>
<?php endif; ?>
</div>