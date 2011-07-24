jQuery(document).ready(function($) { 
  $("#tf-slider-list").sortable({
        // Slider Placeholder  
        placeholder: 'ui-state-highlight', 
        // Slider Dragger
        handle : '.handle', 
        update : function () { 
        // Slider Order Update    
        var order = 1;
        $("li").each( function() {

        $(this).find('input[name*="order"]').val(order);
        order++;
        });  
        }
      }); 
    });