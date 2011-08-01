<?php

/**
* PcrProgramStep form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class PcrProgramStepForm extends BasePcrProgramStepForm {
	public function configure() {
		$this->useFields(array('segment', 'temperature', 'duration'));
		$this->setValidator('delete_object', new sfValidatorBoolean());
		
		$this->widgetSchema->setHelp('temperature', 'Decimal value for temperature (e.g 22.5 ºC)');
		$this->widgetSchema->setHelp('duration', 'Elapsed time in hours and minutes');
	}
}
