$(function(ready){
	$('#select_all').change(function() {
	    var checkboxes = $(this).closest('table').find(':checkbox');
	    if($(this).is(':checked')) {
	        checkboxes.prop('checked', true);
	    } else {
	        checkboxes.prop('checked', false);
	    }
	});
});