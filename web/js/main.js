// Store default text in search boxes
var search_box_hint = '';

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
	
	$("#table_row_selector_header").click(function() {
		var checkedStatus = this.checked;
		$('td.table_row_selector input[type="checkbox"]').each(function(){
			this.checked = checkedStatus;
		});
	});
	
	
});