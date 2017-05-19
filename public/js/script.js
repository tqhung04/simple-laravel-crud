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
            hidePriceForm();
            hideStatusForm();
        } else if($search_type == 'price') {
            showPriceForm();
            hideNameForm();
            hideStatusForm();
            $price_type  = localStorage.getItem("price_type");
            $a = $('#form_price select option[value="'+$price_type+'"]').attr("selected", "selected");
        } else if ($search_type == 'status') {
            showStatusForm();
            hidePriceForm();
            hideNameForm();
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

    // Keep selected status
    if (localStorage.getItem('form_status')) {
        $("#status option").eq(localStorage.getItem('form_status')).prop('selected', true);
    }

    $("#status").on('change', function() {
        localStorage.setItem('form_status', $('option:selected', this).index());
    });

    // Keep selected role
    if (localStorage.getItem('form_role')) {
        $("#role option").eq(localStorage.getItem('form_role')).prop('selected', true);
    }

    $("#role").on('change', function() {
        localStorage.setItem('form_role', $('option:selected', this).index());
    });

    // Keep selected category
    if (localStorage.getItem('form_category')) {
        $("#category option").eq(localStorage.getItem('form_category')).prop('selected', true);
    }

    $("#category").on('change', function() {
        localStorage.setItem('form_category', $('option:selected', this).index());
    });

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
    hidePriceForm();
    hideStatusForm();
    showNameForm();
    localStorage.setItem("search_type", "name");
}

function generatePrice() {
    showPriceForm();
    hideStatusForm();
    hideNameForm();
    localStorage.setItem("search_type", "price");
}

function generateStatus() {
    showStatusForm();
    hidePriceForm();
    hideNameForm();
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

function hideStatusForm() {
    $('#form_status').parent().css( "opacity", "0.5" );
    $('#form_status select').attr("disabled", true);
    $('#search_status').removeAttr("checked");
}

function showStatusForm() {
    $('#form_status').parent().css( "opacity", "1" );
    $('#form_status select').removeAttr("disabled");
    $('#search_status').attr("checked", "checked");
}

function hidePriceForm() {
    $('#form_price').parent().css( "opacity", "0.5" );
    $('#form_price select').attr("disabled", true);
    $('#search_price').removeAttr("checked");
}

function showPriceForm() {
    $('#form_price').parent().css( "opacity", "1" );
    $('#form_price select').removeAttr("disabled");
    $('#search_price').attr("checked", "checked");
}

function hideNameForm() {
    $('#form_name').parent().css( "opacity", "0.5" );
    $('#form_name').parent().css( "opacity", "0.5" );
    $('#form_name input').attr("disabled", true);
    $('#search_name').removeAttr("checked");
}

function showNameForm() {
    $('#form_name').parent().css( "opacity", "1" );
    $('#form_name input').removeAttr("disabled");
    $('#search_name').attr("checked", "checked");
}
