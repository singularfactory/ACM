<?php

/**
* Identification form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class IdentificationForm extends BaseIdentificationForm {
	public function configure() {
		// Configure sample search box
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => SampleTable::getInstance()->getDefaultSampleId())));
		
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
