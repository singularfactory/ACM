<?php

/**
* CultureMedium form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class CultureMediumForm extends BaseCultureMediumForm {

	public function configure() {
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
