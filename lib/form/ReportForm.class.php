<?php
/**
 * ReportForm class
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
 * Report form class.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class ReportForm extends BaseForm {

	protected static $subjects = array(
		'location' => 'Location',
		'sample' => 'Sample',
		'strain' => 'Strain',
		'dna_extraction' => 'DNA extraction',
		'maintenance' => 'Maintenance',
	);

	public static $booleanChoices = array(
		0 => '',
		1 => 'No',
		2 => 'Yes',
	);

	public static $locationGroupByChoices = array(
		0 => '',
		'country' => 'Country',
		'region' => 'Region',
		'island' => 'Island',
		'category' => 'Category',
	);

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

	public static $strainGroupByChoices = array(
		0 => '',
		'taxonomic_class' => 'Taxonomic class',
		'genus' => 'Genus',
		'species' => 'Species',
		'authority' => 'Authority',
		'maintenance_status' => 'Maintenance status',
		'culture_medium' => 'Culture medium',
		'transfer_interval' => 'Transfer interval',
		'is_epitype' => 'Is epitype',
		'is_axenic' => 'Is axenic',
		'in_g_catalog' => 'In G-catalog',
		'deceased' => 'Deceased',
		'sample' => 'Sample',
	);

	protected static $dnaExtractionGroupByChoices = array(
		0 => '',
		'extraction_kit' => 'Extraction kit',
		'concentration' => 'Concentration',
		'aliquots' => 'Number of aliquots',
		'260_280_ratio' => '260:280 DNA quality ratio',
		'260_230_ratio' => '260:230 DNA quality ratio',
		'strain' => 'Strain',
	);


	public function configure() {
		$this->setWidgets(array(
			'subject'	=> new sfWidgetFormChoice(array('choices' => self::$subjects)),

			// Location attributes
			'location_group_by'	=> new sfWidgetFormChoice(array('choices' => self::$locationGroupByChoices)),
			'location_country'	=> new sfWidgetFormInputHidden(),
			'location_region'	=> new sfWidgetFormInputHidden(),
			'location_island'	=> new sfWidgetFormInputHidden(),
			'location_category' => new sfWidgetFormDoctrineChoice(array('model' => 'LocationCategory', 'add_empty' => true)),

			// Sample attributes
			'sample_group_by'	=> new sfWidgetFormChoice(array('choices' => self::$sampleGroupByChoices)),
			'sample_environment' => new sfWidgetFormDoctrineChoice(array('model' => 'Environment', 'add_empty' => true)),
			'sample_habitat' => new sfWidgetFormDoctrineChoice(array('model' => 'Habitat', 'add_empty' => true)),
			'sample_radiation' => new sfWidgetFormDoctrineChoice(array('model' => 'Radiation', 'add_empty' => true)),
			'sample_extremophile' => new sfWidgetFormChoice(array('choices' => self::$booleanChoices)),
			'sample_location_details' => new sfWidgetFormInputText(),

			// Strain attributes
			'strain_group_by' => new sfWidgetFormChoice(array('choices' => self::$strainGroupByChoices)),
			'strain_taxonomic_class' => new sfWidgetFormDoctrineChoice(array('model' => 'TaxonomicClass', 'add_empty' => true)),
			'strain_genus' => new sfWidgetFormDoctrineChoice(array('model' => 'Genus', 'add_empty' => true)),
			'strain_species' => new sfWidgetFormDoctrineChoice(array('model' => 'Species', 'add_empty' => true)),
			'strain_authority' => new sfWidgetFormDoctrineChoice(array('model' => 'Authority', 'add_empty' => true)),
			'strain_maintenance_status' => new sfWidgetFormDoctrineChoice(array('model' => 'MaintenanceStatus', 'add_empty' => true)),
			'strain_culture_medium' => new sfWidgetFormDoctrineChoice(array('model' => 'CultureMedium', 'add_empty' => true)),
			'strain_transfer_interval' => new sfWidgetFormInputText(),
			'strain_epitype' => new sfWidgetFormChoice(array('choices' => self::$booleanChoices)),
			'strain_axenic' => new sfWidgetFormChoice(array('choices' => self::$booleanChoices)),
			'strain_in_g_catalog' => new sfWidgetFormChoice(array('choices' => self::$booleanChoices)),
			'strain_deceased' => new sfWidgetFormChoice(array('choices' => self::$booleanChoices)),

			// DNA extraction attributes
			'dna_extraction_group_by' => new sfWidgetFormChoice(array('choices' => self::$dnaExtractionGroupByChoices)),
			'dna_extraction_extraction_kit' => new sfWidgetFormDoctrineChoice(array('model' => 'ExtractionKit', 'add_empty' => true)),
			'dna_extraction_aliquots' => new sfWidgetFormInputText(),
			'dna_extraction_concentration' => new sfWidgetFormInputText(),
			'dna_extraction_260_280_ratio' => new sfWidgetFormInputText(),
			'dna_extraction_260_230_ratio' => new sfWidgetFormInputText(),
			
			// Maintenance
			'maintenance_strain'	=> new sfWidgetFormInputHidden(),
			'maintenance_strain_id'	=> new sfWidgetFormChoice(array('choices' => array(), 'multiple'=>true)),
		));

		//Obtains all the strain id's for the maintenance report validator
		$results = StrainTable::getInstance()->createQuery('u')->select('u.id')->fetchArray();

		$strains = array();
		foreach ($results as $strain) {
			$strains[] = $strain['id'];
		}

		$this->setValidators(array(
			'subject'	=> new sfValidatorChoice(array('choices' => array_keys(self::$subjects), 'required' => false)),

			// Location attributes
			'location_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$locationGroupByChoices), 'required' => false)),
			'location_country'	=> new sfValidatorInteger(array('required' => false)),
			'location_region'	=> new sfValidatorInteger(array('required' => false)),
			'location_island'	=> new sfValidatorInteger(array('required' => false)),
			'location_category' => new sfValidatorDoctrineChoice(array('model' => 'LocationCategory', 'required' => false)),

			// Sample attributes
			'sample_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$sampleGroupByChoices), 'required' => false)),
			'sample_environment' => new sfValidatorDoctrineChoice(array('model' => 'Environment', 'required' => false)),
			'sample_habitat' => new sfValidatorDoctrineChoice(array('model' => 'Habitat', 'required' => false)),
			'sample_radiation' => new sfValidatorDoctrineChoice(array('model' => 'Radiation', 'required' => false)),
			'sample_extremophile' => new sfValidatorChoice(array('choices' => array_keys(self::$booleanChoices), 'required' => false)),
			'sample_location_details' => new sfValidatorString(array('max_length' => 100, 'required' => false)),

			// Strain attributes
			'strain_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$strainGroupByChoices), 'required' => false)),
			'strain_taxonomic_class' => new sfValidatorDoctrineChoice(array('model' => 'TaxonomicClass', 'required' => false)),
			'strain_genus' => new sfValidatorDoctrineChoice(array('model' => 'Genus', 'required' => false)),
			'strain_species' => new sfValidatorDoctrineChoice(array('model' => 'Species', 'required' => false)),
			'strain_authority' => new sfValidatorDoctrineChoice(array('model' => 'Authority', 'required' => false)),
			'strain_maintenance_status' => new sfValidatorDoctrineChoice(array('model' => 'MaintenanceStatus', 'required' => false)),
			'strain_culture_medium' => new sfValidatorDoctrineChoice(array('model' => 'CultureMedium', 'required' => false)),
			'strain_transfer_interval' => new sfValidatorString(array('max_length' => 40, 'required' => false)),
			'strain_epitype' => new sfValidatorChoice(array('choices' => array_keys(self::$booleanChoices), 'required' => false)),
			'strain_axenic' => new sfValidatorChoice(array('choices' => array_keys(self::$booleanChoices), 'required' => false)),
			'strain_in_g_catalog' => new sfValidatorChoice(array('choices' => array_keys(self::$booleanChoices), 'required' => false)),
			'strain_deceased' => new sfValidatorChoice(array('choices' => array_keys(self::$booleanChoices), 'required' => false)),

			// DNA extraction attributes
			'dna_extraction_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$dnaExtractionGroupByChoices), 'required' => false)),
			'dna_extraction_extraction_kit' => new sfValidatorDoctrineChoice(array('model' => 'ExtractionKit', 'required' => false)),
			'dna_extraction_aliquots' => new sfValidatorString(array('max_length' => 40, 'required' => false)),
			'dna_extraction_concentration' => new sfValidatorString(array('max_length' => 40, 'required' => false)),
			'dna_extraction_260_280_ratio' => new sfValidatorString(array('max_length' => 40, 'required' => false)),
			'dna_extraction_260_230_ratio' => new sfValidatorString(array('max_length' => 40, 'required' => false)),

			// Maintenance
			'maintenance_strain'	=> new sfValidatorInteger(array('required' => false)),
			'maintenance_strain_id' => new sfValidatorChoice(array('choices' => $strains, 'multiple'=>true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

		$this->widgetSchema->setLabels(array(
			'subject'	=> 'Subject',

			// Location attributes
			'location_group_by' => 'Group by',
			'location_country' => 'Limited to country',
			'location_region' => 'Limited to region',
			'location_island' => 'Limited to island',
			'location_category' => 'Limited to category',

			// Sample attributes
			'sample_group_by' => 'Group by',
			'sample_environment' => 'Limited to environment',
			'sample_habitat' => 'Limited to habitat',
			'sample_radiation' => 'Limited to radiation',
			'sample_extremophile' => 'Is extremophile?',
			'sample_location_details' => 'Location details',

			// Strain attributes
			'strain_group_by' => 'Group by',
			'strain_taxonomic_class' => 'Limited to taxonomic class',
			'strain_genus' => 'Limited to genus',
			'strain_species' => 'Limited to species',
			'strain_authority' => 'Limited to authority',
			'strain_maintenance_status' => 'Limited to maintenance status',
			'strain_culture_medium' => 'Limited to culture medium',
			'strain_transfer_interval' => 'Transfer interval',
			'strain_epitype' => 'Is epitype?',
			'strain_axenic' => 'Is axenic?',
			'strain_in_g_catalog' => 'In G-catalog?',
			'strain_deceased' => 'Deceased?',

			// DNA extraction attributes
			'dna_extraction_group_by' => 'Group by',
			'dna_extraction_extraction_kit' => 'Limited to extraction kit',
			'dna_extraction_aliquots' => 'Aliquots',
			'dna_extraction_concentration' => 'Concentration',
			'dna_extraction_260_280_ratio' => '260:280 DNA quality ratio',
			'dna_extraction_260_230_ratio' => '260:230 DNA quality ratio',

			// Maintenance attributes
			'maintenance_strain' => 'Strain',
			'maintenance_strain_id' => 'Selected strains',
		));

		$this->widgetSchema->setHelps(array(
			'subject'	=> 'Choose the subject of this report',

			// Location attributes
			'location_group_by' => 'Choose a criteria to group the results',
			'location_country' => '',
			'location_region' => '',
			'location_island' => '',

			// Sample attributes
			'sample_group_by' => 'Choose a criteria to group the results',
			'sample_environment' => '',
			'sample_habitat' => '',
			'sample_radiation' => '',
			'sample_extremophile' => '',

			'strain_group_by' => 'Choose a criteria to group the results',
			'strain_taxonomic_class' => '',
			'strain_genus' => '',
			'strain_species' => '',
			'strain_authority' => '',
			'strain_maintenance_status' => '',
			'strain_culture_medium' => '',
			'strain_transfer_interval' => '',
			'strain_epitype' => '',
			'strain_axenic' => '',
			'strain_in_g_catalog' => '',
			'strain_deceased' => '',

			// DNA extraction
			'dna_extraction_group_by' => 'Choose a criteria to group the results',
			'dna_extraction_extraction_kit' => '',
			'dna_extraction_aliquots' => '',
			'dna_extraction_concentration' => '',
			'dna_extraction_260_280_ratio' => '',
			'dna_extraction_260_230_ratio' => '',
			
			// Maintenance attributes
			'maintenance_strain' => '',
			'maintenance_strain_id' => '',
		));

		$this->setup();
	}

}
