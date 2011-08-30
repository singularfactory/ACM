<?php slot('main_header', 'Edit this purchase item') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@purchase_item') ?>
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
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
	
	<div id="right_side_help">
		<strong>Order status</strong>
		<p><strong>Pending</strong> means that no action has been taken in order to process this item.</p>
		<p><strong>Processing</strong> means that this item it's being processed.</p>
		<p><strong>Ready</strong> means that this item has been processed.</p>
	</div>
	
	<div class="submit">
		<input type="submit" value="Save changes">
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
