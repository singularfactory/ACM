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

<?php echo form_tag_for($form, '@isolation') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">

		<div id="isolation_subject">
			<?php echo $form['isolation_subject']->renderLabel() ?>
			<?php echo $form['isolation_subject']->renderError() ?>
			<?php echo $form['isolation_subject']->renderHelp() ?>
			<?php echo $form['isolation_subject'] ?>
			<?php if ( $form->getObject()->isNew() ): ?>
				<?php $route = '@isolation_filter_by_subject_new?subject=' ?>
			<?php else: ?>
				<?php $route = '@isolation_filter_by_subject_edit?id='.$form->getObject()->getId().'&subject=' ?>
			<?php endif; ?>
			<a href="<?php echo url_for($route) ?>" class="isolation_isolation_subject_url"></a>
		</div>

		<?php if ( isset($form['sample_id']) ): ?>
		<div id="sample_id">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew() || !$form->getObject()->getSample()->exists())?'Type a sample code...':$form->getObject()->getSample()->getCode(); ?>" id="isolation_sample_search" />
			<a href="<?php echo url_for('@isolation_find_samples?term=') ?>" class="isolation_sample_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if ( isset($form['strain_id']) ): ?>
		<div id="strain_id">
			<?php echo $form['strain_id']->renderLabel() ?>
			<?php echo $form['strain_id']->renderError() ?>
			<?php echo $form['strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a strain code...':$form->getObject()->getStrain()->getFullCode(); ?>" id="isolation_strain_search" />
			<a href="<?php echo url_for('@isolation_find_strains?term=') ?>" class="isolation_strain_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if ( isset($form['external_strain_id']) ): ?>
		<div id="external_strain_id">
			<?php echo $form['external_strain_id']->renderLabel() ?>
			<?php echo $form['external_strain_id']->renderError() ?>
			<?php echo $form['external_strain_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a research collection code...':$form->getObject()->getExternalStrain()->getFullCode(); ?>" id="isolation_external_strain_search" />
			<a href="<?php echo url_for('@isolation_find_external_strains?term=') ?>" class="isolation_external_strain_numbers_url"></a>
		</div>
		<?php endif ?>

		<?php if ( isset($form['external_code']) ): ?>
		<div id="external_code">
			<?php echo $form['external_code']->renderLabel() ?>
			<?php echo $form['external_code']->renderError() ?>
			<?php echo $form['external_code']->renderHelp() ?>
			<?php echo $form['external_code'] ?>
		</div>
		<?php endif ?>

		<div id="reception_date" class="date_field">
			<?php echo $form['reception_date']->renderLabel() ?>
			<?php echo $form['reception_date']->renderError() ?>
			<?php echo $form['reception_date']->renderHelp() ?>
			<?php echo $form['reception_date'] ?>
		</div>

		<?php if ( isset($form['location_id']) ): ?>
		<div id="location">
			<?php echo $form['location_id']->renderLabel() ?>
			<?php echo $form['location_id']->renderError() ?>
			<?php echo $form['location_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a location...':$form->getObject()->getLocation()->getName(); ?>" id="isolation_location_search" />
			<a href="<?php echo url_for('@isolation_find_locations?term=') ?>" class="isolation_location_coordinates_url"></a>
		</div>
		<?php endif ?>

		<?php if ( isset($form['environment_id']) ): ?>
		<div id="environment">
			<?php echo $form['environment_id']->renderLabel() ?>
			<?php echo $form['environment_id']->renderHelp() ?>
			<?php echo $form['environment_id'] ?>
		</div>
		<?php endif ?>

		<?php if ( isset($form['habitat_id']) ): ?>
		<div id="habitat">
			<?php echo $form['habitat_id']->renderLabel() ?>
			<?php echo $form['habitat_id']->renderHelp() ?>
			<?php echo $form['habitat_id'] ?>
		</div>
		<?php endif ?>

		<?php if ( isset($form['taxonomic_class_id']) ): ?>
		<div id="taxonomic_class">
			<?php echo $form['taxonomic_class_id']->renderLabel() ?>
			<?php echo $form['taxonomic_class_id']->renderError() ?>
			<?php echo $form['taxonomic_class_id']->renderHelp() ?>
			<?php echo $form['taxonomic_class_id'] ?>
		</div>
		<?php endif ?>

		<?php if ( isset($form['genus_id']) ): ?>
		<div id="genus">
			<?php echo $form['genus_id']->renderLabel() ?>
			<?php echo $form['genus_id']->renderError() ?>
			<?php echo $form['genus_id']->renderHelp() ?>
			<?php echo $form['genus_id'] ?>
		</div>
		<?php endif ?>

		<?php if ( isset($form['species_id']) ): ?>
		<div id="species">
			<?php echo $form['species_id']->renderLabel() ?>
			<?php echo $form['species_id']->renderError() ?>
			<?php echo $form['species_id']->renderHelp() ?>
			<?php echo $form['species_id'] ?>
		</div>
		<?php endif ?>

		<?php if ( isset($form['authority_id']) ): ?>
		<div id="authority">
			<?php echo $form['authority_id']->renderLabel() ?>
			<?php echo $form['authority_id']->renderError() ?>
			<?php echo $form['authority_id']->renderHelp() ?>
			<?php echo $form['authority_id'] ?>
		</div>
		<?php endif ?>

		<div id="culture_media_list" class="list_field">
			<?php echo $form['culture_media_list']->renderLabel() ?>
			<?php echo $form['culture_media_list']->renderError() ?>
			<?php echo $form['culture_media_list']->renderHelp() ?>
			<?php echo $form['culture_media_list'] ?>
		</div>

		<div id="isolators_list" class="list_field">
			<?php echo $form['isolators_list']->renderLabel() ?>
			<?php echo $form['isolators_list']->renderError() ?>
			<?php echo $form['isolators_list']->renderHelp() ?>
			<?php echo $form['isolators_list'] ?>
		</div>
		
		<div id="supervisor">
			<?php echo $form['supervisor_id']->renderLabel() ?>
			<?php echo $form['supervisor_id'] ?>
		</div>
	</div>

	<div id="right_side_form">
		<div id="delivery_date" class="date_field">
			<?php echo $form['delivery_date']->renderLabel() ?>
			<?php echo $form['delivery_date']->renderError() ?>
			<?php echo $form['delivery_date']->renderHelp() ?>
			<?php echo $form['delivery_date'] ?>
		</div>

		<div id="purification_method">
			<?php echo $form['purification_method_id']->renderLabel() ?>
			<?php echo $form['purification_method_id']->renderError() ?>
			<?php echo $form['purification_method_id']->renderHelp() ?>
			<?php echo $form['purification_method_id'] ?>
		</div>

		<div id="purification_details">
			<?php echo $form['purification_details']->renderLabel() ?>
			<?php echo $form['purification_details']->renderError() ?>
			<?php echo $form['purification_details']->renderHelp() ?>
			<?php echo $form['purification_details'] ?>
		</div>

		<div id="observation">
			<?php echo $form['observation']->renderLabel() ?>
			<?php echo $form['observation']->renderError() ?>
			<?php echo $form['observation']->renderHelp() ?>
			<?php echo $form['observation'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks']->renderError() ?>
			<?php echo $form['remarks']->renderHelp() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'isolation')) ?>
</form>
