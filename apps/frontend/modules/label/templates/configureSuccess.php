<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
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
