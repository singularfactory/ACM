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
	
	<div id="right_side_help">
		<strong>Order status</strong>
		<p><strong>Pending</strong> means that the purchase order has been received but no action has been taken in order to process it.</p>
		<p><strong>Processing</strong> means that the purchase order it's being processed and optionally one or more of the purchase items are being processed as well.</p>
		<p><strong>Ready</strong> means that every item has been processed and the purchase order is ready to be delivered, but has not been sent yet.</p>
		<p><strong>Sent</strong> means that the purchase order has been sent to the customer.</p>	
	</div>	
	
	<div class="submit">
		<input type="submit" value="Save changes">
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
