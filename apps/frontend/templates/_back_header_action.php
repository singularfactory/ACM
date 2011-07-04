<?php
	$pageNumber = null;
	if ( $page = $sf_user->getAttribute("$module.index_page") ) {
		$pageNumber = "?page=$page";	
	}
	
	$searchCriteria = null;
	if ( $text = $sf_user->getAttribute('search.criteria') ) {
		$searchCriteria = "criteria=$text";
		if ( !$pageNumber ) {
			$searchCriteria = "?$searchCriteria";
		}
		else {
			$searchCriteria = "&$searchCriteria";
		}
	}	
?>

<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to('Back to list', "@{$module}_pagination{$pageNumber}{$searchCriteria}") ?>
</div>