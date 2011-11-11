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
		if ( !$(this).next('span.reset_picture').length ) {
			$(this).after('<span class="reset_picture">reset</span>');
			
			$(this).next().click(function(){	// clear input and detach when pressed
				$(this).prev().val('');
				$(this).detach();
			});
		}
	});
	
	// Display remove option when a strain relative input has text and lose focus
	$('div.model_text_input_name input').change(function(){
		if ( $(this).next('span').length == 0 ) {
			$(this).after('<span class="remove_input_text">remove</span>');
			$(this).next().click(function(){	// clear input and detach when pressed
				if( $('div.model_text_input_name input').length > 1 ) {
					$(this).prev().detach();
				}
				else {
					$(this).prev().val('');
				}
				$(this).detach();
			});
		}
	})
	
	// Display a Google Map to pick the latitude and longitude of a place
	if ( $('#gps_coordinates_picker_link').length ) {
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
	}
	

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
	
	
	// Add a search box for Location in Sample, PatentDeposit, MaintenanceDeposit and Isolation forms
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
	
	$('#patent_deposit_location_search').focus(function(){
		if ( $(this).attr("value") == locationSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#patent_deposit_location_search').blur(function(){
		if( $(this).attr("value") == "" ) {
			$(this).attr("value", locationSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#patent_deposit_location_search').val() != locationSearchBoxDefault ) {
		$('#patent_deposit_location_search').css("color", "black");
		$('#patent_deposit_location_search').css("font-size", "12px");
	}
	
	$("#patent_deposit_location_search").autocomplete({
		minLength: 3,
		source: function(term, add) {
			var url = $('a.patent_deposit_location_coordinates_url').attr('href') + $("#patent_deposit_location_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#patent_deposit_location_search" ).val( ui.item.label );
			$( "#patent_deposit_location_id" ).val( ui.item.id );
			return false;
		},
	});
	
	$('#maintenance_deposit_location_search').focus(function(){
		if ( $(this).attr("value") == locationSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#maintenance_deposit_location_search').blur(function(){
		if( $(this).attr("value") == "" ) {
			$(this).attr("value", locationSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#maintenance_deposit_location_search').val() != locationSearchBoxDefault ) {
		$('#maintenance_deposit_location_search').css("color", "black");
		$('#maintenance_deposit_location_search').css("font-size", "12px");
	}
	
	$("#maintenance_deposit_location_search").autocomplete({
		minLength: 3,
		source: function(term, add) {
			var url = $('a.maintenance_deposit_location_coordinates_url').attr('href') + $("#maintenance_deposit_location_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#maintenance_deposit_location_search" ).val( ui.item.label );
			$( "#maintenance_deposit_location_id" ).val( ui.item.id );
			return false;
		},
	});
	
	$('#isolation_location_search').focus(function(){
		if ( $(this).attr("value") == locationSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#isolation_location_search').blur(function(){
		if( $(this).attr("value") == "" ) {
			$(this).attr("value", locationSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#isolation_location_search').val() != locationSearchBoxDefault ) {
		$('#isolation_location_search').css("color", "black");
		$('#isolation_location_search').css("font-size", "12px");
	}
	
	$("#isolation_location_search").autocomplete({
		minLength: 3,
		source: function(term, add) {
			var url = $('a.isolation_location_coordinates_url').attr('href') + $("#isolation_location_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#isolation_location_search" ).val( ui.item.label );
			$( "#isolation_location_id" ).val( ui.item.id );
			return false;
		},
	});
	
	
	// Add a search box for Sample in Strain and Isolation forms
	var sampleSearchBoxDefault = "Type a sample code...";
	$('#strain_sample_search').focus(function(){
		if ( $(this).attr("value") === sampleSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#strain_sample_search').blur(function(){
		if( $(this).attr("value") === "" ) {
			$(this).attr("value", sampleSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#strain_sample_search').val() !== sampleSearchBoxDefault ) {
		$('#strain_sample_search').css("color", "black");
		$('#strain_sample_search').css("font-size", "12px");
	}
	
	$("#strain_sample_search").autocomplete({
		minLength: 2,
		source: function(term, add) {
			var url = $('a.strain_sample_numbers_url').attr('href') + $("#strain_sample_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#strain_sample_search" ).val( ui.item.label );
			$( "#strain_sample_id" ).val( ui.item.id );
			return false;
		},
	});
	
	$('#isolation_sample_search').focus(function(){
		if ( $(this).attr("value") === sampleSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#isolation_sample_search').blur(function(){
		if( $(this).attr("value") === "" ) {
			$(this).attr("value", sampleSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#isolation_sample_search').val() !== sampleSearchBoxDefault ) {
		$('#isolation_sample_search').css("color", "black");
		$('#isolation_sample_search').css("font-size", "12px");
	}
	
	$("#isolation_sample_search").autocomplete({
		minLength: 2,
		source: function(term, add) {
			var url = $('a.isolation_sample_numbers_url').attr('href') + $("#isolation_sample_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#isolation_sample_search" ).val( ui.item.label );
			$( "#isolation_sample_id" ).val( ui.item.id );
			return false;
		},
	});
	
	$('#project_sample_search').focus(function(){
		if ( $(this).attr("value") === sampleSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#project_sample_search').blur(function(){
		if( $(this).attr("value") === "" ) {
			$(this).attr("value", sampleSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#project_sample_search').val() !== sampleSearchBoxDefault ) {
		$('#project_sample_search').css("color", "black");
		$('#project_sample_search').css("font-size", "12px");
	}
	
	$("#project_sample_search").autocomplete({
		minLength: 2,
		source: function(term, add) {
			var url = $('a.project_sample_numbers_url').attr('href') + $("#project_sample_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#project_sample_search" ).val( ui.item.label );
			$( "#project_sample_id" ).val( ui.item.id );
			return false;
		},
	});
	
	
	// Add a search box for Strain in DnaExtraction, Project and Isolation forms
	var strainSearchBoxDefault = "Type a strain code...";
	$('#dna_extraction_strain_search').focus(function(){
		if ( $(this).attr("value") === strainSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#dna_extraction_strain_search').blur(function(){
		if( $(this).attr("value") === "" ) {
			$(this).attr("value", strainSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#dna_extraction_strain_search').val() !== strainSearchBoxDefault ) {
		$('#dna_extraction_strain_search').css("color", "black");
		$('#dna_extraction_strain_search').css("font-size", "12px");
	}
	
	$("#dna_extraction_strain_search").autocomplete({
		minLength: 2,
		source: function(term, add) {
			var url = $('a.dna_extraction_strain_numbers_url').attr('href') + $("#dna_extraction_strain_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#dna_extraction_strain_search" ).val( ui.item.label );
			$( "#dna_extraction_strain_id" ).val( ui.item.id );
			return false;
		},
	});
		
	$('#project_strain_search').focus(function(){
		if ( $(this).attr("value") === strainSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#project_strain_search').blur(function(){
		if( $(this).attr("value") === "" ) {
			$(this).attr("value", strainSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#project_strain_search').val() !== strainSearchBoxDefault ) {
		$('#project_strain_search').css("color", "black");
		$('#project_strain_search').css("font-size", "12px");
	}
	
	$("#project_strain_search").autocomplete({
		minLength: 2,
		source: function(term, add) {
			var url = $('a.project_strain_numbers_url').attr('href') + $("#project_strain_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#project_strain_search" ).val( ui.item.label );
			$( "#project_strain_id" ).val( ui.item.id );
			return false;
		},
	});
	
	$('#isolation_strain_search').focus(function(){
		if ( $(this).attr("value") === strainSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#isolation_strain_search').blur(function(){
		if( $(this).attr("value") === "" ) {
			$(this).attr("value", strainSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});

	if ( $('#isolation_strain_search').val() !== strainSearchBoxDefault ) {
		$('#isolation_strain_search').css("color", "black");
		$('#isolation_strain_search').css("font-size", "12px");
	}
	
	$("#isolation_strain_search").autocomplete({
		minLength: 2,
		source: function(term, add) {
			var url = $('a.isolation_strain_numbers_url').attr('href') + $("#isolation_strain_search").val();
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$( "#isolation_strain_search" ).val( ui.item.label );
			$( "#isolation_strain_id" ).val( ui.item.id );
			return false;
		},
	});
	
	
	// Add a search box for Strain clones
	var strainIsClone = false;
	$("#bea_code #code input").blur(function(){
		if ( $(this).val().length == 0 && strainIsClone ) {
			$( "#strain_sample_id" ).val('');
			$( "#strain_sample_search" ).val(sampleSearchBoxDefault);
			$('#strain_sample_search').css("color", "888");
			$('#strain_sample_search').css("font-size", "11px");
			strainIsClone = false;
		}
	});
	$("#bea_code #code input").autocomplete({
		minLength: 1,
		source: function(term, add) {
			var url = $('a.strain_find_clone_url').attr('href') + $("#bea_code #code input").val();
			$( "#strain_clone_search_progress" ).fadeIn();
			$.getJSON(url, function(data){ add(data); $( "#strain_clone_search_progress" ).fadeOut(); });
		},
		select: function(event, ui) {
			$( "#bea_code #code input" ).val( ui.item.label );
			
			$( "#strain_taxonomic_class_id" ).val( ui.item.taxonomic_class_id );
			$( "#strain_genus_id" ).val( ui.item.genus_id );
			$( "#strain_species_id" ).val( ui.item.species_id );
			
			$( "#strain_sample_id" ).val( ui.item.sample_id );
			$( "#strain_sample_search" ).val( ui.item.sample_code );
			$('#strain_sample_search').css("color", "black");
			$('#strain_sample_search').css("font-size", "12px");
			
			strainIsClone = true;
			return false;
		},
	});
	
	
	// Add a "create" option to taxonomic class, genus, species and authority select elements in strain creation forms
	var strainRelatedModels = ["taxonomic_class", "genus", "species", "authority"];
	var selectCreateOptionValue = 'create';
	for (var i = strainRelatedModels.length - 1; i >= 0; i--) {
		var model = strainRelatedModels[i];
		var element = "#strain_" + model + "_id";
		var modelName = model.replace("taxonomic_", "");
		
		$(element).append('<option value="' + selectCreateOptionValue + '">Create another ' + modelName + '...</option>');
		$(element).change(function(){
			var selectInput = $(this);
			if ( selectInput.val() == selectCreateOptionValue ) {
				var model = selectInput.attr('id').replace("strain_", "").replace("_id", "");
				$.get('/strain/new_related_model/' + model, function(data) {
					selectInput.hide();
					selectInput.parent().append(data);
					$("#strain_new_" + model + "_name").focus();
				});
			}
		});
	};
	
	
	// Generate a new API token when requested
	$("#token_regeneration_link").click(function(event){
		event.preventDefault();
		
		$.get($(this).attr('href'), function(data) {
			$('#token_value_ipad').html(data);
		});
	});
	
	
	// Change the Isolation form on demand
	$("#isolation_isolation_subject").change(function(){
		location.href = $('a.isolation_isolation_subject_url').attr('href') + $(this).attr('value');
	});
	
	// Change the Project form on demand
	$("#project_subject").change(function(){
		location.href = $('a.project_subject_url').attr('href') + $(this).attr('value');
	});
	
	
	//$("#amount input").numeric({ "minValue": 0, emptyValue: false, increment: 1 });
	
	// Add a search box for products in Labels module
	var labelCodeSearchBoxDefault = 'Type a product code...';
	if ( !$('#label_product_id_search').val() ) {
		var input = $('#label_product_id_search');
		input.val(labelCodeSearchBoxDefault);
		input.css("color", "#888");
		input.css("font-size", "11px");
	}
	else if ( $('#label_product_id_search').val() != labelCodeSearchBoxDefault ) {
		var input = $('#label_product_id_search');
		input.css("color", "black");
		input.css("font-size", "12px");
	}
	
	$('#label_product_id_search').focus(function(){
		if ( $(this).val() == labelCodeSearchBoxDefault ){
			$(this).attr("value", "");
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		} 
	});
	$('#label_product_id_search').blur(function(){
		if( $(this).attr("value") == "" ) {
			$(this).attr("value", labelCodeSearchBoxDefault);
			$(this).css("color", "#888");
			$(this).css("font-size", "11px");
		}
	});
	$('#label_all_products input').change(function(){
		var input = $('#label_product_id_search');
		if ( $(this).is(':checked') ) {
			input.attr('disabled', 'disabled');
		}
		else {
			input.removeAttr('disabled');
		}
	});
	$('#label_product_id_search').autocomplete({
		minLength: 1,
		source: function(term, add) {
			var url = $('a.label_find_products_url').attr('href') + $("#label_product_id_search").val();
			url = url.replace('__PRODUCT__', $('#label_product_type #product_type').val());
			
			$.getJSON(url, function(data){ add(data); });
		},
		select: function(event, ui) {
			$("#label_product_id_search").val(ui.item.label);
			$("#product_id").val(ui.item.id);
			
			if ( isNumber(ui.item.transfer_interval) ) {
				$("#label_transfer_interval input").val(ui.item.transfer_interval);
			}
			
			return false;
		},
	});
	$('#label_product_type #product_type').change(function(){
		var url = $(this).parents('form').attr('action').replace('create', $('#label_product_type #product_type').val());
		$.get(url, function(html){
			$('#label_product_form').empty();
			$('#label_product_form').html(html);
			$("#label_transfer_interval input").numeric({ minValue: 0, emptyValue: true, increment: 1 });
		});
	});
	if ( $('#label_transfer_interval input').length ) {
		$("#label_transfer_interval input").numeric({ minValue: 0, emptyValue: true, increment: 1 });
	}
	
});