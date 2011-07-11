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
