<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@location') ?>
	<?php echo $form->renderHiddenFields() ?>
	
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
	
	<div id="remarks">
		<?php echo $form['remarks']->renderLabel() ?>
		<?php echo $form['remarks'] ?>
	</div>
	
	<div id="pictures">
		<?php echo $form['new_Pictures']->renderLabel() ?>
		<?php echo $form['new_Pictures']->renderHelp() ?>
		<?php echo $form['new_Pictures'][0]['filename']->render() ?>
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this location">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', 'location/index', array('class' => 'cancel_form_link')) ?>
	</div>
</form>