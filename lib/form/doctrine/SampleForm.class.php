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
		// Hide widgets
		unset($this['created_at'], $this['updated_at']);
				
		// Configure collection date format
		$lastYear = date('Y');
		for ($i=$lastYear-5; $i <= $lastYear; $i++) { 
			$years[$i] = $i;
		}
		$this->setWidget('collection_date', new sfWidgetFormDate(array(
			'format' => '%year%-%month%-%day%',
			'years' => $years,
		)));
		
		// Configure collector
		$this->setWidget('collector_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Collector'),
			'method' => 'getFullName',
			'add_empty' => false)
		));
		
		// Replace default input elements by file input
		$this->setWidget('field_picture', new sfWidgetFormInputFile());
		$this->setValidator('field_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
		$this->setWidget('detailed_picture', new sfWidgetFormInputFile());
		$this->setValidator('detailed_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
		$this->setWidget('microscopic_picture', new sfWidgetFormInputFile());
		$this->setValidator('microscopic_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
		
		// Configure help messages
		$this->widgetSchema->setHelp('notebook_code', 'Sample code assigned in collector\'s notebook');
		$this->widgetSchema->setHelp('latitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('longitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('ph', 'Decimal value for PH (e.g. 38.2832)');
		$this->widgetSchema->setHelp('conductivity', 'Decimal value for conductivity (e.g. 38.2832)');
		$this->widgetSchema->setHelp('temperature', 'Integer value for temperature (e.g. 22)');
		$this->widgetSchema->setHelp('salinity', 'Decimal value for salinity (e.g. 38.2832)');
		$this->widgetSchema->setHelp('altitude', 'Integer value for altitude in meters (e.g. 1595)');
		
		// Remove <br /> tag after labels and set custom tag
		$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
	}
}
