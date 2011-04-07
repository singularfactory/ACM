$(document).ready(function(){
	// Close flash message after a few seconds
	setTimeout(function() { $('#flash').fadeOut('slow'); }, 7000);

	// Close flash message on demand
	$('.flash_close').click(function(){ $('#flash').fadeOut('fast'); });
	
	// Add an animation to show the flash message
	$('#flash').fadeIn(900);
	
	// Clear default text in search boxes on edition
	$('#search_box_criteria').click(function(){ $(this).val('').css('color', '#333');  });
	
	// Append input value to link url when pressing the link in search boxes
	$('#search_box a').click(function(){
		var url = $(this).attr('href') + $(this).prev().val();
		$(this).attr('href', url);
	});
	
	// Append input value to link url and redirect when pressing Enter key in search boxes
	$('#search_box input').keypress(function(e){
		if( e.which == 13 ) {
			location.href = $('#search_box a').attr('href') + $(this).val();
		}
	});
});