$(document).ready( function() {

	// Action for search input
	$('#mk_search_submit').on('click', function(){
		var search = $('#mk_search').val();
		if (search.length > 0){
			loadRequest( search );
		}
	})

	// Ajax Handle for search input. Return HTML view with result.
	function loadRequest( searchText ) {
		$('#mk_loader').show(); // Show loader
		$('.result').html(); // Clear Ajax Result
		$('#mk_search').attr('disabled', 'disabled'); // Block input search
		$.ajax({
		    type : 'POST',
		    url : '/mkparser/search',
		    data : {value: searchText},
		    dataType: 'json',
		    success: function(response){
		    	if (response.status) { // Check if request is success
						var icon = '<span class="glyphicon glyphicon-file" aria-hidden="true"></span>';
						var fileDownload = '<a href="'+ response.url_download +'"><span style="padding-left: 20px;" class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>';
		    		var view = icon +'<a href="'+ response.url +'" target="_blank">'+ response.file_name +'</a>'+ fileDownload;

		    		$('.result').html(view);
						$('#mk_search').removeAttr("disabled"); // Remove blocked input search
		    	}
		    $('#mk_loader').hide(); // Hidde loader
		    },
		    error: function(jqXHR,textStatus,errorThrown){
		             var error = $.parseJSON(jqXHR.responseText);
		             var content = error.content;
		             console.log(content.message);
		             if(content.display_exceptions)
		             console.log(content.exception.xdebug_message);
		    },
		}) ;
	}

})
