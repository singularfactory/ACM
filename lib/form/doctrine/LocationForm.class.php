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
 * Location form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
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

		// Configure country, region and island widgets
		if ( $this->getObject()->isNew() ) {
			$countryId = CountryTable::getInstance()->getDefaultCountryId();
			$regionId = RegionTable::getInstance()->getDefaultRegionId($countryId);
		}
		else {
			$countryId = $this->getObject()->getCountryId();
			$regionId = $this->getObject()->getRegionId();
		}
		$this->setWidget('region_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Region'),
			'query' => $this->getObject()->getRegion()->getTable()->getRegionsQuery($countryId),
		)));
		$this->setWidget('island_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Island'),
			'query' => $this->getObject()->getIsland()->getTable()->getIslandsQuery($regionId),
			'add_empty' => '---',
		)));

		// Configure custom validators
		$this->setValidator('name', new sfValidatorString(array('max_length' => 255), array('required' => 'Give this location a name')));
		$gpsCoordinatesValidator = new sfValidatorRegex(array('pattern' => '/^\-?\d{1,3}º\d{1,2}(\'|’)\d{1,2}("|\'\'|’’|”)$/','required' => false), array('invalid' => 'Invalid coordinates format'));
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
	 * Set the choices of the Island widget based on a Region
	 *
	 * @param integer $regionId
	 * @return void
	 * @since 1.0
	*/
	public function setIslandChoicesByRegion($regionId) {
		$this->setWidget('island_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Island'),
			'query' => $this->getObject()->getIsland()->getTable()->getIslandsQuery($regionId),
			'add_empty' => '---',
		)));
	}

	/**
	 * Replace two single-quote symbols by a double-quote symbol before saving the form
	 * or unset the GPS coordinates if they are empty
	 *
	 * @param object $connection
	 * @return void
	 * @since 1.0
	 */
	protected function doSave($connection = null) {
		$this->values['latitude'] = str_replace("''", '"', $this->values['latitude']);
		$this->values['latitude'] = str_replace("’’", '"', $this->values['latitude']);
		$this->values['latitude'] = str_replace("’", "'", $this->values['latitude']);
		$this->values['latitude'] = str_replace("”", '"', $this->values['latitude']);

		$this->values['longitude'] = str_replace("''", '"', $this->values['longitude']);
		$this->values['longitude'] = str_replace("’’", '"', $this->values['longitude']);
		$this->values['longitude'] = str_replace("’", "'", $this->values['longitude']);
		$this->values['longitude'] = str_replace("”", '"', $this->values['longitude']);

		parent::doSave($connection);
	}

}
