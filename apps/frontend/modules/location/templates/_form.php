<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@location') ?>
	<?php echo $form->renderHiddenFields() ?>
	<?php echo tag('input', array('type' => 'hidden', 'value' => $form->getOption('max_location_pictures'), 'id' => 'max_location_pictures')) ?>

	<div id="left_side_form">
		<div id="name">
			<?php echo $form['name']->renderLabel() ?>
			<?php echo $form['name']->renderHelp() ?>
			<?php echo $form['name'] ?>
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

		<div id="country">
			<?php echo $form['country_id']->renderLabel() ?>
			<?php echo $form['country_id']->renderHelp() ?>
			<?php echo $form['country_id'] ?>
		</div>

		<div id="region">
			<?php echo $form['region_id']->renderLabel() ?>
			<?php echo $form['region_id']->renderHelp() ?>
			<?php echo $form['region_id'] ?>
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
		<div id="location_picture_list">
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
						 delete this
					</p>
					<div id="thumbnail_image">
						<a href="<?php echo $image ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
							<img src="<?php echo $thumbnail ?>" alt="Picture <?php echo $i ?>" />
						</a>
					</div>
				</div>
				<?php $i++ ?>
				<?php endforeach; ?>
			</div>
		<?php endif ?>

		<?php if ( $form->getOption('max_location_pictures') > 0 ): ?>
		<div id="location_pictures">
			<?php echo $form['new_Pictures']->renderLabel() ?>
			<?php echo $form['new_Pictures']->renderHelp() ?>
			<div class="location_picture">
				<?php echo $form['new_Pictures'][0]['filename']->render() ?>
			</div>
		</div>

		<div id="pictures_add_relation">
			<?php echo $form['new_Pictures']['_']->render() ?>
		</div>
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