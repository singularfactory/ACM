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

<?php echo form_tag_for($form, '@cryopreservation') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="subject">
			<?php echo $form['subject']->renderLabel() ?>
			<?php echo $form['subject']->renderError() ?>
			<?php echo $form['subject']->renderHelp() ?>
			<?php echo $form['subject'] ?>
			<?php if ( $form->getObject()->isNew() ): ?>
				<?php $route = '@cryopreservation_filter_by_subject_new?subject=' ?>
			<?php else: ?>
				<?php $route = '@cryopreservation_filter_by_subject_edit?id='.$form->getObject()->getId().'&subject=' ?>
			<?php endif; ?>
			<a href="<?php echo url_for($route) ?>" class="cryopreservation_subject_url"></a>
		</div>

		<?php if ( isset($form['sample_id']) ): ?>
		<div id="sample_id">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew() || !$form->getObject()->getSample()->exists())?'Type a sample code...':$form->getObject()->getSample()->getCode(); ?>" id="cryopreservation_sample_search" />
			<a href="<?php echo url_for('@cryopreservation_find_samples?term=') ?>" class="cryopreservation_sample_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if ( isset($form['strain_id']) ): ?>
		<div id="strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a strain code...':$form->getObject()->getStrain()->getFullCode(); ?>" id="cryopreservation_strain_search" />
			<a href="<?php echo url_for('@cryopreservation_find_strains?term=') ?>" class="cryopreservation_strain_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if ( isset($form['external_strain_id']) ): ?>
		<div id="external_strain_id">
			<?php echo $form['external_strain_id']->renderLabel() ?>
			<?php echo $form['external_strain_id']->renderError() ?>
			<?php echo $form['external_strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a research collection code...':$form->getObject()->getExternalStrain()->getFullCode(); ?>" id="cryopreservation_external_strain_search" />
			<a href="<?php echo url_for('@cryopreservation_find_external_strains?term=') ?>" class="cryopreservation_external_strain_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if (isset($form['patent_deposit_id']) ): ?>
		<div id="patent_deposit_id">
			<?php echo $form['patent_deposit_id']->renderLabel() ?>
			<?php echo $form['patent_deposit_id']->renderError() ?>
			<?php echo $form['patent_deposit_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a patent deposit code...':$form->getObject()->getExternalStrain()->getFullCode(); ?>" id="cryopreservation_patent_deposit_search" />
			<a href="<?php echo url_for('@cryopreservation_find_patent_deposits?term=') ?>" class="cryopreservation_patent_deposit_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if (isset($form['maintenance_deposit_id']) ): ?>
		<div id="maintenance_deposit_id">
			<?php echo $form['maintenance_deposit_id']->renderLabel() ?>
			<?php echo $form['maintenance_deposit_id']->renderError() ?>
			<?php echo $form['maintenance_deposit_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a maintenance deposit code...':$form->getObject()->getExternalStrain()->getFullCode(); ?>" id="cryopreservation_maintenance_deposit_search" />
			<a href="<?php echo url_for('@cryopreservation_find_maintenance_deposits?term=') ?>" class="cryopreservation_maintenance_deposit_numbers_url"></a>
		</div>
		<?php endif ?>


		<div id="cryopreservation_method_id">
			<?php echo $form['cryopreservation_method_id']->renderLabel() ?>
			<?php echo $form['cryopreservation_method_id']->renderError() ?>
			<?php echo $form['cryopreservation_method_id']->renderHelp() ?>
			<?php echo $form['cryopreservation_method_id'] ?>
		</div>

		<div id="cryopreservation_date" class="date_field">
			<?php echo $form['cryopreservation_date']->renderLabel() ?>
			<?php echo $form['cryopreservation_date']->renderError() ?>
			<?php echo $form['cryopreservation_date']->renderHelp() ?>
			<?php echo $form['cryopreservation_date'] ?>
		</div>

		<div id="first_replicate">
			<?php echo $form['first_replicate']->renderLabel() ?>
			<?php echo $form['first_replicate']->renderError() ?>
			<?php echo $form['first_replicate']->renderHelp() ?>
			<?php echo $form['first_replicate'] ?>
		</div>

		<div id="second_replicate">
			<?php echo $form['second_replicate']->renderLabel() ?>
			<?php echo $form['second_replicate']->renderError() ?>
			<?php echo $form['second_replicate']->renderHelp() ?>
			<?php echo $form['second_replicate'] ?>
		</div>

		<div id="third_replicate">
			<?php echo $form['third_replicate']->renderLabel() ?>
			<?php echo $form['third_replicate']->renderError() ?>
			<?php echo $form['third_replicate']->renderHelp() ?>
			<?php echo $form['third_replicate'] ?>
		</div>
	</div>

	<div id="right_side_form">
		<div id="density">
			<?php echo $form['density']->renderLabel() ?>
			<?php echo $form['density']->renderError() ?>
			<?php echo $form['density']->renderHelp() ?>
			<?php echo $form['density'] ?>
		</div>

		<div id="revival_date" class="date_field">
			<?php echo $form['revival_date']->renderLabel() ?>
			<?php echo $form['revival_date']->renderError() ?>
			<?php echo $form['revival_date']->renderHelp() ?>
			<?php echo $form['revival_date'] ?>
		</div>

		<div id="viability">
			<?php echo $form['viability']->renderLabel() ?>
			<?php echo $form['viability']->renderError() ?>
			<?php echo $form['viability']->renderHelp() ?>
			<?php echo $form['viability'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'cryopreservation')) ?>
</form>
