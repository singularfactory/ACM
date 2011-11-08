<?php

/**
* Project form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class ProjectForm extends BaseProjectForm {
	
	public function configure() {
		// Configure strain and sample search boxes
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => SampleTable::getInstance()->getDefaultSampleId())));
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => StrainTable::getInstance()->getDefaultStrainId())));
		
		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('inoculation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years)));
		$this->setWidget('delivery_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years), array('class' => 'noauto')));
		
		// Configure a custom post validator to manage changes in isolation_subject
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'cleanFieldsByProjectSubject'))));

		// Configure labels
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('strain_id', 'Strain code');
		
		// Configure help messages
		$this->widgetSchema->setHelp('subject', 'Choose the type of material requested');
		$this->widgetSchema->setHelp('amount', 'Amount of strain inoculation');
		$this->widgetSchema->setHelp('inoculation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('delivery_date', 'Year, month and day');
		$this->widgetSchema->setHelp('purpose', 'Project details and usage of the strain');
	}
	
	public function cleanFieldsByProjectSubject($validator, $values) {	
		switch( $values['subject'] ) {
			case 'strain':
				$values['sample_id'] = null;
				break;
			
			case 'sample':
			default:
				$values['strain_id'] = null;
				break;
		}
		
		return $values;
	}
	
}
