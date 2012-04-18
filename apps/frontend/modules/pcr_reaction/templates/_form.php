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

<?php echo form_tag_for($form, '@pcr_reaction') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="dna_primer_id">
			<?php echo $form['dna_primer_id']->renderLabel() ?>
			<?php echo $form['dna_primer_id']->renderError() ?>
			<?php echo $form['dna_primer_id']->renderHelp() ?>
			<?php echo $form['dna_primer_id'] ?>
		</div>

		<div id="worked" class="checkbox">
			<?php echo $form['worked']->renderLabel() ?>
			<?php echo $form['worked'] ?>
			<?php echo $form['worked']->renderHelp() ?>
		</div>
	</div>

	<div id="right_side_form">
	</div>

	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this reaction">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>