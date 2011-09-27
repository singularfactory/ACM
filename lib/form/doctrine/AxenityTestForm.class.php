<?php

/**
* AxenityTest form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class AxenityTestForm extends BaseAxenityTestForm {
	public function configure() {
		$this->useFields(array('date'));
		
		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) {
			$years[$i] = $i;
		}
		$this->setWidget('date', new sfWidgetFormDate(array(
			'format' => '%year%-%month%-%day%',
			'years' => $years,
		)));
		
		$this->setValidator('delete_object', new sfValidatorBoolean());
	}
}
