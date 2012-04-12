<?php use_helper('Thumbnail') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span>New article</span>
<?php end_slot() ?>

<form action="<?php echo url_for('@article_configure') ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>

	<div id="article_strain_id">
		<?php echo $form['strain_id']->renderLabel() ?>
		<?php echo $form['strain_id']->renderError() ?>
		<?php echo $form['strain_id']->renderHelp() ?>
		<input type="text" value="Type a strain code..." id="article_strain_search" />
		<a href="<?php echo url_for('@article_find_strains?term=') ?>" class="article_strain_numbers_url"></a>
	</div>

	<div class="submit">
		<input type="submit" value="Configure article" />
	</div>
</form>