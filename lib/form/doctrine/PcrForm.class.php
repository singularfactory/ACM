<?php

/**
* Pcr form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class PcrForm extends BasePcrForm {

	public function configure() {
		// Configure DNA extraction
		$this->setWidget('dna_extraction_id', new sfWidgetFormInputHidden());
		
		// Configure DNA primer widgets
		$this->setWidget('forward_dna_primer_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('ForwardPrimer'),
			'add_empty' => false,
			'method' => 'getStrand',
			'query' => DnaPrimerTable::getInstance()->findForwardPrimersQuery(),
		)));
		
		$this->setWidget('reverse_dna_primer_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('ReversePrimer'),
			'add_empty' => false,
			'method' => 'getStrand',
			'query' => DnaPrimerTable::getInstance()->findReversePrimersQuery(),
		)));
		
		// Create an embedded form to add or edit gel electrophoresis results
		$this->embedRelations(array(
			'Gel' => array(
				'considerNewFormEmptyFields' => array('number', 'band'),
				'newFormLabel' => 'Gel electrophoresis',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another gel',
			),
		));
		
		// Configure labels
		$this->widgetSchema->setLabel('dna_polymerase_id', 'DNA polymerase kit');
		$this->widgetSchema->setLabel('forward_dna_primer_id', 'Forward DNA primer');
		$this->widgetSchema->setLabel('reverse_dna_primer_id', 'Reverse DNA primer');
		$this->widgetSchema->setLabel('concentration', 'PCR product concentration');
		$this->widgetSchema->setLabel('260_280_ratio', '260:280 DNA quality ratio');
		$this->widgetSchema->setLabel('260_230_ratio', '260:230 DNA quality ratio');
		
		// Configure help messages
		$this->widgetSchema->setHelp('forward_dna_primer_id', 'Strand where the PCR starts');
		$this->widgetSchema->setHelp('reverse_dna_primer_id', 'Strand where the PCR starts');
		$this->widgetSchema->setHelp('concentration', 'Decimal value for concentration in ng/&micro;l');
		$this->widgetSchema->setHelp('260_280_ratio', 'Decimal value for quality ratio, e.g. 1.75');
		$this->widgetSchema->setHelp('260_230_ratio', 'Decimal value for quality ratio, e.g. 1.75');
	}
}
