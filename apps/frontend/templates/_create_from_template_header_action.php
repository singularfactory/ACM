<?php
	$searchCriteria = null;
	$pageNumber = null;
	$url = $module;
	
	if ( $text = $sf_user->getAttribute('search.criteria') ) {
		$searchCriteria = "?criteria=$text";
		$url = "{$module}_search";
	}
	
	if ( $page = $sf_user->getAttribute("$module.index_page") ) {
		$pageNumber = "page=$page";	
		if ( !$searchCriteria ) {
			$pageNumber = "?$pageNumber";
			$url = "{$module}_pagination";
		}
		else {
			$pageNumber = "&$pageNumber";
			$url = "{$module}_search_pagination";
		}
	}

?>

<div id="main_header_action_create_from_template" class="main_header_action">
	<?php echo link_to('Duplicate', "@{$module}_create_from_template?id=$id") ?>
</div>