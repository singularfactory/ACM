<?php
/**
 * Form class
 *
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
 * @package       ACM.Lib.Form
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * MaintenanceDeposit form
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class MaintenanceDepositForm extends BaseMaintenanceDepositForm {

	public function configure() {
		// Configure location
		$this->setWidget('location_id', new sfWidgetFormInputHidden(array('default' => $this->getObject()->getLocation()->getTable()->getDefaultLocationId())));

		// Configure date fields
		for ($i=1980; $i <= date('Y'); $i++) { $years[$i] = $i; }
		$dateWidget = new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years), array('class' => 'noauto'));
		$this->setWidget('collection_date', $dateWidget);
		$this->setWidget('isolation_date', $dateWidget);
		$this->setWidget('deposition_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));

		// Configure many-to-many relationships
		$this->setWidget('culture_media_list', new sfWidgetFormDoctrineChoice(array(
			'multiple' => true,
			'model' => 'CultureMedium',
			'method' => 'getName',
		)));

		$this->setWidget('mf1_document', new sfWidgetFormInputFile());
		$this->setValidator('mf1_document', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_document_size'),
			'mime_types' => sfConfig::get('app_document_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_maintenance_deposit_dir'),
			'required' => false,
			'validated_file_class' => 'myDocument',
		),
		array(
			'invalid' => 'Invalid file',
			'required' => 'Select a file to upload',
			'mime_types' => 'The file must be a supported type',
		)
	));

		// Create an embedded form to add or edit pictures, relatives and axenity tests
		$this->embedRelations(array(
			'Relatives' => array(
				'considerNewFormEmptyFields' => array('name'),
				'newFormLabel' => 'Relatives',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another relative',
			),
		));

		$this->setValidator('location_id', new sfValidatorDoctrineChoice(
			array('model' => $this->getRelatedModelName('Location')),
			array('required' => 'The location of the sample is required')));

		// Configure a custom post validator
		$this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'doPostValidations'))));

		// Configure labels
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('culture_media_list', 'Culture media');
		$this->widgetSchema->setLabel('transfer_interval', 'Transfer interval (weeks)');
		$this->widgetSchema->setLabel('isolators_list', 'Isolators');
		$this->widgetSchema->setLabel('collectors_list', 'Collectors');
		$this->widgetSchema->setLabel('mf1_document', 'MF1 document');
		$this->widgetSchema->setLabel('is_blend', 'Is blend');

		// Configure help messages
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
		$this->widgetSchema->setHelp('authority_id', 'Taxonomic authority');
		$this->widgetSchema->setHelp('environment_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('habitat_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('new_Relatives', 'Codes used in alternate databases or publications');
		$this->widgetSchema->setHelp('observation', 'Notes about strain culture');
		$this->widgetSchema->setHelp('citations', 'Scientific publications where the strain was used');
		$this->widgetSchema->setHelp('amount', 'Items in stock');
		$this->widgetSchema->setHelp('culture_media_list', 'Culture media available for this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('isolators_list', 'Isolators of this deposit. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('collectors_list', 'Collectors of this deposit. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('mf1_document', 'Enclosed MF1 document');
		$this->widgetSchema->setHelp('is_blend', 'The deposit is a blend, taxonomical description is not available.');
	}

	public function doPostValidations($validator, $values) {
		// Check data consistency between blend and taxonomical description
		if ($values['is_blend']) {
			if (empty($values['blend_description'])) {
				$error = new sfValidatorError($validator, 'You must provide a description for the blend');
				throw new sfValidatorErrorSchema($validator, array('blend_description' => $error));
			} else {
				$values['taxonomic_class_id'] = null;
				$values['genus_id'] = null;
				$values['species_id'] = null;
				$values['authority_id'] = null;
			}
		} else {
			if (empty($values['taxonomic_class_id'])) {
				$error = new sfValidatorError($validator, 'You must choose a taxonomic class.');
				throw new sfValidatorErrorSchema($validator, array('taxonomic_class_id' => $error));
			}

			if (empty($values['genus_id'])) {
				$error = new sfValidatorError($validator, 'You must choose a genus.');
				throw new sfValidatorErrorSchema($validator, array('genus_id' => $error));
			}

			if (empty($values['authority_id'])) {
				$error = new sfValidatorError($validator, 'You must choose an authority.');
				throw new sfValidatorErrorSchema($validator, array('authority_id' => $error));
			}

			$values['blend_description'] = null;
		}
		return $values;
	}
}
