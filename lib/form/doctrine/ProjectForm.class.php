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
		// Configure strain code
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => (int)StrainTable::getInstance()->getDefaultStrainId())));
		
		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('inoculation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years)));
		$this->setWidget('delivery_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years), array('class' => 'noauto')));
		
		// Configure custom validators
		$this->setValidator('strain_id', new sfValidatorDoctrineChoice(
			array('model' => $this->getRelatedModelName('Strain')),
			array('required' => 'The origin strain is required')));
		
		// Configure labels
		$this->widgetSchema->setLabel('strain_id', 'Strain code');
		
		// Configure help messages
		$this->widgetSchema->setHelp('amount', 'Amount of strain inoculation');
		$this->widgetSchema->setHelp('inoculation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('delivery_date', 'Year, month and day');
		$this->widgetSchema->setHelp('purpose', 'Project details and usage of the strain');
	}
}
