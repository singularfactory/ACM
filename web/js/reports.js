/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Js
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

var searchBoxHelp = new Array();
searchBoxHelp['country'] = 'Type a country name...';
searchBoxHelp['region'] = 'Type a region name...';
searchBoxHelp['island'] = 'Type an island name...';

function parseSearchBoxTarget (htmlInput) {
	return htmlInput.attr('name').replace(/^\w+_(\w+)_search$/, "$1");
}

function parseSearchBoxSubject (htmlInput) {
	return htmlInput.attr('name').replace(/^(\w+)_\w+_search$/, "$1");
}


$(document).ready(function(){
	// Manage onChange event in report generation
	$('#report_subject #subject').change(function(){
		var url = $(this).parents('form').attr('action').replace('generate', $('#report_subject #subject').val());
		var subjectForm = $('#report_subject_form');

		// Load subform using AJAX
		// $.get(url, function(html){
		// 	subjectForm.empty();
		// 	subjectForm.html(html);
		// });
		
		// Redirect the whole page
		location.href = url;
	});
	
	// Handle search boxes
	$('input.report_search_box').each(function(){
		var name = parseSearchBoxTarget($(this));
		
		// Control whether to initially display the help text and default styles
		if ( ! $(this).val().length ) {
			$(this).val(searchBoxHelp[name])
		}
		else if ( $(this).val() != searchBoxHelp[name] ) {
			$(this).css("color", "black");
			$(this).css("font-size", "12px");
		}
		
		// Remove default help text when input gains focus
		$(this).focus(function(){
			if ( $(this).val() == searchBoxHelp[name] ) {
				$(this).val('');
				$(this).css("color", "black");
				$(this).css("font-size", "12px");
			}
		});
		
		// Assigns default help text when input loses focus
		$(this).blur(function(){
			if( $(this).val() == '' ) {
				$(this).val(searchBoxHelp[name]);
				$(this).css("color", "#888");
				$(this).css("font-size", "11px");
			}
		});
		
		// Assigns autocomplete plugin
		var input = $(this);
		var url = $(this).next('a').attr('href');
		var subject = parseSearchBoxSubject(input);
		
		$(this).autocomplete({
			minLength: 2,
			source: function(term, add) {
				$.getJSON(url + input.val(), function(data){ add(data); });
			},
			select: function(event, ui) {
				input.val( ui.item.label );
				$( '#' + subject + '_' + name ).val( ui.item.id );
				return false;
			},
		});
		
	});
	
	// Clear report form on demand
	$('#report_clear_values_link').click(function(event){
		event.preventDefault();
		var form = $(this).closest('form');
		
		form.find('input[type=text]').each(function(){
			var name = parseSearchBoxTarget($(this));
			
			if ( name !== 'country' && name !== 'region' && name !== 'island' ) {
				$(this).val('');
			}
		});
		
		form.find('select').each(function(){
			var name = parseSearchBoxTarget($(this));
			
			if ( name !== 'subject' ) {
				$(this).val(0);
			}
		});
	});
	
});
