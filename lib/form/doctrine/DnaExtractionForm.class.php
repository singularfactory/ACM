<?php

/**
 * DnaExtraction form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DnaExtractionForm extends BaseDnaExtractionForm {
  
	public function configure() {
		// Configure strain code
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => (int)StrainTable::getInstance()->getDefaultStrainId())));
		
		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$dateWidgetForm = new sfWidgetFormDate(array('format' => '%year%-%month%-%day%', 'years' => $years));
		$this->setWidget('arrival_date', $dateWidgetForm);
		$this->setWidget('extraction_date', $dateWidgetForm);
				
		// Configure custom validators
		$this->setValidator('strain_id', new sfValidatorDoctrineChoice(
			array('model' => $this->getRelatedModelName('Strain')),
			array('required' => 'The origin strain is required')));
		
		// Configure labels
		$this->widgetSchema->setLabel('strain_id', 'Strain code');
		$this->widgetSchema->setLabel('concentration', 'Genomic DNA concentration');
		$this->widgetSchema->setLabel('260_280_ratio', '260:280 DNA quality ratio');
		$this->widgetSchema->setLabel('260_230_ratio', '260:230 DNA quality ratio');
		
		// Configure help messages
		$this->widgetSchema->setHelp('arrival_date', 'Year, month and day');
		$this->widgetSchema->setHelp('extraction_date', 'Year, month and day');
		$this->widgetSchema->setHelp('genbank_link', 'Link to the GenBank where the sequence is stored');
		$this->widgetSchema->setHelp('aliquots', 'Number of aliquots available in this extraction');
		$this->widgetSchema->setHelp('concentration', 'Decimal value for concentration in ng/&micro;l');
		$this->widgetSchema->setHelp('260_280_ratio', 'Decimal value for quality ratio, e.g. 1.75');
		$this->widgetSchema->setHelp('260_230_ratio', 'Decimal value for quality ratio, e.g. 1.75');
		$this->widgetSchema->setHelp('is_public', 'Whether the DNA should be shown in public catalog or not');
  }
}
