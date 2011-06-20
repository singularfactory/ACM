<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@strain') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="sample_code">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			<?php echo $form['sample_id'] ?>
		</div>
		
		<div id="taxonomic_class">
			<?php echo $form['taxonomic_class_id']->renderLabel() ?>
			<?php echo $form['taxonomic_class_id']->renderError() ?>
			<?php echo $form['taxonomic_class_id']->renderHelp() ?>
			<?php echo $form['taxonomic_class_id'] ?>
		</div>
		
		<div id="genus">
			<?php echo $form['genus_id']->renderLabel() ?>
			<?php echo $form['genus_id']->renderError() ?>
			<?php echo $form['genus_id']->renderHelp() ?>
			<?php echo $form['genus_id'] ?>
		</div>
		
		<div id="species">
			<?php echo $form['species_id']->renderLabel() ?>
			<?php echo $form['species_id']->renderError() ?>
			<?php echo $form['species_id']->renderHelp() ?>
			<?php echo $form['species_id'] ?>
		</div>
		
		<div id="authority">
			<?php echo $form['authority_id']->renderLabel() ?>
			<?php echo $form['authority_id']->renderError() ?>
			<?php echo $form['authority_id']->renderHelp() ?>
			<?php echo $form['authority_id'] ?>
		</div>
		
		<div id="epitype" class="checkbox">
			<?php echo $form['is_epitype']->renderLabel() ?>
			<?php echo $form['is_epitype'] ?>
		</div>
		
		<div id="public" class="checkbox">
			<?php echo $form['is_public']->renderLabel() ?>
			<?php echo $form['is_public'] ?>
		</div>
		
		<div id="axenic" class="checkbox">
			<?php echo $form['is_axenic']->renderLabel() ?>
			<?php echo $form['is_axenic'] ?>
		</div>
		
		<div id="isolator">
			<?php echo $form['isolator_id']->renderLabel() ?>
			<?php echo $form['isolator_id'] ?>
		</div>
		
		<div id="isolation_date" class="date_field">
			<?php echo $form['isolation_date']->renderLabel() ?>
			<?php echo $form['isolation_date']->renderError() ?>
			<?php echo $form['isolation_date']->renderHelp() ?>
			<?php echo $form['isolation_date'] ?>
		</div>
		
		<div id="depositor">
			<?php echo $form['depositor_id']->renderLabel() ?>
			<?php echo $form['depositor_id'] ?>
		</div>
		
		<div id="deposition_date" class="date_field">
			<?php echo $form['deposition_date']->renderLabel() ?>
			<?php echo $form['deposition_date']->renderError() ?>
			<?php echo $form['deposition_date']->renderHelp() ?>
			<?php echo $form['deposition_date'] ?>
		</div>
		
		<div id="identifier">
			<?php echo $form['identifier_id']->renderLabel() ?>
			<?php echo $form['identifier_id'] ?>
		</div>
		
		<div id="identification_date" class="date_field">
			<?php echo $form['identification_date']->renderLabel() ?>
			<?php echo $form['identification_date']->renderError() ?>
			<?php echo $form['identification_date']->renderHelp() ?>
			<?php echo $form['identification_date'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="maintenance_status">
			<?php echo $form['maintenance_status_id']->renderLabel() ?>
			<?php echo $form['maintenance_status_id'] ?>
		</div>
		
		<div id="cryopreservation_method">
			<?php echo $form['cryopreservation_method_id']->renderLabel() ?>
			<?php echo $form['cryopreservation_method_id'] ?>
		</div>
		
		<div id="growth_mediums_list" class="list_field">
			<?php echo $form['growth_mediums_list']->renderLabel() ?>
			<?php echo $form['growth_mediums_list'] ?>
		</div>
		
		<div id="transfer_interval">
			<?php echo $form['transfer_interval']->renderLabel() ?>
			<?php echo $form['transfer_interval'] ?>
		</div>
		
		<div id="observation">
			<?php echo $form['observation']->renderLabel() ?>
			<?php echo $form['observation']->renderError() ?>
			<?php echo $form['observation']->renderHelp() ?>
			<?php echo $form['observation'] ?>
		</div>
		
		<div id="citations">
			<?php echo $form['citations']->renderLabel() ?>
			<?php echo $form['citations']->renderError() ?>
			<?php echo $form['citations']->renderHelp() ?>
			<?php echo $form['citations'] ?>
		</div>
	
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this strain">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
