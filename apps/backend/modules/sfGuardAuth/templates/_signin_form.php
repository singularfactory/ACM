<?php if ( $form->hasGlobalErrors() ): ?>
	<span id="errorMessage">
		Unknown error. Contact administrators
	</span>
<?php elseif ( $form->hasErrors() ): ?>
	<span id="errorMessage">
		Invalid username and/or password
	</span>
<?php endif; ?>
<form action="<?php echo url_for('@login') ?>" method="post">
	<div id="username" class="input">
		<?php echo $form['username']->renderLabel() ?>
		<?php echo $form['username']; ?>
	</div>
	<div id="password" class="input">
		<?php echo $form['password']->renderLabel() ?>
		<?php echo $form['password']; ?>
	</div>
	<div class="submit">
		<input type="submit" value="Sign in">
	</div>
	<?php echo $form->renderHiddenFields() ?>
</form>