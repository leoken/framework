jQuery(document).ready(function($) { 
  $("#test-list").sortable({
    placeholder: 'ui-state-highlight',  
    handle : '.handle', 
    update : function () { 
      var order = $('#test-list').sortable('serialize'); 
      $("#info").load("process-sortable.php?"+order); 
    } 
  }); 
}); 