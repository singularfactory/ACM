// Custom function to round up to a number of decimals
function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

// Converts decimal degrees into degrees minutes and seconds
function decimalDegreesToDMS(coordinate) {
	var degrees = Math.floor(Math.abs(coordinate));
	var tmp = (Math.abs(coordinate) - degrees) * 60.0;
	var minutes = Math.floor(tmp);
	var seconds = Math.ceil((tmp - minutes) * 60);
	
	if ( coordinate < 0 ) {
		degrees = degrees * -1;
	}
	return degrees + 'º' + minutes + "'" + seconds + '"';
}

// Converts degrees, minutes and seconds into decimal degrees
function DMSToDecimalDegrees(coordinate) {
	var degreesSeparatorIndex = coordinate.indexOf('º');
	var minutesSeparatorIndex = coordinate.indexOf("'");
	var secondsSeparatorIndex = coordinate.indexOf('"');
	
	var degrees = parseInt(coordinate.substring(0, degreesSeparatorIndex + 1));
	var minutes = parseInt(coordinate.substring(degreesSeparatorIndex + 1, minutesSeparatorIndex));
	var seconds = parseInt(coordinate.substring(minutesSeparatorIndex + 1, secondsSeparatorIndex));
	
	return degrees + (minutes / 60.0) + (seconds / 3600.0);
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
				$('#gps_coordinates_picker_latitude').val(decimalDegreesToDMS(event.latLng.lat()));
				$('#gps_coordinates_picker_longitude').val(decimalDegreesToDMS(event.latLng.lng()));
				$.goMap.clearMarkers();
				$.goMap.createMarker({
					latitude: event.latLng.lat(),
			    longitude: event.latLng.lng(),
				});
				$.goMap.setMap({
					zoom: ($.goMap.getMap().zoom + 1),
					latitude: event.latLng.lat(),
					longitude: event.latLng.lng(),
				});
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

	// Update Region select and Island select when selecting a Country in Location form
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
	
	// Update Island select when selecting a Region in Location form
	$('#location_region_id').change(function(){
		// Retrieve islands
		var region_islands_url = $('a.region_islands_url').attr('href');
		$.getJSON(region_islands_url + $(this).val(), function(json) {
			updateIslandsSelect(json);
		});
		
		return false;
	});
	
	// Add a search box for Location in Sample form
	var locationSearchBoxDefault = "Type a location...";
	$('#sample_location_search').focus(function(){
		if ( $(this).attr("value") == locationSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#sample_location_search').blur(function(){
		if( $(this).attr("value") == "" ) {
			$(this).attr("value", locationSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#sample_location_search').val() != locationSearchBoxDefault ) {
		$('#sample_location_search').css("color", "black");
		$('#sample_location_search').css("font-size", "12px");
	}
	
	$("#sample_location_search").autocomplete({
		minLength: 3,
		source: function(term, add) {
			var url = $('a.sample_location_coordinates_url').attr('href') + $("#sample_location_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#sample_location_search" ).val( ui.item.label );
			$( "#sample_location_id" ).val( ui.item.id );
			$( "#sample_latitude" ).val( ui.item.latitude );
			$( "#sample_longitude" ).val( ui.item.longitude );
			return false;
		},
	});
	
	
});