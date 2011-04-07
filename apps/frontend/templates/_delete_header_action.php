<div id="main_header_action_delete" class="main_header_action">
	<?php echo link_to('Delete', "@{$module}_delete?id=$id", array('method' => 'delete', 'confirm' => "Are you sure you want to delete this $module?")) ?>
</div>