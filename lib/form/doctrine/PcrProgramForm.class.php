<?php

/**
* PcrProgram form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class PcrProgramForm extends BasePcrProgramForm {
	public function configure() {
		// Create an embedded form to add or edit program steps
		$this->embedRelations(array(
			'Steps' => array(
				'considerNewFormEmptyFields' => array('segment', 'temperature'),
				'newFormLabel' => 'Program steps',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another step',
			),
		));
	}
}
