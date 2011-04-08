$(document).ready(function(){
	// Display reset option when a file is specified
	$('input[type=file]').change(function(){
		$(this).after('<span class="reset_picture">reset</span>');
		
		$(this).next().click(function(){	// clear input and detach when pressed
			$(this).prev().val('');
			$(this).detach();
		});
	});
	
	// Display a Google Map to pick the latitude and longitude of a place
	$('a.gps_coordinates_picker_link').click(function(){
		return false;
	})
	
});
