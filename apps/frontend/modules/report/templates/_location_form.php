<div id="report_location_group_by">
	<?php echo $form['location_group_by']->renderLabel() ?>
	<?php echo $form['location_group_by']->renderError() ?>
	<?php echo $form['location_group_by']->renderHelp() ?>
	<?php echo $form['location_group_by'] ?>
</div>

<div id="report_location_country" class="report_inline_where">
	<?php echo $form['location_country']->renderLabel() ?>
	<?php echo $form['location_country']->renderError() ?>
	<?php echo $form['location_country']->renderHelp() ?>
	<input type="text" value="" id="report_location_country_search" name="location_country_search" class="report_search_box" />
	<a href="<?php echo url_for('@report_find_countries?country=') ?>" class="report_find_countries_url"></a>
</div>

<div id="report_location_region" class="report_inline_where">
	<?php echo $form['location_region']->renderLabel() ?>
	<?php echo $form['location_region']->renderError() ?>
	<?php echo $form['location_region']->renderHelp() ?>
	<input type="text" value="" id="report_location_region_search" name="location_region_search" class="report_search_box" />
	<a href="<?php echo url_for('@report_find_regions?region=') ?>" class="report_find_regions_url"></a>
</div>

<div id="report_location_island" class="report_inline_where">
	<?php echo $form['location_island']->renderLabel() ?>
	<?php echo $form['location_island']->renderError() ?>
	<?php echo $form['location_island']->renderHelp() ?>
	<input type="text" value="" id="report_location_island_search" name="location_island_search" class="report_search_box" />
	<a href="<?php echo url_for('@report_find_islands?island=') ?>" class="report_find_islands_url"></a>
</div>

<div id="report_location_category" class="report_inline_where">
	<?php echo $form['location_category']->renderLabel() ?>
	<?php echo $form['location_category']->renderError() ?>
	<?php echo $form['location_category']->renderHelp() ?>
	<?php echo $form['location_category'] ?>
</div>
