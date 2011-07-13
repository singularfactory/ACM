<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@pcr') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="dna_polymerase">
			<?php echo $form['dna_polymerase_id']->renderLabel() ?>
			<?php echo $form['dna_polymerase_id']->renderError() ?>
			<?php echo $form['dna_polymerase_id']->renderHelp() ?>
			<?php echo $form['dna_polymerase_id'] ?>
		</div>
		
		<div id="forward_dna_primer">
			<?php echo $form['forward_dna_primer_id']->renderLabel() ?>
			<?php echo $form['forward_dna_primer_id']->renderError() ?>
			<?php echo $form['forward_dna_primer_id']->renderHelp() ?>
			<?php echo $form['forward_dna_primer_id'] ?>
		</div>
		
		<div id="reverse_dna_primer">
			<?php echo $form['reverse_dna_primer_id']->renderLabel() ?>
			<?php echo $form['reverse_dna_primer_id']->renderError() ?>
			<?php echo $form['reverse_dna_primer_id']->renderHelp() ?>
			<?php echo $form['reverse_dna_primer_id'] ?>
		</div>
		
		<div id="concentration">
			<?php echo $form['concentration']->renderLabel() ?>
			<?php echo $form['concentration']->renderError() ?>
			<?php echo $form['concentration']->renderHelp() ?>
			<?php echo $form['concentration'] ?>
		</div>
		
		<div id="ratio_260_280">
			<?php echo $form['260_280_ratio']->renderLabel() ?>
			<?php echo $form['260_280_ratio']->renderError() ?>
			<?php echo $form['260_280_ratio']->renderHelp() ?>
			<?php echo $form['260_280_ratio'] ?>
		</div>
		
		<div id="ratio_260_230">
			<?php echo $form['260_230_ratio']->renderLabel() ?>
			<?php echo $form['260_230_ratio']->renderError() ?>
			<?php echo $form['260_230_ratio']->renderHelp() ?>
			<?php echo $form['260_230_ratio'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="can_be_sequenced" class="checkbox">
			<?php echo $form['can_be_sequenced']->renderLabel() ?>
			<?php echo $form['can_be_sequenced'] ?>
			<?php echo $form['can_be_sequenced']->renderHelp() ?>
		</div>
		
		<div id="pcr_gel_handler">
			<?php if ( !$form->getObject()->isNew() && isset($form['Gel']) ): ?>
			<div class="model_text_input_list">
				<?php echo $form['Gel']->renderLabel('Actual gel results') ?>
				<?php $i = 0 ?>
				<ul>
					<?php foreach ($form['Gel'] as $widget): ?>
					<?php $gel = $widget->getValue() ?>
					<li>
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][is_valid]" value="<?php echo $gel['is_valid'] ?>" id="pcr_Gel_<?php echo $i ?>_is_valid" />
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][number]" value="<?php echo $gel['number'] ?>" id="pcr_Gel_<?php echo $i ?>_number" />
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][ratio]" value="<?php echo $gel['ratio'] ?>" id="pcr_Gel_<?php echo $i ?>_ratio" />
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][id]" value="<?php echo $gel['id'] ?>" id="pcr_Gel_<?php echo $i ?>_id" />
						<div class="model_text_input_value">
							<span><strong>#<?php echo $gel['number'] ?></strong>:&nbsp;</span>
							<span><?php echo $gel['ratio'] ?></span>
							<?php echo ($gel['is_valid'])?'<span class="gel_is_valid">&#x2713;':'' ?></span>
							<div class="model_text_input_value_checkbox">
								<input type="checkbox" name="pcr[Gel][<?php echo $i ?>][delete_object]" id="pcr_Gel_<?php echo $i ?>_delete_object" />
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
				<?php echo $form['new_Gel']->renderLabel() ?>
				<?php echo $form['new_Gel']->renderError() ?>

				<div class="model_text_input_gel">
					<div class="model_text_input_number">
						# <?php echo $form['new_Gel'][0]['number']->render() ?>
					</div>
					
					<div class="model_text_input_ratio">
						<?php echo $form['new_Gel'][0]['ratio']->renderLabel() ?>
						<?php echo $form['new_Gel'][0]['ratio']->render() ?>
					</div>

					<div class="model_text_input_is_valid">
						<?php echo $form['new_Gel'][0]['is_valid']->renderLabel() ?>
						<?php echo $form['new_Gel'][0]['is_valid']->render() ?>
					</div>
				</div>
			</div>

			<div class="text_inputs_add_relation">
				<?php echo $form['new_Gel']['_']->render() ?>
			</div>
		</div>
		
		<div id="pcr_reaction_handler">
			<?php if ( !$form->getObject()->isNew() && isset($form['Reaction']) ): ?>
			<div class="model_text_input_list">
				<?php echo $form['Reaction']->renderLabel('Actual reactions') ?>
				<?php $i = 0 ?>
				<ul>
					<?php foreach ($form['Reaction'] as $widget): ?>
					<?php $reaction = $widget->getValue() ?>
					<li>
						<input type="hidden" name="pcr[Reaction][<?php echo $i ?>][worked]" value="<?php echo $reaction['worked'] ?>" id="pcr_Reaction_<?php echo $i ?>_worked" />
						<input type="hidden" name="pcr[Reaction][<?php echo $i ?>][dna_primer_id]" value="<?php echo $reaction['dna_primer_id'] ?>" id="pcr_Reaction_<?php echo $i ?>_dna_primer_id" />
						<input type="hidden" name="pcr[Reaction][<?php echo $i ?>][id]" value="<?php echo $reaction['id'] ?>" id="pcr_Reaction_<?php echo $i ?>_id" />
						<div class="model_text_input_value">
							<span><strong>#<?php echo $i+1 ?></strong>:&nbsp;</span>
							<span>
								<?php
									$dnaPrimer = DnaPrimerTable::getInstance()->findOneById($reaction['dna_primer_id']);
									echo $dnaPrimer->getStrand(); ?>
							</span>
							<?php echo ($reaction['worked'])?'<span class="reaction_worked">&#x2713;':'' ?></span>
							<div class="model_text_input_value_checkbox">
								<input type="checkbox" name="pcr[Reaction][<?php echo $i ?>][delete_object]" id="pcr_Reaction_<?php echo $i ?>_delete_object" />
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
				<?php echo $form['new_Reaction']->renderLabel() ?>
				<?php echo $form['new_Reaction']->renderError() ?>

				<div class="model_text_input_reaction">
					<div class="model_text_input_dna_primer">
						<?php echo $form['new_Reaction'][0]['dna_primer_id']->renderLabel() ?>
						<?php echo $form['new_Reaction'][0]['dna_primer_id']->render() ?>
					</div>

					<div class="model_text_input_worked">
						<?php echo $form['new_Reaction'][0]['worked']->renderLabel() ?>
						<?php echo $form['new_Reaction'][0]['worked']->render() ?>
					</div>
				</div>
			</div>

			<div class="text_inputs_add_relation">
				<?php echo $form['new_Reaction']['_']->render() ?>
			</div>
		</div>
		
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this PCR">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
	
</form>
