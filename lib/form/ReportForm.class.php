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
	
	protected static $locationGroupByChoices = array(
		'country' => 'Country',
		'region' => 'Region',
		'island' => 'Island'
	);
	
	
	
	public function configure() {
		$this->setWidgets(array(
			'subject'		=> new sfWidgetFormChoice(array('choices' => self::$subjects)),
			
			// Location attributes
			'location_group_by'	=> new sfWidgetFormChoice(array('choices' => self::$locationGroupByChoices)),
			'location_country'	=> new sfWidgetFormInputHidden(),
			'location_region'	=> new sfWidgetFormInputHidden(),
			'location_island'	=> new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
			'subject'	=> new sfValidatorChoice(array('choices' => array_keys(self::$subjects), 'required' => false)),
			
			// Location attributes
			'location_group_by' => new sfValidatorChoice(array('choices' => array_keys(self::$locationGroupByChoices), 'required' => false)),
			'location_country'	=> new sfValidatorInteger(array('required' => false)),
			'location_region'	=> new sfValidatorInteger(array('required' => false)),
			'location_island'	=> new sfValidatorInteger(array('required' => false)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		$this->widgetSchema->setLabels(array(
			'subject'	=> 'Subject',
			
			// Location attributes
			'location_group_by' => 'Group by',
			'location_country' => 'Limited to country',
			'location_region' => 'Limited to region',
			'location_island' => 'Limited to island',
		));
		
		$this->widgetSchema->setHelps(array(
			'subject'	=> 'Choose the subject of this report',
			
			// Location attributes
			'location_group_by' => 'Choose a criteria to group the results',
			'location_country'=> '',
			'location_region'=> '',
			'location_island'=> '',
		));
		
		$this->setup();
	}

}
