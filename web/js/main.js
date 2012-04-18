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

// Store default text in search boxes
var search_box_hint = '';

// Custom test for number
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

$(document).ready(function(){
	// Store default text in search boxes
	search_box_hint = $('#search_box_criteria').val();
	
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
		var criteria = $(this).prev().val();
		if ( criteria != null && criteria != search_box_hint ) {
			$(this).attr('href', $(this).attr('href') + criteria);
		}
	});
	
	// Append input value to link url and redirect when pressing Enter key in search boxes
	$('#search_box input').keypress(function(e){
		if( e.which == 13 ) {
			location.href = $('#search_box a').attr('href') + $(this).val();
		}
	});
	
	// Link to delete messages in a table
	$('#delete_table_row_selector_link').click(function(event){
		var checkboxes = $('td.table_row_selector input[type="checkbox"]:checked');
		if ( checkboxes.size() > 0 && confirm("Are you sure you want to delete the selected messages?") ) {
			var f = document.createElement('form');
			f.method = 'post';
			f.action = this.href + 0;
			
			checkboxes.each(function(){
				var m = document.createElement('input');
				m.setAttribute('type', 'hidden');
				m.setAttribute('name', $(this).attr('name'));
				m.setAttribute('value', $(this).attr('value'));
				f.appendChild(m);
			});
			
			var m = document.createElement('input');
			m.setAttribute('type', 'hidden');
			m.setAttribute('name', 'sf_method');
			m.setAttribute('value', 'delete');
			f.appendChild(m);
			f.submit();
			return false;
		}
		else {
			event.preventDefault();
		}
	});
	
	// Set the checked/unchecked status to every row in a table
	$("#table_row_selector_header").click(function() {
		var checkedStatus = this.checked;
		$('td.table_row_selector input[type="checkbox"]').each(function(){
			this.checked = checkedStatus;
		});
	});
	
	// Hide main_header div if the page is a HTTP error
	if ( $('div.http_error').size() ) {
		$('#main_header').hide();
	}
	
	// Go back link
	$('#go_back_link').click(function(event){
		event.preventDefault();
		window.history.back();
	});
	
	// Reload link
	$('#reload_link').click(function(event){
		event.preventDefault();
		location.reload();
	});

	$(".header_menu_item").hover(
		function(){
			$("#header_menu_services a").first().css('-webkit-border-top-right-radius', '5px');
			$("#header_menu_services a").first().css('-moz-border-radius-topright', '5px');
			$("#header_menu_services a").first().css('border-top-right-radius', '5px');
			$("#header_menu_services a").last().css('-webkit-border-bottom-right-radius', '5px');
			$("#header_menu_services a").last().css('-moz-border-radius-bottomright', '5px');
			$("#header_menu_services a").last().css('border-bottom-right-radius', '5px');
			$("#header_menu_services a").last().css('-webkit-border-bottom-left-radius', '5px');
			$("#header_menu_services a").last().css('-moz-border-radius-bottomleft', '5px');
			$("#header_menu_services a").last().css('border-bottom-left-radius', '5px');
		},
		function(){
			
		}
	);

	$("#header_menu_services a").hover(
		function(){
			$(this).parents(".header_menu_item").children('a').css('background-color', '#6CF');
		},
		function(){
			$(this).parents(".header_menu_item").children('a').css('background-color', '#18498A');
		}
	);
	
});