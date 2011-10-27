<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span>Configure report</span>
<?php end_slot() ?>

<form action="<?php echo url_for('@report_generate') ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="report_subject">
			<?php echo $form['subject']->renderLabel() ?>
			<?php echo $form['subject']->renderError() ?>
			<?php echo $form['subject']->renderHelp() ?>
			<?php echo $form['subject'] ?>
		</div>
		
		<div id="report_subject_form">
			<?php if ( in_array($subject, array('location', 'sample', 'strain', 'dna_extraction')) ): ?>
			<?php include_partial("{$subject}_form", array('form' => $form)) ?>
			<?php endif ?>
		</div>
	</div>
	
	<div class="submit">
		<input type="submit" value="Generate report">
	</div>
</form>
