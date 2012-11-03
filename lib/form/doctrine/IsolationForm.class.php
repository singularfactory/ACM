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
 * Isolation form
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class IsolationForm extends BaseIsolationForm {
	public static $groupByChoices = array(
		0 => '',
		'isolation_subject' => 'Material',
	);

	/**
	 * Configure Isolation form
	 *
	 * @return void
	 */
	public function configure() {
		// Configure date formats
		for ($i=1990; $i <= date('Y'); $i++) { $years[$i] = $i; }
		$this->setWidget('reception_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));
		$this->setWidget('isolation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));
		$this->setWidget('delivery_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years), array('class' => 'noauto')));

		// Configure a custom post validator to manage changes in isolation_subject
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'cleanFieldsByIsolationSubject'))));

		// Skip the whole configuration if this a search form
		if ($this->getOption('search')) {
			$this->setWidget('group_by', new sfWidgetFormChoice(array('choices' => self::$groupByChoices)));
			$this->setValidator('group_by', new sfValidatorChoice(array('choices' => array_keys(self::$groupByChoices), 'required' => false)));

			$this->setWidget('id', new sfWidgetFormInputText());
			$this->setValidator('id', new sfValidatorString(array('required' => false)));

			$this->setWidget('isolation_subject', new sfWidgetFormChoice(array('choices' => array(
				0 => '',
				'sample' => 'sample',
				'strain' => 'strain',
				'external' => 'external',
				'external_strain' => 'research collection',
			))));
			$this->setValidator('isolation_subject', new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external', 3 => 'external_strain'), 'required' => false)));

			$this->setWidget('related_code', new sfWidgetFormInputText());
			$this->setValidator('related_code', new sfValidatorString(array('required' => false)));

			$this->getWidget('taxonomic_class_id')->setOption('add_empty', true);
			$this->getWidget('genus_id')->setOption('add_empty', true);
			$this->getWidget('species_id')->setOption('add_empty', true);

			$this->widgetSchema->setLabels(array(
				'id' => 'Code',
				'taxonomic_class_id' => 'Limited to class',
				'genus_id' => 'Limited to genus',
				'species_id' => 'Limited to species',
				'isolation_subject' => 'Isolation material',
			));

			return;
		}

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

		// Configure yearly count
		$this->setWidget('yearly_count', new sfWidgetFormInputHidden);

		// Configure many-to-many relationships
		$this->setWidget('culture_media_list', new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'method' => 'getName')));

		// Configure subject validator
		$this->setValidator('isolation_subject', new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external', 3 => 'external_strain'), 'required' => false)));

		// Configure labels
		$this->widgetSchema->setLabel('isolation_subject', 'Isolation material');
		$this->widgetSchema->setLabel('external_strain_id', 'Research collection code');

		// Configure help messages
		$this->widgetSchema->setHelp('isolation_subject', 'Choose the type of material received');
		$this->widgetSchema->setHelp('external_code', 'Code assigned by the entity that request the isolation');
		$this->widgetSchema->setHelp('reception_date', 'Year, month and day');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
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
