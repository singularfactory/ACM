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
 * Isolation form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class IsolationForm extends BaseIsolationForm {

	public function configure() {
		// Configure date formats
		for ($i=1990; $i <= date('Y'); $i++) { $years[$i] = $i; }
		$this->setWidget('reception_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));
		$this->setWidget('delivery_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years), array('class' => 'noauto')));

		// Configure search boxes
		$this->setWidget('location_id', new sfWidgetFormInputHidden(array('default' => LocationTable::getInstance()->getDefaultLocationId())));
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => SampleTable::getInstance()->getDefaultSampleId())));
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => StrainTable::getInstance()->getDefaultStrainId())));
		$this->setWidget('external_strain_id', new sfWidgetFormInputHidden(array('default' => ExternalStrainTable::getInstance()->getDefaultExternalStrainId())));
		$this->setWidget('isolation_subject', new sfWidgetFormChoice(array('choices' => array(
			'sample' => 'sample',
			'strain' => 'strain',
			'external' => 'external',
			'external_strain' => 'research collection',
		))));

		// Configure many-to-many relationships
		$this->setWidget('culture_media_list', new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'method' => 'getName')));

		// Configure subject validator
		$this->setValidator('subject', new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external', 3 => 'external_strain'), 'required' => false)));

		// Configure a custom post validator to manage changes in isolation_subject
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'cleanFieldsByIsolationSubject'))));

		// Configure labels
		$this->widgetSchema->setLabel('isolation_subject', 'Isolation material');
		$this->widgetSchema->setLabel('external_strain_id', 'Research collection code');

		// Configure help messages
		$this->widgetSchema->setHelp('isolation_subject', 'Choose the type of material received');
		$this->widgetSchema->setHelp('external_code', 'Code assigned by the entity that request the isolation');
		$this->widgetSchema->setHelp('reception_date', 'Year, month and day');
		$this->widgetSchema->setHelp('purification_details', 'Notes and conclusions about the purification process');
		$this->widgetSchema->setHelp('delivery_date', 'Year, month and day');
	}

	public function cleanFieldsByIsolationSubject($validator, $values) {
		switch( $values['isolation_subject'] ) {
			case 'strain':
				$values['external_code'] = null;
				$values['location_id'] = null;
				$values['sample_id'] = null;
				$values['environment_id'] = null;
				$values['habitat_id'] = null;
				$values['taxonomic_class_id'] = null;
				$values['genus_id'] = null;
				$values['species_id'] = null;
				$values['authority_id'] = null;
				$values['external_strain_id'] = null;
				break;

			case 'external_strain':
				$values['external_code'] = null;
				$values['location_id'] = null;
				$values['sample_id'] = null;
				$values['environment_id'] = null;
				$values['habitat_id'] = null;
				$values['taxonomic_class_id'] = null;
				$values['genus_id'] = null;
				$values['species_id'] = null;
				$values['authority_id'] = null;
				$values['strain_id'] = null;
				break;

			case 'external':
				$values['sample_id'] = null;
				$values['strain_id'] = null;
				$values['external_strain_id'] = null;
				break;

			case 'sample':
			default:
				$values['external_code'] = null;
				$values['location_id'] = null;
				$values['strain_id'] = null;
				$values['environment_id'] = null;
				$values['habitat_id'] = null;
				$values['taxonomic_class_id'] = null;
				$values['genus_id'] = null;
				$values['species_id'] = null;
				$values['authority_id'] = null;
				$values['external_strain_id'] = null;
				break;
		}

		return $values;
	}

}
