<?php
/**
 * StrainImportForm class
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
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * StrainImport form
 *
 * @package ACM.Lib.Form
 */
class DnaImportForm extends BaseFormDoctrine {
	/**
	 * Configures form 
	 *
	 * @return void
	 */
	public function configure() {
		parent::configure();

		$this->setWidget('filename', new sfWidgetFormInputFile());
		$this->setValidator('filename', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_document_size'),
			'mime_types' => array('text/csv'),
			'required' => false,
		)));
		$this->widgetSchema->setLabel('filename', 'CSV file');
		$this->widgetSchema->setHelp('filename', '');
		$this->setup();
	}

	/**
	 * Returns the name of form associated model
	 */
	public function getModelName() {
		return 'DnaExtraction';
	}

	/**
	 * Returns the name of form associated model
	 */
	public function getName() {
		return 'DnaExtraction';
	}
}
