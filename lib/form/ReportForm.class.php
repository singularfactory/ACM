<?php
/**
 * ReportForm class
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
 * Report form class.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class ReportForm extends BaseForm {
	protected static $subjects = array(
		'maintenance' => 'Maintenance',
	);

	public function configure() {
		$this->setWidgets(array(
			'subject'	=> new sfWidgetFormChoice(array('choices' => self::$subjects)),

			// Maintenance widgets
			'maintenance_strain'	=> new sfWidgetFormInputHidden(),
			'maintenance_strain_id'	=> new sfWidgetFormChoice(array('choices' => array(), 'multiple' => true)),
		));

		// Obtains all the strain id's for the maintenance report validator
		$results = StrainTable::getInstance()->createQuery('u')->select('u.id')->fetchArray();
		$strains = array();
		foreach ($results as $strain) {
			$strains[] = $strain['id'];
		}

		$this->setValidators(array(
			'subject'	=> new sfValidatorChoice(array('choices' => array_keys(self::$subjects), 'required' => false)),

			// Maintenance validators
			'maintenance_strain'	=> new sfValidatorInteger(array('required' => false)),
			'maintenance_strain_id' => new sfValidatorChoice(array('choices' => $strains, 'multiple' => true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

		$this->widgetSchema->setLabels(array(
			'subject'	=> 'Subject',

			// Maintenance labels
			'maintenance_strain' => 'Strain',
			'maintenance_strain_id' => 'Selected strains',
		));

		$this->widgetSchema->setHelps(array(
			'subject'	=> 'Choose the subject of this report',

			// Maintenance help texts
			'maintenance_strain' => '',
			'maintenance_strain_id' => '',
		));

		$this->setup();
	}
}
