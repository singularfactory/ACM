<?php
/**
 * SampleForm class
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
 * Sample form
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class SampleForm extends BaseSampleForm {
	public static $sampleGroupByChoices = array(
		0 => '',
		'environment' => 'Environment',
		'habitat' => 'Habitat',
		'radiation' => 'Radiation',
		'ph' => 'ph',
		'conductivity' => 'Conductivity',
		'temperature' => 'Temperature',
		'salinity' => 'Salinity',
		'altitude' => 'Altitude',
		'location' => 'Location',
	);

	/**
	 * Configure Sample form
	 *
	 * @return void
	 */
	public function configure() {
		// Specific configuration for searching
		if ($this->getOption('search')) {
			$this->setWidget('group_by', new sfWidgetFormChoice(array('choices' => self::$sampleGroupByChoices)));
			$this->setValidator('group_by', new sfValidatorChoice(array('choices' => array_keys(self::$sampleGroupByChoices), 'required' => false)));

			$this->setWidget('id', new sfWidgetFormInputText());
			$this->setValidator('id', new sfValidatorString(array('required' => false)));

			$this->getWidget('environment_id')->setOption('add_empty', true);
			$this->getWidget('habitat_id')->setOption('add_empty', true);
			$this->getWidget('radiation_id')->setOption('add_empty', true);

			$this->setWidget('is_extremophile', new sfWidgetFormChoice(array(
				'choices' => self::$booleanChoices,
			)));

			$this->setWidget('location_id', new sfWidgetFormInputText());
			$this->setValidator('location_id', new sfValidatorString(array('required' => false)));

			$this->widgetSchema->setLabels(array(
				'id' => 'Code',
				'environment_id' => 'Limited to environment',
				'habitat_id' => 'Limited to habitat',
				'radiation_id' => 'Limited to radiation',
				'is_extremophile' => 'Is extremophile?',
				'location_details' => 'Location details',
			));

			return;
		}

		// Configure collection date format
		$years = range(1990, date('Y'));
		$this->setWidget('collection_date', new sfWidgetFormDate(array('format' => '%year%-%month%-%day%', 'years' => array_combine($years, $years))));

		// Configure location
		$this->setWidget('location_id', new sfWidgetFormInputHidden(array('default' => $this->getObject()->getLocation()->getTable()->getDefaultLocationId())));

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

		// Configure list of colectors
		$this->setWidget('collectors_list', new sfWidgetFormDoctrineChoice(array(
			'model' => 'Collector',
			'multiple' => true,
			'order_by' => array('name', 'asc'),
		)));

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
			array('pattern' => '/^\-?\d{1,3}º\d{1,2}(\'|’)\d{1,2}("|\'\'|’’|”)$/', 'required' => false),
			array('invalid' => 'Invalid coordinates format')));

		$this->setValidator('longitude', new sfValidatorRegex(
			array('pattern' => '/^\-?\d{1,3}º\d{1,2}(\'|’)\d{1,2}("|\'\'|’’|”)$/', 'required' => false),
			array('invalid' => 'Invalid coordinates format')));

		$this->setValidator('notebook_code', new sfValidatorString(array('max_length' => 40, 'required' => false), array(
			'invalid' => 'Only an integer number allowed',
			'required' => false)));

		// Configure labels
		$this->widgetSchema->setLabel('ph', 'pH');
		$this->widgetSchema->setLabel('latitude', 'GPS coordinates');
		$this->widgetSchema->setLabel('longitude', 'GPS coordinates');
		$this->widgetSchema->setLabel('collectors_list', 'Collectors');

		// Configure help messages
		$this->widgetSchema->setHelp('notebook_code', 'Sample code assigned in collector\'s notebook');
		$this->widgetSchema->setHelp('latitude', 'Latitude and longitude in degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('longitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('ph', 'Decimal value for pH (e.g. 7)');
		$this->widgetSchema->setHelp('conductivity', 'Decimal value for conductivity (e.g 5.5 S/m)');
		$this->widgetSchema->setHelp('temperature', 'Integer value for temperature (e.g 22 ºC)');
		$this->widgetSchema->setHelp('salinity', 'Value for salinity (ppm)');
		$this->widgetSchema->setHelp('altitude', 'Integer value for altitude in meters (e.g. 1595)');
		$this->widgetSchema->setHelp('radiation_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('environment_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('habitat_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('collectors_list', 'Collectors of this sample. Select more than one with Ctrl or Cmd key.');
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
