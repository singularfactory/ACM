<?php slot('main_header', 'Edit this purchase order') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@purchase_order') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="code">
			<?php echo $form['code']->renderLabel() ?>
			<?php echo $form['code']->renderError() ?>
			<?php echo $form['code']->renderHelp() ?>
			<?php echo $form['code'] ?>
		</div>
				
		<div id="status">
			<?php echo $form['status']->renderLabel() ?>
			<?php echo $form['status']->renderError() ?>
			<?php echo $form['status']->renderHelp() ?>
			<?php echo $form['status'] ?>
		</div>
		
		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>
	
	<div class="submit">
		<input type="submit" value="Save changes">
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
