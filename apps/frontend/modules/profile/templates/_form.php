<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@profile') ?>
	<?php echo $form->renderHiddenFields() ?>
	<?php echo $form->renderGlobalErrors() ?>
	
	<div id="first_name">
		<?php echo $form['first_name']->renderLabel() ?>
		<?php echo $form['first_name']->renderHelp() ?>
	    <?php echo $form['first_name']->renderError() ?>
	    <?php echo $form['first_name'] ?>
	</div>
	
	<div id="last_name">
		<?php echo $form['last_name']->renderLabel() ?>
		<?php echo $form['last_name']->renderHelp() ?>
	    <?php echo $form['last_name']->renderError() ?>
		<?php echo $form['last_name'] ?>
	</div>
	
	<div id="email_address">
		<?php echo $form['email_address']->renderLabel() ?>
		<?php echo $form['email_address']->renderHelp() ?>
		<?php echo $form['email_address']->renderError() ?>
		<?php echo $form['email_address'] ?>
	</div>
	
	<div id="username">
		<?php echo $form['username']->renderLabel() ?>
		<?php echo $form['username']->renderHelp() ?>
		<?php echo $form['username']->renderError() ?>
		<?php echo $form['username'] ?>
	</div>
	
	<div id="password">
		<?php echo $form['password']->renderLabel() ?>
		<?php echo $form['password']->renderHelp() ?>
		<?php echo $form['password']->renderError() ?>
		<?php echo $form['password'] ?>
	</div>
	
	<div id="password_again">
		<?php echo $form['password_again']->renderHelp() ?>
		<?php echo $form['password_again']->renderError() ?>
		<?php echo $form['password_again'] ?>
	</div>
	
	<div class="submit">
		<input type="submit" value="Save changes">
		or <?php echo link_to('cancel', '@homepage', array('class' => 'cancel_form_link')) ?>
	</div>
</form>