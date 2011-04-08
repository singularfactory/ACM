// Custom function to round up to a number of decimals
function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

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
	$('#gps_coordinates_picker_link').colorbox({
		inline: true,
		href: "#gps_coordinates_picker",
		transition: "fade",
		
		onComplete: function(){
			$('#gps_coordinates_picker_map').goMap({
				latitude: 27.991232,		// Latitude of BEA headquarters
		    longitude: -15.368787,	// Longitude of BEA headquarters 
				zoom: 7,
				width: 300,
				disableDoubleClickZoom: false,
				icon: '../../images/maps/location.png',
			});
			$.goMap.createListener({type:'map'}, 'click', function(event, point) { 
				$('#gps_coordinates_picker_latitude').val(roundNumber(event.latLng.lat(), 4));
				$('#gps_coordinates_picker_longitude').val(roundNumber(event.latLng.lng(), 4));
				$.goMap.clearMarkers();
				$.goMap.createMarker({
					latitude: event.latLng.lat(),
			    longitude: event.latLng.lng(),
				});
				$.goMap.setMap({ zoom: ($.goMap.getMap().zoom + 1) });
			});
		},
		
		onCleanup: function() {
			$('#gps_coordinates input').each(function(){
				var id = $(this).attr('id');
				if ( id != null ) {
					var latitude_regexp = /_latitude$/;
					if ( latitude_regexp.test(id) ) {
						$(this).val($('#gps_coordinates_picker_latitude').val());
					}
					
					var longitude_regexp = /_longitude$/;
					if ( longitude_regexp.test(id) ) {
						$(this).val($('#gps_coordinates_picker_longitude').val());
					}
				}
			});
		}

	});

	
});