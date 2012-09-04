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
 * Project form
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class ProjectForm extends BaseProjectForm {
	public static $subjectChoices = array(
		'sample' => 'sample',
		'strain' => 'strain',
		'external_strain' => 'research collection',
	);

	public static $groupByChoices = array(
		0 => '',
		'subject' => 'Subject',
		'petitioner' => 'Petitioner',
	);

	/**
	 * Configure Project form
	 *
	 * @return void
	 */
	public function configure() {
		// Skip the whole configuration if this a search form
		if ($this->getOption('search')) {
			$this->setWidget('group_by', new sfWidgetFormChoice(array('choices' => self::$groupByChoices)));
			$this->setValidator('group_by', new sfValidatorChoice(array('choices' => array_keys(self::$groupByChoices), 'required' => false)));

			$this->setWidget('id', new sfWidgetFormInputText());
			$this->setValidator('id', new sfValidatorString(array('required' => false)));

			$this->getWidget('petitioner_id')->setOption('add_empty', true);
			$this->getWidget('project_name_id')->setOption('add_empty', true);

			$subjectChoices = array(0 => '') + self::$subjectChoices;
			$this->setWidget('subject', new sfWidgetFormChoice(array('choices' => $subjectChoices)));
			$this->setValidator('subject', new sfValidatorChoice(array('choices' => array_keys($subjectChoices), 'required' => false)));

			$this->widgetSchema->setLabels(array(
				'id' => 'Code',
				'petitioner_id' => 'Petitioner',
				'project_name_id' => 'Project',
			));

			return;
		}

		// Configure strain and sample search boxes
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => SampleTable::getInstance()->getDefaultSampleId())));
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => StrainTable::getInstance()->getDefaultStrainId())));
		$this->setWidget('external_strain_id', new sfWidgetFormInputHidden(array('default' => ExternalStrainTable::getInstance()->getDefaultExternalStrainId())));
		$this->setWidget('subject', new sfWidgetFormChoice(array('choices' => array(
			'sample' => 'sample',
			'strain' => 'strain',
			'external_strain' => 'research collection',
		))));

		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('inoculation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years)));
		$this->setWidget('delivery_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years), array('class' => 'noauto')));

		// Configure subject validator
		$this->setValidator('subject', new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external_strain'), 'required' => false)));

		// Configure a custom post validator to manage changes in isolation_subject
		$this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'cleanFieldsByProjectSubject'))));

		// Configure labels
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('strain_id', 'Strain code');
		$this->widgetSchema->setLabel('external_strain_id', 'Research collection code');

		// Configure help messages
		$this->widgetSchema->setHelp('subject', 'Choose the type of material requested');
		$this->widgetSchema->setHelp('amount', 'Amount of strain inoculation');
		$this->widgetSchema->setHelp('inoculation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('delivery_date', 'Year, month and day');
		$this->widgetSchema->setHelp('purpose', 'Project details and usage of the strain');
	}

	public function cleanFieldsByProjectSubject($validator, $values) {
		switch( $values['subject'] ) {
		case 'strain':
			$values['sample_id'] = null;
			$values['external_strain_id'] = null;
			break;

		case 'external_strain':
			$values['sample_id'] = null;
			$values['strain_id'] = null;
			break;

		case 'sample':
		default:
			$values['strain_id'] = null;
			$values['external_strain_id'] = null;
			break;
		}

		return $values;
	}

}
