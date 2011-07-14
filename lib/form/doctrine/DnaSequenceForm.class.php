<?php

/**
* DnaSequence form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class DnaSequenceForm extends BaseDnaSequenceForm {
	public function configure() {
		// Configure PCR
		$this->setWidget('pcr_id', new sfWidgetFormInputHidden());
		
		// Create an embedded form to add or edit PCR reactions
		$this->embedRelations(array(
			'Reaction' => array(
				'considerNewFormEmptyFields' => array('dna_primer_id'),
				'newFormLabel' => 'PCR reactions',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another reaction',
			),
		));
	}
}
