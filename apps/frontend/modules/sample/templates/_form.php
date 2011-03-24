<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@sample') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="id">
		<?php echo $form['id']->renderLabel() ?>
		<?php echo $form['id']->renderHelp() ?>
		<?php echo $form['id'] ?>
	</div>

	<div id="location">
		<?php echo $form['location_id']->renderLabel() ?>
		<?php echo $form['location_id']->renderHelp() ?>
		<?php echo $form['location_id'] ?>
	</div>
	
	<div id="latitude">
		<?php echo $form['latitude']->renderLabel() ?>
		<?php echo $form['latitude']->renderHelp() ?>
		<?php echo $form['latitude'] ?>
	</div>
	
	<div id="longitude">
		<?php echo $form['longitude']->renderLabel() ?>
		<?php echo $form['longitude']->renderHelp() ?>
		<?php echo $form['longitude'] ?>
	</div>

	<div id="environment">
		<?php echo $form['environment_id']->renderLabel() ?>
		<?php echo $form['environment_id']->renderHelp() ?>
		<?php echo $form['environment_id'] ?>
	</div>

	<div id="habitat">
		<?php echo $form['habitat_id']->renderLabel() ?>
		<?php echo $form['habitat_id']->renderHelp() ?>
		<?php echo $form['habitat_id'] ?>
	</div>

	<div id="extremophile" class="checkbox">
		<?php echo $form['is_extremophile']->renderLabel() ?>
		<?php echo $form['is_extremophile']->renderHelp() ?>
		<?php echo $form['is_extremophile'] ?>
	</div>

	<div id="ph">
		<?php echo $form['ph']->renderLabel() ?>
		<?php echo $form['ph']->renderHelp() ?>
		<?php echo $form['ph'] ?>
	</div>

	<div id="conductivity">
		<?php echo $form['conductivity']->renderLabel() ?>
		<?php echo $form['conductivity']->renderHelp() ?>
		<?php echo $form['conductivity'] ?>
	</div>

	<div id="temperature">
		<?php echo $form['temperature']->renderLabel() ?>
		<?php echo $form['temperature']->renderHelp() ?>
		<?php echo $form['temperature'] ?>
	</div>

	<div id="salinity">
		<?php echo $form['salinity']->renderLabel() ?>
		<?php echo $form['salinity']->renderHelp() ?>
		<?php echo $form['salinity'] ?>
	</div>

	<div id="altitude">
		<?php echo $form['altitude']->renderLabel() ?>
		<?php echo $form['altitude']->renderHelp() ?>
		<?php echo $form['altitude'] ?>
	</div>

	<div id="radiation">
		<?php echo $form['radiation_id']->renderLabel() ?>
		<?php echo $form['radiation_id']->renderHelp() ?>
		<?php echo $form['radiation_id'] ?>
	</div>

	<div id="field_picture">
		<?php echo $form['field_picture']->renderLabel() ?>
		<?php echo $form['field_picture']->renderHelp() ?>
		<?php echo $form['field_picture'] ?>
	</div>

	<div id="detailed_picture">
		<?php echo $form['detailed_picture']->renderLabel() ?>
		<?php echo $form['detailed_picture']->renderHelp() ?>
		<?php echo $form['detailed_picture'] ?>
	</div>

	<div id="microscopic_picture">
		<?php echo $form['microscopic_picture']->renderLabel() ?>
		<?php echo $form['microscopic_picture']->renderHelp() ?>
		<?php echo $form['microscopic_picture'] ?>
	</div>

	<div id="collector">
		<?php echo $form['collector_id']->renderLabel() ?>
		<?php echo $form['collector_id']->renderHelp() ?>
		<?php echo $form['collector_id'] ?>
	</div>

	<div id="collection_date">
		<?php echo $form['collection_date']->renderLabel() ?>
		<?php echo $form['collection_date']->renderHelp() ?>
		<?php echo $form['collection_date'] ?>
	</div>
	
	<div id="remarks">
		<?php echo $form['remarks']->renderLabel() ?>
		<?php echo $form['remarks'] ?>
	</div>

	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this sample">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', 'sample/index', array('class' => 'cancel_form_link')) ?>
	</div>
</form>