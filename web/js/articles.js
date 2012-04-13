function fixGoogleMapStyles() {
	if ( $('#object_google_map #map>div').children().eq(1).length ) {
		$('#object_google_map a').css('font-size', '6px');
		$('#object_google_map #map>div').children().eq(1).css('padding', 0).css('margin', 0);
		$('#object_google_map #map>div').children().eq(1).find('div').css('padding', 0).css('margin', 0);
	}
	else {
		setTimeout("fixGoogleMapStyles()", 500);
	}
}

$(document).ready(function(){
	fixGoogleMapStyles();
});