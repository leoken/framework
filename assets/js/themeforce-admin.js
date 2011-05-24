jQuery(document).ready(function($)
{	
$(".tfdate").datepicker({
    dateFormat: 'D, M d, yy',
    showOn: 'both',
	buttonImage: themeforce.buttonImage,
    buttonImageOnly: true,
    numberOfMonths: 3
    });
});