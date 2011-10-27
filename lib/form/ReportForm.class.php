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
	
	public function configure() {
		$this->setWidgets(array(
			'subject'		=> new sfWidgetFormChoice(array('choices' => self::$subjects)),
			
			// Strain attributes
			//'culture_medium_id'	=> new sfWidgetFormDoctrineChoice(array('model' => 'CultureMedium', 'add_empty' => true)),
			//'transfer_interval'	=> new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
			'subject'	=> new sfValidatorChoice(array('choices' => array_keys(self::$subjects), 'required' => false)),
			
			// Strain attributes
			//'culture_medium_id' => new sfValidatorDoctrineChoice(array('model' => 'CultureMedium')),
			//'transfer_interval' => new sfValidatorInteger(array('required' => false, 'trim' => true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		$this->widgetSchema->setLabels(array(
			'subject'	=> 'Subject',
			
			// Strain attributes
			//'culture_medium_id' => 'Culture medium',
			//'transfer_interval' => 'Transfer interval',
		));
		
		$this->widgetSchema->setHelps(array(
			'subject'	=> 'Choose the subject of this report',
			
			// Strain attributes
			//'culture_medium_id' => 'Choose the culture medium that will appear in the label',
			//'transfer_interval'=> 'Overrides the transfer interval specified for the strain',
		));
		
		$this->setup();
	}

}
