$(function(ready){
    // Bulk action
	$('#select_all').change(function() {
	    var checkboxes = $(this).closest('table').find(':checkbox');
	    if($(this).is(':checked')) {
	        checkboxes.prop('checked', true);
	    } else {
	        checkboxes.prop('checked', false);
	    }
	});

    // Close alert message
    $( ".close" ).click(function() {
      $( ".alert" ).fadeOut( "slow" );
    });
});

function preview_image() {
    var total_file = document.getElementById("upload_file").files.length;
    var file_name = document.getElementById('upload_file').files[0].name;
    console.log(file_name);
    for(var i=0;i<total_file;i++) {
        $('#image_preview').append("<img width='50px' height='50px' src='"+URL.createObjectURL(event.target.files[i])+"'/>");
    }
}