<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@cryopreservation') ?>
	<?php echo $form->renderHiddenFields() ?>
  
	<div id="left_side_form">
		<div id="subject">
			<?php echo $form['subject']->renderLabel() ?>
			<?php echo $form['subject']->renderError() ?>
			<?php echo $form['subject']->renderHelp() ?>
			<?php echo $form['subject'] ?>
			<?php if ( $form->getObject()->isNew() ): ?>
				<?php $route = '@cryopreservation_filter_by_subject_new?subject=' ?>
			<?php else: ?>
				<?php $route = '@cryopreservation_filter_by_subject_edit?id='.$form->getObject()->getId().'&subject=' ?>
			<?php endif; ?>
			<a href="<?php echo url_for($route) ?>" class="cryopreservation_subject_url"></a>
		</div>
		
		<?php if ( isset($form['sample_id']) ): ?>
		<div id="sample_id">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew() || !$form->getObject()->getSample()->exists())?'Type a sample code...':$form->getObject()->getSample()->getCode(); ?>" id="cryopreservation_sample_search" />
			<a href="<?php echo url_for('@cryopreservation_find_samples?term=') ?>" class="cryopreservation_sample_numbers_url"></a>
		</div>
		<?php endif ?>
		
		<?php if ( isset($form['strain_id']) ): ?>
		<div id="strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a strain code...':$form->getObject()->getStrain()->getFullCode(); ?>" id="cryopreservation_strain_search" />
			<a href="<?php echo url_for('@cryopreservation_find_strains?term=') ?>" class="cryopreservation_strain_numbers_url"></a>
		</div>
		<?php endif ?>
		
		<div id="cryopreservation_method_id">
			<?php echo $form['cryopreservation_method_id']->renderLabel() ?>
			<?php echo $form['cryopreservation_method_id']->renderError() ?>
			<?php echo $form['cryopreservation_method_id']->renderHelp() ?>
			<?php echo $form['cryopreservation_method_id'] ?>
		</div>
		
		<div id="cryopreservation_date" class="date_field">
			<?php echo $form['cryopreservation_date']->renderLabel() ?>
			<?php echo $form['cryopreservation_date']->renderError() ?>
			<?php echo $form['cryopreservation_date']->renderHelp() ?>
			<?php echo $form['cryopreservation_date'] ?>
		</div>
		
		<div id="first_replicate">
			<?php echo $form['first_replicate']->renderLabel() ?>
			<?php echo $form['first_replicate']->renderError() ?>
			<?php echo $form['first_replicate']->renderHelp() ?>
			<?php echo $form['first_replicate'] ?>
		</div>
		
		<div id="second_replicate">
			<?php echo $form['second_replicate']->renderLabel() ?>
			<?php echo $form['second_replicate']->renderError() ?>
			<?php echo $form['second_replicate']->renderHelp() ?>
			<?php echo $form['second_replicate'] ?>
		</div>
		
		<div id="third_replicate">
			<?php echo $form['third_replicate']->renderLabel() ?>
			<?php echo $form['third_replicate']->renderError() ?>
			<?php echo $form['third_replicate']->renderHelp() ?>
			<?php echo $form['third_replicate'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="density">
			<?php echo $form['density']->renderLabel() ?>
			<?php echo $form['density']->renderError() ?>
			<?php echo $form['density']->renderHelp() ?>
			<?php echo $form['density'] ?>
		</div>
		
		<div id="revival_date" class="date_field">
			<?php echo $form['revival_date']->renderLabel() ?>
			<?php echo $form['revival_date']->renderError() ?>
			<?php echo $form['revival_date']->renderHelp() ?>
			<?php echo $form['revival_date'] ?>
		</div>
		
		<div id="viability">
			<?php echo $form['viability']->renderLabel() ?>
			<?php echo $form['viability']->renderError() ?>
			<?php echo $form['viability']->renderHelp() ?>
			<?php echo $form['viability'] ?>
		</div>
			
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>
		
	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'cryopreservation')) ?>
</form>
