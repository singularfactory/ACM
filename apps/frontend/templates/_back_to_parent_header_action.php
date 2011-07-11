<?php
	if ( !isset($title) ) {
		$title = sfInflector::humanize($module);
	}
	
?>
<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to($title, "@{$module}_show?id=$id") ?>
</div>