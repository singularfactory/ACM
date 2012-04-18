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