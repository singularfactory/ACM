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

<?php echo form_tag_for($form, '@patent_deposit') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="depositor_code">
			<?php echo $form['depositor_code']->renderLabel() ?>
			<?php echo $form['depositor_code']->renderError() ?>
			<?php echo $form['depositor_code']->renderHelp() ?>
			<?php echo $form['depositor_code'] ?>
		</div>

		<div id="depositor">
			<?php echo $form['depositor_id']->renderLabel() ?>
			<?php echo $form['depositor_id'] ?>
		</div>

		<div id="deposition_date" class="date_field">
			<?php echo $form['deposition_date']->renderLabel() ?>
			<?php echo $form['deposition_date']->renderError() ?>
			<?php echo $form['deposition_date']->renderHelp() ?>
			<?php echo $form['deposition_date'] ?>
		</div>

		<div id="location">
			<?php echo $form['location_id']->renderLabel() ?>
			<?php echo $form['location_id']->renderError() ?>
			<?php echo $form['location_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew())?'Type a location...':$form->getObject()->getLocation()->getName(); ?>" id="patent_deposit_location_search" />
			<a href="<?php echo url_for('@patent_deposit_find_locations?term=') ?>" class="patent_deposit_location_coordinates_url"></a>
		</div>

		<div id="environment">
			<?php echo $form['environment_id']->renderLabel() ?>
			<?php echo $form['environment_id']->renderHelp() ?>
			<?php echo $form['environment_id'] ?>
		</div>

		<div id="habitat">
			<?php echo $form['habitat_id']->renderLabel() ?>
			<?php echo $form['habitat_id']->renderHelp() ?>
			<?php echo $form['habitat_id'] ?>
		</div>

		<div id="taxonomic_class">
			<?php echo $form['taxonomic_class_id']->renderLabel() ?>
			<?php echo $form['taxonomic_class_id']->renderError() ?>
			<?php echo $form['taxonomic_class_id']->renderHelp() ?>
			<?php echo $form['taxonomic_class_id'] ?>
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

		<div id="collectors" class="list_field">
			<?php echo $form['collectors_list']->renderLabel() ?>
			<?php echo $form['collectors_list']->renderError() ?>
			<?php echo $form['collectors_list']->renderHelp() ?>
			<?php echo $form['collectors_list'] ?>
		</div>

		<div id="collection_date" class="date_field">
			<?php echo $form['collection_date']->renderLabel() ?>
			<?php echo $form['collection_date']->renderError() ?>
			<?php echo $form['collection_date']->renderHelp() ?>
			<?php echo $form['collection_date'] ?>
		</div>

		<div id="epitype" class="checkbox">
			<?php echo $form['is_epitype']->renderLabel() ?>
			<?php echo $form['is_epitype'] ?>
		</div>

		<div id="axenic" class="checkbox">
			<?php echo $form['is_axenic']->renderLabel() ?>
			<?php echo $form['is_axenic'] ?>
		</div>

		<div id="culture_media_list" class="list_field">
			<?php echo $form['culture_media_list']->renderLabel() ?>
			<?php echo $form['culture_media_list']->renderError() ?>
			<?php echo $form['culture_media_list']->renderHelp() ?>
			<?php echo $form['culture_media_list'] ?>
		</div>

		<div id="maintenance_status">
			<?php echo $form['maintenance_status_list']->renderLabel() ?>
			<?php echo $form['maintenance_status_list'] ?>
		</div>

		<div id="cryopreservation_method">
			<?php echo $form['cryopreservation_method_id']->renderLabel() ?>
			<?php echo $form['cryopreservation_method_id']->renderError() ?>
			<?php echo $form['cryopreservation_method_id']->renderHelp() ?>
			<?php echo $form['cryopreservation_method_id'] ?>
		</div>

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
	</div>

	<div id="right_side_form">
		<div id="dna_availability" class="checkbox">
			<?php echo $form['has_dna']->renderLabel() ?>
			<?php echo $form['has_dna'] ?>
			<?php echo $form['has_dna']->renderHelp() ?>
		</div>

		<div id="identifier">
			<?php echo $form['identifier_id']->renderLabel() ?>
			<?php echo $form['identifier_id'] ?>
		</div>

		<div id="supervisor">
			<?php echo $form['supervisor_id']->renderLabel() ?>
			<?php echo $form['supervisor_id'] ?>
		</div>

		<div id="gen_sequence">
			<?php echo $form['gen_sequence']->renderLabel() ?>
			<?php echo $form['gen_sequence']->renderError() ?>
			<?php echo $form['gen_sequence']->renderHelp() ?>
			<?php echo $form['gen_sequence'] ?>
		</div>

		<?php if ( !$form->getObject()->isNew() && isset($form['Relatives']) ): ?>
		<div class="model_text_input_list">
			<?php echo $form['Relatives']->renderLabel('Actual relatives') ?>
			<?php $i = 0 ?>
			<ul>
				<?php foreach ($form['Relatives'] as $widget): ?>
				<?php $relative = $widget->getValue() ?>
				<li>
					<input type="hidden" name="patent_deposit[Relatives][<?php echo $i ?>][name]" value="<?php echo $relative['name'] ?>" id="patent_deposit_Relatives_<?php echo $i ?>_name" />
					<input type="hidden" name="patent_deposit[Relatives][<?php echo $i ?>][id]" value="<?php echo $relative['id'] ?>" id="patent_deposit_Relatives_<?php echo $i ?>_id" />
					<div class="model_text_input_value">
						<span><?php echo $relative['name'] ?></span>
						<div class="model_text_input_value_checkbox">
							<input type="checkbox" name="patent_deposit[Relatives][<?php echo $i ?>][delete_object]" id="patent_deposit_Relatives_<?php echo $i ?>_delete_object" />
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
		<br />

		<div id="transfer_interval">
			<?php echo $form['transfer_interval']->renderLabel() ?>
			<?php echo $form['transfer_interval'] ?>
		</div>

		<div id="observation">
			<?php echo $form['observation']->renderLabel() ?>
			<?php echo $form['observation']->renderError() ?>
			<?php echo $form['observation']->renderHelp() ?>
			<?php echo $form['observation'] ?>
		</div>

		<div id="viability_test">
			<?php echo $form['viability_test']->renderLabel() ?>
			<?php echo $form['viability_test']->renderError() ?>
			<?php echo $form['viability_test']->renderHelp() ?>
			<?php echo $form['viability_test'] ?>
		</div>

		<div id="citations">
			<?php echo $form['citations']->renderLabel() ?>
			<?php echo $form['citations']->renderError() ?>
			<?php echo $form['citations']->renderHelp() ?>
			<?php echo $form['citations'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>

		<div id="bp1_document">
			<?php echo $form['bp1_document']->renderLabel() ?>
			<?php echo $form['bp1_document']->renderError() ?>
			<?php echo $form['bp1_document']->renderHelp() ?>
			<?php echo $form['bp1_document'] ?>
		</div>

		<div id="bp4_document">
			<?php echo $form['bp4_document']->renderLabel() ?>
			<?php echo $form['bp4_document']->renderError() ?>
			<?php echo $form['bp4_document']->renderHelp() ?>
			<?php echo $form['bp4_document'] ?>
		</div>
	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'patent_deposit', 'title' => 'deposit')) ?>
</form>