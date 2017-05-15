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
        if ($search_type == 'name' || $search_type == null) {
            // Price
            $('#form_price select').attr("disabled", true);
            $('#search_price').removeAttr("checked");
            $('#form_price').hide();
            // Status
            $('#form_status select').attr("disabled", true);
            $('#search_status').removeAttr("checked");
            $('#form_status').hide();
        } else if($search_type == 'price') {
            // Price
            $('#search_price').attr("checked", "checked");
            $('#form_price select').removeAttr("disabled");
            $('#form_price').show();
            // Name
            $('#form_name input').attr("disabled", true);
            $('#search_name').removeAttr("checked");
            $('#form_name').hide();
            // Status
            $('#form_status select').attr("disabled", true);
            $('#search_status').removeAttr("checked");
            $('#form_status').hide();
            $price_type  = localStorage.getItem("price_type");
            $a = $('#form_price select option[value="'+$price_type+'"]').attr("selected", "selected");
        } else if ($search_type == 'status') {
            // Status
            $('#search_status').attr("checked", "checked");
            $('#form_status select').removeAttr("disabled");
            $('#form_status').show();
            // Price
            $('#form_price select').attr("disabled", true);
            $('#search_price').removeAttr("checked");
            $('#form_price').hide();
            // Name
            $('#form_name input').attr("disabled", true);
            $('#search_name').removeAttr("checked");
            $('#form_name').hide();
            $status_type  = localStorage.getItem("status_type");
            $a = $('#form_status select option[value="'+$status_type+'"]').attr("selected", "selected");
        }
    }

    // Sort
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    function setImageOrder($sortBy, $order) {
        if ($order == 'asc') {
            $('#' + $sortBy).attr('class', 'sorting_asc');
        } else {
            $('#' + $sortBy).attr('class', 'sorting_desc');
        }
    }

    $sortBy = getUrlParameter('sortBy');
    $order = getUrlParameter('order');
    setImageOrder($sortBy, $order);

});

function preview_image($status) {
    var total_file = document.getElementById('upload_file').files.length;
    var file_name = document.getElementById('upload_file').files[0].name;
    if ( $status == 'multiple' ) {
        for(var i=0;i<total_file;i++) {
            $('#image_preview').append("<img width='50px' height='50px' src='"+URL.createObjectURL(event.target.files[i])+"'/>");
        }
    } else {
        $('#image_preview').html("<img width='50px' height='50px' src='"+URL.createObjectURL(event.target.files[0])+"'/>");
    }
}


function generateName() {
    // Form Name
    $('#form_name').show();
    $('#form_name input').removeAttr("disabled");
    // Form Price
    $('#form_price select').attr("disabled", true);
    $('#form_price').hide();
    // Form Status
    $('#form_status select').attr("disabled", true);
    $('#form_status').hide();
    localStorage.setItem("search_type", "name");
}

function generatePrice() {
    // Form Price
    $('#form_price').show();
    $('#form_price select').removeAttr("disabled");
    // Form Name
    $('#form_name input').attr("disabled", true);
    $('#form_name').hide();
    // Form Status
    $('#form_status select').attr("disabled", true);
    $('#form_status').hide();
    localStorage.setItem("search_type", "price");
}

function generateStatus() {
    // Form Status
    $('#form_status').show();
    $('#form_status select').removeAttr("disabled");
    // Form Price
    $('#form_price select').attr("disabled", true);
    $('#form_price').hide();
    // Form Name
    $('#form_name input').attr("disabled", true);
    $('#form_name').hide();
    localStorage.setItem("search_type", "status");
}

function setSelectedPrice() {
    $price_type = $('#price_select').val();
    localStorage.setItem("price_type", $price_type);
}

function setSelectedStatus() {
    $status_type = $('#status_select').val();
    localStorage.setItem("status_type", $status_type);
}

