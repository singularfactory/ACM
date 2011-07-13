<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@pcr_reaction') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="dna_primer_id">
			<?php echo $form['dna_primer_id']->renderLabel() ?>
			<?php echo $form['dna_primer_id']->renderError() ?>
			<?php echo $form['dna_primer_id']->renderHelp() ?>
			<?php echo $form['dna_primer_id'] ?>
		</div>
		
		<div id="worked" class="checkbox">
			<?php echo $form['worked']->renderLabel() ?>
			<?php echo $form['worked'] ?>
			<?php echo $form['worked']->renderHelp() ?>
		</div>
	</div>
	
	<div id="right_side_form">
	</div>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this reaction">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>