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

<?php echo form_tag_for($form, '@external_strain') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div class="form-section">
			<h3>General information</h3>
			<div id="sample_id">
				<?php echo $form['sample_id']->renderLabel() ?>
				<?php echo $form['sample_id']->renderError() ?>
				<?php echo $form['sample_id']->renderHelp() ?>

				<?php $value = 'Type a sample code...' ?>
				<?php if ( isset($sampleCode) ): ?>
					<?php $value = $sampleCode ?>
				<?php endif ?>
				<?php if ( !$form->isNew() && !$form->getObject()->getSample() ): ?>
					<?php $value = $form->getObject()->getSample()->getCode() ?>
				<?php endif ?>

				<input type="text" value="<?php echo $value ?>" id="external_strain_sample_search" />
				<a href="<?php echo url_for('@external_strain_find_samples?term=') ?>" class="external_strain_sample_numbers_url"></a>
			</div>
			<div id="axenic" class="checkbox">
				<?php echo $form['is_axenic']->renderLabel() ?>
				<?php echo $form['is_axenic'] ?>
			</div>
		</div>

		<div class="form-section">
			<h3>Taxonomy</h3>
			<div id="kingdom">
				<?php echo $form['kingdom_id']->renderLabel() ?>
				<?php echo $form['kingdom_id']->renderError() ?>
				<?php echo $form['kingdom_id']->renderHelp() ?>
				<?php echo $form['kingdom_id'] ?>
			</div>
			<div id="subkingdom">
				<?php echo $form['subkingdom_id']->renderLabel() ?>
				<?php echo $form['subkingdom_id']->renderError() ?>
				<?php echo $form['subkingdom_id']->renderHelp() ?>
				<?php echo $form['subkingdom_id'] ?>
			</div>
			<div id="phylum">
				<?php echo $form['phylum_id']->renderLabel() ?>
				<?php echo $form['phylum_id']->renderError() ?>
				<?php echo $form['phylum_id']->renderHelp() ?>
				<?php echo $form['phylum_id'] ?>
			</div>
			<div id="taxonomic_class">
				<?php echo $form['taxonomic_class_id']->renderLabel() ?>
				<?php echo $form['taxonomic_class_id']->renderError() ?>
				<?php echo $form['taxonomic_class_id']->renderHelp() ?>
				<?php echo $form['taxonomic_class_id'] ?>
			</div>
			<div id="taxonomic_order">
				<?php echo $form['taxonomic_order_id']->renderLabel() ?>
				<?php echo $form['taxonomic_order_id']->renderError() ?>
				<?php echo $form['taxonomic_order_id']->renderHelp() ?>
				<?php echo $form['taxonomic_order_id'] ?>
			</div>
			<div id="family">
				<?php echo $form['family_id']->renderLabel() ?>
				<?php echo $form['family_id']->renderError() ?>
				<?php echo $form['family_id']->renderHelp() ?>
				<?php echo $form['family_id'] ?>
			</div>
			<div id="genus">
				<?php echo $form['genus_id']->renderLabel() ?>
				<?php echo $form['genus_id']->renderError() ?>
				<?php echo $form['genus_id']->renderHelp() ?>
				<?php echo $form['genus_id'] ?>
			</div>
			<div id="species">
				<?php echo $form['species_id']->renderLabel() ?>
				<?php echo $form['species_id']->renderError() ?>
				<?php echo $form['species_id']->renderHelp() ?>
				<?php echo $form['species_id'] ?>
			</div>
			<div id="authority">
				<?php echo $form['authority_id']->renderLabel() ?>
				<?php echo $form['authority_id']->renderError() ?>
				<?php echo $form['authority_id']->renderHelp() ?>
				<?php echo $form['authority_id'] ?>
			</div>
			<div id="epitype" class="checkbox">
				<?php echo $form['is_epitype']->renderLabel() ?>
				<?php echo $form['is_epitype'] ?>
			</div>
		</div>

		<div class="form-section">
			<h3>Isolation and deposit</h3>
			<div id="isolators" class="list_field">
				<?php echo $form['isolators_list']->renderLabel() ?>
				<?php echo $form['isolators_list']->renderError() ?>
				<?php echo $form['isolators_list']->renderHelp() ?>
				<?php echo $form['isolators_list'] ?>
			</div>
			<div id="isolation_date" class="date_field">
				<?php echo $form['isolation_date']->renderLabel() ?>
				<?php echo $form['isolation_date']->renderError() ?>
				<?php echo $form['isolation_date']->renderHelp() ?>
				<?php echo $form['isolation_date'] ?>
			</div>
			<div id="identifier">
				<?php echo $form['identifier_id']->renderLabel() ?>
				<?php echo $form['identifier_id'] ?>
			</div>
			<div id="depositor">
				<?php echo $form['depositor_id']->renderLabel() ?>
				<?php echo $form['depositor_id']->renderError() ?>
				<?php echo $form['depositor_id']->renderHelp() ?>
				<?php echo $form['depositor_id'] ?>
			</div>
			<div id="remarks">
				<?php echo $form['remarks']->renderLabel() ?>
				<?php echo $form['remarks'] ?>
			</div>
		</div>
	</div>

	<div id="right_side_form">
		<div class="form-section">
			<h3>Maintenance</h3>
			<div id="maintenance_status">
				<?php echo $form['maintenance_status_list']->renderLabel() ?>
				<?php echo $form['maintenance_status_list'] ?>
			</div>
			<div id="culture_media_list" class="list_field">
				<?php echo $form['culture_media_list']->renderLabel() ?>
				<?php echo $form['culture_media_list']->renderError() ?>
				<?php echo $form['culture_media_list']->renderHelp() ?>
				<?php echo $form['culture_media_list'] ?>
			</div>
			<?php if ( isset($form['container_id']) ): ?>
			<div id="container">
				<?php echo $form['container_id']->renderLabel() ?>
				<?php echo $form['container_id']->renderHelp() ?>
				<?php echo $form['container_id'] ?>
			</div>
			<div id="containers_list" class="list_field">
				<?php echo $form['containers_list']->renderLabel() ?>
				<?php echo $form['containers_list']->renderError() ?>
				<?php echo $form['containers_list']->renderHelp() ?>
				<?php echo $form['containers_list'] ?>
			</div>
			<?php endif; ?>
			<div id="transfer_interval">
				<?php echo $form['transfer_interval']->renderLabel() ?>
				<?php echo $form['transfer_interval'] ?>
			</div>
			<div id="supervisor">
				<?php echo $form['supervisor_id']->renderLabel() ?>
				<?php echo $form['supervisor_id'] ?>
			</div>
			<div id="temperature" class="strain_culture_conditions">
				<?php echo $form['temperature']->renderLabel() ?>
				<?php echo $form['temperature']->renderError() ?>
				<?php echo $form['temperature']->renderHelp() ?>
				<?php echo $form['temperature'] ?>
			</div>
			<div id="photoperiod" class="strain_culture_conditions">
				<?php echo $form['photoperiod']->renderLabel() ?>
				<?php echo $form['photoperiod']->renderError() ?>
				<?php echo $form['photoperiod']->renderHelp() ?>
				<?php echo $form['photoperiod'] ?>
			</div>
			<div id="irradiation" class="strain_culture_conditions">
				<?php echo $form['irradiation']->renderLabel() ?>
				<?php echo $form['irradiation']->renderError() ?>
				<?php echo $form['irradiation']->renderHelp() ?>
				<?php echo $form['irradiation'] ?>
			</div>
			<div id="observation">
				<?php echo $form['observation']->renderLabel() ?>
				<?php echo $form['observation']->renderError() ?>
				<?php echo $form['observation']->renderHelp() ?>
				<?php echo $form['observation'] ?>
			</div>
		</div>

		<div class="form-section">
			<h3>Other information</h3>
			<div id="citations">
				<?php echo $form['citations']->renderLabel() ?>
				<?php echo $form['citations']->renderError() ?>
				<?php echo $form['citations']->renderHelp() ?>
				<?php echo $form['citations'] ?>
			</div>
			<?php if ( !$form->getObject()->isNew() && isset($form['Relatives']) ): ?>
			<div class="model_text_input_list">
				<?php echo $form['Relatives']->renderLabel('Actual relatives') ?>
				<?php $i = 0 ?>
				<ul>
					<?php foreach ($form['Relatives'] as $widget): ?>
					<?php $relative = $widget->getValue() ?>
					<li>
						<input type="hidden" name="external_strain[Relatives][<?php echo $i ?>][name]" value="<?php echo $relative['name'] ?>" id="external_strain_Relatives_<?php echo $i ?>_name" />
						<input type="hidden" name="external_strain[Relatives][<?php echo $i ?>][id]" value="<?php echo $relative['id'] ?>" id="external_strain_Relatives_<?php echo $i ?>_id" />
						<div class="model_text_input_value">
							<span><?php echo $relative['name'] ?></span>
							<div class="model_text_input_value_checkbox">
								<input type="checkbox" name="external_strain[Relatives][<?php echo $i ?>][delete_object]" id="external_strain_Relatives_<?php echo $i ?>_delete_object" />
								delete
							</div>
						</div>
					</li>
					<?php $i++ ?>
					<?php endforeach; ?>
				</ul>
				<div class="clear"></div>
			</div>
			<?php endif ?>
			<div id="model_text_inputs">
				<?php echo $form['new_Relatives']->renderLabel() ?>
				<?php echo $form['new_Relatives']->renderHelp() ?>
				<?php echo $form['new_Relatives']->renderError() ?>
				<div class="model_text_input_name">
					<?php echo $form['new_Relatives'][0]['name']->render() ?>
				</div>
			</div>
			<div class="text_inputs_add_relation">
				<?php echo $form['new_Relatives']['_']->render() ?>
			</div>
		</div>
	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'external_strain', 'title' => 'strain')) ?>
</form>
