$(document).ready(function(){
	// Close flash message after a few seconds
	setTimeout(function() { $('#flash').fadeOut('slow'); }, 7000);

	// Close flash message on demand
	$('.flash_close').click(function(){ $('#flash').fadeOut('fast'); });
	
	// Add an animation to show the flash message
	$('#flash').fadeIn(900);
});


