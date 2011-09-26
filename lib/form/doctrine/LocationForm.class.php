<?php

/**
 * Location form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LocationForm extends BaseLocationForm {
	
	public function configure() {
		// Calculate maximum number of images the user can upload
		$actualPictures = $this->getObject()->getNbPictures();
		$defaultMaxPictures = sfConfig::get('app_max_location_pictures');
		$this->setOption('max_location_pictures', $defaultMaxPictures - $actualPictures);
		
		// Create an embedded form to add or edit pictures
		$this->embedRelations(array(
			'Pictures' => array(
				'considerNewFormEmptyFields' => array('filename'),
				'newFormLabel' => 'Pictures',
				'multipleNewForms' => true,
				'newRelationButtonLabel' => 'Add another picture',
			),
		));
		
		// Configure country, region and island widgets to display default options
		$defaultCountryId = $this->getObject()->getCountry()->getTable()->getDefaultCountryId();
		$defaultRegionId = $this->getObject()->getRegion()->getTable()->getDefaultRegionId($defaultCountryId);
		$defaultIslandId = $this->getObject()->getIsland()->getTable()->getDefaultIslandId($defaultRegionId);
		
		$this->widgetSchema->setDefault('country_id', $defaultCountryId);
		$this->setWidget('region_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Region'),
			'query' => $this->getObject()->getRegion()->getTable()->getRegionsQuery($defaultCountryId),
			'default' => $defaultRegionId,
		)));
		$this->setWidget('island_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Island'),
			'query' => $this->getObject()->getIsland()->getTable()->getIslandsQuery($defaultRegionId),
			'add_empty' => '---',
			'default' => $defaultIslandId,
		)));
		
		// Configure custom validators
		$this->setValidator('name', new sfValidatorString(array('max_length' => 255), array('required' => 'Give this location a name')));
		$gpsCoordinatesValidator = new sfValidatorRegex(array('pattern' => '/^-?\d{1,3}º\d{1,2}\'\d{1,2}("|\'\')$/','required' => false), array('invalid' => 'Invalid coordinates format'));
		$this->setValidator('latitude', $gpsCoordinatesValidator);
		$this->setValidator('longitude', $gpsCoordinatesValidator);
		
		// Configure help messages
		$this->widgetSchema->setHelp('latitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('longitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('region_id', 'States and provinces as well');
		$this->widgetSchema->setHelp('island_id', 'Only for regions with islands');
		$this->widgetSchema->setHelp('new_Pictures', 'Select up to '.($defaultMaxPictures - $actualPictures).' pictures in JPEG, PNG or TIFF format');
	
		// Configure labels
		$this->widgetSchema->setLabel('latitude', 'GPS coordinates');
		$this->widgetSchema->setLabel('longitude', 'GPS coordinates');
	}
	
	/**
	 * Replace two single-quote symbols by a double-quote symbol before saving the form
	 * or unset the GPS coordinates if they are empty
	 *
	 * @param object $connection
	 * @return void
	 * @author Eliezer Talon
	 * @version 2011-04-14
	 */
	protected function doSave($connection = null) {
		if ( preg_match('/\'\'$/', $this->values['latitude']) ) {
				$this->values['latitude'] = str_replace("''", '"', $this->values['latitude']);
		}
				
		if ( preg_match('/\'\'$/', $this->values['longitude']) ) {
			$this->values['longitude'] = str_replace("''", '"', $this->values['longitude']);
		}
				
		parent::doSave($connection);
	}
	
}
