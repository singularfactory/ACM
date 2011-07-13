<?php

/**
* PcrReaction form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class PcrReactionForm extends BasePcrReactionForm {
	public function configure() {
		$this->useFields(array('dna_primer_id', 'worked'));
		
		$this->setWidget('dna_primer_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('DnaPrimer'),
			'add_empty' => true,
		)));
		
		$this->setValidator('delete_object', new sfValidatorBoolean());
	}
}
