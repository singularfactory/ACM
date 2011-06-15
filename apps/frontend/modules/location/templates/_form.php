<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@location') ?>
	<?php echo $form->renderHiddenFields() ?>
	<?php echo tag('input', array('type' => 'hidden', 'value' => $form->getOption('max_location_pictures'), 'id' => 'max_location_pictures')) ?>

	<div id="left_side_form">
		<div id="name">
			<?php echo $form['name']->renderLabel() ?>
			<?php echo $form['name']->renderError() ?>
			<?php echo $form['name']->renderHelp() ?>
			<?php echo $form['name'] ?>
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

		<div id="country">
			<?php echo $form['country_id']->renderLabel() ?>
			<?php echo $form['country_id']->renderError() ?>
			<?php echo $form['country_id']->renderHelp() ?>
			<?php echo $form['country_id'] ?>
			<a href="<?php echo url_for('@country_find_regions?country=') ?>" class="country_regions_url"></a>
		</div>

		<div id="region">
			<?php echo $form['region_id']->renderLabel() ?>
			<?php echo $form['region_id']->renderError() ?>
			<?php echo $form['region_id']->renderHelp() ?>
			<?php echo $form['region_id'] ?>
			<a href="<?php echo url_for('@region_find_islands?region=') ?>" class="region_islands_url"></a>
		</div>

		<div id="island">
			<?php echo $form['island_id']->renderLabel() ?>
			<?php echo $form['island_id']->renderHelp() ?>
			<?php echo $form['island_id'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
		
		<?php if ( !$form->getObject()->isNew() && $form->getOption('max_location_pictures') < 5 ): ?>
		<div class="model_picture_list">
			<?php echo $form['Pictures']->renderLabel('Actual pictures') ?>
			<?php $i = 0 ?>
			<?php foreach ($form['Pictures'] as $widget): ?>
			<?php $picture = $widget->getValue() ?>
			<?php $image = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').'/'.$picture['filename'] ?>
			<?php $thumbnail = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$picture['filename'] ?>
			<div class="thumbnail">
				<p class="thumbnail_caption">
					<input type="checkbox" name="location[Pictures][<?php echo $i ?>][delete_object]" id="location_Pictures_<?php echo $i ?>_delete_object" />
					<input type="hidden" name="location[Pictures][<?php echo $i ?>][filename]" value="<?php echo $picture['filename'] ?>" id="location_Pictures_<?php echo $i ?>_filename" />
					<input type="hidden" name="location[Pictures][<?php echo $i ?>][id]" value="<?php echo $picture['id'] ?>" id="location_Pictures_<?php echo $i ?>_id" />
					 delete
				</p>
				<div class="thumbnail_image">
					<a href="<?php echo $image ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
						<img src="<?php echo $thumbnail ?>" alt="Picture <?php echo $i ?>" />
					</a>
				</div>
			</div>
			<?php $i++ ?>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
		<?php endif ?>

		<?php if ( $form->getOption('max_location_pictures') > 0 ): ?>
		<div id="model_pictures">
			<?php echo $form['new_Pictures']->renderLabel() ?>
			<?php echo $form['new_Pictures']->renderHelp() ?>
			<div class="model_picture_filename">
				<?php echo $form['new_Pictures'][0]['filename']->render() ?>
			</div>
		</div>
		
		<?php if ( $form->getOption('max_location_pictures') > 1 ): ?>
		<div class="pictures_add_relation">
			<?php echo $form['new_Pictures']['_']->render() ?>
		</div>
		<?php endif; ?>
		<?php endif; ?>
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this location">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>