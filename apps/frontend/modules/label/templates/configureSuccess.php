<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span>Create labels</span>
<?php end_slot() ?>

<form action="<?php echo url_for('@label_create') ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>
	
	<div id="left_side_form">
		<div id="label_product_type">
			<?php echo $form['product_type']->renderLabel() ?>
			<?php echo $form['product_type']->renderError() ?>
			<?php echo $form['product_type']->renderHelp() ?>
			<?php echo $form['product_type'] ?>
		</div>
		
		<div id="label_product_id">
			<?php echo $form['product_id']->renderLabel() ?>
			<?php echo $form['product_id']->renderHelp() ?>
			<input type="text" value="<?php echo $productCode ?>" id="label_product_id_search" name="product_id_search" />
			<a href="<?php echo url_for('@label_find_products?product=__PRODUCT__&term=') ?>" class="label_find_products_url"></a>
			
			<span class="input_alternative">or</span>
			
			<div id="label_all_products">
				<?php echo $form['all_products'] ?>
				<label for="all_products" class="inline_label">Create labels for every product</label>
			</div>
			
			<?php echo $form['product_id']->renderError() ?> 
		</div>
		
		<div id="label_supervisor">
			<?php echo $form['supervisor']->renderLabel() ?>
			<?php echo $form['supervisor']->renderError() ?>
			<?php echo $form['supervisor']->renderHelp() ?>
			<?php echo $form['supervisor'] ?>
		</div>
		
		<div id="label_product_form">
			<?php if ( $productType === 'strain' ): ?>
			<?php include_partial('strain_form', array('form' => $form)) ?>
			<?php endif ?>
		</div>
		
	</div>
	<div class="submit">
		<input type="submit" value="Create labels">
	</div>
</form>
		