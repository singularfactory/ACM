<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@dna_sequence') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="gen">
			<?php echo $form['gen']->renderLabel() ?>
			<?php echo $form['gen']->renderError() ?>
			<?php echo $form['gen']->renderHelp() ?>
			<?php echo $form['gen'] ?>
		</div>
		
		<div id="date" class="date_field">
			<?php echo $form['date']->renderLabel() ?>
			<?php echo $form['date'] ?>
			<?php echo $form['date']->renderHelp() ?>
		</div>
		
		<div id="worked" class="checkbox">
			<?php echo $form['worked']->renderLabel() ?>
			<?php echo $form['worked'] ?>
			<?php echo $form['worked']->renderHelp() ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<div id="pcr_reaction_handler">
			<?php if ( !$form->getObject()->isNew() && isset($form['Reaction']) ): ?>
			<div class="model_text_input_list">
				<?php echo $form['Reaction']->renderLabel('PCR reactions') ?>
				<?php $i = 0 ?>
				<ul>
					<?php foreach ($form['Reaction'] as $widget): ?>
					<?php $reaction = $widget->getValue() ?>
					<li>
						<input type="hidden" name="dna_sequence[Reaction][<?php echo $i ?>][worked]" value="<?php echo $reaction['worked'] ?>" id="dna_sequence_Reaction_<?php echo $i ?>_worked" />
						<input type="hidden" name="dna_sequence[Reaction][<?php echo $i ?>][dna_primer_id]" value="<?php echo $reaction['dna_primer_id'] ?>" id="dna_sequence_Reaction_<?php echo $i ?>_dna_primer_id" />
						<input type="hidden" name="dna_sequence[Reaction][<?php echo $i ?>][id]" value="<?php echo $reaction['id'] ?>" id="dna_sequence_Reaction_<?php echo $i ?>_id" />
						<div class="model_text_input_value">
							<span><strong>#<?php echo $i+1 ?></strong>:&nbsp;</span>
							<span>
								<?php
									$dnaPrimer = DnaPrimerTable::getInstance()->findOneById($reaction['dna_primer_id']);
									echo $dnaPrimer->getName(); ?>
							</span>
							<?php echo ($reaction['worked'])?'<span class="reaction_worked">&#x2713;':'' ?></span>
							<div class="model_text_input_value_checkbox">
								<input type="checkbox" name="dna_sequence[Reaction][<?php echo $i ?>][delete_object]" id="dna_sequence_Reaction_<?php echo $i ?>_delete_object" />
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
			<input type="submit" value="Register this sequence">
			<input type="submit" name="_save_and_add" value="Send and register another">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
	
</form>
