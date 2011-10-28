<?php

/**
* Report form class.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    2011-10-27
*/
class ReportForm extends BaseForm {
	
	protected static $subjects = array(
		'location' => 'Location',
		'sample' => 'Sample',
		'strain' => 'Strain',
		'dna_extraction' => 'DNA extraction',
	);
	
	protected static $booleanChoices = array(
		-1 => '',
		0 => 'No',
		1 => 'Yes',
	);
	
	protected static $locationGroupByChoices = array(
		'country' => 'Country',
		'region' => 'Region',
		'island' => 'Island'
	);
	
	protected static $sampleGroupByChoices = array(
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
	
	
	public function configure() {
		$this->setWidgets(array(
			'subject'	=> new sfWidgetFormChoice(array('choices' => self::$subjects)),
			
			// Location attributes
			'location_group_by'	=> new sfWidgetFormChoice(array('choices' => self::$locationGroupByChoices)),
			'location_country'	=> new sfWidgetFormInputHidden(),
			'location_region'	=> new sfWidgetFormInputHidden(),
			'location_island'	=> new sfWidgetFormInputHidden(),
			
			// Sample attributes
			'sample_group_by'	=> new sfWidgetFormChoice(array('choices' => self::$sampleGroupByChoices)),
			'sample_environment' => new sfWidgetFormDoctrineChoice(array('model' => 'Environment', 'add_empty' => true)),
			'sample_habitat' => new sfWidgetFormDoctrineChoice(array('model' => 'Habitat', 'add_empty' => true)),
			'sample_radiation' => new sfWidgetFormDoctrineChoice(array('model' => 'Radiation', 'add_empty' => true)),
			'sample_extremophile' => new sfWidgetFormChoice(array('choices' => self::$booleanChoices)),
		));

		$this->setValidators(array(
			'subject'	=> new sfValidatorChoice(array('choices' => array_keys(self::$subjects), 'required' => false)),
			
			// Location attributes
			'location_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$locationGroupByChoices), 'required' => false)),
			'location_country'	=> new sfValidatorInteger(array('required' => false)),
			'location_region'	=> new sfValidatorInteger(array('required' => false)),
			'location_island'	=> new sfValidatorInteger(array('required' => false)),
			
			// Sample attributes
			'sample_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$sampleGroupByChoices), 'required' => false)),
			'sample_environment' => new sfValidatorDoctrineChoice(array('model' => 'Environment', 'required' => false)),
			'sample_habitat' => new sfValidatorDoctrineChoice(array('model' => 'Habitat', 'required' => false)),
			'sample_radiation' => new sfValidatorDoctrineChoice(array('model' => 'Radiation', 'required' => false)),
			'sample_extremophile' => new sfValidatorChoice(array('choices' => array_keys(self::$booleanChoices), 'required' => false)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		$this->widgetSchema->setLabels(array(
			'subject'	=> 'Subject',
			
			// Location attributes
			'location_group_by' => 'Group by',
			'location_country' => 'Limited to country',
			'location_region' => 'Limited to region',
			'location_island' => 'Limited to island',
			
			// Sample attributes
			'sample_group_by' => 'Group by',
			'sample_environment' => 'Limited to environment',
			'sample_habitat' => 'Limited to habitat',
			'sample_radiation' => 'Limited to radiation',
			'sample_extremophile' => 'Is extremophile?',
		));
		
		$this->widgetSchema->setHelps(array(
			'subject'	=> 'Choose the subject of this report',
			
			// Location attributes
			'location_group_by' => 'Choose a criteria to group the results',
			'location_country' => '',
			'location_region' => '',
			'location_island' => '',
			
			// Sample attributes
			'sample_group_by' => 'Group by',
			'sample_environment' => '',
			'sample_habitat' => '',
			'sample_radiation' => '',
			'sample_extremophile' => '',
		));
		
		$this->setup();
	}

}
