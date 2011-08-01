/**
 * Code needed to clone nested relations forms
 * @plugin ahDoctrineEasyEmbeddedRelationsPlugin
 * @author Krzysztof Kotowicz <kkotowicz at gmail dot com>
 */
(function($) {

	$.fn.incrementFields = function(container) {
		return this.each(function() {
			var nameRe = new RegExp('\\[' + container + '\\]\\[(\\d+)\\]');
			var idRe = new RegExp('_' + container + '_(\\d+)_');

			if (matches = nameRe.exec(this.name)) { // check if its name contains [container][number]
				// if so, increase the number in field name
					this.name = this.name.replace(nameRe,'[' + container + '][' + (parseInt(matches[1],10)+1) + ']');
				}
				if (matches = idRe.exec(this.id)) { // check if its name contains _container_number_
					// if so, increase the number in label for attribute
					this.id = this.id.replace(idRe,'_' + container + '_' + (parseInt(matches[1],10)+1) + '_');
				}
				$(this).trigger('change.ah'); // trigger onchange event just for a case

			$(this).end();
		});
	}
	
	$.fn.incrementMultipleFields = function(container) {
		return this.each(function() {
			var nameRe = new RegExp('\\[' + container + '\\]\\[(\\d+)\\]');
			var idRe = new RegExp('_' + container + '_(\\d+)_');
			
			var inputs = $(this).find(':input');
			for (var i = inputs.length - 1; i >= 0; i--){
				var input = inputs[i];
				
				if (matches = nameRe.exec(input.name)) {
					input.name = input.name.replace(nameRe,'[' + container + '][' + (parseInt(matches[1],10)+1) + ']');
				}
				if (matches = idRe.exec(input.id)) {
					input.id = input.id.replace(idRe,'_' + container + '_' + (parseInt(matches[1],10)+1) + '_');
				}
			};
			
			var labels = $(this).find('label');
			for (var i = labels.length - 1; i >= 0; i--){
				var label = labels[i];
				if (matches = idRe.exec($(label).attr('for'))) {
					$(label).attr('for', $(label).attr('for').replace(idRe, '_' + container + '_' + (parseInt(matches[1],10)+1) + '_'));
				}
			};
			
			$(this).trigger('change.ah');
			$(this).end();
		});
	}
	

})(jQuery);

jQuery(function($) {

	// when clicking the 'add relation' button
	$('.ahAddRelation').click(function() {
		// find last row of my siblings (each row represents a subform) 
		$row = $(this).closest('tr,li,div').prev().children('div').children('input').last();

		// clone it, increment the fields and insert it below, additionally triggering events
		$row.trigger('beforeclone.ah');
		var $newrow = $row.clone(true);
		$row.trigger('afterclone.ah');
		
		constantName = "";
		divClass = "";
		singleField = true;
		switch( $(this).attr('rel').replace(/^new_+/, "") ) {
			case "Pictures":
				if ( $(this).parent().attr('id').indexOf("strain") >= 0 ) {
					constantName = "#max_strain_pictures";
				}
				else {
					constantName = "#max_location_pictures";
				}
				divClass = "model_picture_filename";
			  break;
			case "FieldPictures":
				constantName = "#max_sample_field_pictures";
				divClass = "model_picture_filename";
			  break;
			case "DetailedPictures":
				constantName = "#max_sample_detailed_pictures";
				divClass = "model_picture_filename";
			  break;
			case "MicroscopicPictures":
				constantName = "#max_sample_microscopic_pictures";
				divClass = "model_picture_filename";
			  break;
			case "Relatives":
				divClass = "model_text_input_name";
				$newrow.val('');
			  break;
			case "Gel":
				divClass = "model_text_input_gel";
				$newrow.val('');
				singleField = false;
			  break;
			case "Reaction":
				divClass = "model_text_input_reaction";
				$newrow.val('');
				singleField = false;
			  break;
			case "Steps":
				divClass = "model_text_input_steps";
				$newrow.val('');
				singleField = false;
				break;
		}
		
		if ( singleField ) {
			$newrow
				.incrementFields($(this).attr('rel'))
				.trigger('beforeadd.ah')
				.trigger('afteradd.ah')
				.appendTo($(this).parent().prev())
				.wrapAll('<div class="' + divClass + '" />');
		}
		else {
			$row = $(this).closest('tr,li,div').prev().children('div').last();

			// clone it, increment the fields and insert it below, additionally triggering events
			$row.trigger('beforeclone.ah');
			var $newrow = $row.clone(true);
			$row.trigger('afterclone.ah');
			
			$newrow.find(':input').val('');
			
			$newrow
				.incrementMultipleFields($(this).attr('rel'))
				.trigger('beforeadd.ah')
				.trigger('afteradd.ah')
				.appendTo($(this).parent().prev());
		}
		
		// Hide the add button when the limit is reached
		if ( $(this).closest('tr,li,div').prev().children('div').children('input').size() == $(constantName).val() ) {
			$(this).closest('div.pictures_add_relation').css('display', 'none');
		}

		//use events to further modify the cloned row like this
		// $(document).bind('beforeadd.ah', function(event) { $(event.target).hide() /* event.target is cloned row */ });
		// $(document).bind('afteradd.ah', function(event) { });
	})
});