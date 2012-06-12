<?php
/**
 * Form class
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Form
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * DnaExtraction form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class DnaExtractionForm extends BaseDnaExtractionForm {

	public function configure() {
		// Configure strain code
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => (int)StrainTable::getInstance()->getDefaultStrainId())));

		// New extractions are not public by default
		if ($this->getObject()->isNew()) {
			$this->setWidget('is_public', new sfWidgetFormInputHidden(array('default' => false)));
		} elseif (!$this->getObject()->canBePublished()) {
			$this->setWidget('is_public', new sfWidgetFormInputHidden(array('default' => $this->getObject()->getIsPublic())));
		}

		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('arrival_date', new sfWidgetFormDate(array('format' => '%year%-%month%-%day%', 'years' => $years)));
		$this->setWidget('extraction_date', new sfWidgetFormDate(array('format' => '%year%-%month%-%day%', 'years' => $years), array('class' => 'noauto')));

		// Configure list of extraction kits
		$this->setWidget('extraction_kit_id', new sfWidgetFormDoctrineChoice(array(
			'model' => 'ExtractionKit',
			'add_empty' => false,
			'order_by' => array('name', 'asc'),
		)));

		// Configure custom validators
		$this->setValidator('strain_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain')), array('required' => 'The origin strain is required')));

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
