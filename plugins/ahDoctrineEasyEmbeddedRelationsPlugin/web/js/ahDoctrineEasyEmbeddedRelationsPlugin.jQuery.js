/**
 * Code needed to clone nested relations forms
 * @plugin ahDoctrineEasyEmbeddedRelationsPlugin
 * @author Krzysztof Kotowicz <kkotowicz at gmail dot com>
 */
(function($) {

	/**
	 * Increments field IDs and names by one
	 */
	// $.fn.incrementFields = function(container) {
	// 	return this.each(function() {
	// 		var nameRe = new RegExp('\\[' + container + '\\]\\[(\\d+)\\]');
	// 		var idRe = new RegExp('_' + container + '_(\\d+)_');
	// 
	// 		$(this).find(':input').each(function() { // find each input
	// 			var matches;
	// 			if (matches = nameRe.exec(this.name)) { // check if its name contains [container][number]
	// 				// if so, increase the number in field name
	// 				this.name = this.name.replace(nameRe,'[' + container + '][' + (parseInt(matches[1],10)+1) + ']');
	// 			}
	// 			if (matches = idRe.exec(this.id)) { // check if its name contains _container_number_
	// 				// if so, increase the number in label for attribute
	// 				this.id = this.id.replace(idRe,'_' + container + '_' + (parseInt(matches[1],10)+1) + '_');
	// 			}
	// 			$(this).trigger('change.ah'); // trigger onchange event just for a case
	// 		}).end();
	// 
	// 		// fix labels
	// 		$(this).find('label[for]').each(function() {
	// 			var matches;
	// 			if (matches = idRe.exec($(this).attr('for'))) { // check if its name contains _container_number_
	// 				// if so, increase the number in label for attribute
	// 				$(this).attr('for', $(this).attr('for').replace(idRe,'_' + container + '_' + (parseInt(matches[1],10)+1) + '_'));
	// 			}
	// 		});
	// 
	// 		// increase the number in first <th>
	// 		$header = $(this).children('th').eq(0);
	// 		if ($header.text().match(/^\d+$/)) {
	// 			$header.text(parseInt($header.text(),10) + 1);
	// 		}
	// 		$(this).end();
	// 	});
	// }
	
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
	

})(jQuery);

jQuery(function($) {

	// when clicking the 'add relation' button
	$('.ahAddRelation').click(function() {
		// find last row of my siblings (each row represents a subform) 
		// $row = $(this).closest('tr,li').siblings('tr:last,li:last');	REPLACED BY STATEMENT BELOW. PAY ATTENTION IN PLUGIN UPGRADES
		$row = $(this).closest('tr,li,div').prev().children('div').children('input').last();

		// clone it, increment the fields and insert it below, additionally triggering events
		$row.trigger('beforeclone.ah');
		var $newrow = $row.clone(true);
		$row.trigger('afterclone.ah');
		
		constantName = "";
		switch( $(this).attr('rel').replace(/^new_+/, "") ) {
			case "Pictures":
				constantName = "#max_location_pictures";
			  break;
			case "FieldPictures":
				constantName = "#max_sample_field_pictures";
			  break;
			case "DetailedPictures":
				constantName = "#max_sample_detailed_pictures";
			  break;
			case "MicroscopicPictures":
				constantName = "#max_sample_microscopic_pictures";
			  break;
		}
		
		$newrow
			.incrementFields($(this).attr('rel'))
			.trigger('beforeadd.ah')
			.trigger('afteradd.ah')
			.appendTo($(this).parent().prev())
			.wrapAll('<div class="model_picture_filename" />');
		
			// Hide the add button when the limit is reached
			if ( $(this).closest('tr,li,div').prev().children('div').children('input').size() == $(constantName).val() ) {
				$(this).closest('div.pictures_add_relation').css('display', 'none');
			}

		//use events to further modify the cloned row like this
		// $(document).bind('beforeadd.ah', function(event) { $(event.target).hide() /* event.target is cloned row */ });
		// $(document).bind('afteradd.ah', function(event) { });
	})
});