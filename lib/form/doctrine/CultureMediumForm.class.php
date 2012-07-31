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
 * CultureMedium form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class CultureMediumForm extends BaseCultureMediumForm {
	public static $groupByChoices = array(
		0 => '',
		'is_public' => 'Is public',
	);

	public function configure() {
		// Skip the whole configuration if this a search form
		if ($this->getOption('search')) {
			$this->setWidget('group_by', new sfWidgetFormChoice(array('choices' => self::$groupByChoices)));
			$this->setValidator('group_by', new sfValidatorChoice(array('choices' => array_keys(self::$groupByChoices), 'required' => false)));

			$this->setWidget('id', new sfWidgetFormInputText());
			$this->setValidator('id', new sfValidatorString(array('required' => false)));

			$this->setWidget('is_public', new sfWidgetFormChoice(array('choices' => self::$booleanChoices)));

			$this->widgetSchema->setLabels(array(
				'id' => 'Code',
			));

			return;
		}

		$this->setWidget('description', new sfWidgetFormInputFile());
		$this->setValidator('description', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_document_size'),
			'mime_types' => sfConfig::get('app_document_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_culture_media_dir'),
			'required' => false,
			'validated_file_class' => 'myDocument',
		),
		array(
			'invalid' => 'Invalid file',
			'required' => 'Select a file to upload',
			'mime_types' => 'The file must be a supported type',
		)
	));

		$this->widgetSchema->setHelp('name', 'Name of this culture medium');
		$this->widgetSchema->setHelp('description', 'Enclosed document with the details of this culture medium');
		$this->widgetSchema->setHelp('link', 'Links to external resources');
		$this->widgetSchema->setHelp('is_public', 'Whether the culture media must be shown in public catalog or not');
		//$this->widgetSchema->setHelp('amount', 'Items in stock');
	}
}
