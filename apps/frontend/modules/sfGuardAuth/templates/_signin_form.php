<form action="<?php echo url_for('@login') ?>" method="post">
	<div id="username">
		<?php echo $form['username']->renderLabel() ?>
		<?php echo $form['username']; ?>
	</div>
	<div id="password">
		<?php echo $form['password']->renderLabel() ?>
		<?php echo $form['password']; ?>
	</div>
	<div id="submit">
		<input type="submit" value="Sign in">
	</div>
	<?php echo $form->renderHiddenFields() ?>
</form>