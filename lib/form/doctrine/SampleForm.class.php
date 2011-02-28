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
		
		// Replace default input elements by file input
		$this->setWidget('field_picture', new sfWidgetFormInputFile());
		$this->setValidator('field_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
		$this->setWidget('detailed_picture', new sfWidgetFormInputFile());
		$this->setValidator('detailed_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_directory'), 'required' => false)));
		
		// Configure help messages
		$this->widgetSchema->setHelp('latitude_degrees', '<span class="sample_form_help">Integer value for the latitude degrees (N) of GPS coordinates (e.g. 15)</span>');
		$this->widgetSchema->setHelp('longitude_degrees', '<span class="sample_form_help">Integer value for the longitude degrees (E) of GPS coordinates (e.g. 42)</span>');
		$this->widgetSchema->setHelp('latitude_minutes', '<span class="sample_form_help">Decimal value for the latitude minutes of GPS coordinates (e.g. 15.3423)</span>');
		$this->widgetSchema->setHelp('longitude_minutes', '<span class="sample_form_help">Decimal value for the longitude minutes of GPS coordinates (e.g. 38.2832)</span>');
		$this->widgetSchema->setHelp('ph', '<span class="sample_form_help">Decimal value for PH (e.g. 38.2832)</span>');
		$this->widgetSchema->setHelp('conductivity', '<span class="sample_form_help">Decimal value for conductivity (e.g. 38.2832)</span>');
		$this->widgetSchema->setHelp('temperature', '<span class="sample_form_help">Integer value for temperature (e.g. 22)</span>');
		$this->widgetSchema->setHelp('salinity', '<span class="sample_form_help">Decimal value for salinity (e.g. 38.2832)</span>');
		
		// Configure labels
		$this->widgetSchema->setLabel('collector_id', 'User');
	}
}
