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
			<?php if ( in_array($subject, array('maintenance')) ): ?>
			<?php include_partial("{$subject}_form", array('form' => $form)) ?>
			<?php endif ?>
		</div>
	</div>

	<div class="submit">
		<input type="submit" value="Generate report"> or <a href="#" id="report_clear_values_link" class="cancel_form_link">clear values</a>
	</div>
</form>
