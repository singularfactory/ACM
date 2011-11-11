$(document).ready(function(){

	var isolatorsTable = $('#strain_isolators_list tbody');
	if ( isolatorsTable.length ) {
		isolatorsTable.sortable({
			cursor: 'move',
			axis: 'y',
			helper: function(e, tr) {
				var $originals = tr.children();
				var $helper = tr.clone();
				$helper.children().each(function(index) {
					$(this).width($originals.eq(index).width())
				});
				return $helper;
			},
			
			stop: function(event, ui) {
				var ids = new Array();
				ui.item.closest('table').find('td.isolator_id').each(function(){
					ids.push($(this).text()); 
				});
				
				$.post($('#strain_isolators_list').siblings('a.strain_isolators_list_url').attr('href'), { 'isolators[]': ids, 'strain_id' : 6 } );
			}
		});
		
		isolatorsTable.disableSelection();
	}
	
});