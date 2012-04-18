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
 * Pcr form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class PcrForm extends BasePcrForm {

	public function configure() {
		// Configure DNA extraction
		$this->setWidget('dna_extraction_id', new sfWidgetFormInputHidden());

		// Configure DNA primer widgets
		$this->setWidget('forward_dna_primer_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('ForwardPrimer'),
			'add_empty' => false,
			'query' => DnaPrimerTable::getInstance()->findForwardPrimersQuery(),
		)));

		$this->setWidget('reverse_dna_primer_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('ReversePrimer'),
			'add_empty' => false,
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
		$this->widgetSchema->setLabel('dna_polymerase_id', 'DNA polymerase');
		$this->widgetSchema->setLabel('forward_dna_primer_id', 'Forward DNA primer');
		$this->widgetSchema->setLabel('reverse_dna_primer_id', 'Reverse DNA primer');
		$this->widgetSchema->setLabel('pcr_program_id', 'PCR program');
		$this->widgetSchema->setLabel('concentration', 'PCR product concentration');
		$this->widgetSchema->setLabel('260_280_ratio', '260:280 DNA quality ratio');
		$this->widgetSchema->setLabel('260_230_ratio', '260:230 DNA quality ratio');

		// Configure help messages
		$this->widgetSchema->setHelp('forward_dna_primer_id', 'Strand where the PCR starts');
		$this->widgetSchema->setHelp('reverse_dna_primer_id', 'Strand where the PCR starts');
		$this->widgetSchema->setHelp('pcr_program_id', 'Program that defines the conditions of this PCR');
		$this->widgetSchema->setHelp('concentration', 'Decimal value for concentration in ng/&micro;l');
		$this->widgetSchema->setHelp('260_280_ratio', 'Decimal value for quality ratio, e.g. 1.75');
		$this->widgetSchema->setHelp('260_230_ratio', 'Decimal value for quality ratio, e.g. 1.75');
	}
}
