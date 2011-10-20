<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@culture_medium') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="name">
			<?php echo $form['name']->renderLabel() ?>
			<?php echo $form['name']->renderError() ?>
			<?php echo $form['name']->renderHelp() ?>
			<?php echo $form['name'] ?>
		</div>

		<div id="description">
			<?php echo $form['description']->renderLabel() ?>
			<?php echo $form['description']->renderError() ?>
			<?php echo $form['description']->renderHelp() ?>
			<?php echo $form['description'] ?>
		</div>
		
		<div id="link">
			<?php echo $form['link']->renderLabel() ?>
			<?php echo $form['link']->renderError() ?>
			<?php echo $form['link']->renderHelp() ?>
			<?php echo $form['link'] ?>
		</div>
		
		<!--
		<div id="amount">
			<?php //echo $form['amount']->renderLabel() ?>
			<?php //echo $form['amount']->renderError() ?>
			<?php //echo $form['amount']->renderHelp() ?>
			<?php //echo $form['amount'] ?>
		</div>
		-->
		
		<div id="public" class="checkbox">
			<?php echo $form['is_public']->renderLabel() ?>
			<?php echo $form['is_public'] ?>
			<?php echo $form['is_public']->renderHelp() ?>
		</div>
	</div>

	<div id="right_side_form">
	</div>
	
	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'culture_medium', 'title' => 'medium')) ?>
</form>