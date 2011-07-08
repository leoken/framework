jQuery(document).ready(function() {
    
    jQuery("a.thumb").fancybox({
            'overlayShow'	: false,
            'transitionIn'	: 'elastic',
            'transitionOut'	: 'elastic',
            'padding' : 5
    });
    
    jQuery("a.thumb-iframe").fancybox({
            'width'		: '75%',
            'height'		: '75%',
            'autoScale'     	: false,
            'transitionIn'	: 'none',
            'transitionOut'	: 'none',
            'type'		: 'iframe'
    });	

});