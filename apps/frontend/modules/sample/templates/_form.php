<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@sample') ?>
	<?php echo $form->renderHiddenFields() ?>
	<?php echo tag('input', array('type' => 'hidden', 'value' => $form->getOption('max_sample_field_pictures'), 'id' => 'max_sample_field_pictures')) ?>
	<?php echo tag('input', array('type' => 'hidden', 'value' => $form->getOption('max_sample_detailed_pictures'), 'id' => 'max_sample_detailed_pictures')) ?>
	<?php echo tag('input', array('type' => 'hidden', 'value' => $form->getOption('max_sample_microscopic_pictures'), 'id' => 'max_sample_microscopic_pictures')) ?>

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

	</div>
	
	<div id="right_side_form">
		<div class="sample_picture_handler">
			<?php if ( !$form->getObject()->isNew() && $form->getOption('max_sample_field_pictures') < 3 ): ?>
			<div class="model_picture_list">
				<?php echo $form['FieldPictures']->renderLabel('Actual field pictures') ?>
				<?php $i = 0 ?>
				<?php foreach ($form['FieldPictures'] as $widget): ?>
				<?php $picture = $widget->getValue() ?>
				<div class="thumbnail">
					<p class="thumbnail_caption">
						<input type="checkbox" name="sample[FieldPictures][<?php echo $i ?>][delete_object]" id="sample_FieldPictures_<?php echo $i ?>_delete_object" />
						<input type="hidden" name="sample[FieldPictures][<?php echo $i ?>][filename]" value="<?php echo $picture['filename'] ?>" id="sample_FieldPictures_<?php echo $i ?>_filename" />
						<input type="hidden" name="sample[FieldPictures][<?php echo $i ?>][id]" value="<?php echo $picture['id'] ?>" id="sample_FieldPictures_<?php echo $i ?>_id" />
						 delete
					</p>
					<div class="thumbnail_image">
						<a href="<?php echo get_picture_with_path($picture['filename'], 'sample') ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
							<img src="<?php echo get_thumbnail($picture['filename'], 'sample') ?>" alt="Picture <?php echo $i ?>" />
						</a>
					</div>
				</div>
				<?php $i++ ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>
			<?php endif ?>

			<?php if ( $form->getOption('max_sample_field_pictures') > 0 ): ?>
			<div id="model_pictures">
				<?php echo $form['new_FieldPictures']->renderLabel() ?>
				<?php echo $form['new_FieldPictures']->renderHelp() ?>
				<div class="model_picture_filename">
					<?php echo $form['new_FieldPictures'][0]['filename']->render() ?>
				</div>
			</div>

			<?php if ( $form->getOption('max_sample_field_pictures') > 1 ): ?>
			<div class="pictures_add_relation">
				<?php echo $form['new_FieldPictures']['_']->render() ?>
			</div>
			<?php endif; ?>
			<?php endif; ?>

			
		</div>
		
		<div class="sample_picture_handler">
			<?php if ( !$form->getObject()->isNew() && $form->getOption('max_sample_detailed_pictures') < 3 ): ?>
			<div class="model_picture_list">
				<?php echo $form['DetailedPictures']->renderLabel('Actual detailed pictures') ?>
				<?php $i = 0 ?>
				<?php foreach ($form['DetailedPictures'] as $widget): ?>
				<?php $picture = $widget->getValue() ?>
				<div class="thumbnail">
					<p class="thumbnail_caption">
						<input type="checkbox" name="sample[DetailedPictures][<?php echo $i ?>][delete_object]" id="sample_DetailedPictures_<?php echo $i ?>_delete_object" />
						<input type="hidden" name="sample[DetailedPictures][<?php echo $i ?>][filename]" value="<?php echo $picture['filename'] ?>" id="sample_DetailedPictures_<?php echo $i ?>_filename" />
						<input type="hidden" name="sample[DetailedPictures][<?php echo $i ?>][id]" value="<?php echo $picture['id'] ?>" id="sample_DetailedPictures_<?php echo $i ?>_id" />
						 delete
					</p>
					<div class="thumbnail_image">
						<a href="<?php echo get_picture_with_path($picture['filename'], 'sample') ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
							<img src="<?php echo get_thumbnail($picture['filename'], 'sample') ?>" alt="Picture <?php echo $i ?>" />
						</a>
					</div>
				</div>
				<?php $i++ ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>
			<?php endif ?>

			<?php if ( $form->getOption('max_sample_detailed_pictures') > 0 ): ?>
			<div id="model_pictures">
				<?php echo $form['new_DetailedPictures']->renderLabel() ?>
				<?php echo $form['new_DetailedPictures']->renderHelp() ?>
				<div class="model_picture_filename">
					<?php echo $form['new_DetailedPictures'][0]['filename']->render() ?>
				</div>
			</div>

			<?php if ( $form->getOption('max_sample_detailed_pictures') > 1 ): ?>
			<div class="pictures_add_relation">
				<?php echo $form['new_DetailedPictures']['_']->render() ?>
			</div>
			<?php endif; ?>

			<?php endif; ?>
			
		</div>
		
		<div class="sample_picture_handler">
			<?php if ( !$form->getObject()->isNew() && $form->getOption('max_sample_microscopic_pictures') < 3 ): ?>
			<div class="model_picture_list">
				<?php echo $form['MicroscopicPictures']->renderLabel('Actual microscopic pictures') ?>
				<?php $i = 0 ?>
				<?php foreach ($form['MicroscopicPictures'] as $widget): ?>
				<?php $picture = $widget->getValue() ?>
				<div class="thumbnail">
					<p class="thumbnail_caption">
						<input type="checkbox" name="sample[MicroscopicPictures][<?php echo $i ?>][delete_object]" id="sample_MicroscopicPictures_<?php echo $i ?>_delete_object" />
						<input type="hidden" name="sample[MicroscopicPictures][<?php echo $i ?>][filename]" value="<?php echo $picture['filename'] ?>" id="sample_MicroscopicPictures_<?php echo $i ?>_filename" />
						<input type="hidden" name="sample[MicroscopicPictures][<?php echo $i ?>][id]" value="<?php echo $picture['id'] ?>" id="sample_MicroscopicPictures_<?php echo $i ?>_id" />
						 delete
					</p>
					<div class="thumbnail_image">
						<a href="<?php echo get_picture_with_path($picture['filename'], 'sample') ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
							<img src="<?php echo get_thumbnail($picture['filename'], 'sample') ?>" alt="Picture <?php echo $i ?>" />
						</a>
					</div>
				</div>
				<?php $i++ ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>
			<?php endif ?>

			<?php if ( $form->getOption('max_sample_microscopic_pictures') > 0 ): ?>
			<div id="model_pictures">
				<?php echo $form['new_MicroscopicPictures']->renderLabel() ?>
				<?php echo $form['new_MicroscopicPictures']->renderHelp() ?>
				<div class="model_picture_filename">
					<?php echo $form['new_MicroscopicPictures'][0]['filename']->render() ?>
				</div>
			</div>

			<?php if ( $form->getOption('max_sample_microscopic_pictures') > 1 ): ?>
			<div class="pictures_add_relation">
				<?php echo $form['new_MicroscopicPictures']['_']->render() ?>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			
		</div>
		
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
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