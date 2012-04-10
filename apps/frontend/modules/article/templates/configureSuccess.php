<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span>Create article</span>
<?php end_slot() ?>

<form action="<?php echo url_for('@article_create') ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="article_strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="Type a strain code..." id="article_strain_search" />
			<a href="<?php echo url_for('@article_find_strains?term=') ?>" class="article_strain_numbers_url"></a>
		</div>
		
		<div id="article_content">
			<?php echo $form['content']->renderLabel() ?>
			<?php echo $form['content']->renderError() ?>
			<?php echo $form['content']->renderHelp() ?>
			<?php echo $form['content'] ?>
		</div>		
	</div>
	<div class="submit">
		<input type="submit" value="Download article">
	</div>
</form>
