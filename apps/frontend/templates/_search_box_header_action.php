<div id="main_header_action_search" class="main_header_action">
	<div id="search_box">
		<input type="text" name="criteria" id="search_box_criteria" value="<?php echo sfConfig::get('app_search_box_hint') ?>" />
		<?php echo link_to(image_tag('search.png', array('alt' => 'search')), $route) ?>
	</div>
</div>