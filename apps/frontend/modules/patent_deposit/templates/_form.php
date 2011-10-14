<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@patent_deposit') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="depositor_code">
			<?php echo $form['depositor_code']->renderLabel() ?>
			<?php echo $form['depositor_code']->renderError() ?>
			<?php echo $form['depositor_code']->renderHelp() ?>
			<?php echo $form['depositor_code'] ?>
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
		
		<div id="location">
			<?php echo $form['location_id']->renderLabel() ?>
			<?php echo $form['location_id']->renderError() ?>
			<?php echo $form['location_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a location...':$form->getObject()->getLocation()->getName(); ?>" id="patent_deposit_location_search" />
			<a href="<?php echo url_for('@patent_deposit_find_locations?term=') ?>" class="patent_deposit_location_coordinates_url"></a>
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
		
		<div id="collectors" class="list_field">
			<?php echo $form['collectors_list']->renderLabel() ?>
			<?php echo $form['collectors_list']->renderError() ?>
			<?php echo $form['collectors_list']->renderHelp() ?>
			<?php echo $form['collectors_list'] ?>
		</div>
		
		<div id="collection_date" class="date_field">
			<?php echo $form['collection_date']->renderLabel() ?>
			<?php echo $form['collection_date']->renderError() ?>
			<?php echo $form['collection_date']->renderHelp() ?>
			<?php echo $form['collection_date'] ?>
		</div>
		
		<div id="epitype" class="checkbox">
			<?php echo $form['is_epitype']->renderLabel() ?>
			<?php echo $form['is_epitype'] ?>
		</div>
		
		<div id="axenic" class="checkbox">
			<?php echo $form['is_axenic']->renderLabel() ?>
			<?php echo $form['is_axenic'] ?>
		</div>
		
		<div id="public" class="checkbox">
			<?php echo $form['is_public']->renderLabel() ?>
			<?php echo $form['is_public'] ?>
			<?php echo $form['is_public']->renderHelp() ?>
		</div>
				
		<div id="culture_media_list" class="list_field">
			<?php echo $form['culture_media_list']->renderLabel() ?>
			<?php echo $form['culture_media_list']->renderError() ?>
			<?php echo $form['culture_media_list']->renderHelp() ?>
			<?php echo $form['culture_media_list'] ?>
		</div>
		
		<div id="maintenance_status">
			<?php echo $form['maintenance_status_id']->renderLabel() ?>
			<?php echo $form['maintenance_status_id'] ?>
		</div>
		
		<div id="cryopreservation_method">
			<?php echo $form['cryopreservation_method_id']->renderLabel() ?>
			<?php echo $form['cryopreservation_method_id']->renderError() ?>
			<?php echo $form['cryopreservation_method_id']->renderHelp() ?>
			<?php echo $form['cryopreservation_method_id'] ?>
		</div>
			
		<div id="isolators" class="list_field">
			<?php echo $form['isolators_list']->renderLabel() ?>
			<?php echo $form['isolators_list']->renderError() ?>
			<?php echo $form['isolators_list']->renderHelp() ?>
			<?php echo $form['isolators_list'] ?>
		</div>
		
		<div id="isolation_date" class="date_field">
			<?php echo $form['isolation_date']->renderLabel() ?>
			<?php echo $form['isolation_date']->renderError() ?>
			<?php echo $form['isolation_date']->renderHelp() ?>
			<?php echo $form['isolation_date'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="dna_availability" class="checkbox">
			<?php echo $form['has_dna']->renderLabel() ?>
			<?php echo $form['has_dna'] ?>
			<?php echo $form['has_dna']->renderHelp() ?>
		</div>
		
		<div id="identifier">
			<?php echo $form['identifier_id']->renderLabel() ?>
			<?php echo $form['identifier_id'] ?>
		</div>
		
		<div id="gen_sequence">
			<?php echo $form['gen_sequence']->renderLabel() ?>
			<?php echo $form['gen_sequence']->renderError() ?>
			<?php echo $form['gen_sequence']->renderHelp() ?>
			<?php echo $form['gen_sequence'] ?>
		</div>
		
		<?php if ( !$form->getObject()->isNew() && isset($form['Relatives']) ): ?>
		<div class="model_text_input_list">
			<?php echo $form['Relatives']->renderLabel('Actual relatives') ?>
			<?php $i = 0 ?>
			<ul>
				<?php foreach ($form['Relatives'] as $widget): ?>
				<?php $relative = $widget->getValue() ?>
				<li>
					<input type="hidden" name="strain[Relatives][<?php echo $i ?>][name]" value="<?php echo $relative['name'] ?>" id="strain_Relatives_<?php echo $i ?>_name" />
					<input type="hidden" name="strain[Relatives][<?php echo $i ?>][id]" value="<?php echo $relative['id'] ?>" id="strain_Relatives_<?php echo $i ?>_id" />
					<div class="model_text_input_value">
						<span><?php echo $relative['name'] ?></span>
						<div class="model_text_input_value_checkbox">
							<input type="checkbox" name="strain[Relatives][<?php echo $i ?>][delete_object]" id="strain_Relatives_<?php echo $i ?>_delete_object" />
							delete
						</div>
					</div>
				</li>
				<?php $i++ ?>
				<?php endforeach; ?>
			</ul>
			<div class="clear"></div>
		</div>
		<?php endif ?>
		
		<div id="model_text_inputs">
			<?php echo $form['new_Relatives']->renderLabel() ?>
			<?php echo $form['new_Relatives']->renderHelp() ?>
			<?php echo $form['new_Relatives']->renderError() ?>
			<div class="model_text_input_name">
				<?php echo $form['new_Relatives'][0]['name']->render() ?>
			</div>
		</div>
		
		<div class="text_inputs_add_relation">
			<?php echo $form['new_Relatives']['_']->render() ?>
		</div>
		<br />
		
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
		
		<div id="viability_test">
			<?php echo $form['viability_test']->renderLabel() ?>
			<?php echo $form['viability_test']->renderError() ?>
			<?php echo $form['viability_test']->renderHelp() ?>
			<?php echo $form['viability_test'] ?>
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
		
		<div id="bp1_link">
			<?php echo $form['bp1_link']->renderLabel() ?>
			<?php echo $form['bp1_link']->renderError() ?>
			<?php echo $form['bp1_link']->renderHelp() ?>
			<?php echo $form['bp1_link'] ?>
		</div>
		
		<div id="bp4_link">
			<?php echo $form['bp4_link']->renderLabel() ?>
			<?php echo $form['bp4_link']->renderError() ?>
			<?php echo $form['bp4_link']->renderHelp() ?>
			<?php echo $form['bp4_link'] ?>
		</div>		
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Register this deposit">
			<input type="submit" name="_save_and_add" value="Register and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>