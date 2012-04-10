<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@project') ?>
	<?php echo $form->renderHiddenFields() ?>
  
	<div id="left_side_form">
		
		<div id="subject">
			<?php echo $form['subject']->renderLabel() ?>
			<?php echo $form['subject']->renderError() ?>
			<?php echo $form['subject']->renderHelp() ?>
			<?php echo $form['subject'] ?>
			<?php if ( $form->getObject()->isNew() ): ?>
				<?php $route = '@project_filter_by_subject_new?subject=' ?>
			<?php else: ?>
				<?php $route = '@project_filter_by_subject_edit?id='.$form->getObject()->getId().'&subject=' ?>
			<?php endif; ?>
			<a href="<?php echo url_for($route) ?>" class="project_subject_url"></a>
		</div>
		
		<?php if ( isset($form['sample_id']) ): ?>
		<div id="sample_id">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew() || !$form->getObject()->getSample()->exists())?'Type a sample code...':$form->getObject()->getSample()->getCode(); ?>" id="project_sample_search" />
			<a href="<?php echo url_for('@project_find_samples?term=') ?>" class="project_sample_numbers_url"></a>
		</div>
		<?php endif ?>
		
		<?php if ( isset($form['strain_id']) ): ?>
		<div id="strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a strain code...':$form->getObject()->getStrain()->getFullCode(); ?>" id="project_strain_search" />
			<a href="<?php echo url_for('@project_find_strains?term=') ?>" class="project_strain_numbers_url"></a>
		</div>
		<?php endif ?>
		
		<?php if ( isset($form['external_strain_id']) ): ?>
		<div id="external_strain_id">
			<?php echo $form['external_strain_id']->renderLabel() ?>
			<?php echo $form['external_strain_id']->renderError() ?>
			<?php echo $form['external_strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a research collection code...':$form->getObject()->getExternalStrain()->getFullCode(); ?>" id="project_external_strain_search" />
			<a href="<?php echo url_for('@project_find_external_strains?term=') ?>" class="project_external_strain_numbers_url"></a>
		</div>
		<?php endif ?>
		
		<div id="project_name_id">
			<?php echo $form['project_name_id']->renderLabel() ?>
			<?php echo $form['project_name_id']->renderError() ?>
			<?php echo $form['project_name_id']->renderHelp() ?>
			<?php echo $form['project_name_id'] ?>
		</div>
		
		<div id="petitioner_id">
			<?php echo $form['petitioner_id']->renderLabel() ?>
			<?php echo $form['petitioner_id']->renderError() ?>
			<?php echo $form['petitioner_id']->renderHelp() ?>
			<?php echo $form['petitioner_id'] ?>
		</div>
		
		<div id="purpose">
			<?php echo $form['purpose']->renderLabel() ?>
			<?php echo $form['purpose']->renderError() ?>
			<?php echo $form['purpose']->renderHelp() ?>
			<?php echo $form['purpose'] ?>
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
	</div>
	
	<div id="right_side_form">
		<div id="provider_id">
			<?php echo $form['provider_id']->renderLabel() ?>
			<?php echo $form['provider_id']->renderError() ?>
			<?php echo $form['provider_id']->renderHelp() ?>
			<?php echo $form['provider_id'] ?>
		</div>
		
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
		
	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'project')) ?>
</form>
