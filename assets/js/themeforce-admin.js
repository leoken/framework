jQuery(document).ready(function($) {	

	
	if( typeof themeforce != "undefined" ) {
		$(".tfdate").datepicker({
		    dateFormat: 'D, M d, yy',
		    showOn: 'both',
			buttonImage: themeforce.buttonImage,
		    buttonImageOnly: true,
			changeMonth:true,
			changeYear: true,
		    numberOfMonths: 3
		    });
	}

	if( jQuery( '.tf_sortable_admin_row_handle' ).length > 0 ) {
	
		jQuery( "#the-list" ).sortable( {
			axis: 'y',
			handle: '.tf_sortable_admin_row_handle',
			containment: 'parent',
			update: function( e, ui ) {
				console.log(e.srcElement);
				
				var posts = [];
				
				jQuery( "#the-list" ).find( 'tr' ).each( function() {
					posts.push( jQuery( this ).attr('id').replace( 'post-', '' ) );
				} );
				
				params = { posts: posts, action: 'tf_sort_admin_rows', term: jQuery( "select[name='term']" ).val() }
				
				$.post('admin-ajax.php', params, function(r) {
					console.log(r);
				} );
				console.log( posts );
			}
		} );
	
	}
		    
});