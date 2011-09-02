<?php

/**
* Sample form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class SampleForm extends BaseSampleForm {
	public function configure() {
		// Configure collection date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { 
			$years[$i] = $i;
		}
		$this->setWidget('collection_date', new sfWidgetFormDate(array(
			'format' => '%year%-%month%-%day%',
			'years' => $years,
		)));
		
		// Configure location
		$this->setWidget('location_id', new sfWidgetFormInputHidden(array('default' => $this->getObject()->getLocation()->getTable()->getDefaultLocationId())));
     
		// Configure collector
		$this->setWidget('collector_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Collector'),
			'add_empty' => false)
		));
		
		// Configure picture widgets
		$actualFieldPictures = $this->getObject()->getNbFieldPictures();
		$actualDetailedPictures = $this->getObject()->getNbDetailedPictures();
		$actualMicroscopicPictures = $this->getObject()->getNbMicroscopicPictures();
		
		$defaultMaxFieldPictures = sfConfig::get('app_max_sample_field_pictures');
		$defaultMaxDetailedPictures = sfConfig::get('app_max_sample_detailed_pictures');
		$defaultMaxMicroscopicPictures = sfConfig::get('app_max_sample_microscopic_pictures');
		
		$this->setOption('max_sample_field_pictures', $defaultMaxFieldPictures - $actualFieldPictures);
		$this->setOption('max_sample_detailed_pictures', $defaultMaxDetailedPictures - $actualDetailedPictures);
		$this->setOption('max_sample_microscopic_pictures', $defaultMaxMicroscopicPictures - $actualMicroscopicPictures);
		
		// Create an embedded form to add or edit pictures
		$this->embedRelations(array(
			'FieldPictures' => array(
				'considerNewFormEmptyFields' => array('filename'),
				'newFormLabel' => 'Field pictures',
				'multipleNewForms' => true,
				'newRelationButtonLabel' => 'Add another picture',
			),
			'DetailedPictures' => array(
				'considerNewFormEmptyFields' => array('filename'),
				'newFormLabel' => 'Detailed pictures',
				'multipleNewForms' => true,
				'newRelationButtonLabel' => 'Add another picture',
			),
			'MicroscopicPictures' => array(
				'considerNewFormEmptyFields' => array('filename'),
				'newFormLabel' => 'Microscopic pictures',
				'multipleNewForms' => true,
				'newRelationButtonLabel' => 'Add another picture',
			),
		));
				
		// Configure custom validators
		$this->setValidator('location_id', new sfValidatorDoctrineChoice(
			array('model' => $this->getRelatedModelName('Location')),
			array('required' => 'The location of the sample is required')));
		
		$this->setValidator('latitude', new sfValidatorRegex(
			array('pattern' => '/^\-?\d{1,2}º\d{1,2}\'\d{1,2}("|\'\')$/', 'required' => false),
			array('invalid' => 'Invalid coordinates format')));
		$this->setValidator('longitude', new sfValidatorRegex(
			array('pattern' => '/^\-?\d{1,2}º\d{1,2}\'\d{1,2}("|\'\')$/', 'required' => false),
			array('invalid' => 'Invalid coordinates format')));
				
		$this->setValidator('notebook_code', new sfValidatorInteger(array('required' => true), array(
			'invalid' => 'Only an integer number allowed',
			'required' => 'Provide the notebook code')));
				
		// Configure labels
		$this->widgetSchema->setLabel('ph', 'pH');
		$this->widgetSchema->setLabel('latitude', 'GPS coordinates');
		$this->widgetSchema->setLabel('longitude', 'GPS coordinates');
		
		// Configure help messages
		$this->widgetSchema->setHelp('notebook_code', 'Sample code assigned in collector\'s notebook');
		$this->widgetSchema->setHelp('latitude', 'Latitude and longitude in degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('longitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('ph', 'Decimal value for pH (e.g. 7)');
		$this->widgetSchema->setHelp('conductivity', 'Decimal value for conductivity (e.g 5.5 S/m)');
		$this->widgetSchema->setHelp('temperature', 'Integer value for temperature (e.g 22 ºC)');
		$this->widgetSchema->setHelp('salinity', 'Value for salinity (ppm)');
		$this->widgetSchema->setHelp('altitude', 'Integer value for altitude in meters (e.g. 1595)');
		$this->widgetSchema->setHelp('collection_date', 'Year, month and day');
		$this->widgetSchema->setHelp('new_FieldPictures', 'Select up to '.($defaultMaxFieldPictures - $actualFieldPictures).' pictures in JPEG, PNG or TIFF format');
		$this->widgetSchema->setHelp('new_DetailedPictures', 'Select up to '.($defaultMaxDetailedPictures - $actualDetailedPictures).' pictures in JPEG, PNG or TIFF format');
		$this->widgetSchema->setHelp('new_MicroscopicPictures', 'Select up to '.($defaultMaxMicroscopicPictures - $actualMicroscopicPictures).' pictures in JPEG, PNG or TIFF format');
	}

	/**
	 * Replace two single-quote symbols by a double-quote symbol before saving the form
	 *
	 * @param object $connection
	 * @return void
	 * @author Eliezer Talon
	 * @version 2011-04-14
	 */
	protected function doSave($connection = null) {
		if ( $this->values['latitude'] && preg_match('/\'\'$/', $this->values['latitude']) ) {
			$this->values['latitude'] = str_replace("''", '"', $this->values['latitude']);
		}
		
		if ( $this->values['longitude'] && preg_match('/\'\'$/', $this->values['longitude']) ) {
			$this->values['longitude'] = str_replace("''", '"', $this->values['longitude']);
		}
		
		parent::doSave($connection);
	}

}
