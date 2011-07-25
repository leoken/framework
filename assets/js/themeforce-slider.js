jQuery(document).ready(function($) {
    
  // Sortable List and Update
  
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
      
    // Show Edit
    
    $('.slider-edit').click(function () {
        $(this).hide();
        $(this).parent().parent().find('input, textarea').show();
        $(this).parent().parent().find('span').hide();
    });
    
    // Delete Slide
    
    $('.slider-delete').click(function () {
    var thisbox = $(this);    
        
    jConfirm('Can you confirm this? (You\'ll still need to click on \'Update\')', 'Confirmation Dialog', function(r) {
        if (r) {
                $(thisbox).parent().parent().find('input[name*="delete"]').val('true');
                $(thisbox).parent().parent().slideUp('slow')
                }
        });    
        
    });
    
    // Upload Slide Image
    
    $('#upload_image_button').click(function() {
     formfield = jQuery('#tfslider_image').attr('name');
     tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;tab=gallery');
     $('tr.post_title, tr.image_alt, tr.post_except, tr.post_content, tr.url, tr.0, tr.align, tr.image-size').hide();
     return false;
    });

    window.send_to_editor = function(html) {
     imgurl = jQuery('img',html).attr('src');
     jQuery('#tfslider_image').val(imgurl);
     tb_remove();
    }    

  });