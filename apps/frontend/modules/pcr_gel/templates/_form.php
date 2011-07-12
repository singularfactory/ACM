<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@pcr_gel') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="number">
			<?php echo $form['number']->renderLabel() ?>
			<?php echo $form['number']->renderError() ?>
			<?php echo $form['number']->renderHelp() ?>
			<?php echo $form['number'] ?>
		</div>
		
		<div id="ratio">
			<?php echo $form['ratio']->renderLabel() ?>
			<?php echo $form['ratio']->renderError() ?>
			<?php echo $form['ratio']->renderHelp() ?>
			<?php echo $form['ratio'] ?>
		</div>
		
		<div id="is_valid" class="checkbox">
			<?php echo $form['is_valid']->renderLabel() ?>
			<?php echo $form['is_valid'] ?>
			<?php echo $form['is_valid']->renderHelp() ?>
		</div>
	</div>
	
	<div id="right_side_form">
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this gel">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
