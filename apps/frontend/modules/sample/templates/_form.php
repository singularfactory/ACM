<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@sample') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="notebook_code">
			<?php echo $form['notebook_code']->renderLabel() ?>
			<?php echo $form['notebook_code']->renderError() ?>
			<?php echo $form['notebook_code']->renderHelp() ?>
			<?php echo $form['notebook_code'] ?>
		</div>

		<div id="location">
			<?php echo $form['location_id']->renderLabel() ?>
			<?php echo $form['location_id']->renderError() ?>
			<?php echo $form['location_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a location...':$form->getObject()->getLocation()->getName(); ?>" id="sample_location_search" />
			<a href="<?php echo url_for('@sample_find_locations?term=') ?>" class="sample_location_coordinates_url"></a>
		</div>

		<div id="gps_coordinates">
			<?php echo $form['latitude']->renderLabel() ?>
			
			<?php if ( $form['latitude']->hasError() || $form['longitude']->hasError() ): ?>
				<?php if ( $form['latitude']->hasError() ): ?>
					<?php echo $form['latitude']->renderError() ?>
				<?php elseif ( $form['longitude']->hasError() ): ?>
					<?php echo $form['longitude']->renderError() ?>
				<?php endif; ?>					
			<?php endif; ?>
			
			<?php echo $form['latitude']->renderHelp() ?>
			<?php echo $form['latitude'] ?>
			<span class="gps_coordinates_separator"><?php echo sfConfig::get('app_gps_coordinates_separator') ?></span>
			<?php echo $form['longitude'] ?>
			<?php include_partial('global/gps_picker_link') ?>
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
			<?php echo $form['is_extremophile'] ?>
		</div>

		<div id="ph">
			<?php echo $form['ph']->renderLabel() ?>
			<?php echo $form['ph']->renderError() ?>
			<?php echo $form['ph']->renderHelp() ?>
			<?php echo $form['ph'] ?>
		</div>

		<div id="conductivity">
			<?php echo $form['conductivity']->renderLabel() ?>
			<?php echo $form['conductivity']->renderError() ?>
			<?php echo $form['conductivity']->renderHelp() ?>
			<?php echo $form['conductivity'] ?>
			<span class="value_unit"><?php echo sfConfig::get('app_conductivity_unit') ?></span>
		</div>

		<div id="temperature">
			<?php echo $form['temperature']->renderLabel() ?>
			<?php echo $form['temperature']->renderError() ?>
			<?php echo $form['temperature']->renderHelp() ?>
			<?php echo $form['temperature'] ?>
			<span class="value_unit"><?php echo sfConfig::get('app_temperature_unit') ?></span>
		</div>

		<div id="salinity">
			<?php echo $form['salinity']->renderLabel() ?>
			<?php echo $form['salinity']->renderError() ?>
			<?php echo $form['salinity']->renderHelp() ?>
			<?php echo $form['salinity'] ?>
			<span class="value_unit"><?php echo sfConfig::get('app_salinity_unit') ?></span>
		</div>

		<div id="altitude">
			<?php echo $form['altitude']->renderLabel() ?>
			<?php echo $form['altitude']->renderError() ?>
			<?php echo $form['altitude']->renderHelp() ?>
			<?php echo $form['altitude'] ?>
			<span class="value_unit"><?php echo sfConfig::get('app_altitude_unit') ?></span>
		</div>

		<div id="radiation">
			<?php echo $form['radiation_id']->renderLabel() ?>
			<?php echo $form['radiation_id']->renderHelp() ?>
			<?php echo $form['radiation_id'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="collector">
			<?php echo $form['collector_id']->renderLabel() ?>
			<?php echo $form['collector_id']->renderError() ?>
			<?php echo $form['collector_id']->renderHelp() ?>
			<?php echo $form['collector_id'] ?>
		</div>

		<div id="collection_date" class="date_field">
			<?php echo $form['collection_date']->renderLabel() ?>
			<?php echo $form['collection_date']->renderError() ?>
			<?php echo $form['collection_date']->renderHelp() ?>
			<?php echo $form['collection_date'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>

		<?php $pictures = array() ?>
		<?php if ( !$form['field_picture']->getValue() ): ?>
		<div id="field_picture">
			<?php echo $form['field_picture']->renderLabel() ?>
			<?php echo $form['field_picture'] ?>
		</div>
		<?php else: ?>
		<?php $pictures['field_picture'] = $form['field_picture']->getValue() ?>
		<?php endif; ?>

		<?php if ( !$form['detailed_picture']->getValue() ): ?>
		<div id="detailed_picture">
			<?php echo $form['detailed_picture']->renderLabel() ?>
			<?php echo $form['detailed_picture'] ?>
		</div>
		<?php else: ?>
		<?php $pictures['detailed_picture'] = $form['detailed_picture']->getValue() ?>
		<?php endif; ?>

		<?php if ( !$form['microscopic_picture']->getValue() ): ?>
		<div id="microscopic_picture">
			<?php echo $form['microscopic_picture']->renderLabel() ?>
			<?php echo $form['microscopic_picture'] ?>
		</div>
		<?php else: ?>
		<?php $pictures['microscopic_picture'] = $form['microscopic_picture']->getValue() ?>
		<?php endif; ?>
		
		<?php if ( !empty($pictures) ): ?>
		<div id="sample_picture_list">
			<label for="sample_pictures">Actual pictures</label>
			<?php foreach ($pictures as $picture => $filename): ?>
				<?php $image = sfConfig::get('app_pictures_dir').sfConfig::get('app_sample_pictures_dir').'/'.$filename ?>
				<?php $thumbnail = sfConfig::get('app_pictures_dir').sfConfig::get('app_sample_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$filename ?>
				<div class="thumbnail">
					<p class="thumbnail_caption">
						<?php echo str_replace(' picture', '', $form[$picture]->renderLabel()) ?>
						<input type="checkbox" name="sample[<?php echo $picture ?>_delete]" id="sample_<?php echo $picture ?>_delete" />
						<input type="hidden" name="sample[<?php echo $picture ?>]" value="<?php echo $picture ?>" id="sample_<?php echo $picture ?>" />
						 delete
					</p>
					<div id="thumbnail_image">
						<a href="<?php echo $image ?>" rel="thumbnail_link" title="<?php echo $picture ?>" class="cboxElement">
							<img src="<?php echo $thumbnail ?>" alt="<?php echo $picture ?>" />
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this sample">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>