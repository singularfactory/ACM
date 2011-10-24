<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span>Create labels</span>
<?php end_slot() ?>

<form action="<?php echo url_for('@label_create') ?>" method="post">
	<div id="left_side_form">
		<div id="label_product">
			<?php echo $form['product']->renderLabel() ?>
			<?php echo $form['product']->renderError() ?>
			<?php echo $form['product']->renderHelp() ?>
			<?php echo $form['product'] ?>
		</div>
		
		<div id="label_code">
			<?php echo $form['code']->renderLabel() ?>
			<?php echo $form['code']->renderError() ?>
			<?php echo $form['code']->renderHelp() ?>
			
			<input type="text" value="" id="label_code_search" />
			<a href="<?php echo url_for('@label_find_products?product=__PRODUCT__&term=') ?>" class="label_find_products_url"></a>
			
			<span class="input_alternative">or</span>
			
			<div id="label_all_products">
				<?php echo $form['all_products'] ?>
				<label for="all_products" class="labelinline_label">Create labels for every product</label>
			</div>
			 
		</div>
		
		<div id="label_supervisor">
			<?php echo $form['supervisor']->renderLabel() ?>
			<?php echo $form['supervisor']->renderError() ?>
			<?php echo $form['supervisor']->renderHelp() ?>
			<?php echo $form['supervisor'] ?>
		</div>
		
		<div id="label_transfer_interval">
			<?php echo $form['transfer_interval']->renderLabel() ?>
			<?php echo $form['transfer_interval']->renderError() ?>
			<?php echo $form['transfer_interval']->renderHelp() ?>
			<?php echo $form['transfer_interval'] ?>
		</div>
		
	</div>
	<div class="submit">
		<input type="submit" value="Create labels">
	</div>
</form>
		