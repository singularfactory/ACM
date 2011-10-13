<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@project') ?>
	<?php echo $form->renderHiddenFields() ?>
  
	<div id="left_side_form">
		<div id="strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a strain code...':$form->getObject()->getStrain()->getCode(); ?>" id="project_strain_search" />
			<a href="<?php echo url_for('@project_find_strains?term=') ?>" class="project_strain_numbers_url"></a>
		</div>
		
		<div id="provider_id">
			<?php echo $form['provider_id']->renderLabel() ?>
			<?php echo $form['provider_id']->renderError() ?>
			<?php echo $form['provider_id']->renderHelp() ?>
			<?php echo $form['provider_id'] ?>
		</div>
		
		<div id="amount">
			<?php echo $form['amount']->renderLabel() ?>
			<?php echo $form['amount']->renderError() ?>
			<?php echo $form['amount']->renderHelp() ?>
			<?php echo $form['amount'] ?>
		</div>
		
		<div id="inoculation_date" class="date_field">
			<?php echo $form['inoculation_date']->renderLabel() ?>
			<?php echo $form['inoculation_date']->renderError() ?>
			<?php echo $form['inoculation_date']->renderHelp() ?>
			<?php echo $form['inoculation_date'] ?>
		</div>
		
		<div id="purpose">
			<?php echo $form['purpose']->renderLabel() ?>
			<?php echo $form['purpose']->renderError() ?>
			<?php echo $form['purpose']->renderHelp() ?>
			<?php echo $form['purpose'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="delivery_date" class="date_field">
			<?php echo $form['delivery_date']->renderLabel() ?>
			<?php echo $form['delivery_date']->renderError() ?>
			<?php echo $form['delivery_date']->renderHelp() ?>
			<?php echo $form['delivery_date'] ?>
		</div>
			
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>
	
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this project">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
