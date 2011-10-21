<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@strain') ?>
	<?php echo $form->renderHiddenFields() ?>
	<?php echo tag('input', array('type' => 'hidden', 'value' => $form->getOption('max_strain_pictures'), 'id' => 'max_strain_pictures')) ?>
	<?php echo progress_key() ?>
	
	<div id="left_side_form">
		<div id="id">
			<?php echo $form['id']->renderLabel() ?>
			<?php echo $form['id']->renderError() ?>
			<?php echo $form['id']->renderHelp() ?>
			<?php echo $form['id'] ?>
		</div>
		
		<div id="sample_id">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			
			<?php $value = 'Type a sample code...' ?>
			<?php if ( isset($sampleCode) ): ?>
				<?php $value = $sampleCode ?>
			<?php endif ?>
			<?php if ( !$form->isNew() && !$form->getObject()->getSample() ): ?>
				<?php $value = $form->getObject()->getSample()->getCode() ?>
			<?php endif ?>
			
			<input type="text" value="<?php echo $value ?>" id="strain_sample_search" />
			<a href="<?php echo url_for('@strain_find_samples?term=') ?>" class="strain_sample_numbers_url"></a>
		</div>
		
		<div id="depositor">
			<?php echo $form['depositor_id']->renderLabel() ?>
			<?php echo $form['depositor_id']->renderError() ?>
			<?php echo $form['depositor_id']->renderHelp() ?>
			<?php echo $form['depositor_id'] ?>
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
			<?php echo $form['is_public']->renderHelp() ?>
		</div>
		
		
		<?php if ( isset($form['container_id']) ): ?>
		<div id="container">
			<?php echo $form['container_id']->renderLabel() ?>
			<?php echo $form['container_id']->renderHelp() ?>
			<?php echo $form['container_id'] ?>
		</div>
		<?php endif; ?>
		
		<!--
		<div id="amount">
			<?php //echo $form['amount']->renderLabel() ?>
			<?php //echo $form['amount']->renderError() ?>
			<?php //echo $form['amount']->renderHelp() ?>
			<?php //echo $form['amount'] ?>
		</div> 
		-->
		
		<div id="maintenance_status" class="list_field">
			<?php echo $form['maintenance_status_list']->renderLabel() ?>
			<?php echo $form['maintenance_status_list']->renderError() ?>
			<?php echo $form['maintenance_status_list']->renderHelp() ?>
			<?php echo $form['maintenance_status_list'] ?>
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
				
		<?php if ( isset($form['identifier_id']) ): ?>
		<div id="identifier">
			<?php echo $form['identifier_id']->renderLabel() ?>
			<?php echo $form['identifier_id'] ?>
		</div>
		<?php endif; ?>
		
		<div id="culture_media_list" class="list_field">
			<?php echo $form['culture_media_list']->renderLabel() ?>
			<?php echo $form['culture_media_list']->renderError() ?>
			<?php echo $form['culture_media_list']->renderHelp() ?>
			<?php echo $form['culture_media_list'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="axenic" class="checkbox">
			<?php echo $form['is_axenic']->renderLabel() ?>
			<?php echo $form['is_axenic'] ?>
		</div>
		
		<?php if ( !$form->getObject()->isNew() && isset($form['AxenityTests']) ): ?>
		<div class="model_text_input_list">
			<?php echo $form['AxenityTests']->renderLabel('Actual tests') ?>
			<?php $i = 0 ?>
			<ul>
				<?php foreach ($form['AxenityTests'] as $widget): ?>
				<?php $test = $widget->getValue() ?>
				<li>
					<input type="hidden" name="strain[AxenityTests][<?php echo $i ?>][date]" value="<?php echo $test['date'] ?>" id="strain_AxenityTests_<?php echo $i ?>_date" />
					<input type="hidden" name="strain[AxenityTests][<?php echo $i ?>][id]" value="<?php echo $test['id'] ?>" id="strain_AxenityTests_<?php echo $i ?>_id" />
					<div class="model_text_input_value">
						<span><?php echo $test['date'] ?></span>
						<div class="model_text_input_value_checkbox">
							<input type="checkbox" name="strain[AxenityTests][<?php echo $i ?>][delete_object]" id="strain_AxenityTests_<?php echo $i ?>_delete_object" />
							delete
						</div>
					</div>
				</li>
				<?php $i++ ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif ?>
		
		<div id="model_text_inputs" class="date_field">
			<?php echo $form['new_AxenityTests']->renderLabel() ?>
			<?php echo $form['new_AxenityTests']->renderHelp() ?>
			<?php echo $form['new_AxenityTests']->renderError() ?>
			<div class="model_text_input_date">
				<?php echo $form['new_AxenityTests'][0]['date']->render() ?>
			</div>
		</div>
		
		<div class="text_inputs_add_relation">
			<?php echo $form['new_AxenityTests']['_']->render() ?>
		</div>
		<br />
		
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
		
		<?php if ( !$form->getObject()->isNew() && $form->getOption('max_strain_pictures') < 5 ): ?>
		<div class="model_picture_list">
			<?php echo $form['Pictures']->renderLabel('Actual pictures') ?>
			<?php $i = 0 ?>
			<?php foreach ($form['Pictures'] as $widget): ?>
			<?php $picture = $widget->getValue() ?>
			<div class="thumbnail">
				<p class="thumbnail_caption">
					<input type="checkbox" name="strain[Pictures][<?php echo $i ?>][delete_object]" id="strain_Pictures_<?php echo $i ?>_delete_object" />
					<input type="hidden" name="strain[Pictures][<?php echo $i ?>][filename]" value="<?php echo $picture['filename'] ?>" id="strain_Pictures_<?php echo $i ?>_filename" />
					<input type="hidden" name="strain[Pictures][<?php echo $i ?>][id]" value="<?php echo $picture['id'] ?>" id="strain_Pictures_<?php echo $i ?>_id" />
					 delete
				</p>
				<div class="thumbnail_image">
					<a href="<?php echo get_picture_with_path($picture['filename'], 'strain') ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
						<img src="<?php echo get_thumbnail($picture['filename'], 'strain') ?>" alt="Picture <?php echo $i ?>" />
					</a>
				</div>
			</div>
			<?php $i++ ?>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
		<?php endif ?>

		<?php if ( $form->getOption('max_strain_pictures') > 0 ): ?>
		<div id="model_pictures">
			<?php echo $form['new_Pictures']->renderLabel() ?>
			<?php echo $form['new_Pictures']->renderHelp() ?>
			<div class="model_picture_filename">
				<?php echo $form['new_Pictures'][0]['filename']->render() ?>
			</div>
		</div>
		
		<?php if ( $form->getOption('max_strain_pictures') > 1 ): ?>
		<div class="pictures_add_relation" id="model_strain_picture">
			<?php echo $form['new_Pictures']['_']->render() ?>
		</div>
		<?php endif; ?>
		<?php endif; ?>
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
		
		<div id="web_notes">
			<?php echo $form['web_notes']->renderLabel() ?>
			<?php echo $form['web_notes']->renderError() ?>
			<?php echo $form['web_notes']->renderHelp() ?>
			<?php echo $form['web_notes'] ?>
		</div>
	</div>
	
	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'strain', 'progressBar' => true)) ?>

</form>
