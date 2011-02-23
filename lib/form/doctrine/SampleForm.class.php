<?php

/**
* Sample form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class SampleForm extends BaseSampleForm
{
	public function configure()
	{
		$this->useFields(array(
			'id',
			'number',
			'ecosystem_id',
			'location',
			'latitude_degrees',
			'latitude_minutes',
			'longitude_degrees',
			'longitude_minutes',
			'environment_id',
			'habitat_id',
			'ph',
			'conductivity',
			'temperature',
			'salinity',
			'field_picture',
			'detailed_picture',
			'collector_id',
			'collection_date',
			'remarks',
		));
		
		$this->setWidget('field_picture', new sfWidgetFormInputFile());
		$this->setWidget('detailed_picture', new sfWidgetFormInputFile());
		
		$this->setValidator('field_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
		$this->setValidator('detailed_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
	}
}
