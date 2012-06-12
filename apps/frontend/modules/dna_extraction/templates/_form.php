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

<?php echo form_tag_for($form, '@dna_extraction') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a strain code...':$form->getObject()->getStrain()->getFullCode(); ?>" id="dna_extraction_strain_search" />
			<a href="<?php echo url_for('@dna_extraction_find_strains?term=') ?>" class="dna_extraction_strain_numbers_url"></a>
		</div>

		<div id="arrival_date" class="date_field">
			<?php echo $form['arrival_date']->renderLabel() ?>
			<?php echo $form['arrival_date']->renderError() ?>
			<?php echo $form['arrival_date']->renderHelp() ?>
			<?php echo $form['arrival_date'] ?>
		</div>

		<div id="extraction_date" class="date_field">
			<?php echo $form['extraction_date']->renderLabel() ?>
			<?php echo $form['extraction_date']->renderError() ?>
			<?php echo $form['extraction_date']->renderHelp() ?>
			<?php echo $form['extraction_date'] ?>
		</div>

		<div id="extraction_kit">
			<?php echo $form['extraction_kit_id']->renderLabel() ?>
			<?php echo $form['extraction_kit_id'] ?>
		</div>

		<div id="concentration">
			<?php echo $form['concentration']->renderLabel() ?>
			<?php echo $form['concentration']->renderError() ?>
			<?php echo $form['concentration']->renderHelp() ?>
			<?php echo $form['concentration'] ?>
		</div>

		<div id="ratio_260_280">
			<?php echo $form['260_280_ratio']->renderLabel() ?>
			<?php echo $form['260_280_ratio']->renderError() ?>
			<?php echo $form['260_280_ratio']->renderHelp() ?>
			<?php echo $form['260_280_ratio'] ?>
		</div>

		<div id="ratio_260_230">
			<?php echo $form['260_230_ratio']->renderLabel() ?>
			<?php echo $form['260_230_ratio']->renderError() ?>
			<?php echo $form['260_230_ratio']->renderHelp() ?>
			<?php echo $form['260_230_ratio'] ?>
		</div>
	</div>

	<div id="right_side_form">
		<?php if ($aliquotsAreEditable): ?>
		<div id="aliquots">
			<?php echo $form['aliquots']->renderLabel() ?>
			<?php echo $form['aliquots']->renderError() ?>
			<?php echo $form['aliquots']->renderHelp() ?>
			<?php echo $form['aliquots'] ?>
		</div>
		<?php endif; ?>

		<?php if ($form->getObject()->canBePublished()): ?>
		<div id="public" class="checkbox">
			<?php echo $form['is_public']->renderLabel() ?>
			<?php echo $form['is_public'] ?>
			<?php echo $form['is_public']->renderHelp() ?>
		</div>
		<?php endif ?>

		<div id="genbank_link">
			<?php echo $form['genbank_link']->renderLabel() ?>
			<?php echo $form['genbank_link']->renderError() ?>
			<?php echo $form['genbank_link']->renderHelp() ?>
			<?php echo $form['genbank_link'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>

	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this extraction">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
