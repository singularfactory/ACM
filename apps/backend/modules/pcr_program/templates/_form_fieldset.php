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
 * @package       ACM.Backend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<fieldset id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
  <?php if ('NONE' != $fieldset): ?>
    <h2><?php echo __($fieldset, array(), 'messages') ?></h2>
  <?php endif; ?>

  <?php foreach ($fields as $name => $field): ?>
    <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>

		<?php if ( $name === 'new_Steps' || $name === 'Steps' ): ?>
			<?php $class = 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name ?>

			<?php if ( $name === 'new_Steps' ): ?>
			<div id="pcr_program_steps_handler" class="<?php echo $class ?>">
				<?php echo $form['new_Steps']->renderLabel() ?>

				<div class="model_text_input_steps">
					<div class="model_text_input_segment">
						<?php echo $form['new_Steps'][0]['segment']->renderLabel() ?>
						<?php echo $form['new_Steps'][0]['segment']->renderHelp() ?>
						<?php echo $form['new_Steps'][0]['segment']->renderError() ?>
						<?php echo $form['new_Steps'][0]['segment']->render() ?>
					</div>

					<div class="model_text_input_temperature">
						<?php echo $form['new_Steps'][0]['temperature']->renderLabel() ?>
						<?php echo $form['new_Steps'][0]['temperature']->renderHelp() ?>
						<?php echo $form['new_Steps'][0]['temperature']->renderError() ?>
						<?php echo $form['new_Steps'][0]['temperature']->render() ?>
					</div>

					<div class="model_text_input_duration">
						<?php echo $form['new_Steps'][0]['duration']->renderLabel() ?>
						<?php echo $form['new_Steps'][0]['duration']->renderHelp() ?>
						<?php echo $form['new_Steps'][0]['duration']->render() ?>
						<?php echo $form['new_Steps'][0]['duration']->renderError() ?>
					</div>
				</div>
			</div>

			<div class="text_inputs_add_relation">
				<?php echo $form['new_Steps']['_']->render() ?>
			</div>
			<?php endif; ?>

			<?php if ( $name === 'Steps' ): ?>
			<?php $label = $field->getConfig('label') ?>
			<?php $attributes = $field->getConfig('attributes', array()) ?>
			<?php $help = $field->getConfig('help') ?>
			<div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
				<div>
					<label for="pcr_program_Steps">Actual steps</label><?php //echo $form[$name]->renderLabel($label) ?>
					<div class="content">
						<?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
					</div>
				</div>
			</div>
			<?php endif; ?>

		<?php else: ?>
	    <?php include_partial('pcr_program/form_field', array(
	      'name'       => $name,
	      'attributes' => $field->getConfig('attributes', array()),
	      'label'      => $field->getConfig('label'),
	      'help'       => $field->getConfig('help'),
	      'form'       => $form,
	      'field'      => $field,
	      'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
	    )) ?>
		<?php endif; ?>
  <?php endforeach; ?>
</fieldset>
