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

    // Hide message
    $('.message').delay(3000).slideUp();

    // Generate filter form
    if (typeof(Storage) !== "undefined") {
        $search_type  = localStorage.getItem("search_type");
        if ($search_type == 'name') {
            $('#form_price select').attr("disabled", true);
            $('#form_price').hide();
        } else if($search_type == 'price') {
            $('#form_name input').attr("disabled", true);
            $('#search_name').removeAttr("checked");
            $('#form_name').hide();
            $('#search_price').attr("checked", "checked");
            $('#form_price select').removeAttr("disabled");
            $('#form_price').show();
            $price_type  = localStorage.getItem("price_type");
            $a = $('#form_price select option[value="'+$price_type+'"]').attr("selected", "selected");
            console.log($price_type);
        }
    }

});

function preview_image() {
    var total_file = document.getElementById("upload_file").files.length;
    var file_name = document.getElementById('upload_file').files[0].name;
    for(var i=0;i<total_file;i++) {
        $('#image_preview').append("<img width='50px' height='50px' src='"+URL.createObjectURL(event.target.files[i])+"'/>");
    }
}


function generateName() {
    $('#form_name').show();
    $('#form_name input').removeAttr("disabled");
    $('#form_price select').attr("disabled", true);
    $('#form_price').hide();
    localStorage.setItem("search_type", "name");
}

function generatePrice() {
    $('#form_name').hide();
    $('#form_price').show();
    $('#form_price select').removeAttr("disabled");
    $('#form_name input').attr("disabled", true);
    localStorage.setItem("search_type", "price");
}

function setSelected() {
    $price_type = $('#price').val();
    localStorage.setItem("price_type", $price_type);
}