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
 * Identification form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class IdentificationForm extends BaseIdentificationForm {
	public function configure() {
		// Configure sample search box
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => SampleTable::getInstance()->getDefaultSampleId())));

		// Configure yearly count
		$this->setWidget('yearly_count', new sfWidgetFormInputHidden);

		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('identification_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years)));

		// Configure document uploads
		$this->setWidget('request_document', new sfWidgetFormInputFile());
		$this->setWidget('report_document', new sfWidgetFormInputFile());
		$this->setValidator('request_document', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_document_size'),
			'mime_types' => sfConfig::get('app_document_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_identification_dir'),
			'required' => false,
			'validated_file_class' => 'myDocument',
			),
			array(
				'invalid' => 'Invalid file',
				'required' => 'Select a file to upload',
				'mime_types' => 'The file must be a supported type',
			)
		));
		$this->setValidator('report_document', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_document_size'),
			'mime_types' => sfConfig::get('app_document_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_identification_dir'),
			'required' => false,
			'validated_file_class' => 'myDocument',
			),
			array(
				'invalid' => 'Invalid file',
				'required' => 'Select a file to upload',
				'mime_types' => 'The file must be a supported type',
			)
		));

		// Configure sample picture management
		$this->setWidget('sample_picture', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => false,
			'is_image' => true,
		)));
		$this->setValidator('sample_picture', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => sfConfig::get('app_image_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_identification_pictures_dir'),
			'validated_file_class' => 'sfCustomValidatedFile',
			'required' => false,
		)));

		// Configure labels
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('request_document', 'Request document');
		$this->widgetSchema->setLabel('report_document', 'Report document');

		// Configure help messages
		$this->widgetSchema->setHelp('identification_date', 'Year, month and day');
		$this->widgetSchema->setHelp('request_document', 'Enclosed request document');
		$this->widgetSchema->setHelp('report_document', 'Enclosed report document');
	}
}
