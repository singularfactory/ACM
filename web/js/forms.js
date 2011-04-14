// Custom function to round up to a number of decimals
function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

// Update GPS coordinates of Sample with inherited values from Location
function updateSampleCoordinates(coordinates) {
	$('#sample_latitude').val(coordinates.latitude);
	$('#sample_longitude').val(coordinates.longitude);
}

// Regions select box in Location
function updateRegionsSelect(options) {
	$('#location_region_id').empty();
	if ( options.length > 0 ) {
		$.each(options, function(key, option){
			$('#location_region_id').append('<option value="' + option.id + '">' + option.name + '</option');
		});
		return options[0].id;
	}
	else {
		$('#location_region_id').append('<option value>---</option');
		return null;
	}
}

// Islands select box in Location
function updateIslandsSelect(options) {
	$('#location_island_id').empty();
	if ( options.length > 0 ) {
		$.each(options, function(key, option){
			$('#location_island_id').append('<option value="' + option.id + '">' + option.name + '</option');
		});
	} 
	else {
		$('#location_island_id').append('<option value>---</option');
	}
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
				icon: '/images/maps/location.png',
			});
			$.goMap.createListener({type:'map'}, 'click', function(event, point) { 
				$('#gps_coordinates_picker_latitude').val(roundNumber(event.latLng.lat(), 5));
				$('#gps_coordinates_picker_longitude').val(roundNumber(event.latLng.lng(), 5));
				$.goMap.clearMarkers();
				$.goMap.createMarker({
					latitude: event.latLng.lat(),
			    longitude: event.latLng.lng(),
				});
				$.goMap.setMap({ zoom: ($.goMap.getMap().zoom + 1) });
			});
		},
		
		onCleanup: function(){
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

	// Load location coordinates when creating a sample
	$('#sample_location_id').ready(function(){
		if ( $('#sample_id').length && !$('#sample_id').val() ) {
			var sample_location_url = $('a.sample_location_coordinates_url').attr('href');
			$.getJSON(sample_location_url + $('#location select').children().first().val(), function(json) {
				updateSampleCoordinates(json);
			});
		}
		return false;
	});

	$('#sample_location_id').change(function(){
		var sample_location_url = $('a.sample_location_coordinates_url').attr('href');
		$.getJSON(sample_location_url + $(this).val(), function(json) {
			updateSampleCoordinates(json);
		});
		return false;
	});

	$('#location_country_id').change(function(){
		// Retrieve regions
		var country_regions_url = $('a.country_regions_url').attr('href');
		$.getJSON(country_regions_url + $(this).val(), function(json) {
			var id = updateRegionsSelect(json);
			
			// Retrieve islands
			var region_islands_url = $('a.region_islands_url').attr('href');
			$.getJSON(region_islands_url + id, function(json) {
				updateIslandsSelect(json);
			});
		});
		
		return false;
	});
	
	$('#location_region_id').change(function(){
		// Retrieve islands
		var region_islands_url = $('a.region_islands_url').attr('href');
		$.getJSON(region_islands_url + $(this).val(), function(json) {
			updateIslandsSelect(json);
		});
		
		return false;
	});
	

});